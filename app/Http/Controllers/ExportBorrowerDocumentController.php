<?php

namespace App\Http\Controllers;
use App\Exports\BorrowerDocumentExport;
use App\Models\Documents;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ExportBorrowerDocumentController extends Controller
{

    function convert_to_dmy_date()
    {
        $currentDateTime = Carbon::now();
        return $currentDateTime->format('d-m-Y');
    }

    public function exportBorrowerDocument(Request $request)
    {
        $sessionData = $request->session()->get('dashboard_data');
        $document = Documents::join('doc_types', 'documents.doctype_id' , '=', 'doc_types.id')
            ->where('documents.doctype_id' ,$sessionData['doc_type'])
            ->where('documents.year', $sessionData['year'])
            ->where('documents.term', $sessionData['term'])
            ->where('documents.isactive', true)
            ->select(
                'documents.year',
                'documents.term',
                'doc_types.doctype_title',
            )
            ->first() ?? null;
        if($document == null){
            return redirect('/admin/dashboard')->withErrors('ไม่มีข้อมูลสำหรับรายงานนี้');
        }
        $export = new BorrowerDocumentExport($sessionData, $document);

        $fileName = 'รายงาน'. $document['doctype_title']. ' '. $document['term'].'-'.$document['year'] .' '. $this->convert_to_dmy_date() . '.xlsx';

        // Generate the file and set custom headers
        return Excel::download($export, $fileName, \Maatwebsite\Excel\Excel::XLSX);
    }
}
