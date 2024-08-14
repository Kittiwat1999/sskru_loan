<?php

namespace App\Http\Controllers;

use App\Models\AddOnStructure;
use App\Models\Borrower;
use App\Models\BorrowerChildDocument;
use App\Models\BorrowerFiles;
use App\Models\Config;
use App\Models\DocStructure;
use App\Models\DocTypes;
use App\Models\UsefulActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BorrowerDocumentController extends Controller
{

    private function convertBuddhistDataTime($input_date){
        $updatedAtGregorian = Carbon::parse($input_date);
        $updatedAtBuddhist = $updatedAtGregorian->copy()->addYears(543);
        return $updatedAtBuddhist->format('d-m-Y H:i:s');
    }
    public function index(){
        $user_id = Session::get('user_id','1');
        $borrower_documents = DocTypes::join('documents','doc_types.id','=','documents.doctype_id')
            ->join('borrower_documents','documents.id', '=', 'borrower_documents.document_id')
            ->where('borrower_documents.user_id', $user_id)
            ->where('borrower_documents.status', 'delivered')
            ->orWhere('borrower_documents.status','wait-teacher-comment')
            ->select('documents.year', 'documents.term', 'doc_types.doctype_title','borrower_documents.id', 'borrower_documents.status', 'borrower_documents.delivered_date','borrower_documents.check_date', 'borrower_documents.document_id')
            ->get();
        return view('borrower.documents.index', compact('borrower_documents'));
    }

    public function DocumentPage($document_id){
        $current_date = Carbon::today()->addYears(543);
        $user_id = session()->get('user_id', '1');
        $budhist_date = Carbon::today()->addYears(543); // Get the current date and time and add year 543 its meen buddhist year
        $document = DocTypes::join('documents','doc_types.id','=','documents.doctype_id')
            ->where('documents.isactive',true)
            ->where('documents.id', $document_id)
            ->where('documents.start_date', '<=', $current_date)
            ->where('documents.end_date', '>=', $current_date)
            ->first();
        if($document == null){
            return redirect()->back()->withErrors('ไม่น่ารักเลยนะ');
        }

        if(Carbon::parse($document['end_date']) < $budhist_date || $budhist_date < Carbon::parse($document['start_date'])){
            return redirect()->back()->withErrors('เอกสารดังกล่าวได้ปิดรับแล้ว');
        }

        $borrower_birthday = Borrower::where('user_id',$user_id)->value('birthday');
        $parse_birthday = Carbon::parse($borrower_birthday)->subYears(543);
        $borrower_age = $parse_birthday->age;

        $useful_activities = UsefulActivity::where('user_id',$user_id)->get();
        $borrower_useful_activities_hours_sum = UsefulActivity::where('user_id',$user_id)->where('document_id',$document_id)->sum('hour_count') ?? 0 ;
        $useful_activities_hours = Config::where('variable','useful_activity_hour')->value('value');
        $borrower_child_document_delivered_count = BorrowerChildDocument::where('document_id', $document_id)->count();
        $child_documents = DocStructure::join('child_documents','doc_structures.child_document_id','=','child_documents.id')
            ->where('doc_structures.document_id',$document_id)
            ->where('child_documents.id', '!=' , 4) //กยศ 101 ระบบออกให้
            ->get();
        $child_document_required_count = 0;

        foreach($child_documents as $child_document){
            $child_document['addon_documents'] = AddOnStructure::join('addon_documents','addon_structures.addon_document_id','=','addon_documents.id')
                ->where('addon_structures.child_document_id',$child_document['id'])
                ->get();
            $child_document['borrower_child_document'] =  BorrowerFiles::join('borrower_child_documents' ,'borrower_files.id' ,'=', 'borrower_child_documents.borrower_file_id')
                ->where('borrower_child_documents.document_id', $document['id'])
                ->where('borrower_child_documents.child_document_id', $child_document['id'])
                ->where('borrower_child_documents.user_id', $user_id)
                ->first() ?? null ;
            if($child_document['isrequired']) $child_document_required_count += 1;
        }

        // dd($child_document);

        return view('borrower.documents.document_page',
            compact(
                'document',
                'child_documents',
                'borrower_age',
                'useful_activities',
                'borrower_useful_activities_hours_sum',
                'useful_activities_hours',
                'child_document_required_count',
                'borrower_child_document_delivered_count',
            ));
    }
}
