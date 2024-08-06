<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Http\Requests\AdminDocumentSchedulerRequest;
use App\Models\AddOnStructure;
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
        $useful_activity_hour = Config::where('variable','useful_activity_hour')->value('value');
        $documents = Documents::where('isactive',true)->orderBy('created_at', 'desc')->get();

        foreach($documents as $document){
            $document['last_access'] = Users::where('id',$document['last_access'])->value('firstname');
            $document['doctype_title'] = DocTypes::where('id',$document['doctype_id'])->value('doctype_title');
        }
        foreach($child_documents as $child_document){
            $child_document['addon_documents'] = AddOnStructure::join('addon_documents','addon_structures.addon_document_id','=','addon_documents.id')
                ->where('addon_structures.child_document_id',$child_document->id)
                ->select('addon_documents.id','addon_documents.title','addon_documents.for_minors',)
                ->get();
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

        foreach($request->child_documents as $child_document_id){
            DocStructure::create(['child_document_id'=>$child_document_id,'document_id'=>$document['id']]);
        }

        return redirect()->back()->with(['success'=>'เพิ่มรายการเอกสารที่ผู้กู้ต้องส่งเรียบร้อยแล้ว']);
    }

    public function getDocumentById($document_id){
        $document = Documents::find($document_id);
        $document['child_document_id'] = DocStructure::where('document_id',$document_id)->pluck('child_document_id')->toArray();
        $document['doctype_title'] = DocTypes::where('id',$document['doctype_id'])->value('doctype_title');
        $child_document['addon_documents'] = AddOnStructure::join('addon_documents','addon_structures.addon_document_id','=','addon_documents.id')
            ->where('addon_structures.child_document_id',$document['id'])
            ->select('addon_documents.id','addon_documents.title','addon_documents.for_minors',)
            ->get();
        return json_encode($document);
    }

    public function postDocSchedulerData(AdminDocumentSchedulerRequest $request,$document_id){
        $user_id = $request->session()->get('user_id','1');

        $document = Documents::find($document_id);
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

        $child_document_inDB = DocStructure::where('document_id',$document_id)->pluck('child_document_id')->toArray();
        $child_document_inREQ = $request->child_documents;

        $child_document_for_delete = array_diff($child_document_inDB,$child_document_inREQ);
        $child_document_for_add = array_diff($child_document_inREQ,$child_document_inDB);

        foreach($child_document_for_delete as $child_document_id){
            Docstructure::where('document_id',$document_id)->where('child_document_id',$child_document_id)->delete();
        }

        foreach($child_document_for_add as $child_document_id){
            DocStructure::create(['child_document_id'=>$child_document_id,'document_id'=>$document_id]);
        }

        return redirect()->back()->with(['success'=>'แก้ใขข้อมูลหนังสือเรียบร้อยแล้ว']);
    }

    public function deleteDocSchedulerData($document_id){
        $document = Documents::find($document_id);
        $document['isactive'] = false;
        $document->save();

        return redirect()->back()->with(['success'=>'ลบข้อมูลหนังสือเรียบร้อยแล้ว']);

    }
}
