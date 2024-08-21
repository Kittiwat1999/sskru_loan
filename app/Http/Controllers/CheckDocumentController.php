<?php

namespace App\Http\Controllers;

use App\Models\BorrowerDocument;
use App\Models\BorrowerFiles;
use App\Models\Config;
use App\Models\DocStructure;
use App\Models\DocTypes;
use App\Models\Documents;
use App\Models\Faculties;
use App\Models\Majors;
use App\Models\UsefulActivity;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;


class CheckDocumentController extends Controller
{
    protected $status = [
        'sending' => 'ผู้กู้ยืมกำลังดำเนินการ',
        'wait-teacher-comment' => 'รออารจารย์ที่ปรึกษาให้ความเห็น',
        'wait-employee-approve' => 'รออนุมัติ',
        'rejected' => 'ต้องแก้ไข',
        'approved' => 'อนุมัติแล้ว',
        'response-reject' => 'แก้ใขแล้ว',
    ];

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

    private function convert_to_iso_date($inputDate){
        $parsedDate = Carbon::createFromFormat('d-m-Y', $inputDate);
        $isoDate = $parsedDate->format('Y-m-d');

        return $isoDate;
    }

    function convert_to_dmy_date($input_date){
        $currentDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $input_date);
        return $currentDateTime->format('d-m-Y H:i:s');
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

    public function index(){
        $documents = Documents::join('doc_types', 'documents.doctype_id', '=', 'doc_types.id')
            ->where('documents.isactive',true)
            ->select('documents.*', 'doc_types.doctype_title')
            ->orderBy('created_at', 'desc')
            ->get();

        foreach($documents as $document){
            $document['last_access'] = Users::where('id',$document['last_access'])->value('firstname');
        }
        return view('check_document.index',compact('documents'));
    }

    public function selectDocument($document_id, Request $request){
        $request->session()->put([
            'select_status' =>  $request->session()->get('select_status') ?? 'wait-employee-approve',
            'select_faculty' => $request->session()->get('select_faculty') ?? 'all',
            'select_major' => $request->session()->get('select_major') ?? 'all',
            'select_grade' => $request->session()->get('select_grade') ?? 'all',
        ]);
        $document = Documents::join('doc_types', 'documents.doctype_id', '=', 'doc_types.id')
            ->where('documents.isactive',true)
            ->where('documents.id', $document_id)
            ->select('documents.*', 'doc_types.doctype_title')
            ->orderBy('created_at', 'desc')
            ->first();
        $faculties = Faculties::where('isactive', true)->get();
        $majors = Majors::where('isactive', true)->get();
        return view('check_document.select_check_document',compact('document' ,'faculties','majors'));
    }
    public function selectMajorByFacultyId($faculty_id){
        $majors = Majors::where('faculty_id', $faculty_id)->where('isactive', true)->get();
        return json_encode($majors);
    }
    
    public function selectStatusDocument($document_id, Request $request){
        // dd($request);
        $request->session()->put([                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
            'select_status' => $request->status,
            'select_faculty' => $request->faculty ?? 'all',
            'select_major' => $request->major ?? 'all',
            'select_grade' => $request->grade ?? 'all',
        ]);
        return redirect('/check_document/select_document/'.$document_id);
    }

    public function multipleQuery($document_id, $request){
        $select_status = $request->session()->get('select_status','wait-employee-approve');
        $select_faculty = $request->session()->get('select_faculty','all');
        $select_major = $request->session()->get('select_major','all');
        $select_grade = $request->session()->get('select_grade','all');

        if(($select_faculty == 'all' && $select_major == 'all') && $select_grade == 'all'){ //ไม่ได้เลือก คณะ, สาขา, ชั้นปี
            $data = Users::join('borrowers', 'users.id', '=', 'borrowers.user_id')
                ->join('borrower_documents', 'users.id', '=', 'borrower_documents.user_id')
                ->join('documents', 'documents.id', '=', 'borrower_documents.document_id')
                ->join('faculties', 'borrowers.faculty_id', '=', 'faculties.id')
                ->join('majors', 'borrowers.major_id', '=', 'majors.id')
                ->where('documents.id', $document_id)
                ->where('borrower_documents.status', $select_status)
                ->select('users.prefix', 'users.firstname', 'users.lastname', 'borrowers.student_id' ,'borrower_documents.id','borrower_documents.status', 'borrower_documents.delivered_date','faculties.faculty_name', 'majors.major_name')
                ->orderBy('delivered_date', 'asc')
                ->get();
        }else if(($select_faculty != 'all' && $select_major == 'all') && $select_grade == 'all'){  //เลือก คณะ แต่ ไม่ได้เลือก สาขา, ชั้นปี
            $data = Users::join('borrowers', 'users.id', '=', 'borrowers.user_id')
                ->join('borrower_documents', 'users.id', '=', 'borrower_documents.user_id')
                ->join('documents', 'documents.id', '=', 'borrower_documents.document_id')
                ->join('faculties', 'borrowers.faculty_id', '=', 'faculties.id')
                ->join('majors', 'borrowers.major_id', '=', 'majors.id')
                ->where('documents.id', $document_id)
                ->where('borrower_documents.status', $select_status)
                ->where('borrowers.faculty_id', $select_faculty)
                ->select('users.prefix', 'users.firstname', 'users.lastname', 'borrowers.student_id' ,'borrower_documents.id','borrower_documents.status', 'borrower_documents.delivered_date','faculties.faculty_name', 'majors.major_name')
                ->orderBy('delivered_date', 'asc')
                ->get();
        }else if(($select_faculty != 'all' && $select_major != 'all') && $select_grade == 'all'){ //เลือก คณะ , สาขา แต่ ไม่ได้เลือก ชั้นปี
            $data = Users::join('borrowers', 'users.id', '=', 'borrowers.user_id')
                ->join('borrower_documents', 'users.id', '=', 'borrower_documents.user_id')
                ->join('documents', 'documents.id', '=', 'borrower_documents.document_id')
                ->join('faculties', 'borrowers.faculty_id', '=', 'faculties.id')
                ->join('majors', 'borrowers.major_id', '=', 'majors.id')
                ->where('documents.id', $document_id)
                ->where('borrower_documents.status', $select_status)
                ->where('borrowers.faculty_id', $select_faculty)
                ->where('borrowers.major_id', $select_major)
                ->select('users.prefix', 'users.firstname', 'users.lastname', 'borrowers.student_id' ,'borrower_documents.id','borrower_documents.status', 'borrower_documents.delivered_date','faculties.faculty_name', 'majors.major_name')
                ->orderBy('delivered_date', 'asc')
                ->get();
        }else if(($select_faculty != 'all' && $select_major != 'all') && $select_grade != 'all'){ //เลือกทั้ง คณะ, สาขา และ ชั้นปี
            $data = Users::join('borrowers', 'users.id', '=', 'borrowers.user_id')
                ->join('borrower_documents', 'users.id', '=', 'borrower_documents.user_id')
                ->join('documents', 'documents.id', '=', 'borrower_documents.document_id')
                ->join('faculties', 'borrowers.faculty_id', '=', 'faculties.id')
                ->join('majors', 'borrowers.major_id', '=', 'majors.id')
                ->where('documents.id', $document_id)
                ->where('borrower_documents.status', $select_status)
                ->where('borrowers.faculty_id', $select_faculty)
                ->where('borrowers.major_id', $select_major)
                ->where('borrowers.student_id', 'like', $this->getBorrowerBeginYear($select_grade).'%')
                ->select('users.prefix', 'users.firstname', 'users.lastname', 'borrowers.student_id' ,'borrower_documents.id','borrower_documents.status', 'borrower_documents.delivered_date','faculties.faculty_name', 'majors.major_name')
                ->orderBy('delivered_date', 'asc')
                ->get();
        }else if(($select_faculty == 'all' && $select_major != 'all') && $select_grade != 'all'){ //เลือก สาขา, ชั้นปี แต่ ไม่ได้เลือก คณะ
            $data = Users::join('borrowers', 'users.id', '=', 'borrowers.user_id')
                ->join('borrower_documents', 'users.id', '=', 'borrower_documents.user_id')
                ->join('documents', 'documents.id', '=', 'borrower_documents.document_id')
                ->join('faculties', 'borrowers.faculty_id', '=', 'faculties.id')
                ->join('majors', 'borrowers.major_id', '=', 'majors.id')
                ->where('documents.id', $document_id)
                ->where('borrower_documents.status', $select_status)
                ->where('borrowers.major_id', $select_major)
                ->where('borrowers.student_id', 'like', $this->getBorrowerBeginYear($select_grade).'%')
                ->select('users.prefix', 'users.firstname', 'users.lastname', 'borrowers.student_id' ,'borrower_documents.id','borrower_documents.status', 'borrower_documents.delivered_date','faculties.faculty_name', 'majors.major_name')
                ->orderBy('delivered_date', 'asc')
                ->get();
        }else if(($select_faculty == 'all' && $select_major != 'all') && $select_grade == 'all'){ //เลือกเฉพาะสาขา
            $data = Users::join('borrowers', 'users.id', '=', 'borrowers.user_id')
                ->join('borrower_documents', 'users.id', '=', 'borrower_documents.user_id')
                ->join('documents', 'documents.id', '=', 'borrower_documents.document_id')
                ->join('faculties', 'borrowers.faculty_id', '=', 'faculties.id')
                ->join('majors', 'borrowers.major_id', '=', 'majors.id')
                ->where('documents.id', $document_id)
                ->where('borrower_documents.status', $select_status)
                ->where('borrowers.major_id', $select_major)
                ->select('users.prefix', 'users.firstname', 'users.lastname', 'borrowers.student_id' ,'borrower_documents.id','borrower_documents.status', 'borrower_documents.delivered_date','faculties.faculty_name', 'majors.major_name')
                ->orderBy('delivered_date', 'asc')
                ->get();
        }else if(($select_faculty == 'all' && $select_major == 'all') && $select_grade != 'all'){ //เลือกเฉพาะชั้นปี
            $data = Users::join('borrowers', 'users.id', '=', 'borrowers.user_id')
                ->join('borrower_documents', 'users.id', '=', 'borrower_documents.user_id')
                ->join('documents', 'documents.id', '=', 'borrower_documents.document_id')
                ->join('faculties', 'borrowers.faculty_id', '=', 'faculties.id')
                ->join('majors', 'borrowers.major_id', '=', 'majors.id')
                ->where('documents.id', $document_id)
                ->where('borrower_documents.status', $select_status)
                ->where('borrowers.student_id', 'like', $this->getBorrowerBeginYear($select_grade).'%')
                ->select('users.prefix', 'users.firstname', 'users.lastname', 'borrowers.student_id' ,'borrower_documents.id','borrower_documents.status', 'borrower_documents.delivered_date','faculties.faculty_name', 'majors.major_name')
                ->orderBy('delivered_date', 'asc')
                ->get();
        }   
        return $data;

    }

    public function getBorrowerDocuments($document_id, Request $request){
        if ($request->ajax()) {
            $data = $this->multipleQuery($document_id, $request);
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
                    if($row->status == 'wait-employee-approve'){
                        $selectBtn = '<a href="' .route('check.borrower.document', $row->id). '" class="btn btn-primary mt-4">ตรวจเอกสาร</a>';
                    }elseif($row->status == 'sending'){
                        $selectBtn = '<a href="#" class="btn btn-light mt-4">ผู้กู้ยืมกำลังดำเนินการ</a>';
                    }
                    else{
                        $selectBtn = '<a href="' .route('view.borrower.document', $row->id). '" class="btn btn-primary mt-4">ดูเอกสาร</a>';
                    }
                    return $selectBtn;
                })
                ->rawColumns(['information','deliverd_date','action'])
                ->make(true);
        }
    }

    public function showBorrowerDocument($borrower_document_id, Request $request){
        dd($borrower_document_id);
    }

    public function viewBorrowerDocument($borrower_document_id, Request $request){
        $borrower_document = BorrowerDocument::find($borrower_document_id);
        $document = DocTypes::join('documents','doc_types.id','=','documents.doctype_id')
        ->where('documents.isactive',true)
        ->where('documents.id', $borrower_document['document_id'])
        ->first();
        $useful_activities = UsefulActivity::where('user_id', $borrower_document['user_id'])->get();
        $borrower_useful_activities_hours_sum = UsefulActivity::where('user_id', $borrower_document['user_id'])
        ->where('document_id', $borrower_document['document_id'])
        ->sum('hour_count') ?? 0 ;
        $useful_activities_hours = Config::where('variable','useful_activity_hour')->value('value');
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

        return view('check_document.view_documents', 
            compact(
                'document',
                'useful_activities',
                'borrower_useful_activities_hours_sum',
                'useful_activities_hours',
                'child_documents',
            ));
    }

    public function previewBorrowerFile($borrower_child_document_id){
        $user_id = Session::get('user_id','1');
        $borrower_child_document = Documents::join('borrower_child_documents', 'documents.id' ,'=' ,'borrower_child_documents.document_id')
            ->where('borrower_child_documents.id', $borrower_child_document_id)
            ->select('borrower_child_documents.document_id', 'borrower_child_documents.child_document_id', 'borrower_child_documents.borrower_file_id')
            ->first();
        $document = DocTypes::join('documents', 'doc_types.id', '=', 'documents.doctype_id')
            ->where('documents.id', $borrower_child_document['document_id'])
            ->select('doc_types.id', 'documents.year', 'documents.term')
            ->first();

        $borrower_file = BorrowerFiles::find($borrower_child_document['borrower_file_id']);
        $response = $this->displayFile(
            $document['term'] . '-' . $document['year'] 
            .'/' .$document['id']
            .'/'. $borrower_child_document['child_document_id'] 
            .'/' . $user_id
            , $borrower_file['file_name']);

        return $response;
    }

    public function generateFile103(Request $request, $document_id){
        $user_id = $request->session()->get('user_id','1');
        $generator = new GenerateFile();
        return $generator->teacherCommentDocument103($user_id, $document_id);
    }
}
