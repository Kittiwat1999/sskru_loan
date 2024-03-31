<?php

namespace App\Http\Controllers;

use App\Models\ChildDocuments;
use App\Models\ChildDocumentFiles;
use App\Models\Config;
use App\Models\DocTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;


class AdminManageDocumentsController extends Controller
{
    private $child_document_file_path = "app/public/child_document_files/";

    public function manage_documents(Request $request){
        $doc_types = DocTypes::where('isactive',true)->get();
        $child_documents = ChildDocuments::where('isactive',true)->get();
        $useful_activity_hour = Config::where('id',1)->value('useful_activity_hour');

        foreach($child_documents as $child_document){
            $child_document['everyone_files'] = ChildDocumentFiles::where('child_document_id',$child_document['id'])->where('file_for','everyone')->select('id','description')->get();
            $child_document['minors_file'] = ChildDocumentFiles::where('child_document_id',$child_document['id'])->where('file_for','minors')->select('id','description')->first();
        }
        return view('admin.manage_documents',compact('doc_types','child_documents','useful_activity_hour'));
    }

    public function storeDocument(Request $request){

        // dd($request);
        $rules = [
            'child_document_title' => 'required|string|max:100',
            'need_loan_balance' => 'required|string',
            'file_everyone.*' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'description.*' => 'required',
            'file_minors' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
        
        $messages = [
            'child_document_title.required' => 'กรุณากรอกชื่อเอกสาร',
            'child_document_title.string' => 'ชื่อเอกสารต้องเป็นข้อความ',
            'child_document_title.max' => 'ชื่อเอกสารต้องมีความยาวไม่เกิน :max ตัวอักษร',
            'need_loan_balance.required' => 'กรุณากรอกยอดเงินกู้ที่ต้องการ',
            'need_loan_balance.string' => 'ยอดเงินกู้ที่ต้องการต้องเป็นข้อความ',
            'file_everyone.*.required' => 'กรุณาเลือกไฟล์ที่ต้องการ',
            'file_everyone.*.file' => 'ไฟล์ที่เลือกต้องเป็นไฟล์',
            'file_everyone.*.mimes' => 'ไฟล์ที่เลือกต้องเป็นประเภท: jpg, jpeg, png, pdf',
            'file_everyone.*.max' => 'ไฟล์ที่เลือกต้องมีขนาดไม่เกิน :max KB',
            'description.*.required' => 'กรุณากรอกคำอธิบาย',
            'file_minors.file' => 'ไฟล์ที่เลือกต้องเป็นไฟล์',
            'file_minors.mimes' => 'ไฟล์ที่เลือกต้องเป็นประเภท: jpg, jpeg, png, pdf',
            'file_minors.max' => 'ไฟล์ที่เลือกต้องมีขนาดไม่เกิน :max KB',
        ];
        
        $request->validate($rules,$messages);

        $child_document = new ChildDocuments();
        $child_document['child_document_title'] = $request->child_document_title;
        $child_document['need_loan_balance'] = filter_var($request->need_loan_balance, FILTER_VALIDATE_BOOLEAN);
        $child_document['isactive'] = true;
        $child_document->save();

        $file_everyone = $request->file('file_everyone');
        $file_everyone_description = $request->description;

        if(count($file_everyone) !== count($file_everyone_description)){
            return back()->withErrors('คำอธิบายตัวอย่างไฟล์กับไฟล์ไม่สอดคล้องกัน คุณอาจกรอกข้อมูลไม่ครบถ้วน');
        }

        for($i = 0; $i < count($file_everyone); $i++){
            $file_name = $this->storeFile($file_everyone[$i]);
            $child_document_file = new ChildDocumentFiles();
            $child_document_file['child_document_id'] = $child_document['id'];
            $child_document_file['description'] = $file_everyone_description[$i];
            $child_document_file['file_for'] = 'everyone';
            $child_document_file['original_name'] = $file_everyone[$i]->getClientOriginalName();
            $child_document_file['file_path'] = $this->child_document_file_path;
            $child_document_file['file_name'] = $file_name;
            $child_document_file['file_type'] = last(explode('.', $file_name));
            $child_document_file['full_path'] = $this->child_document_file_path.$file_name;
            $child_document_file['upload_date'] = date('Y-m-d');
            $child_document_file->save();
            
        }

        if($request->hasFile('file_minors')){
            $file_minors = $request->file('file_minors');
            $file_name = $this->storeFile($file_minors);
            $child_document_file = new ChildDocumentFiles();
            $child_document_file['child_document_id'] = $child_document['id'];
            $child_document_file['description'] = 'ตัวอย่างเอกสารสำหรับผู้มีอายุต่ำกว่า 20 ปี';
            $child_document_file['original_name'] = $file_minors->getClientOriginalName();
            $child_document_file['file_for'] = 'minors';
            $child_document_file['file_path'] = $this->child_document_file_path;
            $child_document_file['file_name'] = $file_name;
            $child_document_file['file_type'] = last(explode('.', $file_name));
            $child_document_file['full_path'] = $this->child_document_file_path.$file_name;
            $child_document_file['upload_date'] = date('Y-m-d');
            $child_document_file->save();
            
        }
        return redirect()->back()->with(['success'=>'เพิ่มข้อมูลเอกสารเรียบร้อยแล้ว']);

    }

    public function EditChildDoc(Request $request,$child_document_id){
        // dd($request);
        $rules = [
            'child_document_title' => 'required|string|max:100',
            'need_loan_balance' => 'required|string',
            'file_everyone.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_minors' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
        
        $messages = [
            'child_document_title.required' => 'กรุณากรอกชื่อเอกสาร',
            'child_document_title.string' => 'ชื่อเอกสารต้องเป็นข้อความ',
            'child_document_title.max' => 'ชื่อเอกสารต้องมีความยาวไม่เกิน :max ตัวอักษร',
            'need_loan_balance.required' => 'กรุณากรอกยอดเงินกู้ที่ต้องการ',
            'need_loan_balance.string' => 'ยอดเงินกู้ที่ต้องการต้องเป็นข้อความ',
            'file_everyone.*.file' => 'ไฟล์ที่เลือกต้องเป็นไฟล์',
            'file_everyone.*.mimes' => 'ไฟล์ที่เลือกต้องเป็นประเภท: jpg, jpeg, png, pdf',
            'file_everyone.*.max' => 'ไฟล์ที่เลือกต้องมีขนาดไม่เกิน :max KB',
            'file_minors.file' => 'ไฟล์ที่เลือกต้องเป็นไฟล์',
            'file_minors.mimes' => 'ไฟล์ที่เลือกต้องเป็นประเภท: jpg, jpeg, png, pdf',
            'file_minors.max' => 'ไฟล์ที่เลือกต้องมีขนาดไม่เกิน :max KB',
        ];
        
        $request->validate($rules,$messages);

        $child_document = ChildDocuments::find($child_document_id);
        $child_document['child_document_title'] = $request->child_document_title;
        $child_document['need_loan_balance'] = filter_var($request->need_loan_balance, FILTER_VALIDATE_BOOLEAN);
        $child_document->save();

        if(isset($request->edit_description)){
            foreach($request->edit_description as $id => $description){
                ChildDocumentFiles::where('id',$id)->update(['description'=>$description]);
            }
        }

        if(isset($request->delete_file)){
            foreach($request->delete_file as $delete_file_id){
                $child_document_file_to_delete = ChildDocumentFiles::where('id',$delete_file_id)->first();
                $this->deleteFile($child_document_file_to_delete->file_name);
                $child_document_file_to_delete->delete();
            }
        }

        if($request->file('file_everyone') != null){
            $rules = [
                'file_everyone.*' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'description.*' => 'required',
            ];
            
            $messages = [
                'file_everyone.*.required' => 'กรุณาเลือกไฟล์ที่ต้องการ',
                'file_everyone.*.file' => 'ไฟล์ที่เลือกต้องเป็นไฟล์',
                'file_everyone.*.mimes' => 'ไฟล์ที่เลือกต้องเป็นประเภท: jpg, jpeg, png, pdf',
                'file_everyone.*.max' => 'ไฟล์ที่เลือกต้องมีขนาดไม่เกิน :max KB',
                'description.*.required' => 'กรุณากรอกคำอธิบาย',
            ];

            $request->validate($rules,$messages);

            $file_everyone = $request->file('file_everyone');
            $file_everyone_description = $request->description;

            if(count($file_everyone) !== count($file_everyone_description)){
                return back()->withErrors('คำอธิบายตัวอย่างไฟล์กับไฟล์ไม่สอดคล้องกัน คุณอาจกรอกข้อมูลไม่ครบถ้วน');
            }

            for($i = 0; $i < count($file_everyone); $i++){
                $file_name = $this->storeFile($file_everyone[$i]);
                $child_document_file = new ChildDocumentFiles();
                $child_document_file['child_document_id'] = $child_document_id;
                $child_document_file['description'] = $file_everyone_description[$i];
                $child_document_file['file_for'] = 'everyone';
                $child_document_file['original_name'] = $file_everyone[$i]->getClientOriginalName();
                $child_document_file['file_path'] = $this->child_document_file_path;
                $child_document_file['file_name'] = $file_name;
                $child_document_file['file_type'] = last(explode('.', $file_name));
                $child_document_file['full_path'] = $this->child_document_file_path.$file_name;
                $child_document_file['upload_date'] = date('Y-m-d');
                $child_document_file->save();
            }
        }

        if($request->hasFile('file_minors')){
            $file_minors = $request->file('file_minors');
            $file_name = $this->storeFile($file_minors);
            $child_document_file = new ChildDocumentFiles();
            $child_document_file['child_document_id'] = $child_document_id;
            $child_document_file['description'] = 'ตัวอย่างเอกสารสำหรับผู้มีอายุต่ำกว่า 20 ปี';
            $child_document_file['original_name'] = $file_minors->getClientOriginalName();
            $child_document_file['file_for'] = 'minors';
            $child_document_file['file_path'] = $this->child_document_file_path;
            $child_document_file['file_name'] = $file_name;
            $child_document_file['file_type'] = last(explode('.', $file_name));
            $child_document_file['full_path'] = $this->child_document_file_path.$file_name;
            $child_document_file['upload_date'] = date('Y-m-d');
            $child_document_file->save();
            
        }
        return redirect()->back()->with(['success'=>'แก้ใขข้อมูลเอกสาร'.$child_document['child_document_title'].'เรียบร้อยแล้ว']);

    }

    public function DeleteChildDoc($child_document_id){
        $child_document = ChildDocuments::find($child_document_id);
        $child_document['isactive'] = false;
        $child_document->save();

        return redirect()->back()->with(['success'=>'ลบเอกสาร'.$child_document['child_document_title'].'เรียบร้อยแล้ว']);
    }

    public function sotoreDocType(Request $request){
        $request->validate(
            ['doctype_title' => 'required|string'],
            [
                'doctype_title.required' => 'ต้องกรอกชื่อหนังสือ',
                'doctype_title.string' => 'ชื่อหนังสือต้องเป็นตัวอักษร',
            ]
        );

        $doc_type = new DocTypes();
        $doc_type['doctype_title'] = $request->doctype_title;
        $doc_type->save();

        return redirect()->back()->with(['success'=>'เพิ่มหนังสือ '.$doc_type['doctype_title'].' เรียบร้อยแล้ว']);

    }

    public function editDocType(Request $request,$doc_type_id){
        $request->validate(
            ['doctype_title' => 'required|string'],
            [
                'doctype_title.required' => 'ต้องกรอกชื่อหนังสือ',
                'doctype_title.string' => 'ชื่อหนังสือต้องเป็นตัวอักษร',
            ]
        );

        $doc_type = DocTypes::find($doc_type_id);
        $old_doc_type_title = $doc_type['doctype_title'];
        $doc_type['doctype_title'] = $request->doctype_title;
        $doc_type->save();


        return redirect()->back()->with(['success'=>'แก้ใขหนังสือจาก '.$old_doc_type_title.' เป็น '.$request->doctype_title.' เรียบร้อยแล้ว']);

    }

    public function deleteDocType($doc_type_id){

        $doc_type = DocTypes::find($doc_type_id);
        $doc_type['isactive'] = false;
        $doc_type->save();

        return redirect()->back()->with(['success'=>'ลบหนังสือ '.$doc_type['doctype_title'].' เรียบร้อยแล้ว']);

    }

    public function deleteFile($file)
    {
        $path = storage_path($this->child_document_file_path.$file);

        if (File::exists($path)) {
            File::delete($path);
        } else {
            echo 'File does not exist.';
        }
    }

    private function storeFile($file,)
    {
        $path = storage_path($this->child_document_file_path);

        !file_exists($path) && mkdir($path, 0777, true);

        $name = now()->format('Y-m-d_H-i-s') . '_' . $file->getClientOriginalName();
        $file->move($path, $name);

        return $name;
    }

    public function displayFile($file)
    {
        $path = storage_path($this->child_document_file_path.$file);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function displayfile_page($file_id){
        $file = ChildDocumentFiles::find($file_id);
        return view('admin.display_file',compact('file'));
    }

    public function updateUsefulActivitytHour(Request $request){
        $request->validate(
            ['useful_activity_hour' => 'required'],
            [
                'doctype_title.required' => 'ต้องกรอกชัวโมงกิจกรรมจิตอาสา',
            ]
        );

        Config::where('id',1)->update(['useful_activity_hour'=>$request->useful_activity_hour]);

        return redirect()->back()->with(['success'=>'แก้ใขชั่วโมงกิจกรรมจิตอาสาเป็น '.$request->useful_activity_hour.' ชั่วโมง เรียบร้อยแล้ว']);

    }
}
