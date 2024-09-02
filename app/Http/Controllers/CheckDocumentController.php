<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use App\Models\BorrowerChildDocument;
use App\Models\BorrowerDocument;
use App\Models\BorrowerFiles;
use App\Models\ChildDocuments;
use App\Models\Comments;
use App\Models\CommentsBorrowerChildDocument;
use App\Models\Config;
use App\Models\DocStructure;
use App\Models\DocTypes;
use App\Models\Documents;
use App\Models\Faculties;
use App\Models\Majors;
use App\Models\UsefulActivitiesComments;
use App\Models\UsefulActivity;
use App\Models\UsefulActivityStatus;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use League\CommonMark\Node\Block\Document;

class CheckDocumentController extends Controller
{
    protected $status = [
        'sending' => 'ผู้กู้ยืมกำลังดำเนินการ',
        'wait-teacher-comment' => 'รออารจารย์ที่ปรึกษาให้ความเห็น',
        'wait-approve' => 'รออนุมัติ',
        'rejected' => 'ต้องแก้ไข',
        'approved' => 'อนุมัติแล้ว',
        'response-reject' => 'แก้ใขแล้ว',
    ];

    private function convertToBuddhistDateTime()
    {
        $currentDateTime = Carbon::now();
        $buddhistDateTime = $currentDateTime->addYears(543);
        return $buddhistDateTime->format('Y-m-d H:i:s');
    }

    public function deleteFile($file_path, $file_name)
    {
        $path = storage_path($file_path . '/' . $file_name);
        if (File::exists($path)) {
            File::delete($path);
        }
    }

    private function storeFile($file_path, $file)
    {
        $path = storage_path($file_path);
        !file_exists($path) && mkdir($path, 0755, true);
        $name = now()->format('Y-m-d_H-i-s') . '_' . $file->getClientOriginalName();
        $file->move($path, $name);
        return $name;
    }

    public function displayFile($file_path, $file_name)
    {
        $path = storage_path($file_path . '/' . $file_name);
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }

    private function convert_to_iso_date($inputDate)
    {
        $parsedDate = Carbon::createFromFormat('d-m-Y', $inputDate);
        $isoDate = $parsedDate->format('Y-m-d');

        return $isoDate;
    }

    function convert_to_dmy_date($input_date)
    {
        $currentDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $input_date);
        return $currentDateTime->format('d-m-Y H:i:s');
    }

    function getBorrowerBeginYear($grade)
    {
        $year = date('Y') + 543;
        $begin_year = $year - (int) $grade + 1;
        return $lastTwoDigits = substr($begin_year, -2);
    }

    function calculateGrade($student_id)
    {
        $date = date('Y') + 543;
        $firstTwoDigits = floor($date / 100);
        $buddhistCurrentYear = intval(floor($date));
        $beginYear = intval($firstTwoDigits . substr($student_id, 0, 2));
        $grade = ($buddhistCurrentYear - $beginYear) + 1;
        return $grade;
    }

    public function index()
    {
        $documents = Documents::join('doc_types', 'documents.doctype_id', '=', 'doc_types.id')
            ->where('documents.isactive', true)
            ->select('documents.*', 'doc_types.doctype_title')
            // ->orderBy('documents.created_at', 'desc')
            ->get();
        // dd($documents);
        foreach ($documents as $document) {
            $document['last_access'] = Users::where('id', $document['last_access'])->value('firstname');
        }
        return view('check_document.index', compact('documents'));
    }

    public function selectDocument($document_id, Request $request)
    {
        $request->session()->put([
            'select_status' =>  $request->session()->get('select_status') ?? 'wait-approve',
            'select_faculty' => $request->session()->get('select_faculty') ?? 'all',
            'select_major' => $request->session()->get('select_major') ?? 'all',
            'select_grade' => $request->session()->get('select_grade') ?? 'all',
        ]);
        $document = Documents::join('doc_types', 'documents.doctype_id', '=', 'doc_types.id')
            ->where('documents.isactive', true)
            ->where('documents.id', $document_id)
            ->select('documents.*', 'doc_types.doctype_title')
            ->first();
        $faculties = Faculties::where('isactive', true)->get();
        $majors = Majors::where('isactive', true)->get();
        return view('check_document.select_check_document', compact('document', 'faculties', 'majors'));
    }
    
    public function selectMajorByFacultyId($faculty_id)
    {
        if ($faculty_id == 'all') {
            $majors = Majors::where('isactive', true)->get();
        } else {
            $majors = Majors::where('faculty_id', $faculty_id)->where('isactive', true)->get();
        }
        return json_encode($majors);
    }

    public function selectStatusDocument($document_id, Request $request)
    {
        // dd($request);
        $request->session()->put([
            'select_status' => $request->status,
            'select_faculty' => $request->faculty ?? 'all',
            'select_major' => $request->major ?? 'all',
            'select_grade' => $request->grade ?? 'all',
        ]);
        return redirect('/check_document/select_document/' . $document_id);
    }

    public function multipleQuery($document_id, $request)
    {
        $select_status = $request->session()->get('select_status', 'wait-approve');
        $select_faculty = $request->session()->get('select_faculty', 'all');
        $select_major = $request->session()->get('select_major', 'all');
        $select_grade = $request->session()->get('select_grade', 'all');

        if (($select_faculty == 'all' && $select_major == 'all') && $select_grade == 'all') { //ไม่ได้เลือก คณะ, สาขา, ชั้นปี
            $data = Users::join('borrowers', 'users.id', '=', 'borrowers.user_id')
                ->join('borrower_documents', 'users.id', '=', 'borrower_documents.user_id')
                ->join('documents', 'documents.id', '=', 'borrower_documents.document_id')
                ->join('faculties', 'borrowers.faculty_id', '=', 'faculties.id')
                ->join('majors', 'borrowers.major_id', '=', 'majors.id')
                ->where('documents.id', $document_id)
                ->where('borrower_documents.status', $select_status)
                ->where('borrower_documents.checking', false)
                ->select('users.prefix', 'users.firstname', 'users.lastname', 'borrowers.student_id', 'borrower_documents.id', 'borrower_documents.status', 'borrower_documents.delivered_date', 'faculties.faculty_name', 'majors.major_name')
                ->orderBy('delivered_date', 'asc')
                ->get();
        } else if (($select_faculty != 'all' && $select_major == 'all') && $select_grade == 'all') {  //เลือก คณะ แต่ไม่ได้เลือก สาขา, ชั้นปี
            $data = Users::join('borrowers', 'users.id', '=', 'borrowers.user_id')
                ->join('borrower_documents', 'users.id', '=', 'borrower_documents.user_id')
                ->join('documents', 'documents.id', '=', 'borrower_documents.document_id')
                ->join('faculties', 'borrowers.faculty_id', '=', 'faculties.id')
                ->join('majors', 'borrowers.major_id', '=', 'majors.id')
                ->where('documents.id', $document_id)
                ->where('borrower_documents.status', $select_status)
                ->where('borrower_documents.checking', false)
                ->where('borrowers.faculty_id', $select_faculty)
                ->select('users.prefix', 'users.firstname', 'users.lastname', 'borrowers.student_id', 'borrower_documents.id', 'borrower_documents.status', 'borrower_documents.delivered_date', 'faculties.faculty_name', 'majors.major_name')
                ->orderBy('delivered_date', 'asc')
                ->get();
        } else if (($select_faculty != 'all' && $select_major != 'all') && $select_grade == 'all') { //เลือก คณะ , สาขา แต่ไม่ได้เลือก ชั้นปี
            $data = Users::join('borrowers', 'users.id', '=', 'borrowers.user_id')
                ->join('borrower_documents', 'users.id', '=', 'borrower_documents.user_id')
                ->join('documents', 'documents.id', '=', 'borrower_documents.document_id')
                ->join('faculties', 'borrowers.faculty_id', '=', 'faculties.id')
                ->join('majors', 'borrowers.major_id', '=', 'majors.id')
                ->where('documents.id', $document_id)
                ->where('borrower_documents.status', $select_status)
                ->where('borrower_documents.checking', false)
                ->where('borrowers.faculty_id', $select_faculty)
                ->where('borrowers.major_id', $select_major)
                ->select('users.prefix', 'users.firstname', 'users.lastname', 'borrowers.student_id', 'borrower_documents.id', 'borrower_documents.status', 'borrower_documents.delivered_date', 'faculties.faculty_name', 'majors.major_name')
                ->orderBy('delivered_date', 'asc')
                ->get();
        } else if (($select_faculty != 'all' && $select_major != 'all') && $select_grade != 'all') { //เลือกทั้ง คณะ, สาขา และ ชั้นปี
            $data = Users::join('borrowers', 'users.id', '=', 'borrowers.user_id')
                ->join('borrower_documents', 'users.id', '=', 'borrower_documents.user_id')
                ->join('documents', 'documents.id', '=', 'borrower_documents.document_id')
                ->join('faculties', 'borrowers.faculty_id', '=', 'faculties.id')
                ->join('majors', 'borrowers.major_id', '=', 'majors.id')
                ->where('documents.id', $document_id)
                ->where('borrower_documents.status', $select_status)
                ->where('borrower_documents.checking', false)
                ->where('borrowers.faculty_id', $select_faculty)
                ->where('borrowers.major_id', $select_major)
                ->where('borrowers.student_id', 'like', $this->getBorrowerBeginYear($select_grade) . '%')
                ->select('users.prefix', 'users.firstname', 'users.lastname', 'borrowers.student_id', 'borrower_documents.id', 'borrower_documents.status', 'borrower_documents.delivered_date', 'faculties.faculty_name', 'majors.major_name')
                ->orderBy('delivered_date', 'asc')
                ->get();
        } else if (($select_faculty == 'all' && $select_major != 'all') && $select_grade != 'all') { //เลือก สาขา, ชั้นปี แต่ไม่ได้เลือก คณะ
            $data = Users::join('borrowers', 'users.id', '=', 'borrowers.user_id')
                ->join('borrower_documents', 'users.id', '=', 'borrower_documents.user_id')
                ->join('documents', 'documents.id', '=', 'borrower_documents.document_id')
                ->join('faculties', 'borrowers.faculty_id', '=', 'faculties.id')
                ->join('majors', 'borrowers.major_id', '=', 'majors.id')
                ->where('documents.id', $document_id)
                ->where('borrower_documents.status', $select_status)
                ->where('borrower_documents.checking', false)
                ->where('borrowers.major_id', $select_major)
                ->where('borrowers.student_id', 'like', $this->getBorrowerBeginYear($select_grade) . '%')
                ->select('users.prefix', 'users.firstname', 'users.lastname', 'borrowers.student_id', 'borrower_documents.id', 'borrower_documents.status', 'borrower_documents.delivered_date', 'faculties.faculty_name', 'majors.major_name')
                ->orderBy('delivered_date', 'asc')
                ->get();
        } else if (($select_faculty == 'all' && $select_major != 'all') && $select_grade == 'all') { //เลือกเฉพาะสาขา
            $data = Users::join('borrowers', 'users.id', '=', 'borrowers.user_id')
                ->join('borrower_documents', 'users.id', '=', 'borrower_documents.user_id')
                ->join('documents', 'documents.id', '=', 'borrower_documents.document_id')
                ->join('faculties', 'borrowers.faculty_id', '=', 'faculties.id')
                ->join('majors', 'borrowers.major_id', '=', 'majors.id')
                ->where('documents.id', $document_id)
                ->where('borrower_documents.status', $select_status)
                ->where('borrower_documents.checking', false)
                ->where('borrowers.major_id', $select_major)
                ->select('users.prefix', 'users.firstname', 'users.lastname', 'borrowers.student_id', 'borrower_documents.id', 'borrower_documents.status', 'borrower_documents.delivered_date', 'faculties.faculty_name', 'majors.major_name')
                ->orderBy('delivered_date', 'asc')
                ->get();
        } else if (($select_faculty == 'all' && $select_major == 'all') && $select_grade != 'all') { //เลือกเฉพาะชั้นปี
            $data = Users::join('borrowers', 'users.id', '=', 'borrowers.user_id')
                ->join('borrower_documents', 'users.id', '=', 'borrower_documents.user_id')
                ->join('documents', 'documents.id', '=', 'borrower_documents.document_id')
                ->join('faculties', 'borrowers.faculty_id', '=', 'faculties.id')
                ->join('majors', 'borrowers.major_id', '=', 'majors.id')
                ->where('documents.id', $document_id)
                ->where('borrower_documents.status', $select_status)
                ->where('borrower_documents.checking', false)
                ->where('borrowers.student_id', 'like', $this->getBorrowerBeginYear($select_grade) . '%')
                ->select('users.prefix', 'users.firstname', 'users.lastname', 'borrowers.student_id', 'borrower_documents.id', 'borrower_documents.status', 'borrower_documents.delivered_date', 'faculties.faculty_name', 'majors.major_name')
                ->orderBy('delivered_date', 'asc')
                ->get();
        }
        return $data;
    }

    public function getBorrowerDocuments($document_id, Request $request)
    {
        if ($request->ajax()) {
            $data = $this->multipleQuery($document_id, $request);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('information', function ($row) {
                    return '<span>' . $row->prefix . $row->firstname . ' ' . $row->lastname . '</span><br>
                    <small class="text-secondary fw-lighter">' . $row->faculty_name . '</small><br>
                    <small class="text-secondary fw-lighter">' . $row->major_name . '</small><br>
                    <small class="text-secondary fw-lighter">' . 'ชั้นปี : ' . $this->calculateGrade($row->student_id) . '</small>';
                })
                ->addColumn('delivered_date', function ($row) {
                    return $this->convert_to_dmy_date($row->delivered_date);
                })
                ->addColumn('action', function ($row) {
                    if ($row->status == 'wait-approve') {
                        $selectBtn = '<a href="' . route('check_document.borrower_child_document.list', $row->id) . '" class="btn btn-primary mt-4">ตรวจเอกสาร</a>';
                    } elseif ($row->status == 'sending') {
                        $selectBtn = '<a href="#" class="btn btn-light mt-4">ผู้กู้ยืมกำลังดำเนินการ</a>';
                    } else {
                        $selectBtn = '<a href="' . route('check_document.view.borrower.document', $row->id) . '" class="btn btn-primary mt-4">ดูเอกสาร</a>';
                    }
                    return $selectBtn;
                })
                ->rawColumns(['information', 'deliverd_date', 'action'])
                ->make(true);
        }
    }

    public function borrowerChildDocumentList($borrower_document_id, Request $request)
    {
        $checker_id = $request->session()->get('user_id');
        $borrower_document = BorrowerDocument::find($borrower_document_id);
        $useful_activities_status = UsefulActivityStatus::where('document_id', $borrower_document['document_id'])
            ->where('borrower_uid', $borrower_document['user_id'])
            ->first();
        $document = DocTypes::join('documents', 'doc_types.id', '=', 'documents.doctype_id')
            ->where('documents.isactive', true)
            ->where('documents.id', $borrower_document['document_id'])
            ->first();
        $child_documents = DocStructure::join('child_documents', 'doc_structures.child_document_id', '=', 'child_documents.id')
            ->join('borrower_child_documents', 'borrower_child_documents.child_document_id', '=', 'child_documents.id')
            ->where('doc_structures.document_id', $borrower_document['document_id'])
            ->where('borrower_child_documents.user_id', $borrower_document['user_id'])
            ->select(
                'child_documents.id',
                'child_documents.child_document_title as title',
                'borrower_child_documents.id as borrower_child_document_id',
                'borrower_child_documents.status',)
            ->orderBy('child_documents.id', 'asc')
            ->get();
        $borrower = Borrower::join('users', 'users.id', '=', 'borrowers.user_id')
            ->join('faculties', 'faculties.id', '=', 'borrowers.faculty_id')
            ->join('majors', 'majors.id', '=', 'borrowers.major_id')
            ->join('borrower_apprearance_types', 'borrower_apprearance_types.id', '=', 'borrowers.borrower_appearance_id')
            ->where('user_id', $borrower_document['user_id'])
            ->select(
                'users.prefix',
                'users.firstname',
                'users.lastname',
                'borrower_apprearance_types.title',
                'borrowers.user_id',
                'borrowers.birthday',
                'borrowers.student_id',
                'borrowers.phone',
                'borrowers.gpa',
                'borrowers.birthday',
                'faculties.faculty_name',
                'majors.major_name',)
            ->first();

        $checked_document = DocStructure::join('child_documents', 'doc_structures.child_document_id', '=', 'child_documents.id')
            ->join('borrower_child_documents', 'borrower_child_documents.child_document_id', '=', 'child_documents.id')
            ->where('doc_structures.document_id', $borrower_document['document_id'])
            ->where('borrower_child_documents.user_id', $borrower_document['user_id'])
            ->where('borrower_child_documents.checker_id', '!=', null)
            ->where('borrower_child_documents.status', 'approved')
            ->orWhere('borrower_child_documents.status', 'rejected')
            ->count();

        $document_to_check = count($child_documents) ?? 0;
        if($document['need_useful_activity']){
            $document_to_check += 1;
            $checked_document += 1;
        } 

        return view(
            'check_document.borrower_document_list',
            compact(
                'document',
                'child_documents',
                'borrower',
                'borrower_document',
                'useful_activities_status',
                'document_to_check',
                'checked_document',
            )
        );
    }

    public function getBorrowerChildDocument($borrower_child_document_id, $borrower_document_id, Request $request)
    {
        $borrower_child_document = BorrowerChildDocument::find($borrower_child_document_id);
        $child_document = ChildDocuments::find($borrower_child_document['child_document_id']);        
        $comments_db = CommentsBorrowerChildDocument::where('borrower_child_document_id', $borrower_child_document_id)->where('comment_id', '!=', null)->pluck('comment_id')->toArray() ?? null;
        $custom_comment = CommentsBorrowerChildDocument::where('borrower_child_document_id', $borrower_child_document_id)->where('comment_id', null)->first() ?? null;
        $comments = Comments::where('isactive', true)->get();
        return view(
            'check_document.check_borrower_document', 
            compact(
                'borrower_child_document',
                'child_document',
                'borrower_document_id', 
                'comments',
                'comments_db',
                'custom_comment',
            ));
    }

    public function postBorrowerChildDocument($borrower_child_document_id, $borrower_document_id, Request $request)
    {
        $checker_id = $request->session()->get('user_id');
        $borrower_document = BorrowerDocument::find($borrower_document_id);
        $borrower_child_document = BorrowerChildDocument::find($borrower_child_document_id);
        $request->validate([
            'status' => 'required|string|max:25',
            'commnets' => 'array',
            'commnets.*' => 'string',
            'more_comment_check' => 'string|max:10',
            'more_comment_text' => 'string|max:100',
        ], [
            "status.required" => 'กรุณากรอกคุณสมบัติผู้กู้',
            "status.string" => 'รูปแบบข้อมูลที่ส่งมาไม่ถูกต้อง',
            "status.max" => 'ชื่อของคุณสมบัติผู้กู้ต้องมีความยาวไม่เกิน :max ตัวอักษร',
            "reject_comment.string" => 'รูปแบบข้อมูลที่ส่งมาไม่ถูกต้อง',
            "reject_comment.max" => 'ความเห็นต้องไม่เกิน :max ตัวอักษร',
            "comments.array" => 'รูปแบบข้อมูลที่ส่งมาไม่ถูกต้อง',
            "comments.*.string" => 'รูปแบบข้อมูลที่ส่งมาไม่ถูกต้อง',
            "more_comment_check.string" => 'รูปแบบข้อมูลที่ส่งมาไม่ถูกต้อง',
            "more_comment_check.max" => 'ความเห็นต้องไม่เกิน :max ตัวอักษร',
            "more_comment_text.string" => 'รูปแบบข้อมูลที่ส่งมาไม่ถูกต้อง',
            "more_comment_text.max" => 'ความเห็นต้องไม่เกิน :max ตัวอักษร',
        ]);

        if ($request->status == 'reject') {
            $comments_db = CommentsBorrowerChildDocument::where('borrower_child_document_id', $borrower_child_document_id)->where('comment_id', '!=', null)->pluck('comment_id')->toArray();
            $comments_req = $request->comments ?? [];
            $custom_comment = CommentsBorrowerChildDocument::where('borrower_child_document_id', $borrower_child_document_id)->where('comment_id', null)->first() ?? new CommentsBorrowerChildDocument();
            $comments_for_delete = array_diff($comments_db, $comments_req);
            $comments_for_add = array_diff($comments_req, $comments_db);
            foreach($comments_for_add as $comment_id){
                $comment_borrower_child_document = new CommentsBorrowerChildDocument();
                $comment_borrower_child_document['comment_id'] = $comment_id;
                $comment_borrower_child_document['borrower_child_document_id'] = $borrower_child_document_id;
                $comment_borrower_child_document->save();
            }

            foreach($comments_for_delete as $comment_id){
                $comment_borrower_child_document = CommentsBorrowerChildDocument::where('borrower_child_document_id', $borrower_child_document_id)->where('comment_id', $comment_id)->delete();
            }

            if (isset($request->more_comment_check) && $request->more_comment_check == 'true') {
                $custom_comment['borrower_child_document_id'] = $borrower_child_document_id;
                $custom_comment['comment_id'] = null;
                $custom_comment['other_comment'] = $request->more_comment_text;
                $custom_comment->save();
            } else {
                $custom_comment->delete();
            }

            $borrower_child_document['status'] = 'rejected';
            $borrower_child_document['checker_id'] = $checker_id;
            $borrower_child_document->save();
            
        } else {
            CommentsBorrowerChildDocument::where('borrower_child_document_id', $borrower_child_document_id)->delete();
            $borrower_child_document['status'] = 'approved';
            $borrower_child_document['checker_id'] = $checker_id;
            $borrower_child_document->save();
        }
        $borrower_document['checking'] = true;
        $borrower_document['checker_id'] = $checker_id;
        $borrower_document->save();
        return redirect()->route('check_document.borrower_child_document.list',['borrower_document_id' => $borrower_document_id])->with(['success' => 'บันทึกข้อมูลเรียบร้อยแล้ว']);
    }

    public function getBorrowerUsefulActivities($borrower_document_id)
    {
        $borrower_document = BorrowerDocument::find($borrower_document_id);
        $useful_activities = UsefulActivity::where('user_id', $borrower_document['user_id'])->get();
        $useful_activities_status = UsefulActivityStatus::where('document_id', $borrower_document['document_id'])
            ->where('borrower_uid', $borrower_document['user_id'])
            ->first();
        $borrower_useful_activities_hours_sum = UsefulActivity::where('user_id', $borrower_document['user_id'])
            ->where('document_id', $borrower_document['document_id'])
            ->sum('hour_count') ?? 0;
        $useful_activities_hours = Config::where('variable', 'useful_activity_hour')->value('value');
        $comments_db = UsefulActivitiesComments::where('document_id', $borrower_document['document_id'])->where('comment_id', '!=', null)->pluck('comment_id')->toArray() ?? null;
        $custom_comment = UsefulActivitiesComments::where('document_id', $borrower_document['document_id'])->where('comment_id', null)->first() ?? null;
        $comments = Comments::where('isactive', true)->get();
        return view('check_document.check_borrower_useful_activity', 
            compact(
                'useful_activities', 
                'borrower_useful_activities_hours_sum', 
                'useful_activities_hours', 
                'borrower_document',
                'useful_activities_status',
                'comments_db',
                'custom_comment',
                'comments',
            ));
    }

    public function postBorrowerUsefulActivities ($borrower_document_id, Request $request )
    {
        // dd($request);
        $checker_id = $request->session()->get('user_id');
        $borrower_document = BorrowerDocument::find($borrower_document_id);
        $useful_activities_status = UsefulActivityStatus::where('document_id', $borrower_document['document_id'])
            ->where('borrower_uid', $borrower_document['user_id'])
            ->first();
        $useful_activities_status['document_id'] = $borrower_document['document_id'];
        $useful_activities_status['borrower_uid'] = $borrower_document['user_id'];

        $request->validate([
            'status' => 'required|string|max:25',
            'commnets' => 'array',
            'commnets.*' => 'string',
            'more_comment_check' => 'string|max:10',
            'more_comment_text' => 'string|max:100',
        ], [
            "status.required" => 'กรุณากรอกคุณสมบัติผู้กู้',
            "status.string" => 'รูปแบบข้อมูลที่ส่งมาไม่ถูกต้อง',
            "status.max" => 'ชื่อของคุณสมบัติผู้กู้ต้องมีความยาวไม่เกิน :max ตัวอักษร',
            "reject_comment.string" => 'รูปแบบข้อมูลที่ส่งมาไม่ถูกต้อง',
            "reject_comment.max" => 'ความเห็นต้องไม่เกิน :max ตัวอักษร',
            "comments.array" => 'รูปแบบข้อมูลที่ส่งมาไม่ถูกต้อง',
            "comments.*.string" => 'รูปแบบข้อมูลที่ส่งมาไม่ถูกต้อง',
            "more_comment_check.string" => 'รูปแบบข้อมูลที่ส่งมาไม่ถูกต้อง',
            "more_comment_check.max" => 'ความเห็นต้องไม่เกิน :max ตัวอักษร',
            "more_comment_text.string" => 'รูปแบบข้อมูลที่ส่งมาไม่ถูกต้อง',
            "more_comment_text.max" => 'ความเห็นต้องไม่เกิน :max ตัวอักษร',
        ]);

        if ($request->status == 'reject') {
            $comments_db = UsefulActivitiesComments::where('document_id', $borrower_document['id'])
                ->where('borrower_uid', $borrower_document['user_id'])
                ->where('comment_id', '!=', null)
                ->pluck('comment_id')->toArray();
            $comments_req = $request->comments ?? [];
            $custom_comment = UsefulActivitiesComments::where('document_id', $borrower_document['id'])
                ->where('borrower_uid', $borrower_document['user_id'])
                ->where('comment_id', null)
                ->first() ?? new UsefulActivitiesComments();
            $comments_for_delete = array_diff($comments_db, $comments_req);
            $comments_for_add = array_diff($comments_req, $comments_db);
            foreach($comments_for_add as $comment_id){
                $comment_borrower_child_document = new UsefulActivitiesComments();
                $comment_borrower_child_document['document_id'] = $borrower_document['document_id'];
                $comment_borrower_child_document['borrower_uid'] = $borrower_document['user_id'];
                $comment_borrower_child_document['comment_id'] = $comment_id;
                $comment_borrower_child_document->save();
            }

            foreach($comments_for_delete as $comment_id){
                $comment_borrower_child_document = UsefulActivitiesComments::where('document_id', $borrower_document['id'])
                    ->where('borrower_uid', $borrower_document['user_id'])
                    ->where('comment_id', $comment_id)->delete();
            }

            if (isset($request->more_comment_check) && $request->more_comment_check == 'true') {
                $custom_comment['document_id'] = $borrower_document['document_id'];
                $custom_comment['borrower_uid'] = $borrower_document['user_id'];
                $custom_comment['comment_id'] = null;
                $custom_comment['custom_comment'] = $request->more_comment_text;
                $custom_comment->save();
            } else {
                $custom_comment->delete();
            }

            $useful_activities_status['status'] = 'rejected';
            $useful_activities_status['checker_id'] = $checker_id;
            $useful_activities_status->save();
        } else {
            UsefulActivitiesComments::where('document_id', $borrower_document['id'])->where('borrower_uid', $borrower_document['user_id'])->delete();
            $useful_activities_status['status'] = 'approved';
            $useful_activities_status['checker_id'] = $checker_id;
            $useful_activities_status->save();
        }

        $borrower_document['checking'] = true;
        $borrower_document['checker_id'] = $checker_id;
        $borrower_document->save();
        return redirect()->route('check_document.borrower_child_document.list',['borrower_document_id' => $borrower_document_id])->with(['success' => 'บันทึกข้อมูลเรียบร้อยแล้ว']);
    }

    public function checkDocumentResult($borrower_document_id, Request $request){
        $checker_id = $request->session()->get('user_id');
        $borrower_document = BorrowerDocument::find($borrower_document_id);
        $useful_activities_status = UsefulActivityStatus::where('document_id', $borrower_document['document_id'])
            ->where('borrower_uid', $borrower_document['user_id'])
            ->first();
        $document = DocTypes::join('documents', 'doc_types.id', '=', 'documents.doctype_id')
            ->where('documents.isactive', true)
            ->where('documents.id', $borrower_document['document_id'])
            ->first();
        $child_documents = DocStructure::join('child_documents', 'doc_structures.child_document_id', '=', 'child_documents.id')
            ->join('borrower_child_documents', 'borrower_child_documents.child_document_id', '=', 'child_documents.id')
            ->where('doc_structures.document_id', $borrower_document['document_id'])
            ->where('borrower_child_documents.user_id', $borrower_document['user_id'])
            ->select(
                'child_documents.id',
                'child_documents.child_document_title as title',
                'borrower_child_documents.id as borrower_child_document_id',
                'borrower_child_documents.status',)
            ->orderBy('child_documents.id', 'asc')
            ->get();
        $borrower = Borrower::join('users', 'users.id', '=', 'borrowers.user_id')
            ->join('faculties', 'faculties.id', '=', 'borrowers.faculty_id')
            ->join('majors', 'majors.id', '=', 'borrowers.major_id')
            ->join('borrower_apprearance_types', 'borrower_apprearance_types.id', '=', 'borrowers.borrower_appearance_id')
            ->where('user_id', $borrower_document['user_id'])
            ->select(
                'users.prefix',
                'users.firstname',
                'users.lastname',
                'borrower_apprearance_types.title',
                'borrowers.user_id',
                'borrowers.birthday',
                'borrowers.student_id',
                'borrowers.phone',
                'borrowers.gpa',
                'borrowers.birthday',
                'faculties.faculty_name',
                'majors.major_name',)
            ->first();
        $list_status = DocStructure::join('child_documents', 'doc_structures.child_document_id', '=', 'child_documents.id')
            ->join('borrower_child_documents', 'borrower_child_documents.child_document_id', '=', 'child_documents.id')
            ->where('doc_structures.document_id', $borrower_document['document_id'])
            ->where('borrower_child_documents.user_id', $borrower_document['user_id'])
            ->where('borrower_child_documents.checker_id', '!=', null)
            ->pluck('borrower_child_documents.status')
            ->toArray();
        
        if($document['need_useful_activity']){
            array_push($list_status, $useful_activities_status['status']);
        } 
        (in_array('rejected', $list_status)) ? $result_status = 'rejected' : $result_status = 'approved' ; 

        foreach($child_documents as $child_document){
            $child_document['comments'] = CommentsBorrowerChildDocument::join('comments', 'comments_borrower_child_documents.comment_id', '=', 'comments.id')
                ->where('comments_borrower_child_documents.borrower_child_document_id', $child_document['borrower_child_document_id'])
                ->where('comments_borrower_child_documents.comment_id', '!=', null)
                ->pluck('comments.comment')->toArray();
            $child_document['custom_comment'] = CommentsBorrowerChildDocument::where('borrower_child_document_id', $child_document['borrower_child_document_id'])
                ->where('comment_id', null)
                ->value('other_comment') ?? null;
        }

        $useful_activities_comments = UsefulActivitiesComments::join('comments', 'comments.id', '=', 'useful_activities_comments.comment_id')
            ->where('useful_activities_comments.document_id', $borrower_document['id'])
            ->where('useful_activities_comments.borrower_uid', $borrower_document['user_id'])
            ->where('useful_activities_comments.comment_id', '!=', null)
            ->pluck('comments.comment')->toArray();
        $useful_activities_custom_comments =  UsefulActivitiesComments::where('document_id', $borrower_document['id'])
            ->where('borrower_uid', $borrower_document['user_id'])
            ->where('comment_id', null)
            ->value('custom_comment') ?? null;

        if($useful_activities_custom_comments != null) array_push($useful_activities_comments, $useful_activities_custom_comments);

        return view(
            'check_document.document_submission',
            compact(
                'document',
                'child_documents',
                'borrower',
                'borrower_document',
                'useful_activities_status',
                'result_status',
                'useful_activities_comments',
            )
        );
    }

    public function submitCheckDocument($borrower_document_id, Request $request){
        $checker_id = $request->session()->get('user_id');
        $borrower_document = BorrowerDocument::find($borrower_document_id);
        $request->validate([
            'status' => 'required|string|max:30',
        ], [
            "status.required" => 'กรุณากรอกคุณสมบัติผู้กู้',
            "status.string" => 'รูปแบบข้อมูลที่ส่งมาไม่ถูกต้อง',
            "status.max" => 'ชื่อของคุณสมบัติผู้กู้ต้องมีความยาวไม่เกิน :max ตัวอักษร',
        ]);
        
        $borrower_document['status'] = $request->status;
        $borrower_document['checker_id'] = $checker_id;
        $borrower_document['checking'] = false;
        $borrower_document['checked_date'] = $this->convertToBuddhistDateTime();
        $borrower_document->save();
    }

    public function viewBorrowerDocument($borrower_document_id, Request $request)
    {
        $borrower_document = BorrowerDocument::find($borrower_document_id);
        $document = DocTypes::join('documents', 'doc_types.id', '=', 'documents.doctype_id')
            ->where('documents.isactive', true)
            ->where('documents.id', $borrower_document['document_id'])
            ->first();
        $useful_activities = UsefulActivity::where('user_id', $borrower_document['user_id'])->get();
        $borrower_useful_activities_hours_sum = UsefulActivity::where('user_id', $borrower_document['user_id'])
            ->where('document_id', $borrower_document['document_id'])
            ->sum('hour_count') ?? 0;
        $useful_activities_hours = Config::where('variable', 'useful_activity_hour')->value('value');
        $child_documents = DocStructure::join('child_documents', 'doc_structures.child_document_id', '=', 'child_documents.id')
            ->where('doc_structures.document_id', $borrower_document['document_id'])
            ->select('child_documents.*')
            ->get();
        $borrower = Borrower::join('users', 'users.id', '=', 'borrowers.user_id')
            ->join('faculties', 'faculties.id', '=', 'borrowers.faculty_id')
            ->join('majors', 'majors.id', '=', 'borrowers.major_id')
            ->join('borrower_apprearance_types', 'borrower_apprearance_types.id', '=', 'borrowers.borrower_appearance_id')
            ->where('user_id', $borrower_document['user_id'])
            ->select(
                'users.prefix',
                'users.firstname',
                'users.lastname',
                'borrower_apprearance_types.title',
                'borrowers.user_id',
                'borrowers.birthday',
                'borrowers.student_id',
                'borrowers.phone',
                'borrowers.gpa',
                'borrowers.birthday',
                'faculties.faculty_name',
                'majors.major_name',
            )
            ->first();

        foreach ($child_documents as $child_document) {
            $child_document['borrower_child_document'] =  BorrowerFiles::join('borrower_child_documents', 'borrower_files.id', '=', 'borrower_child_documents.borrower_file_id')
                ->where('borrower_child_documents.document_id', $document->id)
                ->where('borrower_child_documents.child_document_id', $child_document['id'])
                ->where('borrower_child_documents.user_id', $borrower_document['user_id'])
                ->first();
        }

        return view(
            'check_document.view_documents',
            compact(
                'document',
                'useful_activities',
                'borrower_useful_activities_hours_sum',
                'useful_activities_hours',
                'child_documents',
                'borrower',
                'borrower_document',
            )
        );
    }

    public function previewBorrowerFile($borrower_child_document_id)
    {
        $borrower_child_document = Documents::join('borrower_child_documents', 'documents.id', '=', 'borrower_child_documents.document_id')
            ->where('borrower_child_documents.id', $borrower_child_document_id)
            ->select('borrower_child_documents.document_id', 'borrower_child_documents.child_document_id', 'borrower_child_documents.borrower_file_id')
            ->first();

        $borrower_file = BorrowerFiles::find($borrower_child_document['borrower_file_id']);
        $response = $this->displayFile($borrower_file['file_path'], $borrower_file['file_name']);
        return $response;
    }

    public function generateFile103($borrower_document_id, $borrower_uid)
    {
        $generator = new GenerateFile();
        return $generator->teacherCommentDocument103($borrower_uid, $borrower_document_id);
    }
}
