<?php

namespace App\Http\Controllers;

use App\Models\AddOnStructure;
use App\Models\Borrower;
use App\Models\BorrowerChildDocument;
use App\Models\BorrowerDocument;
use App\Models\BorrowerFiles;
use App\Models\BorrowerRegisterDocument;
use App\Models\BorrowerRegisterType;
use App\Models\ChildDocumentExampleFiles;
use App\Models\ChildDocuments;
use App\Models\CommentsBorrowerChildDocument;
use App\Models\Config;
use App\Models\DocStructure;
use App\Models\DocTypes;
use App\Models\Documents;
use App\Models\RegisterDocument;
use App\Models\RegisterType;
use App\Models\TeacherRejectDocument;
use App\Models\UsefulActivitiesComments;
use App\Models\UsefulActivity;
use App\Models\UsefulActivityStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use iio\libmergepdf\Merger;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;


class BorrowerRegister extends Controller
{

    public static function checkActiveDocument()
    {
        $current_date = Carbon::today()->addYears(543); // Get the current date and time and add year 543 its meen buddhist year

        $document = DocTypes::join('documents', 'doc_types.id', '=', 'documents.doctype_id')
            ->where('doc_types.id', 1)
            ->where('documents.isactive', true)
            ->where('documents.start_date', '<=', $current_date)
            ->where('documents.end_date', '>=', $current_date)
            ->select('documents.*', 'doc_types.doctype_title as doctype_title')
            ->first()
            ??
            BorrowerDocument::join('documents', 'documents.id', '=', 'borrower_documents.document_id')
            ->join('doc_types', 'doc_types.id', '=', 'documents.doctype_id')
            ->where('doc_types.id', 1)
            ->where('documents.isactive', true)
            ->select('documents.*', 'doc_types.doctype_title as doctype_title')
            ->first();

        return $document ?? null;
    }

    public function deleteFile($file_path, $file_name)
    {
        $path = storage_path($file_path . '/' . $file_name);
        if (File::exists($path)) {
            File::delete($path);
        }
    }

    private function storeFile($file_path, $file)
    {
        $path = storage_path($file_path);
        !file_exists($path) && mkdir($path, 0755, true);
        $name = now()->format('Y-m-d_H-i-s') . '_' . $file->getClientOriginalName();
        $file->move($path, $name);
        return $name;
    }

    public function displayFile($file_path, $file_name)
    {
        $path = storage_path($file_path . '/' . $file_name);
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }

    function convertToBuddhistDateTime()
    {
        $currentDateTime = Carbon::now();
        $buddhistDateTime = $currentDateTime->addYears(543);
        return $buddhistDateTime->format('Y-m-d H:i:s');
    }

    function checkStep($document_id, $user_id)
    {
        $child_document_required_count = DocStructure::join('child_documents', 'doc_structures.child_document_id', '=', 'child_documents.id')
            ->where('doc_structures.document_id', $document_id)
            ->where('doc_structures.child_document_id', '!=', 4) //id=4 คือ กยศ 101 ที่ระบบจะออกให้เองผู้กู้ไม้ต้องอัพโหลด
            ->where('doc_structures.child_document_id', '!=', 5) //id=5 คือ กยศ 103 ที่ระบบจะออกให้เองผู้กู้ไม้ต้องอัพโหลด
            ->where('child_documents.isrequired', true)
            ->count();
        $borrower_useful_activities_hours_sum = UsefulActivity::where('user_id', $user_id)->where('document_id', $document_id)->sum('hour_count') ?? 0;
        $useful_activities_hours = Config::where('variable', 'useful_activity_hour')->value('value');
        $borrower_child_document_delivered_count = BorrowerChildDocument::where('document_id', $document_id)->where('user_id', $user_id)->count();
        $registered_document = BorrowerRegisterDocument::where('user_id', $user_id)->exists();
        $delivered_borrower_document = BorrowerDocument::where('user_id', $user_id)
            ->where('document_id', $document_id)
            ->where('status', '!=', 'sending')
            ->exists();
        $borrower_register_type = BorrowerRegisterType::where('user_id', $user_id)->first();
        $step = 1;

        if ($borrower_register_type == null) {
            $step = 1;
        }

        if ($borrower_register_type != null) {
            $step = 2;
        }

        if (((int) $borrower_child_document_delivered_count >= (int) $child_document_required_count) && ((int) $borrower_useful_activities_hours_sum >= (int) $useful_activities_hours)) {
            $step = 3;
        }

        if ($registered_document) {
            $step = 4;
        }

        if ($delivered_borrower_document) {
            $step = 5;
        }
        return $step;
    }

    public function index(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $document = $this->checkActiveDocument();
        if (!CheckBorrowerInformation::check($user_id)) {
            return view('borrower.borrower_information_not_complete');
        }
        if ($document == null) {
            return view('borrower.document_undefined');
        }

        $step = $this->checkStep($document['id'], $user_id);
        // dd($step);
        switch ($step) {
            case 1:
                return $this->registerType($request);
                break;
            case 2:
                return $this->uploadDocumentPage($request);
                break;
            case 3:
                return $this->result($request);
                break;
            case 4:
                return $this->recheckDocument($request);
                break;
            case 5:
                return $this->status($request);
                break;
            default:
                return $this->registerType($request);
        }
    }

    public function registerType(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $document = $this->checkActiveDocument();
        if (!CheckBorrowerInformation::check($user_id)) {
            return view('borrower.borrower_information_not_complete');
        }
        if ($document == null) {
            return view('borrower.document_undefined');
        }

        $borrower_document = BorrowerDocument::where('user_id', $user_id)->where('document_id', $document['id'])->first() ?? null;
        if($borrower_document != null && $borrower_document['status'] == 'approved'){
            return $this->status($request);
        }

        $borrower_register_type = BorrowerRegisterType::where('user_id', $user_id)->first();
        $step = $this->checkStep($document['id'], $user_id);
        return view('borrower.register.register_type', compact('borrower_register_type', 'step'));
    }

    public function storeRegisterType(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        if (!CheckBorrowerInformation::check($user_id)) {
            return view('borrower.borrower_information_not_complete');
        }
        $request->validate([
            'register_type' => 'required|string|max:5',
            'times' => 'string|max:5',
        ], [
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

        return redirect('/borrower/borrower_register/upload_document')->with(['success' => 'บันทึกข้อมูลประเภทผู้กู้แล้ว']);
    }

    public function uploadDocumentPage(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $document = $this->checkActiveDocument();
        if (!CheckBorrowerInformation::check($user_id)) {
            return view('borrower.borrower_information_not_complete');
        }
        if ($document == null) {
            return view('borrower.document_undefined');
        }

        $borrower_document = BorrowerDocument::where('user_id', $user_id)->where('document_id', $document['id'])->first() ?? null;
        if($borrower_document != null && $borrower_document['status'] == 'approved'){
            return $this->status($request);
        }

        $borrower_birthday = Borrower::where('user_id', $user_id)->value('birthday');
        $parse_birthday = Carbon::parse($borrower_birthday)->subYears(543);
        $borrower_age = $parse_birthday->age;

        $useful_activities = UsefulActivity::where('user_id', $user_id)->get();
        $borrower_useful_activities_hours_sum = UsefulActivity::where('user_id', $user_id)->where('document_id', $document->id)->sum('hour_count') ?? 0;
        $useful_activities_hours = Config::where('variable', 'useful_activity_hour')->value('value');
        $useful_activities_comments = UsefulActivitiesComments::join('comments', 'comments.id', '=', 'useful_activities_comments.comment_id')
            ->where('useful_activities_comments.document_id', $document['id'])
            ->where('useful_activities_comments.borrower_uid', $user_id)
            ->where('useful_activities_comments.comment_id', '!=', null)
            ->pluck('comments.comment')->toArray() ?? [];
        $useful_activities_custom_comments =  UsefulActivitiesComments::where('document_id', $document['id'])
            ->where('borrower_uid', $user_id)
            ->where('comment_id', null)
            ->value('custom_comment') ?? null;
        if($useful_activities_custom_comments != null) array_push($useful_activities_comments, $useful_activities_custom_comments);

        $borrower_child_document_delivered_count = BorrowerChildDocument::where('document_id', $document->id)->where('user_id', $user_id)->count();
        $child_documents = DocStructure::join('child_documents', 'doc_structures.child_document_id', '=', 'child_documents.id')
            ->where('doc_structures.document_id', $document->id)
            ->where('doc_structures.child_document_id', '!=', 4) //id=4 คือ กยศ 101 ที่ระบบจะออกให้เองผู้กู้ไม้ต้องอัพโหลด
            ->where('doc_structures.child_document_id', '!=', 5) //id=5 คือ กยศ 103 ที่ระบบจะออกให้เองผู้กู้ไม้ต้องอัพโหลด
            ->get();
        $child_document_required_count = 0;

        foreach ($child_documents as $child_document) {
            $child_document['addon_documents'] = AddOnStructure::join('addon_documents', 'addon_structures.addon_document_id', '=', 'addon_documents.id')
                ->where('addon_structures.child_document_id', $child_document['id'])
                ->get();
            $child_document['borrower_child_document'] =  BorrowerChildDocument::where('document_id', $document->id)
                ->where('child_document_id', $child_document['id'])
                ->where('user_id', $user_id)
                ->first();
            if ($child_document['isrequired']) $child_document_required_count += 1;

            if($child_document['borrower_child_document'] != null){
                $comments = CommentsBorrowerChildDocument::join('comments', 'comments_borrower_child_documents.comment_id', '=', 'comments.id')
                    ->where('comments_borrower_child_documents.borrower_child_document_id', $child_document['borrower_child_document']['id'] )
                    ->where('comments_borrower_child_documents.comment_id', '!=', null)
                    ->pluck('comments.comment')->toArray();
                $custom_comment = CommentsBorrowerChildDocument::where('borrower_child_document_id', $child_document['borrower_child_document']['id'] )
                    ->where('comment_id', null)
                    ->value('other_comment') ?? null;
                if($custom_comment != null) array_push($comments, $custom_comment);
                $child_document['comments'] = $comments;
            }
        }

        $step = $this->checkStep($document['id'], $user_id);

        return view(
            'borrower.register.upload_document',
            compact(
                'document',
                'child_documents',
                'borrower_age',
                'useful_activities',
                'borrower_useful_activities_hours_sum',
                'useful_activities_hours',
                'child_document_required_count',
                'borrower_child_document_delivered_count',
                'useful_activities_comments',
                'step',
            )
        );
    }

    public function mergeExampleFile($child_document_id, $file_for)
    {
        $child_document_example_files = ChildDocumentExampleFiles::where('child_document_id', $child_document_id)->where('file_for', $file_for)->get();
        $addon_document_example_files = AddOnStructure::join('addon_documents', 'addon_structures.addon_document_id', '=', 'addon_documents.id')
            ->join('addon_document_example_files', 'addon_structures.addon_document_id', '=', 'addon_document_example_files.addon_document_id')
            ->where('addon_structures.child_document_id', $child_document_id)
            ->select('addon_documents.for_minors', 'addon_document_example_files.file_name')
            ->get();

        $child_document_example_files_path = Config::where('variable', 'child_document_example_files_path')->value('value');
        $addon_document_example_files_path = Config::where('variable', 'addon_document_example_files_path')->value('value');

        $merger = new Merger();

        foreach ($child_document_example_files as $child_document_example) {
            $file_path = public_path($child_document_example_files_path . '/' . $child_document_example['file_name']);
            $merger->addFile($file_path);
        }

        foreach ($addon_document_example_files as $addon_document_example) {
            if ($file_for != 'minors' && $addon_document_example['for_minors']) continue;
            $file_path = public_path($addon_document_example_files_path . '/' . $addon_document_example['file_name']);
            $merger->addFile($file_path);
        }

        $createdPdf = $merger->merge();

        return response($createdPdf, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="ตัวอย่าง.pdf"')
            ->header('note', 'Files have been merged');
    }

    public function uploadDocument($document_id, $child_document_id, Request $request)
    {

        $rules = [
            'document_file' => 'required|file|mimes:jpg,png,jpeg,pdf|max:2048',
            'document_code' => 'string|max:50',
            'education_fee' => 'string|max:50',
            'living_exprenses' => 'string|max:50',
        ];
        $messages = [
            'document_file.required' => 'กรุณาเลือกไฟล์',
            'document_file.file' => 'ต้องเป็นไฟล์',
            'document_file.mimes' => 'ไฟล์ที่เลือกต้องเป็นประเภท: jpg, jpeg, png, pdf',
            'document_file.max' => 'ไฟล์ที่เลือกต้องมีขนาดไม่เกิน :max KB',

            'document_code.string' => 'ประเภทข้อมูล รหัสเอกสาร นำเข้าไม่ถูกต้อง',
            'document_code.max' => 'ความยาวของ รหัสเอกสาร ต้องไม่เกิน :max',
            'education_fee.string' => 'ประเภทข้อมูล ค่าเล่าเรียน นำเข้าไม่ถูกต้อง',
            'education_fee.max' => 'ความยาวของ ค่าเล่าเรียน ต้องไม่เกิน :max',
            'living_exprenses.string' => 'ประเภทข้อมูล ค่าครองชีพ นำเข้าไม่ถูกต้อง',
            'living_exprenses.max' => 'ความยาวของ ค่าครองชีพ ต้องไม่เกิน :max',
        ];
        $request->validate($rules, $messages);

        $user_id = Session::get('user_id', '1');
        $document = DocTypes::join('documents', 'doc_types.id', '=', 'documents.doctype_id')
            ->where('documents.id', $document_id)
            ->select('doc_types.id', 'documents.year', 'documents.term')
            ->first();
        $child_document_title = ChildDocuments::where('id', $child_document_id)->value('child_document_title');
        $borrower_document = BorrowerDocument::where('user_id', $user_id)->where('document_id', $document_id)->first() ?? new BorrowerDocument();
        $borrower_document['user_id'] = $user_id;
        $borrower_document['document_id'] = $document_id;
        $borrower_document['status'] = $borrower_document['status'] ?? 'sending';
        $borrower_document->save();

        $borrower_child_document = BorrowerChildDocument::where('document_id', $document_id)->where('child_document_id', $child_document_id)->where('user_id', $user_id)->first() ?? new BorrowerChildDocument();
        $borrower_child_document['user_id'] = $user_id;
        $borrower_child_document['document_id'] = $document_id;
        $borrower_child_document['child_document_id'] = $child_document_id;
        $borrower_child_document['education_fee'] = isset($request->education_fee) ? str_replace(',', '', $request->education_fee) : 0;
        $borrower_child_document['living_exprenses'] = isset($request->living_exprenses) ? str_replace(',', '', $request->living_exprenses) : 0;
        $borrower_child_document['document_code'] = isset($request->document_code) ? $request->document_code : '-';
        $borrower_child_document['status'] = 'delivered';
        //file
        $input_file = $request->file('document_file');
        $merger = new Merger(); 
        try {
            $merger->addFile($input_file);
            $merger->merge();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('ไฟล์ PDF ไม่รองรับเทคนิคการบีบอัดนี้ ลองเปลี่ยนเครื่องมือแสกน PDF');
        }

        $file_path = $document['term'] . '-' . $document['year'] . '/' . $document['id'] . '/' . $child_document_id . '/' . $user_id;
        $file_name = $this->storeFile($file_path, $input_file);
        $borrower_file = new BorrowerFiles();
        $borrower_file['user_id'] = $user_id;
        $borrower_file['description'] = '-';
        $borrower_file['original_name'] = $input_file->getClientOriginalName();
        $borrower_file['file_path'] = $file_path;
        $borrower_file['file_name'] = $file_name;
        $borrower_file['file_type'] = last(explode('.', $file_name));
        $borrower_file['full_path'] = $file_path . '/' . $file_name;
        $borrower_file['upload_date'] = date('Y-m-d');
        $borrower_file->save();
        $borrower_child_document['borrower_file_id'] = $borrower_file['id'];
        $borrower_child_document->save();

        return redirect()->back()->with(['success' => 'อัพโหลดไฟล์ ' . $child_document_title . ' เสร็จสิ้น']);
    }

    public function editDocument(Request $request, $document_id, $child_document_id)
    {
        $rules = [
            'document_file' => 'file|mimes:jpg,png,jpeg,pdf|max:2048',
            'document_code' => 'string|max:50',
            'education_fee' => 'string|max:50',
            'living_exprenses' => 'string|max:50',
        ];
        $messages = [
            'document_file.required' => 'กรุณาเลือกไฟล์',
            'document_file.file' => 'ต้องเป็นไฟล์',
            'document_file.mimes' => 'ไฟล์ที่เลือกต้องเป็นประเภท: jpg, jpeg, png, pdf',
            'document_file.max' => 'ไฟล์ที่เลือกต้องมีขนาดไม่เกิน :max KB',

            'document_code.string' => 'ประเภทข้อมูล รหัสเอกสาร นำเข้าไม่ถูกต้อง',
            'document_code.max' => 'ความยาวของ รหัสเอกสาร ต้องไม่เกิน :max',
            'education_fee.string' => 'ประเภทข้อมูล ค่าเล่าเรียน นำเข้าไม่ถูกต้อง',
            'education_fee.max' => 'ความยาวของ ค่าเล่าเรียน ต้องไม่เกิน :max',
            'living_exprenses.string' => 'ประเภทข้อมูล ค่าครองชีพ นำเข้าไม่ถูกต้อง',
            'living_exprenses.max' => 'ความยาวของ ค่าครองชีพ ต้องไม่เกิน :max',
        ];
        $request->validate($rules, $messages);

        $user_id = Session::get('user_id', '1');
        $document = DocTypes::join('documents', 'doc_types.id', '=', 'documents.doctype_id')
            ->where('documents.id', $document_id)
            ->select('doc_types.id', 'documents.year', 'documents.term')
            ->first();
        $child_document_title = ChildDocuments::where('id', $child_document_id)->value('child_document_title');
        $borrower_document = BorrowerDocument::where('user_id', $user_id)->where('document_id', $document_id)->first() ?? new BorrowerDocument();
        $borrower_document['user_id'] = $user_id;
        $borrower_document['document_id'] = $document_id;
        $borrower_document['status'] = $borrower_document['status'] ?? 'sending';
        $borrower_document->save();
        $borrower_child_document = BorrowerChildDocument::where('document_id', $document_id)->where('child_document_id', $child_document_id)->where('user_id', $user_id)->first() ?? new BorrowerChildDocument();
        $borrower_child_document['user_id'] = $user_id;
        $borrower_child_document['document_id'] = $document_id;
        $borrower_child_document['child_document_id'] = $child_document_id;
        $borrower_child_document['education_fee'] = isset($request->education_fee) ? str_replace(',', '', $request->education_fee) : 0;
        $borrower_child_document['living_exprenses'] = isset($request->living_exprenses) ? str_replace(',', '', $request->living_exprenses) : 0;
        $borrower_child_document['document_code'] = isset($request->document_code) ? $request->document_code : '-';
        if($borrower_child_document['status'] != 'approved'){
            if($borrower_child_document['status'] == 'rejected'){
                $borrower_child_document['status'] = 'response-reject';
            }else{
                $borrower_child_document['status'] = 'delivered';
            }
            $borrower_child_document['checker_id'] = null;
        }
        //file
        if ($request->file('document_file') != null) {
            $input_file = $request->file('document_file');
            $merger = new Merger(); 
            try {
                $merger->addFile($input_file);
                $merger->merge();
            } catch (\Exception $e) {
                return redirect()->back()->withErrors('ไฟล์ PDF ไม่รองรับเทคนิคการบีบอัดนี้ ลองเปลี่ยนเครื่องมือแสกน PDF');
            }
            
            $file_path = $document['term'] . '-' . $document['year'] . '/' . $document['id'] . '/' . $child_document_id . '/' . $user_id;
            $file_name = $this->storeFile($file_path, $input_file);
            $borrower_file = BorrowerFiles::find($borrower_child_document['borrower_file_id']) ?? new BorrowerFiles();;
            $this->deleteFile($borrower_file['file_path'], $borrower_file['file_name']);
            $borrower_file['user_id'] = $user_id;
            $borrower_file['description'] = '-';
            $borrower_file['original_name'] = $input_file->getClientOriginalName();
            $borrower_file['file_path'] = $file_path;
            $borrower_file['file_name'] = $file_name;
            $borrower_file['file_type'] = last(explode('.', $file_name));
            $borrower_file['full_path'] = $file_path . '/' . $file_name;
            $borrower_file['upload_date'] = date('Y-m-d');
            $borrower_file->save();
            $borrower_child_document['borrower_file_id'] = $borrower_file['id'];
        }
        $borrower_child_document->save();

        return redirect()->back()->with(['success' => 'แก้ไขไฟล์ ' . $child_document_title . ' เสร็จสิ้น']);
    }

    public function previewBorrowerFile($borrower_child_document_id)
    {
        $user_id = Session::get('user_id', '1');
        $borrower_child_document = Documents::join('borrower_child_documents', 'documents.id', '=', 'borrower_child_documents.document_id')
            ->where('borrower_child_documents.id', $borrower_child_document_id)
            ->select('borrower_child_documents.document_id', 'borrower_child_documents.child_document_id', 'borrower_child_documents.borrower_file_id')
            ->first();
        $document = DocTypes::join('documents', 'doc_types.id', '=', 'documents.doctype_id')
            ->where('documents.id', $borrower_child_document['document_id'])
            ->select('doc_types.id', 'documents.year', 'documents.term')
            ->first();

        $borrower_file = BorrowerFiles::find($borrower_child_document['borrower_file_id']);
        $response = $this->displayFile(
            $document['term'] . '-' . $document['year']
                . '/' . $document['id']
                . '/' . $borrower_child_document['child_document_id']
                . '/' . $user_id,
            $borrower_file['file_name']
        );

        return $response;
    }

    public function result(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $document = $this->checkActiveDocument();
        $marital_status = json_decode(Borrower::where('user_id', $user_id)->value('marital_status'));
        // dd($marital_status);
        if (!CheckBorrowerInformation::check($user_id)) {
            return view('borrower.borrower_information_not_complete');
        }
        if ($document == null) {
            return view('borrower.document_undefined');
        }

        $borrower_document = BorrowerDocument::where('user_id', $user_id)->where('document_id', $document['id'])->first() ?? null;
        if($borrower_document != null && $borrower_document['status'] == 'approved'){
            return $this->status($request);
        }

        $child_document_required_count = 0;
        $child_documents = DocStructure::join('child_documents', 'doc_structures.child_document_id', '=', 'child_documents.id')
            ->where('doc_structures.document_id', $document['id'])
            ->where('doc_structures.child_document_id', '!=', 4) //id=4 คือ กยศ 101 ที่ระบบจะออกให้เองผู้กู้ไม้ต้องอัพโหลด
            ->where('doc_structures.child_document_id', '!=', 5) //id=5 คือ กยศ 103 ที่ระบบจะออกให้เองผู้กู้ไม้ต้องอัพโหลด
            ->get();
        foreach ($child_documents as $child_document) {
            $child_document['borrower_child_document'] =  BorrowerChildDocument::where('borrower_child_documents.document_id', $document['id'])
                ->where('borrower_child_documents.child_document_id', $child_document['id'])
                ->where('borrower_child_documents.user_id', $user_id)
                ->first() ?? null;

            if ($child_document['isrequired']) $child_document_required_count += 1;
        }
        $step = $this->checkStep($document['id'], $user_id);
        $borrower_useful_activities_hours_sum = UsefulActivity::where('user_id', $user_id)->where('document_id', $document->id)->sum('hour_count') ?? 0;
        $useful_activities_hours = Config::where('variable', 'useful_activity_hour')->value('value');
        $register_documents = RegisterDocument::all();
        foreach ($register_documents as $register_document) {
            $register_document['checked'] = BorrowerRegisterDocument::where('register_document_id', $register_document['id'])->where('user_id', $user_id)->exists();
        }
        return view(
            'borrower.register.document_result',
            compact(
                'document',
                'child_documents',
                'child_document_required_count',
                'borrower_useful_activities_hours_sum',
                'useful_activities_hours',
                'register_documents',
                'marital_status',
                'step',
            )
        );
    }

    public function storeBorrowerRegisterDocument(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $document = $this->checkActiveDocument();
        if ($document == null) {
            return view('borrower.document_undefined');
        }
        $rules = [
            'register_document' => 'required',
            'register_document.*' => 'string|max:5',
        ];
        $messages = [
            'register_document.required' => 'กรุณาเลือกไฟล์ที่ส่ง',
            'register_document.*.string' => 'รูปแบบข้อมูลไม่ถุกต้อง',
        ];
        $request->validate($rules, $messages);

        $register_document_Db = BorrowerRegisterDocument::where('user_id', $user_id)->pluck('register_document_id')->toArray();
        $register_document_Req = $request->register_document;

        $register_document_for_delete = array_diff($register_document_Db, $register_document_Req);
        $register_document_for_add = array_diff($register_document_Req, $register_document_Db);

        foreach ($register_document_for_delete as $register_document_id) {
            BorrowerRegisterDocument::where('user_id', $user_id)->where('register_document_id', $register_document_id)->delete();
        }

        foreach ($register_document_for_add as $register_document_id) {
            BorrowerRegisterDocument::create(['user_id' => $user_id, 'register_document_id' => $register_document_id]);
        }
        
        return redirect('/borrower/borrower_register/recheck')->with(['success' => 'บันทึกข้อมูลเสร็จสิ้น']);
    }

    public function recheckDocument(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $document = $this->checkActiveDocument();
        if (!CheckBorrowerInformation::check($user_id)) {
            return view('borrower.borrower_information_not_complete');
        }
        if ($document == null) {
            return view('borrower.document_undefined');
        }

        $borrower_document = BorrowerDocument::where('user_id', $user_id)->where('document_id', $document['id'])->first() ?? null;
        if($borrower_document != null && $borrower_document['status'] == 'approved'){
            return $this->status($request);
        }

        $borrower_child_document_101 = BorrowerChildDocument::where('document_id', $document['id'])->where('user_id', $user_id)->where('child_document_id', 4)->first() ?? null;
        if($borrower_child_document_101 != null){
            $comments = CommentsBorrowerChildDocument::join('comments', 'comments_borrower_child_documents.comment_id', '=', 'comments.id')
                ->where('comments_borrower_child_documents.borrower_child_document_id', $borrower_child_document_101['id'])
                ->where('comments_borrower_child_documents.comment_id', '!=', null)
                ->pluck('comments.comment')->toArray();
            $custom_comment = CommentsBorrowerChildDocument::where('borrower_child_document_id', $borrower_child_document_101['id'])
                ->where('comment_id', null)
                ->value('other_comment') ?? null;
            if($custom_comment != null) array_push($comments, $custom_comment);
            $borrower_child_document_101['comments'] = $comments;
        }

        $borrower_child_document_103 = BorrowerChildDocument::where('document_id', $document['id'])->where('user_id', $user_id)->where('child_document_id', 5)->first() ?? null;
        if($borrower_child_document_103 != null){
            $comments = CommentsBorrowerChildDocument::join('comments', 'comments_borrower_child_documents.comment_id', '=', 'comments.id')
                ->where('comments_borrower_child_documents.borrower_child_document_id', $borrower_child_document_103['id'])
                ->where('comments_borrower_child_documents.comment_id', '!=', null)
                ->pluck('comments.comment')->toArray();
            $custom_comment = CommentsBorrowerChildDocument::where('borrower_child_document_id', $borrower_child_document_103['id'])
                ->where('comment_id', null)
                ->value('other_comment') ?? null;
            if($custom_comment != null) array_push($comments, $custom_comment);
            $borrower_child_document_103['comments'] = $comments;
        }
        
        $child_document = DocStructure::join('child_documents', 'doc_structures.child_document_id', '=', 'child_documents.id')
            ->where('doc_structures.document_id', $document->id)
            ->where('doc_structures.child_document_id', 4) //id=4 คือ กยศ 101 ที่ระบบจะออกให้เองผู้กู้ไม้ต้องอัพโหลด
            ->first();

        $step = $this->checkStep($document['id'], $user_id);
        return view('borrower.register.recheck_document', 
        compact(
            'document', 
            'child_document', 
            'step', 
            'borrower_document',
            'borrower_child_document_103',
            'borrower_child_document_101',
        ));
    }

    public function submitDocument(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $document = $this->checkActiveDocument();
        if (!CheckBorrowerInformation::check($user_id)) {
            return view('borrower.borrower_information_not_complete');
        }
        if ($document == null) {
            return view('borrower.document_undefined');
        }
        $child_document_101 = ChildDocuments::join('child_document_files', 'child_documents.id', '=', 'child_document_files.child_document_id')
            ->where('child_documents.isactive', true)
            ->where('child_documents.id', 4) //id=4 คือ กยศ 101 ที่ระบบจะออกให้เองผู้กู้ไม้ต้องอัพโหลด
            ->select('child_document_files.file_path', 'child_document_files.file_name', 'child_document_files.file_type', 'child_documents.child_document_title', 'child_documents.generate_file', 'child_documents.id')
            ->first();

        $child_document_103 = ChildDocuments::join('child_document_files', 'child_documents.id', '=', 'child_document_files.child_document_id')
            ->where('child_documents.isactive', true)
            ->where('child_documents.id', 5) //id=3 คือ กยศ 103 ที่ระบบจะออกให้เองผู้กู้ไม้ต้องอัพโหลด
            ->select('child_document_files.file_path', 'child_document_files.file_name', 'child_document_files.file_type', 'child_documents.child_document_title', 'child_documents.generate_file', 'child_documents.id')
            ->first();

        $borrower_document = BorrowerDocument::where('user_id', $user_id)->where('document_id', $document->id)->first();
        if ($borrower_document['status'] == 'sending') {
            $this->mergeMaritalFile($document, $user_id);
        }

        //save file
        if ($borrower_document['status'] != 'approved') {
            $generator = new GenerateFile();
            $_101temp_path = $generator->saveBorrowerDocument101($user_id, $child_document_101, $document['id']);
            $this->saveDocument101($document, $user_id, $_101temp_path);
            $_103temp_path = $generator->saveDocument103($user_id, $borrower_document['id']);
            $this->saveDocument103($document, $user_id, $_103temp_path);
        }

        if ($document['need_teacher_comment']) {

            if ($borrower_document['teacher_status'] == null) {
                $borrower_document['teacher_status'] = 'wait-approve';
                $borrower_document['status'] = 'wait-teacher-approve';
            } elseif ($borrower_document['teacher_status'] == 'rejected') {
                $borrower_document['teacher_status'] = 'response-reject';
            } elseif ($borrower_document['teacher_status'] == 'approved'){
                if ($borrower_document['status'] == 'sending') {
                    $borrower_document['status'] = 'wait-approve';
                } elseif ($borrower_document['status'] == 'rejected') {
                    $borrower_document['status'] = 'response-reject';
                }
            }
        } else {
            if ($borrower_document['status'] == 'sending') {
                $borrower_document['status'] = 'wait-approve';
            } elseif ($borrower_document['status'] == 'rejected') {
                $borrower_document['status'] = 'response-reject';
            }
        }
        $borrower_document['delivered_date'] = $this->convertToBuddhistDateTime();
        $borrower_document->save();
        return redirect('/borrower/borrower_register/status')->with(['success' => 'บันทึกข้อมูลเสร็จสิ้น']);
    }

    public function showFile101($document_id, $child_document_id, Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $child_document = ChildDocuments::join('child_document_files', 'child_documents.id', '=', 'child_document_files.child_document_id')
            ->where('child_documents.isactive', true)
            ->where('child_documents.id', $child_document_id)
            ->select('child_document_files.file_path', 'child_document_files.file_name', 'child_document_files.file_type', 'child_documents.child_document_title', 'child_documents.generate_file', 'child_documents.id')
            ->first();
        $generator = new GenerateFile();
        return $generator->borrowerDocument101($user_id, $child_document, $document_id);
    }

    public function generateFile103(Request $request, $borrower_document_id)
    {
        $borrower_uid = $request->session()->get('user_id');
        $generator = new GenerateFile();
        return $generator->teacherCommentDocument103($borrower_uid, $borrower_document_id);
    }

    //save file กยศ 101
    private function saveDocument101($document, $user_id, $temp_path)
    {
        $borrower_child_document = BorrowerChildDocument::where('document_id', $document['id'])->where('child_document_id', 4)->where('user_id', $user_id)->first() ?? new BorrowerChildDocument();
        $borrower_child_document['user_id'] = $user_id;
        $borrower_child_document['document_id'] = $document['id'];
        $borrower_child_document['child_document_id'] = 4;
        $borrower_child_document['education_fee'] = isset($request->education_fee) ? str_replace(',', '', $request->education_fee) : 0;
        $borrower_child_document['living_exprenses'] = isset($request->living_exprenses) ? str_replace(',', '', $request->living_exprenses) : 0;
        if($borrower_child_document['status'] != 'approved'){
            if($borrower_child_document['status'] == 'rejected'){
                $borrower_child_document['status'] = 'response-reject';
            }else{
                $borrower_child_document['status'] = 'delivered';
            }
            $borrower_child_document['checker_id'] = null;
        }

        //file
        $custom_filename = now()->format('Y-m-d_H-i-s') . '_' . 'กยศ 101_' . $user_id . '.pdf';
        $store_path = $document['term'] . '-' . $document['year'] . '/' . $document['doctype_id'] . '/' . 4  . '/' . $user_id;
        $path = storage_path($store_path);
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
        $final_path = $path . '/' . $custom_filename;
        File::move($temp_path, $final_path);
        $borrower_file = BorrowerFiles::find($borrower_child_document['borrower_file_id']) ?? new BorrowerFiles();;
        $this->deleteFile($borrower_file['file_path'], $borrower_file['file_name']);
        $borrower_file['user_id'] = $user_id;
        $borrower_file['description'] = '-';
        $borrower_file['original_name'] = $custom_filename;
        $borrower_file['file_path'] = $store_path;
        $borrower_file['file_name'] = $custom_filename;
        $borrower_file['file_type'] = last(explode('.', $custom_filename));
        $borrower_file['full_path'] = $store_path . '/' . $custom_filename;
        $borrower_file['upload_date'] = date('Y-m-d');
        $borrower_file->save();
        $borrower_child_document['borrower_file_id'] = $borrower_file['id'];
        $borrower_child_document->save();
    }

    private function saveDocument103($document, $user_id, $temp_path)
    {
        $borrower_child_document = BorrowerChildDocument::where('document_id', $document['id'])->where('child_document_id', 5)->where('user_id', $user_id)->first() ?? new BorrowerChildDocument();
        $borrower_child_document['user_id'] = $user_id;
        $borrower_child_document['document_id'] = $document['id'];
        $borrower_child_document['child_document_id'] = 5;
        $borrower_child_document['education_fee'] = isset($request->education_fee) ? str_replace(',', '', $request->education_fee) : 0;
        $borrower_child_document['living_exprenses'] = isset($request->living_exprenses) ? str_replace(',', '', $request->living_exprenses) : 0;
        if($borrower_child_document['status'] != 'approved'){
            if($borrower_child_document['status'] == 'rejected'){
                $borrower_child_document['status'] = 'response-reject';
            }else{
                $borrower_child_document['status'] = 'delivered';
            }
            $borrower_child_document['checker_id'] = null;
        }

        //file
        $custom_filename = now()->format('Y-m-d_H-i-s') . '_' . 'กยศ 103_' . $user_id . '.pdf';
        $store_path = $document['term'] . '-' . $document['year'] . '/' . $document['doctype_id'] . '/' . 5  . '/' . $user_id;
        $path = storage_path($store_path);
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
        $final_path = $path . '/' . $custom_filename;
        File::move($temp_path, $final_path);
        $borrower_file = BorrowerFiles::find($borrower_child_document['borrower_file_id']) ?? new BorrowerFiles();;
        $this->deleteFile($borrower_file['file_path'], $borrower_file['file_name']);
        $borrower_file['user_id'] = $user_id;
        $borrower_file['description'] = '-';
        $borrower_file['original_name'] = $custom_filename;
        $borrower_file['file_path'] = $store_path;
        $borrower_file['file_name'] = $custom_filename;
        $borrower_file['file_type'] = last(explode('.', $custom_filename));
        $borrower_file['full_path'] = $store_path . '/' . $custom_filename;
        $borrower_file['upload_date'] = date('Y-m-d');
        $borrower_file->save();
        $borrower_child_document['borrower_file_id'] = $borrower_file['id'];
        $borrower_child_document->save();
    }

    public function mergeMaritalFile($document, $user_id)
    {
        $marital_status = json_decode(Borrower::where('user_id', $user_id)->value('marital_status'));
        if ($marital_status->status == 'หย่า') {
            $child_document = DocStructure::join('child_documents', 'doc_structures.child_document_id', '=', 'child_documents.id')
                ->where('doc_structures.document_id', $document['id'])
                ->where('doc_structures.child_document_id', '=', 11) //id=11 คือ ไฟล์อื่นๆ
                ->first() ?? null;
            if ($child_document != null) {
                $borrower_child_document =  BorrowerFiles::join('borrower_child_documents', 'borrower_files.id', '=', 'borrower_child_documents.borrower_file_id')
                    ->where('borrower_child_documents.document_id', $document['id'])
                    ->where('borrower_child_documents.child_document_id', $child_document['id'])
                    ->where('borrower_child_documents.user_id', $user_id)
                    ->first() ?? null;
                if ($borrower_child_document != null) {
                    $merger = new Merger();

                    $borrower_child_document_file_path = storage_path($borrower_child_document['file_path'] . '/' . $borrower_child_document['file_name']);
                    $merger->addFile($borrower_child_document_file_path);

                    $marital_status_path = Config::where('variable', 'marital_file_path')->value('value');
                    $marital_file_path = storage_path($marital_status_path . '/' . $user_id . '/' . $marital_status->file_name);
                    $merger->addFile($marital_file_path);

                    $mergedPdf = $merger->merge();
                    $outputFileName = 'merged_' . time() . $user_id . '.pdf';
                    $file_path = 'public/merged/' . $outputFileName;
                    $temp_path = storage_path('app/' . $file_path);
                    Storage::put($file_path, $mergedPdf);
                    $this->moveMegedFile($document, $user_id, $temp_path);
                } else {
                    $marital_status_path = Config::where('variable', 'marital_file_path')->value('value');
                    $marital_file_path = storage_path($marital_status_path . '/' . $user_id . '/' . $marital_status->file_name);
                    $temp_path = storage_path($marital_status_path . '/' . $user_id);
                    $file_name = $marital_status->file_name;
                    $this->copyMaritalFile($document, $user_id, $temp_path, $file_name);
                }
            } else {
                $marital_status_path = Config::where('variable', 'marital_file_path')->value('value');
                $marital_file_path = storage_path($marital_status_path . '/' . $user_id . '/' . $marital_status->file_name);
                $temp_path = storage_path($marital_status_path . '/' . $user_id);
                $file_name = $marital_status->file_name;
                $this->copyMaritalFile($document, $user_id, $temp_path, $file_name);
            }
        }
    }

    public function moveMegedFile($document, $user_id, $temp_path)
    {
        $borrower_child_document = BorrowerChildDocument::where('document_id', $document['id'])->where('child_document_id', 11)->where('user_id', $user_id)->first() ?? new BorrowerChildDocument();
        $borrower_child_document['user_id'] = $user_id;
        $borrower_child_document['document_id'] = $document['id'];
        $borrower_child_document['child_document_id'] = 11;
        $borrower_child_document['education_fee'] = isset($request->education_fee) ? str_replace(',', '', $request->education_fee) : 0;
        $borrower_child_document['living_exprenses'] = isset($request->living_exprenses) ? str_replace(',', '', $request->living_exprenses) : 0;
        if($borrower_child_document['status'] != 'approved'){
            if($borrower_child_document['status'] == 'rejected'){
                $borrower_child_document['status'] = 'response-reject';
            }else{
                $borrower_child_document['status'] = 'delivered';
            }
            $borrower_child_document['checker_id'] = null;
        }

        //file
        $custom_filename = now()->format('Y-m-d_H-i-s') . '_' . 'other_file' . $user_id . '.pdf';
        $store_path = $document['term'] . '-' . $document['year'] . '/' . $document['doctype_id'] . '/' . 11  . '/' . $user_id;
        $path = storage_path($store_path);
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
        $final_path = $path . '/' . $custom_filename;
        File::move($temp_path, $final_path);
        $borrower_file = BorrowerFiles::find($borrower_child_document['borrower_file_id']) ?? new BorrowerFiles();;
        $this->deleteFile($borrower_file['file_path'], $borrower_file['file_name']);
        $borrower_file['user_id'] = $user_id;
        $borrower_file['description'] = '-';
        $borrower_file['original_name'] = $custom_filename;
        $borrower_file['file_path'] = $store_path;
        $borrower_file['file_name'] = $custom_filename;
        $borrower_file['file_type'] = last(explode('.', $custom_filename));
        $borrower_file['full_path'] = $store_path . '/' . $custom_filename;
        $borrower_file['upload_date'] = date('Y-m-d');
        $borrower_file->save();
        $borrower_child_document['borrower_file_id'] = $borrower_file['id'];
        $borrower_child_document->save();
    }

    public function copyMaritalFile($document, $user_id, $temp_path, $file_name)
    {
        $borrower_child_document = BorrowerChildDocument::where('document_id', $document['id'])->where('child_document_id', 11)->where('user_id', $user_id)->first() ?? new BorrowerChildDocument();
        $borrower_child_document['user_id'] = $user_id;
        $borrower_child_document['document_id'] = $document['id'];
        $borrower_child_document['child_document_id'] = 11;
        $borrower_child_document['education_fee'] = isset($request->education_fee) ? str_replace(',', '', $request->education_fee) : 0;
        $borrower_child_document['living_exprenses'] = isset($request->living_exprenses) ? str_replace(',', '', $request->living_exprenses) : 0;
        if($borrower_child_document['status'] != 'approved'){
            if($borrower_child_document['status'] == 'rejected'){
                $borrower_child_document['status'] = 'response-reject';
            }else{
                $borrower_child_document['status'] = 'delivered';
            }
            $borrower_child_document['checker_id'] = null;
        }

        //file
        $custom_filename = now()->format('Y-m-d_H-i-s') . '_' . 'other_file' . $user_id . '.pdf';
        $store_path = $document['term'] . '-' . $document['year'] . '/' . $document['doctype_id'] . '/' . 11  . '/' . $user_id;
        $path = storage_path($store_path);
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
        $final_path = $path . '/' . $custom_filename;
        File::copy($temp_path . '/' . $file_name, $final_path);
        $borrower_file = BorrowerFiles::find($borrower_child_document['borrower_file_id']) ?? new BorrowerFiles();;
        $borrower_file['user_id'] = $user_id;
        $borrower_file['description'] = '-';
        $borrower_file['original_name'] = $custom_filename;
        $borrower_file['file_path'] = $store_path;
        $borrower_file['file_name'] = $custom_filename;
        $borrower_file['file_type'] = last(explode('.', $custom_filename));
        $borrower_file['full_path'] = $store_path . '/' . $custom_filename;
        $borrower_file['upload_date'] = date('Y-m-d');
        $borrower_file->save();
        $borrower_child_document['borrower_file_id'] = $borrower_file['id'];
        $borrower_child_document->save();
    }

    public function status(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $document = $this->checkActiveDocument();
        if (!CheckBorrowerInformation::check($user_id)) {
            return view('borrower.borrower_information_not_complete');
        }
        if ($document == null) {
            return view('borrower.document_undefined');
        }

        $borrower_document = BorrowerDocument::where('user_id', $user_id)->where('document_id', $document['id'])->first();
        $borrower_document['teacher_reject'] = TeacherRejectDocument::where('borrower_document_id', $borrower_document['id'])->value('reject_comment');
        $child_documents = DocStructure::join('child_documents', 'doc_structures.child_document_id', '=', 'child_documents.id')
            ->join('borrower_child_documents', 'borrower_child_documents.child_document_id', '=', 'child_documents.id')
            ->where('doc_structures.document_id', $borrower_document['document_id'])
            ->where('borrower_child_documents.user_id', $borrower_document['user_id'])
            ->where('borrower_child_documents.status', 'rejected')
            ->select(
                'child_documents.id',
                'child_documents.child_document_title as title',
                'borrower_child_documents.id as borrower_child_document_id',
                'borrower_child_documents.status',)
            ->orderBy('child_documents.id', 'asc')
            ->get() ?? [] ;

        foreach($child_documents as $child_document){
            $comments = CommentsBorrowerChildDocument::join('comments', 'comments_borrower_child_documents.comment_id', '=', 'comments.id')
                ->where('comments_borrower_child_documents.borrower_child_document_id', $child_document['borrower_child_document_id'])
                ->where('comments_borrower_child_documents.comment_id', '!=', null)
                ->pluck('comments.comment')->toArray();
            $custom_comment = CommentsBorrowerChildDocument::where('borrower_child_document_id', $child_document['borrower_child_document_id'])
                ->where('comment_id', null)
                ->value('other_comment') ?? null;
            if($custom_comment != null) array_push($comments, $custom_comment);
            $child_document['comments'] = $comments;
        }

        $useful_activities_comments = UsefulActivitiesComments::join('comments', 'comments.id', '=', 'useful_activities_comments.comment_id')
            ->where('useful_activities_comments.document_id', $borrower_document['document_id'])
            ->where('useful_activities_comments.borrower_uid', $borrower_document['user_id'])
            ->where('useful_activities_comments.comment_id', '!=', null)
            ->pluck('comments.comment')->toArray() ?? [];
        $useful_activities_custom_comments =  UsefulActivitiesComments::where('document_id', $borrower_document['document_id'])
            ->where('borrower_uid', $borrower_document['user_id'])
            ->where('comment_id', null)
            ->value('custom_comment') ?? null;

        if($useful_activities_custom_comments != null) array_push($useful_activities_comments, $useful_activities_custom_comments);

        $step = $this->checkStep($document['id'], $user_id);
        return view('borrower.register.status', 
            compact(
                'step', 
                'document', 
                'borrower_document',
                'child_documents',
                'useful_activities_comments',
            ));
    }
    
}
