<?php

namespace App\Exports;

use App\Models\BorrowerDocument;
use App\Models\Documents;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class BorrowerDocumentExport implements FromCollection, WithMapping, WithHeadings, WithCustomStartCell,WithEvents
{
    protected $sessionData;
    protected $status = [
        'sending' => 'ผู้กู้ยืมกำลังดำเนินการ',
        'wait-teacher-comment' => 'รออารจารย์ที่ปรึกษาให้ความเห็น',
        'wait-approve' => 'รออนุมัติ',
        'rejected' => 'ต้องแก้ไข',
        'approved' => 'อนุมัติแล้ว',
        'response-reject' => 'แก้ใขแล้ว',
    ];
    protected $document;

    public function __construct($sessionData)
    {
        $this->sessionData = $sessionData;
        $this->document = Documents::join('doc_types', 'documents.doctype_id' , '=', 'doc_types.id')
            ->where('documents.doctype_id' ,$sessionData['select_doc_type'])
            ->where('documents.year', $sessionData['select_year'])
            ->where('documents.term', $sessionData['select_term'])
            ->where('documents.isactive', true)
            ->select(
                'documents.year',
                'documents.term',
                'doc_types.doctype_title',
            )
            ->first() ?? null;;
    }

    private function convert_date($inputDate)
    {
        $parsedDate = Carbon::createFromFormat('d-m-Y', $inputDate);
        $isoDate = $parsedDate->format('Y-m-d');
        return $isoDate;
    }

    function convert_date_not_input()
    {
        $currentDateTime = Carbon::now();
        return $currentDateTime->format('d-m-Y');
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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event,) {
                // Add custom titles or headers
                $event->sheet->setCellValue('A1', 'ชื่อเอกสาร');
                $event->sheet->setCellValue('A2', 'สถานะเอกสาร');
                $event->sheet->setCellValue('A3', 'วันที่เรียกราบงาน');
                $event->sheet->setCellValue('B1', 'รายการตรวจสอบ'.$this->document['doctype_title']. ' ' .$this->document['term'].'-'.$this->document['year']);
                $event->sheet->setCellValue('B2', $this->status[$this->sessionData['select_status']]);
                $event->sheet->setCellValue('B3', $this->convert_date_not_input());

                // Format the custom headers
                $event->sheet->getStyle('A1:B2')->getFont()->setBold(true);
                $event->sheet->getStyle('A1:B2')->getFont()->setSize(14);
                $event->sheet->getRowDimension(1)->setRowHeight(25);
            }
        ];
    }

    public function collection()
    {
        return $this->queryData($this->sessionData);
    }

    public function queryData($sessionData){
        $document = Documents::where('doctype_id' ,$sessionData['select_doc_type'])->where('year', $sessionData['select_year'])->where('term', $sessionData['select_term'])->where('isactive', true)->first() ?? null;
        // dd($sessionData);
        $query = Users::query()
            ->join('borrowers', 'users.id', '=', 'borrowers.user_id')
            ->join('borrower_apprearance_types', 'borrowers.borrower_appearance_id', '=', 'borrower_apprearance_types.id')
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
        $query->where('borrower_documents.document_id', $document['id']);
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
            'documents.term',
            'documents.year',
            'borrower_apprearance_types.title as apprearance_type_title',
        );

        $data = $query->get();
        return $data;
    }

    public function map($row): array
    {
        return [
            $this->convert_to_dmy_date($row->delivered_date),
            '-',
            $row->year,
            $row->term,
            'ปริญญาตรี',
            $row->student_id,
            Crypt::decryptString($row->citizen_id),
            $row->prefix.$row->firstname. ' ' .$row->lastname,
            $this->calculateGrade($row->student_id),
            $row->faculty_name,
            $row->major_name,
            $row->apprearance_type_title,
            $this->status[$row->status],
        ];
    }

    public function headings(): array
    {
        return [
            'วันที่ยื่นคำขอ',
            'เลขที่คำขอกู้ยืม',
            'ปีการศึกษา',
            'ภาคเรียน',
            'ระดับการศึกษา',
            'รหัสนักเรียน/นักศึกษา',
            'เลขประจำตัวประชาชน',
            'ชื่อ-นามสกุล',
            'ชั้นปี',
            'คณะ',
            'สาขา',
            'ลักษณะ',
            'สถานะเอกสาร',
        ];
    }

    public function startCell(): string
    {
        return 'A5'; // Start data from cell A3
    }
}
