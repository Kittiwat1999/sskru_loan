<?php

namespace App\Http\Controllers;

use App\Models\AddOnDocument;
use App\Models\AddOnDocumentFile;
use App\Models\AddOnDocumentExampleFile;
use App\Models\AddOnStructure;
use App\Models\ChildDocuments;
use App\Models\ChildDocumentExampleFiles;
use App\Models\ChildDocumentFiles;
use App\Models\Config;
use App\Models\DocTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;


class AdminManageDocumentsController extends Controller
{
    public function manage_documents(Request $request)
    {
        $doc_types = DocTypes::where('isactive', true)->get();
        $useful_activity_hour = Config::where('variable', 'useful_activity_hour')->value('value');
        $child_documents = ChildDocuments::where('isactive', true)->get();
        $addon_documents = AddOnDocument::where('isactive', true)->get();
        return view('admin.manage_documents', compact('doc_types', 'child_documents', 'useful_activity_hour', 'addon_documents'));
    }

    public function manage_documents_file($child_document_id)
    {
        $child_document = ChildDocuments::find($child_document_id);
        $child_document['everyone_files'] = ChildDocumentExampleFiles::where('child_document_id', $child_document['id'])->where('file_for', 'everyone')->select('id', 'description')->get();
        $child_document['minors_file'] = ChildDocumentExampleFiles::where('child_document_id', $child_document['id'])->where('file_for', 'minors')->select('id', 'description')->first();
        $child_document['file_download'] = ChildDocumentFiles::where('child_document_id', $child_document['id'])->select('id')->first();
        return view('admin.manage_document_file', compact('child_document'));
    }

    public function storeChildDocument(Request $request)
    {
        // dd($request);
        $rules = [
            'child_document_title' => 'required|string|max:100',
            'need_loan_balance' => 'required|string',
            'isrequired' => 'required|string',
        ];
        $messages = [
            'child_document_title.required' => 'กรุณากรอกชื่อเอกสาร',
            'child_document_title.string' => 'ชื่อเอกสาร มีรูปแบบข้อมูลไม่ถูกต้อง (string)',
            'child_document_title.max' => 'ชื่อเอกสารต้องมีความยาวไม่เกิน :max ตัวอักษร',
            'need_loan_balance.required' => 'กรุณาระบุว่าต้องการยอดเงินกู้หรือไม่',
            'need_loan_balance.string' => 'ยอดเงินกู้ที่ต้องการ มีรูปแบบข้อมูลไม่ถูกต้อง (string)',
            'isrequired.required' => 'กรุณาระบุว่าต้องการเอกสารหรือไม่',
            'isrequired.string' => 'เอกสารที่ต้องการ มีรูปแบบข้อมูลไม่ถูกต้อง (string)',
        ];
        $request->validate($rules, $messages);
        $child_document = new ChildDocuments();
        $child_document['child_document_title'] = $request->child_document_title;
        $child_document['need_loan_balance'] = filter_var($request->need_loan_balance, FILTER_VALIDATE_BOOLEAN);
        $child_document['isrequired'] = filter_var($request->isrequired, FILTER_VALIDATE_BOOLEAN);
        $child_document['isactive'] = true;
        $child_document->save();
        return redirect()->back()->with(['success' => 'เพิ่มข้อมูลเอกสารเรียบร้อยแล้ว']);
    }

    public function editChildDocument(Request $request, $child_document_id)
    {
        // dd($request);
        $rules = [
            'child_document_title' => 'required|string|max:100',
            'need_loan_balance' => 'required|string',
            'isrequired' => 'required|string',
        ];

        $messages = [
            'child_document_title.required' => 'กรุณากรอกชื่อเอกสาร',
            'child_document_title.string' => 'ชื่อเอกสาร มีรูปแบบข้อมูลไม่ถูกต้อง (string)',
            'child_document_title.max' => 'ชื่อเอกสารต้องมีความยาวไม่เกิน :max ตัวอักษร',
            'need_loan_balance.required' => 'กรุณาระบุว่าต้องการยอดเงินกู้หรือไม่',
            'need_loan_balance.string' => 'ยอดเงินกู้ที่ต้องการ มีรูปแบบข้อมูลไม่ถูกต้อง (string)',
            'isrequired.required' => 'กรุณาระบุว่าต้องการเอกสารหรือไม่',
            'isrequired.string' => 'เอกสารที่ต้องการ มีรูปแบบข้อมูลไม่ถูกต้อง (string)',
        ];
        $request->validate($rules, $messages);
        $child_document = ChildDocuments::find($child_document_id);
        $child_document['child_document_title'] = $request->child_document_title;
        $child_document['need_loan_balance'] = filter_var($request->need_loan_balance, FILTER_VALIDATE_BOOLEAN);
        $child_document['isrequired'] = filter_var($request->isrequired, FILTER_VALIDATE_BOOLEAN);
        $child_document->save();
        return redirect()->back()->with(['success' => 'แก้ใขข้อมูลเอกสาร' . $child_document['child_document_title'] . 'เรียบร้อยแล้ว']);
    }

    public function deleteChildDocument($child_document_id)
    {
        $child_document = ChildDocuments::find($child_document_id);
        $child_document['isactive'] = false;
        $child_document->save();
        return redirect()->back()->with(['success' => 'ลบเอกสาร' . $child_document['child_document_title'] . 'เรียบร้อยแล้ว']);
    }

    public function store_child_document_file(Request $request, $child_document_id)
    {
        // dd($request,$child_document_id);
        $rules = [
            'child_documnet_file' => 'required|file|mimes:jpg,png,jpeg,pdf|max:2048',
        ];
        $messages = [
            'child_documnet_file.required' => 'กรุณาเลือกไฟล์',
            'child_documnet_file.file' => 'ต้องเป็นไฟล์',
            'child_documnet_file.mimes' => 'ไฟล์ที่เลือกต้องเป็นประเภท: jpg, jpeg, png, pdf',
            'child_documnet_file.max' => 'ไฟล์ที่เลือกต้องมีขนาดไม่เกิน :max KB',
        ];
        $request->validate($rules, $messages);
        $child_document_files_path = Config::where('variable', 'child_document_files_path')->value('value');
        $child_document = ChildDocuments::find($child_document_id);
        $child_documnet_file = $request->file('child_documnet_file');
        $file_name = $this->storeFile($child_document_files_path, $child_documnet_file);
        $child_document_file = new ChildDocumentFiles();
        $child_document_file['child_document_id'] = $child_document['id'];
        $child_document_file['description'] = $child_document['child_document_title'];
        $child_document_file['original_name'] = $child_documnet_file->getClientOriginalName();
        $child_document_file['file_path'] = $child_document_files_path;
        $child_document_file['file_name'] = $file_name;
        $child_document_file['file_type'] = last(explode('.', $file_name));
        $child_document_file['full_path'] = $child_document_files_path . '/' . $file_name;
        $child_document_file['upload_date'] = date('Y-m-d');
        $child_document_file->save();
        return redirect()->back()->with(['success' => 'เพิ่มไฟล์สำหรับดาวน์โหลดเสร็จสิ้น']);
    }

    public function update_child_document_generate_file(Request $request, $child_document_id)
    {
        if (isset($request->generate_file)) {
            $child_document = ChildDocuments::find($child_document_id);
            $child_document->generate_file = true;
            $child_document->save();
            return redirect()->back()->with(['success' => 'เปิดใช้งานระบบช่วยกรอกเอกสารสำหรับ ' . $child_document->child_document_title . 'แล้ว']);
        } else {
            $child_document = ChildDocuments::find($child_document_id);
            $child_document->generate_file = false;
            $child_document->save();
            return redirect()->back()->with(['success' => 'ปิดใช้งานระบบช่วยกรอกเอกสารสำหรับ ' . $child_document->child_document_title . 'แล้ว']);
        }
    }

    public function delete_child_document_file($child_document_file_id)
    {
        $child_document_file = ChildDocumentFiles::find($child_document_file_id);
        $this->deleteFile($child_document_file->file_path, $child_document_file->file_name);
        $child_document_file->delete();
        return redirect()->back()->with(['success' => 'ลบไฟล์เสร็จสิ้น']);
    }

    public function store_example_file(Request $request, $child_document_id)
    {
        $rules = [
            'example_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'description' => 'required|string',
        ];
        $messages = [
            'example_file.required' => 'กรุณาเลือกไฟล์ที่ต้องการ',
            'example_file.file' => 'ไฟล์ที่เลือกต้องเป็นไฟล์',
            'example_file.mimes' => 'ไฟล์ที่เลือกต้องเป็นประเภท: jpg, jpeg, png, pdf',
            'example_file.max' => 'ไฟล์ที่เลือกต้องมีขนาดไม่เกิน :max KB',
            'description.required' => 'กรุณากรอกคำอธิบาย',
            'description.string' => 'คำอธิบายต้องเป็นข้อความ',
        ];
        $request->validate($rules, $messages);
        $child_document_example_files_path = Config::where('variable', 'child_document_example_files_path')->value('value');
        $get_example_file = $request->file('example_file');
        $file_name = $this->storeFile($child_document_example_files_path, $get_example_file);
        $example_file = new ChildDocumentExampleFiles();
        $example_file['child_document_id'] = $child_document_id;
        $example_file['description'] = $request->description;
        $example_file['file_for'] = 'everyone';
        $example_file['original_name'] = $get_example_file->getClientOriginalName();
        $example_file['file_path'] = $child_document_example_files_path;
        $example_file['file_name'] = $file_name;
        $example_file['file_type'] = last(explode('.', $file_name));
        $example_file['full_path'] = $child_document_example_files_path . '/' . $file_name;
        $example_file['upload_date'] = date('Y-m-d');
        $example_file->save();
        return redirect()->back()->with(['success' => 'เพิ่มไฟล์ตัวอย่างเสร็จสิ้น']);
    }

    public function stroe_minors_example_file(Request $request, $child_document_id)
    {
        $rules = [
            'example_file' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            'description' => 'required|string',
        ];
        $messages = [
            'example_file.file' => 'ไฟล์ที่เลือกต้องเป็นไฟล์',
            'example_file.mimes' => 'ไฟล์ที่เลือกต้องเป็นประเภท: jpg, jpeg, png, pdf',
            'example_file.max' => 'ไฟล์ที่เลือกต้องมีขนาดไม่เกิน :max KB',
            'description.required' => 'กรุณากรอกคำอธิบาย',
            'description.string' => 'คำอธิบายต้องเป็นข้อความ',
        ];
        $request->validate($rules, $messages);
        $child_document_example_files_path = Config::where('variable', 'child_document_example_files_path')->value('value');
        $get_minors_example_file = $request->file('example_file');
        $file_name = $this->storeFile($child_document_example_files_path, $get_minors_example_file);
        $minors_example_file = new ChildDocumentExampleFiles();
        $minors_example_file['child_document_id'] = $child_document_id;
        $minors_example_file['description'] = $request->description;
        $minors_example_file['original_name'] = $get_minors_example_file->getClientOriginalName();
        $minors_example_file['file_for'] = 'minors';
        $minors_example_file['file_path'] = $child_document_example_files_path;
        $minors_example_file['file_name'] = $file_name;
        $minors_example_file['file_type'] = last(explode('.', $file_name));
        $minors_example_file['full_path'] = $child_document_example_files_path . '/' . $file_name;
        $minors_example_file['upload_date'] = date('Y-m-d');
        $minors_example_file->save();
        return redirect()->back()->with(['success' => 'เพิ่มไฟล์ตัวอย่างเสร็จสิ้น']);
    }

    public function delete_example_file($example_file_id)
    {
        $example_file = ChildDocumentExampleFiles::find($example_file_id);
        $this->deleteFile($example_file->file_path, $example_file->file_name);
        $example_file->delete();
        return redirect()->back()->with(['success' => 'ลบไฟล์เสร็จสิ้น']);
    }



    public function sotoreDocument(Request $request)
    {
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
        return redirect()->back()->with(['success' => 'เพิ่มหนังสือ ' . $doc_type['doctype_title'] . ' เรียบร้อยแล้ว']);
    }

    public function editDocument(Request $request, $doc_type_id)
    {
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
        return redirect()->back()->with(['success' => 'แก้ใขหนังสือจาก ' . $old_doc_type_title . ' เป็น ' . $request->doctype_title . ' เรียบร้อยแล้ว']);
    }

    public function deleteDocument($doc_type_id)
    {
        $doc_type = DocTypes::find($doc_type_id);
        $doc_type['isactive'] = false;
        $doc_type->save();
        return redirect()->back()->with(['success' => 'ลบหนังสือ ' . $doc_type['doctype_title'] . ' เรียบร้อยแล้ว']);
    }

    public function store_addon_document(Request $request)
    {
        $request->validate(
            ['title' => 'required|string'],
            [
                'title.required' => 'ต้องกรอกชื่อเอกสารส่วนเสริม',
                'title.string' => 'ชื่อเอกสารส่วนเสริมต้องเป็นตัวอักษร',
            ]
        );

        $add_on_document = new AddOnDocument();
        $add_on_document->title = $request->title;
        $add_on_document->for_minors = (isset($request->for_minors)) ? true : false;
        $add_on_document->save();
        return redirect()->back()->with(['success' => 'เพิ่มเอกสารส่วนเสริม ' . $add_on_document->title . ' เรียบร้อยแล้ว']);
    }

    public function edit_addon_document(Request $request, $addon_document_id)
    {
        $request->validate(
            ['title' => 'required|string'],
            [
                'title.required' => 'ต้องกรอกชื่อเอกสารส่วนเสริม',
                'title.string' => 'ชื่อเอกสารส่วนเสริมต้องเป็นตัวอักษร',
            ]
        );
        $add_on_document = AddOnDocument::find($addon_document_id);
        $add_on_document->title = $request->title;
        $add_on_document->for_minors = (isset($request->for_minors)) ? true : false;
        $add_on_document->save();
        return redirect()->back()->with(['success' => 'แก้ใขเอกสารส่วนเสริม ' . $add_on_document->title . ' เรียบร้อยแล้ว']);
    }

    public function  delete_addon_document($add_on_document_id)
    {
        $add_on_document = AddOnDocument::find($add_on_document_id);
        $add_on_document->isactive = false;
        $add_on_document->save();
        return redirect()->back()->with(['success' => 'ลบเอกสารส่วนเสริม ' . $add_on_document->title . ' เรียบร้อยแล้ว']);
    }

    public function store_addon_document_file(Request $request, $addon_document_id)
    {
        // dd($request,$addon_document_id);
        $rules = [
            'addon_document_file' => 'required|file|mimes:jpg,png,jpeg,pdf|max:2048',
        ];
        $messages = [
            'addon_document_file.required' => 'กรุณาเลือกไฟล์',
            'addon_document_file.file' => 'ต้องเป็นไฟล์',
            'addon_document_file.mimes' => 'ไฟล์ที่เลือกต้องเป็นประเภท: jpg, jpeg, png, pdf',
            'addon_document_file.max' => 'ไฟล์ที่เลือกต้องมีขนาดไม่เกิน :max KB',
        ];
        $request->validate($rules, $messages);
        $addon_document_files_path = Config::where('variable', 'addon_document_files_path')->value('value');
        $addon_document = AddOnDocument::find($addon_document_id);
        $get_addon_document_file = $request->file('addon_document_file');
        $file_name = $this->storeFile($addon_document_files_path, $get_addon_document_file);
        $addon_document_file = new AddOnDocumentFile();
        $addon_document_file['addon_document_id'] = $addon_document['id'];
        $addon_document_file['description'] = $addon_document['title'];
        $addon_document_file['original_name'] = $get_addon_document_file->getClientOriginalName();
        $addon_document_file['file_path'] = $addon_document_files_path;
        $addon_document_file['file_name'] = $file_name;
        $addon_document_file['file_type'] = last(explode('.', $file_name));
        $addon_document_file['full_path'] = $addon_document_files_path . '/' . $file_name;
        $addon_document_file['upload_date'] = date('Y-m-d');
        $addon_document_file->save();
        return redirect()->back()->with(['success' => 'เพิ่มไฟล์สำหรับดาวน์โหลดเสร็จสิ้น']);
    }

    public function update_addon_document_generate_file(Request $request, $add_on_documnet_file)
    {
        if (isset($request->generate_file)) {
            $addon_document = AddOnDocument::find($add_on_documnet_file);
            $addon_document->generate_file = true;
            $addon_document->save();
            return redirect()->back()->with(['success' => 'เปิดใช้งานระบบช่วยกรอกเอกสารสำหรับ ' . $addon_document->title . 'แล้ว']);
        } else {
            $addon_document = AddOnDocument::find($add_on_documnet_file);
            $addon_document->generate_file = false;
            $addon_document->save();
            return redirect()->back()->with(['success' => 'ปิดใช้งานระบบช่วยกรอกเอกสารสำหรับ ' . $addon_document->title . 'แล้ว']);
        }
    }

    public function delete_addon_document_file($addon_document_file_id)
    {
        $addon_document_file = AddOnDocumentFile::find($addon_document_file_id);
        $this->deleteFile($addon_document_file->file_path, $addon_document_file->file_name);
        $addon_document_file->delete();
        return redirect()->back()->with(['success' => 'ลบไฟล์เสร็จสิ้น']);
    }

    public function store_example_addon_file(Request $request, $addon_document_id)
    {
        $rules = [
            'addon_example_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'description' => 'required|string',
        ];
        $messages = [
            'addon_example_file.required' => 'กรุณาเลือกไฟล์ที่ต้องการ',
            'addon_example_file.file' => 'ไฟล์ที่เลือกต้องเป็นไฟล์',
            'addon_example_file.mimes' => 'ไฟล์ที่เลือกต้องเป็นประเภท: jpg, jpeg, png, pdf',
            'addon_example_file.max' => 'ไฟล์ที่เลือกต้องมีขนาดไม่เกิน :max KB',
            'description.required' => 'กรุณากรอกคำอธิบาย',
            'description.string' => 'คำอธิบายต้องเป็นข้อความ',
        ];
        $request->validate($rules, $messages);
        $addon_document_example_files_path = Config::where('variable', 'addon_document_example_files_path')->value('value');
        $get_addon_example_file = $request->file('addon_example_file');
        $file_name = $this->storeFile($addon_document_example_files_path, $get_addon_example_file);
        $addon_example_file = new AddOnDocumentExampleFile();
        $addon_example_file['addon_document_id'] = $addon_document_id;
        $addon_example_file['description'] = $request->description;
        $addon_example_file['original_name'] = $get_addon_example_file->getClientOriginalName();
        $addon_example_file['file_path'] = $addon_document_example_files_path;
        $addon_example_file['file_name'] = $file_name;
        $addon_example_file['file_type'] = last(explode('.', $file_name));
        $addon_example_file['full_path'] = $addon_document_example_files_path . '/' . $file_name;
        $addon_example_file['upload_date'] = date('Y-m-d');
        $addon_example_file->save();
        return redirect()->back()->with(['success' => 'เพิ่มไฟล์ตัวอย่างเสร็จสิ้น']);
    }

    public function delete_example_addon_file($example_addon_file_id)
    {
        $addon_example_file = AddOnDocumentExampleFile::find($example_addon_file_id);
        $this->deleteFile($addon_example_file->file_path, $addon_example_file->file_name);
        $addon_example_file->delete();
        return redirect()->back()->with(['success' => 'ลบไฟล์เสร็จสิ้น']);
    }

    public function deleteFile($file_path, $file_name)
    {
        $path = public_path($file_path . '/' . $file_name);
        if (File::exists($path)) {
            File::delete($path);
        }
    }

    private function storeFile($file_path, $file)
    {
        $path = public_path($file_path);
        !file_exists($path) && mkdir($path, 0777, true);
        $name = now()->format('Y-m-d_H-i-s') . '_' . $file->getClientOriginalName();
        $file->move($path, $name);
        return $name;
    }

    public function displayFile($file_path, $file_name)
    {
        $path = public_path($file_path . '/' . $file_name);
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }

    public function updateUsefulActivitytHour(Request $request)
    {
        $request->validate(
            ['useful_activity_hour' => 'required'],
            [
                'doctype_title.required' => 'ต้องกรอกชัวโมงกิจกรรมจิตอาสา',
            ]
        );
        $useful_activity_hour = Config::where('variable', 'useful_activity_hour')->first();
        $useful_activity_hour->value = $request->useful_activity_hour;
        $useful_activity_hour->save();
        return redirect()->back()->with(['success' => 'แก้ใขชั่วโมงกิจกรรมจิตอาสาเป็น ' . $request->useful_activity_hour . ' ชั่วโมง เรียบร้อยแล้ว']);
    }

    public function mange_file_page($child_document_id)
    {
        $child_document = ChildDocuments::find($child_document_id);
        $child_document_file = ChildDocumentFiles::where('child_document_id', $child_document_id)->select('id', 'original_name', 'file_path', 'file_type', 'file_name')->first();
        $example_files = ChildDocumentExampleFiles::where('child_document_id', $child_document_id)->where('file_for', 'everyone')->select('id', 'original_name', 'file_path', 'file_type', 'file_name', 'description')->get();
        $minors_example_files = ChildDocumentExampleFiles::where('child_document_id', $child_document_id)->where('file_for', 'minors')->select('id', 'original_name', 'file_path', 'file_type', 'file_name', 'description')->get();
        $addon_documents = AddOnDocument::where('isactive', true)->get();
        $all_addon_id = AddOnDocument::where('isactive', true)->pluck('id')->toArray();
        $child_document_addons = AddOnStructure::join('addon_documents', 'addon_structures.addon_document_id', '=', 'addon_documents.id')
            ->where('addon_structures.child_document_id', $child_document_id)
            ->select('addon_documents.*')
            ->get();
        $child_document_addon_id = AddOnStructure::where('child_document_id', $child_document_id)->pluck('addon_document_id')->toArray();
        return view('admin.manage_file_document', compact('child_document', 'child_document_file', 'example_files', 'minors_example_files', 'addon_documents', 'child_document_addons', 'child_document_addon_id', 'all_addon_id'));
    }

    public function mange_addon_file_page($addon_document_id)
    {
        $addon_document = AddOnDocument::find($addon_document_id);
        $addon_document_file = AddOnDocumentFile::where('addon_document_id', $addon_document_id)->select('id', 'original_name', 'file_path', 'file_type', 'file_name')->first();
        $addon_example_files = AddOnDocumentExampleFile::where('addon_document_id', $addon_document_id)->select('id', 'original_name', 'file_path', 'file_type', 'file_name', 'description')->get();
        return view('admin.manage_file_addon_document', compact('addon_document', 'addon_document_file', 'addon_example_files'));
    }

    public function update_child_document_addon(Request $request, $child_document_id)
    {
        $validate_request = $request->validate(
            [
                'addons' => 'array',
            ],
            [
                'addons.aray' => 'ประเภทข้อมูลไม่ถูกต้อง',
            ]
        );
        if (!isset($request->addons)) $validate_request['addons'] = [];
        $child_document_addon = AddOnStructure::where('child_document_id', $child_document_id)->pluck('addon_document_id')->toArray();
        $addon_to_add = array_diff($validate_request['addons'], $child_document_addon);
        $addon_to_delete = array_diff($child_document_addon, $validate_request['addons']);
        // dd($addon_to_delete);
        foreach ($addon_to_add as $addon_document_id) {
            $addon_structure = new AddOnStructure();
            $addon_structure->child_document_id = $child_document_id;
            $addon_structure->addon_document_id = $addon_document_id;
            $addon_structure->save();
        }
        foreach ($addon_to_delete as $addon_document_id) {
            AddOnStructure::where('addon_document_id', $addon_document_id)->delete();
        }
        return redirect()->back()->with(['success' => 'แก้ใขข้อมูลเอกสารส่วนเสริมเรียบร้อยแลล้ว']);
    }
}
