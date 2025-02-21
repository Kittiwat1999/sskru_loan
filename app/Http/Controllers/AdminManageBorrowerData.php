<?php

namespace App\Http\Controllers;

use App\Exports\BorrowerExcel;
use App\Imports\ImportBorrower;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class AdminManageBorrowerData extends Controller
{
    function convert_to_dmy_date()
    {
        $currentDateTime = Carbon::now();
        return $currentDateTime->format('d-m-Y');
    }

    public function index() 
    {
        return view('admin/borrowers_data');     
    }

    public function exportBorrowers(Request $request)
    {
        $beginYear = $request->begin_year;
        $export = new BorrowerExcel($beginYear);
        $fileName = 'รายชื่อผู้กู้ยืมรหัส '. $beginYear .' '. $this->convert_to_dmy_date() . '.xlsx';

        // Generate the file and set custom headers
        return Excel::download($export, $fileName, \Maatwebsite\Excel\Excel::XLSX);
    }

    public function importCsv(Request $request)
    {
        $request->validate([
            'borrower_csv' => 'required|mimes:csv,txt'
        ]);

        Excel::import(new ImportBorrower, $request->file('borrower_csv'));

        return redirect()->back()->with('success', 'CSV Imported Successfully');
    }
}
