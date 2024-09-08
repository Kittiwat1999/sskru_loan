<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use App\Models\BorrowerDocument;
use App\Models\DocTypes;
use App\Models\Documents;
use App\Models\Faculties;
use App\Models\Majors;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Crypt;


class DashboadController extends Controller
{
    protected $status = [
        'sending' => 'ผู้กู้ยืมกำลังดำเนินการ',
        'wait-teacher-comment' => 'รออารจารย์ที่ปรึกษาให้ความเห็น',
        'wait-approve' => 'รออนุมัติ',
        'rejected' => 'ต้องแก้ไข',
        'approved' => 'อนุมัติแล้ว',
        'response-reject' => 'แก้ใขแล้ว',
    ];

    private function convert_date($inputDate)
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

    public function index(Request $request)
    {
        $doc_types = DocTypes::where('isactive', true)->get();
        $faculties = Faculties::where('isactive', true)->get();
        $majors = Majors::where('isactive', true)->get();
        return view('admin.dashboard', compact('doc_types', 'faculties', 'majors'));
    }

    public function geMajorByFacultyId($faculty_id){
        if($faculty_id == '*'){
            $majors = Majors::where('isactive', true)->get();
        }else{
            $majors = Majors::where('faculty_id', $faculty_id)->get();
        }
        return json_encode($majors);
    }

    public function setData(Request $request)
    {
        $validatedData = $request->validate([
            'select_doc_type' => 'required|integer', // assuming doct_type is an integer
            'select_status' => 'required|string|in:approved,rejected,response-reject,sending,wait-approve,wait-teacher-approve', // validating that status is one of the expected values
            'select_year' => 'required|digits:4|integer|min:2567', // assuming year is a 4-digit Thai year
            'select_term' => 'required|integer|in:1,2', // assuming term is either 1 or 2
            'select_grade' => 'nullable|string', // allowing '*' or other string values
            'select_start_date' => 'nullable|date', // allowing null or valid date format
            'select_end_date' => 'nullable|date|after_or_equal:start_date', // allowing null or valid date format, must be after start_date if both are provided
            'select_faculty' => 'nullable|string', // allowing '*' or other string values
            'select_major' => 'nullable|string', // allowing '*' or other string values
        ], [
            'select_doct_type.required' => 'กรุณาเลือกประเภทเอกสาร', // custom Thai error messages as per your preference
            'select_status.required' => 'กรุณาระบุสถานะ',
            'select_year.required' => 'กรุณาระบุปี',
            'select_term.required' => 'กรุณาระบุภาคการศึกษา',
            'select_start_date.date' => 'วันที่เริ่มต้นต้องเป็นวันที่',
            'select_end_date.date' => 'วันที่สิ้นสุดต้องเป็นวันที่',
            'select_end_date.after_or_equal' => 'วันที่สิ้นสุดต้องมากกว่าหรือเท่ากับวันที่เริ่มต้น',
        ]);

        $request->session()->put($validatedData);
        $doc_types = DocTypes::where('isactive', true)->get();
        $faculties = Faculties::where('isactive', true)->get();
        $majors = Majors::where('isactive', true)->get();
        return view('admin.dashboard-post', compact('doc_types', 'faculties', 'majors'));
    }

    function getData(Request $request)
    {
        $sessionData = $request->session()->all();
        $document = Documents::where('doctype_id' ,$sessionData['select_doc_type'])->where('year', $sessionData['select_year'])->where('term', $sessionData['select_term'])->where('isactive', true)->first() ?? null;
        if ($request->ajax()) {
            if ($document == null) {
                return DataTables::of(collect([]))->make(true);  // Return empty data
            }
            $data = $this->queryData($sessionData, $document['id']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('delivered_date', function ($row) {
                    return $this->convert_to_dmy_date($row->delivered_date);
                })
                ->addColumn('fullname', function ($row) {
                    return '<span>'. $row->prefix . $row->firstname . ' ' . $row->lastname. '</span><br/>'. '<span class="text-secondary">' .Crypt::decryptString($row->citizen_id). '</span>';
                })
                ->addColumn('education', function() {
                    return '<span>ปริญญาตรี</span>';
                })
                ->addColumn('grade_term', function($row){
                    return '<span>ชั้นปีที่ '. $this->calculateGrade($row->student_id). '</span><br/>' . 
                            '<span class="text-secondary">ภาคเรียนที่ ' .$row->term. '</span>';
                })
                ->addColumn('faculty_major', function($row){
                    return '<span class="text-dark fw-lighter">' . $row->faculty_name . '</span><br>' .
                            '<span class="text-secondary fw-lighter">' . $row->major_name . '</span>';
                })
                ->addColumn('status', function ($row){
                    if($row->status == 'approved') {
                        return '<span class="text-success">'.$this->status[$row->status].'</span>';
                    }elseif (($row->status == 'wait-approve' || $row->status == 'wait-teacher-approve') || $row->status == 'response-reject'){
                        return '<span class="text-warning">'.$this->status[$row->status].'</span>';
                    }elseif ($row->status == 'rejected'){
                        return '<span class="text-danger">'.$this->status[$row->status].'</span>';
                    }elseif ($row->status == 'sending'){
                        return '<span class="text-secondary">'.$this->status[$row->status].'</span>';
                    }else{
                        return '<span class="text-danger">สถานะเอกสารไม่ถูกต้อง</span>';
                    }
                })
                ->rawColumns(['delivered_date', 'fullname', 'education', 'grade_term', 'faculty_major', 'status'])
                ->make(true);
        }else{
            if ($document == null) {
                return 'document is null';  // Return empty data
            }
            $data = $this->queryData($sessionData, $document['id']);
            return $data;
        }
    }

    public function queryData($sessionData, $document_id){
        // dd($sessionData);
        $query = Users::query()
            ->join('borrowers', 'users.id', '=', 'borrowers.user_id')
            ->join('borrower_documents', 'users.id', '=', 'borrower_documents.user_id')
            ->join('documents', 'documents.id', '=', 'borrower_documents.document_id')
            ->join('faculties', 'borrowers.faculty_id', '=', 'faculties.id')
            ->join('majors', 'borrowers.major_id', '=', 'majors.id');

        if($sessionData['select_grade'] == '*') {
            $query->where('borrowers.student_id', 'like', '%');
        }else{
            $query->where('borrowers.student_id', 'like', $this->getBorrowerBeginYear($sessionData['select_grade']) . '%');
        }

        if($sessionData['select_faculty'] == '*') {
            $query->where('faculties.id', 'like', '%');
        }else {
            $query->where('faculties.id', $sessionData['select_faculty']);
        }

        if($sessionData['select_major'] == '*') {
            $query->where('majors.id', 'like', '%');
        }else {
            $query->where('majors.id', $sessionData['select_major']);
        }

        if($sessionData['select_start_date'] == null && $sessionData['select_end_date'] == null) {
            $query->where('borrower_documents.delivered_date', 'like', '%');
        }elseif ($sessionData['select_start_date'] == null && $sessionData['select_end_date'] !== null) {
            $query->where('borrower_documents.delivered_date', '<', $this->convert_date($sessionData['select_end_date']));
        }elseif ($sessionData['select_start_date'] !== null && $sessionData['select_end_date'] == null) {
            $query->where('borrower_documents.delivered_date', '>', $this->convert_date($sessionData['select_start_date']));
        }elseif ($sessionData['select_start_date'] !== null && $sessionData['select_end_date'] !== null) {
            $query->whereBetween('borrower_documents.delivered_date', [$this->convert_date($sessionData['select_start_date']), $this->convert_date($sessionData['select_end_date'])]);
        }

        $query->where('borrower_documents.status', $sessionData['select_status']);
        $query->where('borrower_documents.document_id', $document_id);
        $query->select(
            'users.prefix', 
            'users.firstname', 
            'users.lastname', 
            'borrowers.student_id', 
            'borrowers.citizen_id', 
            'borrower_documents.id', 
            'borrower_documents.status', 
            'borrower_documents.delivered_date', 
            'faculties.faculty_name', 
            'majors.major_name',
            'documents.term'
        );

        $data = $query->get();
        return $data;
    }
}
