<?php

namespace App\Http\Controllers;

use App\Models\BorrowerChildDocument;
use App\Models\BorrowerRegisterType;
use App\Models\Config;
use App\Models\DocStructure;
use App\Models\DocTypes;
use App\Models\UsefulActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BorrowerRegister extends Controller
{
    public function index(Request $request){
        $user_id = $request->session()->get('user_id','1');
        if(!CheckBorrowerInformation::check($user_id)){
            return view('borrower/borrower_information_not_complete');
        }
        $borrower_register_type = BorrowerRegisterType::where('user_id', $user_id)->first();
        return view('borrower.register.index',compact('borrower_register_type'));
    }

    public function storeRegisterType(Request $request){
        $user_id = $request->session()->get('user_id','1');
        $request->validate([
            'register_type' => 'required|string|max:5',
            'times' => 'string|max:5',
        ],[
            "register_type.required" => 'กรุณากรอกคุณสมบัติผู้กู้',
            "register_type.string" => 'รูปแบบข้อมูลที่ส่งมาไม่ถูกต้อง',
            "register_type.max" => 'ชื่อของคุณสมบัติผู้กู้ต้องมีความยาวไม่เกิน :max ตัวอักษร',
            "times.string" => 'รูปแบบข้อมูลที่ส่งมาไม่ถูกต้อง',
            "times.max" => 'ชื่อของคุณสมบัติผู้กู้ต้องมีความยาวไม่เกิน :max ตัวอักษร',
        ]);

        $borrower_register_type = BorrowerRegisterType::where('user_id', $user_id)->first() ?? new BorrowerRegisterType();
        $borrower_register_type['user_id'] = $user_id;
        $borrower_register_type['type_id'] = $request->register_type;
        $borrower_register_type['times'] = $request->times ?? null;
        $borrower_register_type->save();

        return redirect('/borrower/borrower_register/upload_document');
    }

    public function uploadDocument(){

        return view('borrower.register.upload_document');
    }

    public function result($document_id){
        $user_id = Session::get('user_id','1');
        $document = DocTypes::join('documents', 'doc_types.id', '=', 'documents.doctype_id')->where('documents.id', $document_id)->first();
        $child_documents = DocStructure::join('child_documents','doc_structures.child_document_id','=','child_documents.id')->where('doc_structures.document_id',$document_id)->get();
        $child_document_required_count = 0;

        foreach($child_documents as $child_document){
            $child_document['borrower_child_document'] =  BorrowerChildDocument::where('borrower_child_documents.document_id', $document['id'])
                ->where('borrower_child_documents.child_document_id', $child_document['id'])
                ->where('borrower_child_documents.user_id', $user_id)
                ->first() ?? null;

            if($child_document['isrequired']) $child_document_required_count += 1;
        }

        $borrower_useful_activities_hours_sum = UsefulActivity::where('user_id',$user_id)->where('document_id',$document_id)->sum('hour_count') ?? 0 ;
        $useful_activities_hours = Config::where('variable','useful_activity_hour')->value('value');
        $borrower_child_document_delivered_count = BorrowerChildDocument::where('document_id', $document_id)->count();

        return view('borrower.register.document_result',
            compact(
                'document',
                'child_documents',
                'child_document_required_count',
                'borrower_useful_activities_hours_sum',
                'useful_activities_hours',
                'borrower_child_document_delivered_count'
            )
        );
    }

    public function status(){

        return view('borrower.register.status');
    }
}
