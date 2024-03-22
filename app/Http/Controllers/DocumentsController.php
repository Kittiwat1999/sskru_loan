<?php

namespace App\Http\Controllers;

use App\Models\ChildDocuments;
use App\Models\DocTypes;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    private $child_document_file_path = "app/public/child_document_files/";

    public function manage_documents(Request $request){
        $doc_types = DocTypes::where('isactive',true)->get();
        $child_documents = ChildDocuments::where('isactive',true)->get();

        return view('admin.manage_documents',compact('doc_types','child_documents'));
    }

    public function storeDocument(Request $request){

        $validated = $request->validate(
            [
                'child_document_title' => 'required|string|max:100',
                'need_loan_balance' => 'required|string',
                
                //file
                'file_everyone.*' => 'requird|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'description.*' => 'required',
                'file_minors' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            ], [
                'child_document_title.required' => 'กรุณากรอกชื่อเอกสารลูกหนี้',
                'child_document_title.string' => 'ชื่อเอกสารลูกหนี้ต้องเป็นข้อความ',
                'child_document_title.max' => 'ชื่อเอกสารลูกหนี้ต้องมีความยาวไม่เกิน :max ตัวอักษร',
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
            ]
        );

        if($validated->fails()){
            return back()->withErrors($validated->errors());
        }

        $child_document = new ChildDocuments();
        $child_document['child_document_title'] = $request->child_ducument_title;
        $child_document['need_loan_balance'] = filter_var($request->need_loan_balance, FILTER_VALIDATE_BOOLEAN);
        $child_document['isactive'] = true;
        $child_document->save();

        $file_everyone = $request->files('file_everyone');
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
            $child_document_file['file_path'] = $child_document_file_path.$file_name;
            $child_document_file['file_name'] = $file_name;
            $child_document_file['file_type'] = $file_everyone[$i]->extension();
            $child_document_file['upload_date'] = date('Y-m-d');
            
        }
        if($request->hasFile('file_minors')){
            $file_minors = $request->file('file_minors');
            $file_name = $this->storeFile($file_minors);
            $child_document_file = new ChildDocumentFiles();
            $child_document_file['child_document_id'] = $child_document['id'];
            $child_document_file['description'] = $file_everyone_description[$i];
            $child_document_file['file_for'] = 'minors';
            $child_document_file['file_path'] = $child_document_file_path.$file_name;
            $child_document_file['file_name'] = $file_name;
            $child_document_file['file_type'] = $file_minors->extension();
            $child_document_file['upload_date'] = date('Y-m-d');
            
        }


        return redirect()->back()->with(['success'=>'เพิ่มข้อมูลเอกสารเรียบร้อยแล้ว']);

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
}
