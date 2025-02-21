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


class BorrowerExcel implements FromCollection, WithMapping, WithHeadings, WithCustomStartCell,WithEvents
{
    protected $beginYear;

    public function __construct($beginYear)
    {
        $this->beginYear = $beginYear;
    }

    public function registerEvents(): array
    {
        return [];
    }

    public function collection()
    {
        return $this->queryData();
    }

    public function queryData(){

        // dd($sessionData);
        $query = Users::query()
            ->join('borrowers', 'users.id', '=', 'borrowers.user_id')
            ->join('borrower_apprearance_types', 'borrowers.borrower_appearance_id', '=', 'borrower_apprearance_types.id')
            ->join('faculties', 'borrowers.faculty_id', '=', 'faculties.id')
            ->join('majors', 'borrowers.major_id', '=', 'majors.id');

        $query->where('borrowers.student_id', 'like', $this->beginYear . '%');

        $query->select(
            'users.prefix', 
            'users.firstname', 
            'users.lastname', 
            'borrowers.id', 
            'borrowers.student_id', 
            'borrowers.citizen_id', 
            'faculties.faculty_name', 
            'majors.major_name',
            'borrower_apprearance_types.title as apprearance_type_title',
        );

        $query->orderBy('borrowers.student_id');

        $data = $query->get();
        return $data;
    }

    public function map($row): array
    {
        return [
            $row->id,
            Crypt::decryptString($row->citizen_id),
            $row->student_id,
            $row->prefix.$row->firstname. ' ' .$row->lastname,
            $row->faculty_name,
            $row->major_name,
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'citizen_id',
            'student_id',
            'full_name',
            'faculty',
            'major'
        ];
    }

    public function startCell(): string
    {
        return 'A1'; // Start data from cell A3
    }
}
