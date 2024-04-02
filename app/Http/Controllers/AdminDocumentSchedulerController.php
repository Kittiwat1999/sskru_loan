<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Http\Requests\AdminDocumentSchedulerRequest;

use App\Models\DocTypes;
use App\Models\Users;
use App\Models\ChildDocuments;
use App\Models\Config;
use App\Models\DocStructure;
use App\Models\Documents;

class AdminDocumentSchedulerController extends Controller
{

    private function convert_date($inputDate){
        $parsedDate = Carbon::createFromFormat('d-m-Y', $inputDate);
        $isoDate = $parsedDate->format('Y-m-d');

        return $isoDate;

    }

    public function index(){
        $doc_types = DocTypes::where('isactive',true)->get();
        $child_documents = ChildDocuments::where('isactive',true)->get();
        $useful_activity_hour = Config::where('id',1)->value('useful_activity_hour');
        $documents = Documents::where('isactive',true)->get();

        foreach($documents as $document){
            $document['last_access'] = Users::where('id',$document['last_access'])->value('firstname');
            $document['doctype_title'] = DocTypes::where('id',$document['doctype_id'])->value('doctype_title');
        }

        return view('admin.document_scheduler',compact('doc_types','child_documents','useful_activity_hour','documents'));
    }

    public function putDocSchedulerData(AdminDocumentSchedulerRequest $request){
        $user_id = $request->session()->get('user_id','1');

        $document = new Documents();
        $document['doctype_id'] = $request->doctype_id;
        $document['last_access'] = $user_id;
        $document['term'] = $request->term;
        $document['year'] = $request->year;
        $document['start_date'] = $this->convert_date($request->start_date);
        $document['end_date'] = $this->convert_date($request->end_date);
        $document['need_useful_activity'] = filter_var($request->need_useful_activity, FILTER_VALIDATE_BOOLEAN);
        $document['need_teacher_comment'] = filter_var($request->need_teacher_comment, FILTER_VALIDATE_BOOLEAN);
        if($request->description != null)$document['description'] = $request->description;
        $document->save();

        foreach($request->child_documents as $child_document){
            DocStructure::create(['child_document_id'=>$child_document,'document_id'=>$document['id']]);
        }

        return redirect()->back()->with(['success'=>'เพิ่มรายการเอกสารที่ผู้กู้ต้องส่งเรียบร้อยแล้ว']);
    }

    public function getDocumentById($document_id){
        $document = Documents::find($document_id);
        $document['child_document_id'] = DocStructure::where('document_id',$document_id)->pluck('child_document_id')->toArray();

        return json_encode($document);
    }
}
