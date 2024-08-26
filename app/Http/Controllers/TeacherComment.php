<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use App\Models\BorrowerChildDocument;
use App\Models\BorrowerDocument;
use App\Models\BorrowerFiles;
use App\Models\Comments;
use App\Models\Config;
use App\Models\DocStructure;
use App\Models\DocTypes;
use App\Models\TeacherAccounts;
use App\Models\TeacherCommentDocuments;
use App\Models\TeacherComments;
use App\Models\TeacherRejectDocument;
use App\Models\UsefulActivity;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class TeacherComment extends Controller
{

    public function deleteFile($file_path,$file_name){
        $path = storage_path($file_path.'/'.$file_name);
        if (File::exists($path)) {
            File::delete($path);
        }
    }

    private function storeFile($file_path,$file){
        $path = storage_path($file_path);
        !file_exists($path) && mkdir($path, 0755, true);
        $name = now()->format('Y-m-d_H-i-s') . '_' . $file->getClientOriginalName();
        $file->move($path, $name);
        return $name;
    }

    public function displayFile($file_path,$file_name){
        $path = storage_path($file_path.'/'.$file_name);
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }

    function getBorrowerBeginYear($grade){
        $year = date('Y') + 543;
        $begin_year = $year - (int) $grade + 1;
        return $lastTwoDigits = substr($begin_year, -2);
    }

    function calculateGrade($student_id){
        $date = date('Y') + 543;
        $firstTwoDigits = floor($date / 100);
        $buddhistCurrentYear = intval(floor($date));
        $beginYear = intval($firstTwoDigits . substr($student_id, 0, 2));
        $grade = ($buddhistCurrentYear - $beginYear) + 1;
        return $grade;
    }

    function convert_to_dmy_date($input_date){
        $currentDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $input_date);
        return $currentDateTime->format('d-m-Y H:i:s');
    } 

    public function index(Request $request){
        $user_id = $request->session()->get('user_id', '2');
        $teacher = TeacherAccounts::join('users', 'users.id', '=', 'teacher_accounts.user_id')
            ->join('faculties', 'teacher_accounts.faculty_id', '=', 'faculties.id')
            ->join('majors', 'teacher_accounts.major_id', '=', 'majors.id')
            ->where('teacher_accounts.user_id', $user_id)
            ->select([
                'users.prefix as prefix',
                'users.firstname as firstname',
                'users.lastname as lastname',
                'faculties.faculty_name as faculty_name',
                'majors.major_name as major_name',
                'faculties.id as faculty_id',
                'majors.id as major_id'])
            ->first();
        $request->session()->put('faculty_id', $teacher->faculty_id);
        $request->session()->put('major_id', $teacher->major_id);
        return view('teachers.index',compact('teacher'));
    }

    public function multipleQuery($request){
        $select_grade = $request->session()->get('select_grade', 'all');
        $select_status = $request->session()->get('select_status', 'wait-approve');
        $faculty_id = $request->session()->get('faculty_id');
        $major_id = $request->session()->get('major_id');
        
        if($select_grade == 'all'){
            $borrower_documents = Users::join('borrowers', 'users.id', '=', 'borrowers.user_id')
            ->join('borrower_documents', 'users.id', '=', 'borrower_documents.user_id')
            ->join('documents', 'documents.id', '=', 'borrower_documents.document_id')
            ->join('faculties', 'borrowers.faculty_id', '=', 'faculties.id')
            ->join('majors', 'borrowers.major_id', '=', 'majors.id')
            ->where('documents.id', 1)
            ->where('borrower_documents.teacher_status', $select_status)
            ->where('borrowers.faculty_id', $faculty_id)
            ->where('borrowers.major_id', $major_id)
            ->select('users.prefix', 'users.firstname', 'users.lastname', 'borrowers.student_id', 'borrower_documents.id', 'borrower_documents.teacher_status', 'borrower_documents.delivered_date','faculties.faculty_name', 'majors.major_name')
            ->orderBy('delivered_date', 'asc')
            ->get();
        }else{
            $borrower_documents = Users::join('borrowers', 'users.id', '=', 'borrowers.user_id')
            ->join('borrower_documents', 'users.id', '=', 'borrower_documents.user_id')
            ->join('documents', 'documents.id', '=', 'borrower_documents.document_id')
            ->join('faculties', 'borrowers.faculty_id', '=', 'faculties.id')
            ->join('majors', 'borrowers.major_id', '=', 'majors.id')
            ->where('documents.id', 1)
            ->where('borrower_documents.teacher_status', $select_status)
            ->where('borrowers.faculty_id', $faculty_id)
            ->where('borrowers.major_id', $major_id)
            ->where('borrowers.student_id', 'like', $this->getBorrowerBeginYear($select_grade).'%')
            ->select('users.prefix', 'users.firstname', 'users.lastname', 'borrowers.student_id', 'borrower_documents.id', 'borrower_documents.teacher_status', 'borrower_documents.delivered_date','faculties.faculty_name', 'majors.major_name')
            ->orderBy('delivered_date', 'asc')
            ->get();
        }
        return $borrower_documents;
    }

    public function getBorrowerDocuments(Request $request){
        if ($request->ajax()) {
            $data = $this->multipleQuery($request);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('information', function($row){
                    return '<span>' . $row->prefix . $row->firstname . ' ' . $row->lastname .'</span><br>
                    <small class="text-secondary fw-lighter">'. $row->faculty_name . '</small><br>
                    <small class="text-secondary fw-lighter">' . $row->major_name . '</small><br>
                    <small class="text-secondary fw-lighter">' . 'ชั้นปี : ' . $this->calculateGrade($row->student_id). '</small>';
                })
                ->addColumn('delivered_date', function($row){
                    return $this->convert_to_dmy_date($row->delivered_date);
                })
                ->addColumn('action', function($row){
                    if($row->teacher_status == 'wait-approve' || $row->teacher_status == 'response-reject'){
                        $selectBtn = '<a href="' .route('teacher.comment.borrower.document', $row->id). '" class="btn btn-primary mt-4">ตรวจเอกสาร</a>';
                    }elseif($row->teacher_status == 'approved' || $row->teacher_status == 'rejected'){
                        $selectBtn = '<a href="' .route('teacher.view.borrower.document', $row->id). '" class="btn btn-primary mt-4">ดูเอกสาร</a>';
                    }elseif($row->teacher_status == 'sending'){
                        $selectBtn = '<a href="#" class="btn btn-light mt-4">ผู้กู้ยืมกำลังดำเนินการ</a>';
                    }else{
                        $selectBtn = '<a href="#" class="btn btn-light mt-4">เกิดข้อผิดพลาดของระบบสถานะ</a>';
                    }
                    return $selectBtn;
                })
                ->rawColumns(['information','deliverd_date','action'])
                ->make(true);
        }
    }

    public function selectOption(Request $request){
        $request->session()->put('select_grade', $request->select_grade);
        $request->session()->put('select_status', $request->select_status);
        return redirect('/teacher/index');
    }

    public function commnetBorrowerDocument($borrower_document_id, Request $request){
        $borrower_document = BorrowerDocument::find($borrower_document_id);
        $useful_activities = UsefulActivity::where('user_id', $borrower_document['user_id'])->get();
        $useful_activities_hours = Config::where('variable','useful_activity_hour')->value('value');
        $comments = TeacherComments::where('isactive', true)->get();
        $more_comment = TeacherCommentDocuments::where('borrower_document_id',$borrower_document_id)->where('teacher_comment_id', null)->first() ?? null;
        $teacher_reject_document = TeacherRejectDocument::where('borrower_document_id',$borrower_document_id)->first() ?? null;
        $borrower = Borrower::join('users', 'users.id', '=', 'borrowers.user_id')
            ->join('faculties' ,'faculties.id', '=', 'borrowers.faculty_id')
            ->join('majors' ,'majors.id', '=', 'borrowers.major_id')
            ->join('borrower_apprearance_types' ,'borrower_apprearance_types.id', '=', 'borrowers.borrower_appearance_id')
            ->select(
                'users.prefix',
                'users.firstname',
                'users.lastname',
                'borrower_apprearance_types.title',
                'borrowers.birthday',
                'borrowers.student_id',
                'borrowers.phone',
                'borrowers.gpa',
                'borrowers.birthday',
                'faculties.faculty_name',
                'majors.major_name',
            )
            ->where('user_id',$borrower_document['user_id'])
            ->first();
        $document = DocTypes::join('documents','doc_types.id','=','documents.doctype_id')
            ->where('documents.isactive',true)
            ->where('documents.id', $borrower_document['document_id'])
            ->first();
        $borrower_useful_activities_hours_sum = UsefulActivity::where('user_id', $borrower_document['user_id'])
            ->where('document_id', $borrower_document['document_id'])
            ->sum('hour_count') ?? 0 ;
        $child_documents = DocStructure::join('child_documents', 'doc_structures.child_document_id', '=', 'child_documents.id')
            ->where('doc_structures.document_id',$borrower_document['document_id'])
            ->select('child_documents.*')
            ->get();

        foreach($child_documents as $child_document){
            $child_document['borrower_child_document'] =  BorrowerFiles::join('borrower_child_documents' ,'borrower_files.id' ,'=', 'borrower_child_documents.borrower_file_id')
            ->where('borrower_child_documents.document_id', $document->id)
            ->where('borrower_child_documents.child_document_id', $child_document['id'])
            ->where('borrower_child_documents.user_id', $borrower_document['user_id'])
            ->first();
        }
        foreach($comments as $comment){
            $comment['checked'] = TeacherCommentDocuments::where('borrower_document_id',$borrower_document_id)->where('teacher_comment_id', $comment['id'])->exists();
        }

        return view('teachers.comment_documents', 
            compact(
                'document',
                'borrower',
                'useful_activities',
                'borrower_useful_activities_hours_sum',
                'useful_activities_hours',
                'child_documents',
                'comments',
                'borrower_document',
                'more_comment',
                'teacher_reject_document',
            ));
    }

    public function storeComment($borrower_document_id, Request $request){
        $user_id = $request->session()->get('user_id', '2');
        $borrower_document = BorrowerDocument::find($borrower_document_id);
        $request->validate([
            'status' => 'required|string|max:25',
            'reject_comment' => 'string|max:100',
            'commnets' => 'array',
            'commnets.*' => 'string',
            'more_comment' => 'string|max:100',
        ],[
            "status.required" => 'กรุณากรอกคุณสมบัติผู้กู้',
            "status.string" => 'รูปแบบข้อมูลที่ส่งมาไม่ถูกต้อง',
            "status.max" => 'ชื่อของคุณสมบัติผู้กู้ต้องมีความยาวไม่เกิน :max ตัวอักษร',
            "reject_comment.string" => 'รูปแบบข้อมูลที่ส่งมาไม่ถูกต้อง',
            "reject_comment.max" => 'ความเห็นต้องไม่เกิน :max ตัวอักษร',
            "comments.array" => 'รูปแบบข้อมูลที่ส่งมาไม่ถูกต้อง',
            "comments.*.string" => 'รูปแบบข้อมูลที่ส่งมาไม่ถูกต้อง',
            "more_comment.string" => 'รูปแบบข้อมูลที่ส่งมาไม่ถูกต้อง',
            "more_comment.max" => 'ความเห็นต้องไม่เกิน :max ตัวอักษร',
        ]);
        if($request->status == "approve"){
            $comments_Db = TeacherCommentDocuments::where('borrower_document_id',$borrower_document_id)->pluck('teacher_comment_id')->toArray();
            $comments_Req = $request->comments ?? [];
            $custom_comment = TeacherCommentDocuments::where('borrower_document_id',$borrower_document_id)->where('teacher_comment_id', null)->first() ?? new TeacherCommentDocuments();
            $borrower_child_document_101 = BorrowerChildDocument::where('document_id', $borrower_document['document_id'])->where('child_document_id', 4)->first();
            $comments_for_delete = array_diff($comments_Db,$comments_Req) ;
            $comments_for_add = array_diff($comments_Req,$comments_Db);

            foreach($comments_for_delete as $teacher_comment_id){
                TeacherCommentDocuments::where('borrower_document_id',$borrower_document_id)->where('teacher_comment_id',$teacher_comment_id)->delete();
            }

            foreach($comments_for_add as $teacher_comment_id){
                TeacherCommentDocuments::create(
                    [
                        'borrower_document_id' => $borrower_document_id,
                        'teacher_comment_id' => $teacher_comment_id,
                        'teacher_uid' => $user_id,
                        'custom_comment' => '',
                    ]
                );
            }

            if(isset($request->more_comment_check) && $request->more_comment_check == '1'){
                $custom_comment['borrower_document_id'] = $borrower_document_id;
                $custom_comment['teacher_comment_id'] = null;
                $custom_comment['teacher_uid'] = $user_id;
                $custom_comment['custom_comment'] = $request->more_comment;
                $custom_comment->save();
            }else{
                if($custom_comment != null) $custom_comment->delete();
            }

            $teacher_reject_document = TeacherRejectDocument::where('borrower_document_id',$borrower_document_id)->first();
            if($teacher_reject_document != null) $teacher_reject_document->delete();

            //sign borrower 101
            $generator = new GenerateFile();
            $temp_path = $generator->teacherCommentDocument101($user_id, $borrower_child_document_101['borrower_file_id']);
            $this->updateBorrowerFile101($temp_path, $borrower_child_document_101['borrower_file_id']);

            $borrower_document['teacher_status'] = 'approved';
            $borrower_document['status'] = 'wait-approve';
            $borrower_document->save();
            return redirect('/teacher/index')->with(['success' => 'บันทึกข้อมูลเสร็จสิ้น']);
        }elseif($request->status == "reject"){
            $teacher_reject_document = TeacherRejectDocument::where('borrower_document_id',$borrower_document_id)->first() ?? new TeacherRejectDocument();
            $teacher_reject_document['teacher_uid'] = $user_id;
            $teacher_reject_document['borrower_document_id'] = $borrower_document_id;
            $teacher_reject_document['reject_comment'] = $request->reject_comment;
            $teacher_reject_document->save();
            $borrower_document['teacher_status'] = 'rejected';
            $borrower_document->save();
            return redirect('/teacher/index')->with(['success' => 'บันทึกข้อมูลเสร็จสิ้น']);
        }else{
            return redirect()->back()->withErrors('สถานะที่เลือกไม่ตรงกับสถานะใดๆในระบบ');
        }
    }

    public function updateBorrowerFile101($temp_path, $borrower_file_101_id){
        $borrower_file = BorrowerFiles::find($borrower_file_101_id);
        //file
        $custom_filename = now()->format('Y-m-d_H-i-s') . '_' . 'กยศ 101_.pdf';
        $store_path = $borrower_file['file_path'];
        $path = storage_path($store_path);
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
        $final_path = $path. '/' .$custom_filename;
        File::move($temp_path, $final_path);
        $this->deleteFile($borrower_file['file_path'], $borrower_file['file_name']);
        $borrower_file['file_path'] = $store_path;
        $borrower_file['file_name'] = $custom_filename;
        $borrower_file['file_type'] = last(explode('.', $custom_filename));
        $borrower_file['full_path'] = $store_path. '/' .$custom_filename;
        $borrower_file->save(); 
    }

    public function viewBorrowerDocument($borrower_document_id, Request $request){
        $borrower_document = BorrowerDocument::find($borrower_document_id);
        $useful_activities = UsefulActivity::where('user_id', $borrower_document['user_id'])->get();
        $useful_activities_hours = Config::where('variable','useful_activity_hour')->value('value');
        $comments = TeacherComments::where('isactive', true)->get();
        $more_comment = TeacherCommentDocuments::where('borrower_document_id',$borrower_document_id)->where('teacher_comment_id', null)->first() ?? null;
        $teacher_reject_document = TeacherRejectDocument::where('borrower_document_id',$borrower_document_id)->first() ?? null;
        $borrower = Borrower::join('users', 'users.id', '=', 'borrowers.user_id')
            ->join('faculties' ,'faculties.id', '=', 'borrowers.faculty_id')
            ->join('majors' ,'majors.id', '=', 'borrowers.major_id')
            ->join('borrower_apprearance_types' ,'borrower_apprearance_types.id', '=', 'borrowers.borrower_appearance_id')
            ->select(
                'users.prefix',
                'users.firstname',
                'users.lastname',
                'borrower_apprearance_types.title',
                'borrowers.birthday',
                'borrowers.student_id',
                'borrowers.phone',
                'borrowers.gpa',
                'borrowers.birthday',
                'faculties.faculty_name',
                'majors.major_name',
            )
            ->where('user_id',$borrower_document['user_id'])
            ->first();
        $document = DocTypes::join('documents','doc_types.id','=','documents.doctype_id')
            ->where('documents.isactive',true)
            ->where('documents.id', $borrower_document['document_id'])
            ->first();
        $borrower_useful_activities_hours_sum = UsefulActivity::where('user_id', $borrower_document['user_id'])
            ->where('document_id', $borrower_document['document_id'])
            ->sum('hour_count') ?? 0 ;
        $child_documents = DocStructure::join('child_documents', 'doc_structures.child_document_id', '=', 'child_documents.id')
            ->where('doc_structures.document_id',$borrower_document['document_id'])
            ->select('child_documents.*')
            ->get();

        foreach($child_documents as $child_document){
            $child_document['borrower_child_document'] =  BorrowerFiles::join('borrower_child_documents' ,'borrower_files.id' ,'=', 'borrower_child_documents.borrower_file_id')
            ->where('borrower_child_documents.document_id', $document->id)
            ->where('borrower_child_documents.child_document_id', $child_document['id'])
            ->where('borrower_child_documents.user_id', $borrower_document['user_id'])
            ->first();
        }
        foreach($comments as $comment){
            $comment['checked'] = TeacherCommentDocuments::where('borrower_document_id',$borrower_document_id)->where('teacher_comment_id', $comment['id'])->exists();
        }
        return view('teachers.view_document', 
            compact(
                'document',
                'borrower',
                'useful_activities',
                'borrower_useful_activities_hours_sum',
                'useful_activities_hours',
                'child_documents',
                'comments',
                'borrower_document',
                'more_comment',
                'teacher_reject_document',
            ));
    }
}
