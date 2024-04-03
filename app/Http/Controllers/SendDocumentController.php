<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

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

    public function sendDocument($document_id){
        // dd($document_id);
        $current_date = Carbon::today()->addYears(543); // Get the current date and time and add year 543 its meen buddhist year
        $document = Documents::find($document_id);

        if($document == null){
            return redirect()->back()->withErrors('ไม่น่ารักเลยนะ');
        }

        if(Carbon::parse($document['end_date']) < $current_date || $current_date < Carbon::parse($document['start_date'])){
            return redirect()->back()->withErrors('เอกสารดังกล่าวได้ปิดรับแล้ว');
        }

        $child_documents = DocStructure::join('child_documents','doc_structures.child_document_id','=','child_documents.id')
            ->where('doc_structures.document_id',$document_id)
            ->get();

        return view('borrower.send_document',compact('document','child_documents'));
    }
}
