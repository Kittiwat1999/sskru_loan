<?php

namespace App\Http\Controllers;

use App\Models\AddOnDocumentExampleFile;
use App\Models\AddOnStructure;
use App\Models\Borrower;
use App\Models\BorrowerChildDocument;
use App\Models\BorrowerDocument;
use App\Models\BorrowerFiles;
use App\Models\ChildDocumentExampleFiles;
use Illuminate\Http\Request;
use Carbon\Carbon;
use iio\libmergepdf\Merger;
use App\Models\Documents;
use App\Models\DocStructure;
use App\Models\ChildDocuments;
use App\Models\CommentsBorrowerChildDocument;
use App\Models\Config;
use App\Models\DocTypes;
use App\Models\UsefulActivitiesComments;
use App\Models\UsefulActivity;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use League\CommonMark\Node\Block\Document;

class SendDocumentController extends Controller
{

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

    public function index(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        if (!CheckBorrowerInformation::check($user_id)) {
            return view('borrower/borrower_information_not_complete');
        }
        $current_date = Carbon::today()->addYears(543); // Get the current date and time and add year 543 its meen buddhist year
        $documents = DocTypes::join('documents', 'doc_types.id', '=', 'documents.doctype_id')
            ->where('documents.isactive', true)
            ->where('doc_types.id', '!=', 1)
            ->where('documents.start_date', '<=', $current_date)
            ->where('documents.end_date', '>=', $current_date)
            ->select('documents.*', 'doc_types.doctype_title')
            ->get();
        foreach ($documents as $document) {
            $document['borrower_status'] = BorrowerDocument::where('user_id', $user_id)->where('document_id', $document['id'])->value('status') ?? 'sending';
        }
        // dd($documents);
        return view('borrower.send_document.list_document', compact('documents'));
    }

    public function uploadDocumentPage(Request $request, $document_id)
    {
        $document_id = Crypt::decryptString($document_id);
        $current_date = Carbon::today()->addYears(543);
        $user_id = $request->session()->get('user_id');
        $budhist_date = Carbon::today()->addYears(543); // Get the current date and time and add year 543 its meen buddhist year
        $document = DocTypes::join('documents', 'doc_types.id', '=', 'documents.doctype_id')
            ->where('documents.isactive', true)
            ->where('documents.id', $document_id)
            ->where('documents.start_date', '<=', $current_date)
            ->where('documents.end_date', '>=', $current_date)
            ->first();
        if ($document == null) {
            return redirect()->back()->withErrors('ไม่น่ารักเลยนะ');
        }

        if (Carbon::parse($document['end_date']) < $budhist_date || $budhist_date < Carbon::parse($document['start_date'])) {
            return redirect()->back()->withErrors('เอกสารดังกล่าวได้ปิดรับแล้ว');
        }

        $borrower_birthday = Borrower::where('user_id', $user_id)->value('birthday');
        $parse_birthday = Carbon::parse($borrower_birthday)->subYears(543);
        $borrower_age = $parse_birthday->age;

        $useful_activities = UsefulActivity::where('user_id', $user_id)->get();
        $borrower_useful_activities_hours_sum = UsefulActivity::where('user_id', $user_id)->where('document_id', $document_id)->sum('hour_count') ?? 0;
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
        $borrower_child_document_delivered_count = BorrowerChildDocument::where('document_id', $document_id)->where('user_id', $user_id)->count();
        $child_documents = DocStructure::join('child_documents', 'doc_structures.child_document_id', '=', 'child_documents.id')
            ->where('doc_structures.document_id', $document_id)
            ->get();
        $child_document_required_count = 0;

        foreach ($child_documents as $child_document) {
            $child_document['addon_documents'] = AddOnStructure::join('addon_documents', 'addon_structures.addon_document_id', '=', 'addon_documents.id')
                ->where('addon_structures.child_document_id', $child_document['id'])
                ->get();
            $child_document['borrower_child_document'] =  BorrowerFiles::join('borrower_child_documents', 'borrower_files.id', '=', 'borrower_child_documents.borrower_file_id')
                ->where('borrower_child_documents.document_id', $document['id'])
                ->where('borrower_child_documents.child_document_id', $child_document['id'])
                ->where('borrower_child_documents.user_id', $user_id)
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

        return view(
            'borrower.send_document.upload_document',
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

        $user_id = $request->session()->get('user_id');
        $document = DocTypes::join('documents', 'doc_types.id', '=', 'documents.doctype_id')
            ->where('documents.id', $document_id)
            ->select('doc_types.id', 'documents.year', 'documents.term')
            ->first();
        $child_document_title = ChildDocuments::where('id', $child_document_id)->value('child_document_title');
        $borrower_document = BorrowerDocument::where('user_id', $user_id)->where('document_id', $document_id)->first() ?? new BorrowerDocument();
        $borrower_document['user_id'] = $user_id;
        $borrower_document['document_id'] = $document_id;
        $borrower_document['status'] = 'sending';
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
        $input_file = $request->file('document_file');
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

    public function editDocument($document_id, $child_document_id, Request $request)
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

        $user_id = $request->session()->get('user_id');
        $document = DocTypes::join('documents', 'doc_types.id', '=', 'documents.doctype_id')
            ->where('documents.id', $document_id)
            ->select('doc_types.id', 'documents.year', 'documents.term')
            ->first();
        $child_document_title = ChildDocuments::where('id', $child_document_id)->value('child_document_title');

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
            $file_path = $document['term'] . '-' . $document['year'] . '/' . $document['id'] . '/' . $child_document_id . '/' . $user_id;
            $file_name = $this->storeFile($file_path, $input_file);
            $borrower_file = BorrowerFiles::find($borrower_child_document['borrower_file_id']);
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

    public function previewBorrowerFile(Request $request,$borrower_child_document_id)
    {
        $user_id = $request->session()->get('user_id');
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

    public function result(Request $request, $document_id)
    {
        $user_id = $request->session()->get('user_id');
        $document_id = Crypt::decryptString($document_id);
        $document = DocTypes::join('documents', 'doc_types.id', '=', 'documents.doctype_id')->where('documents.id', $document_id)->first();
        $child_documents = DocStructure::join('child_documents', 'doc_structures.child_document_id', '=', 'child_documents.id')->where('doc_structures.document_id', $document_id)->get();
        $child_document_required_count = 0;

        foreach ($child_documents as $child_document) {
            $child_document['borrower_child_document'] =  BorrowerChildDocument::where('borrower_child_documents.document_id', $document['id'])
                ->where('borrower_child_documents.child_document_id', $child_document['id'])
                ->where('borrower_child_documents.user_id', $user_id)
                ->first() ?? null;

            if ($child_document['isrequired']) $child_document_required_count += 1;
        }

        $borrower_useful_activities_hours_sum = UsefulActivity::where('user_id', $user_id)->where('document_id', $document_id)->sum('hour_count') ?? 0;
        $useful_activities_hours = Config::where('variable', 'useful_activity_hour')->value('value');
        $borrower_child_document_delivered_count = BorrowerChildDocument::where('document_id', $document_id)->where('user_id', $user_id)->count();

        return view(
            'borrower.send_document.document_result',
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

    public function submitDocument(Request $request, $document_id)
    {
        $user_id = $request->session()->get('user_id');
        $document_id = Crypt::decryptString($document_id);
        $document = Documents::find($document_id);
        $borrower_document = BorrowerDocument::where('user_id', $user_id)->where('document_id', $document_id)->first();
        if ($document['neen_teacher_comment']) {
            if ($borrower_document['teacher_status'] == 'rejected') {
                $borrower_document['teacher_status'] = 'response-reject';
            } else {
                $borrower_document['teacher_status'] = 'wait-approve';
                $borrower_document['status'] = 'wait-teacher-approve';
            }
        } else {
            if ($borrower_document['status'] == 'rejected') {
                $borrower_document['status'] = 'response-reject';
            } else {
                $borrower_document['status'] = 'wait-approve';
            }
        }
        $borrower_document['delivered_date'] = $this->convertToBuddhistDateTime();
        $borrower_document->save();

        return redirect('/borrower/borrower_document/index');
    }
}
