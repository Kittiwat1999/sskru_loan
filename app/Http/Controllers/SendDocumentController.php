<?php

namespace App\Http\Controllers;

use App\Models\AddOnDocumentExampleFile;
use App\Models\AddOnStructure;
use App\Models\Borrower;
use App\Models\ChildDocumentExampleFiles;
use Illuminate\Http\Request;
use Carbon\Carbon;
use iio\libmergepdf\Merger;
use iio\libmergepdf\Pages;
use App\Models\Documents;
use App\Models\DocStructure;
use App\Models\ChildDocuments;

class SendDocumentController extends Controller
{
    public function index(){
        $current_date = Carbon::today()->addYears(543); // Get the current date and time and add year 543 its meen buddhist year
        $documents = Documents::join('doc_types','doc_types.id','=','documents.doctype_id')
            ->where('documents.isactive',true)
            ->where('documents.start_date', '<=', $current_date)
            ->where('documents.end_date', '>=', $current_date)
            ->select('documents.*', 'doc_types.doctype_title')
            ->get();

        return view('borrower.list_document',compact('documents'));
    }

    public function upload_document_page($document_id){
        // dd($document_id);
        $user_id = session()->get('user_id','1');
        $budhist_date = Carbon::today()->addYears(543); // Get the current date and time and add year 543 its meen buddhist year
        $document = Documents::find($document_id);
        $borrower_birthday = Borrower::where('user_id',$user_id)->value('birthday');
        $parse_birthday = Carbon::parse($borrower_birthday)->subYears(543);
        $borrower_age = $parse_birthday->age;
        if($document == null){
            return redirect()->back()->withErrors('ไม่น่ารักเลยนะ');
        }

        if(Carbon::parse($document['end_date']) < $budhist_date || $budhist_date < Carbon::parse($document['start_date'])){
            return redirect()->back()->withErrors('เอกสารดังกล่าวได้ปิดรับแล้ว');
        }

        $child_documents = DocStructure::join('child_documents','doc_structures.child_document_id','=','child_documents.id')
            ->where('doc_structures.document_id',$document_id)
            ->get();

        foreach($child_documents as $child_document){
            $child_document['addon_documents'] = AddOnStructure::join('addon_documents','addon_structures.addon_document_id','=','addon_documents.id')
                ->where('addon_structures.child_document_id',$child_document['id'])
                ->get();
            // dd($child_document['addon_documents']);
        }

        return view('borrower.upload_document',compact('document','child_documents','borrower_age'));
    }

    public function mergeExampleFile($child_document_id, $isminors){
        $child_document_example_files = ChildDocumentExampleFiles::where('child_document_id',$child_document_id)->get();
        $addon_document_example_files = AddOnDocumentExampleFile::where('child_document_id',$child_document_id)->get();
        $pdf1 = public_path('pdf/file1.pdf');
        $pdf2 = public_path('pdf/file2.pdf');

        $merger = new Merger();
        $merger->addFile($pdf1);
        $merger->addFile($pdf2);

        $createdPdf = $merger->merge();

        $outputPath = public_path('pdf/merged.pdf');
        file_put_contents($outputPath, $createdPdf);

        return response()->download($outputPath);
    }
}
