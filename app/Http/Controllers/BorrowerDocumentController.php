<?php

namespace App\Http\Controllers;

use App\Models\AddOnStructure;
use App\Models\Borrower;
use App\Models\BorrowerChildDocument;
use App\Models\BorrowerDocument;
use App\Models\BorrowerFiles;
use App\Models\Config;
use App\Models\DocStructure;
use App\Models\DocTypes;
use App\Models\Documents;
use App\Models\UsefulActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class BorrowerDocumentController extends Controller
{

    private function convertBuddhistDataTime($input_date)
    {
        $updatedAtGregorian = Carbon::parse($input_date);
        $updatedAtBuddhist = $updatedAtGregorian->copy()->addYears(543);
        return $updatedAtBuddhist->format('d-m-Y H:i:s');
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

    public function index()
    {
        $user_id = Session::get('user_id', '1');
        $borrower_documents = DocTypes::join('documents', 'doc_types.id', '=', 'documents.doctype_id')
            ->join('borrower_documents', 'documents.id', '=', 'borrower_documents.document_id')
            ->where('borrower_documents.user_id', $user_id)
            ->select(
                'documents.year',
                'documents.term',
                'doc_types.doctype_title',
                'doc_types.id as doctype_id',
                'borrower_documents.id',
                'borrower_documents.teacher_status',
                'borrower_documents.status',
                'borrower_documents.delivered_date',
                'borrower_documents.checked_date',
                'borrower_documents.document_id'
            )
            ->get();
        return view('borrower.documents.index', compact('borrower_documents'));
    }

    public function viewBorrowerDocument($borrower_document_id, Request $request)
    {
        $borrower_document_id = Crypt::decryptString($borrower_document_id);
        $borrower_document = BorrowerDocument::find($borrower_document_id);
        $document = DocTypes::join('documents', 'doc_types.id', '=', 'documents.doctype_id')
            ->where('documents.isactive', true)
            ->where('documents.id', $borrower_document['document_id'])
            ->first();
        $useful_activities = UsefulActivity::where('user_id', $borrower_document['user_id'])->get();
        $borrower_useful_activities_hours_sum = UsefulActivity::where('user_id', $borrower_document['user_id'])
            ->where('document_id', $borrower_document['document_id'])
            ->sum('hour_count') ?? 0;
        $useful_activities_hours = Config::where('variable', 'useful_activity_hour')->value('value');
        $child_documents = DocStructure::join('child_documents', 'doc_structures.child_document_id', '=', 'child_documents.id')
            ->where('doc_structures.document_id', $borrower_document['document_id'])
            ->select('child_documents.*')
            ->get();
        foreach ($child_documents as $child_document) {
            $child_document['borrower_child_document'] =  BorrowerFiles::join('borrower_child_documents', 'borrower_files.id', '=', 'borrower_child_documents.borrower_file_id')
                ->where('borrower_child_documents.document_id', $document->id)
                ->where('borrower_child_documents.child_document_id', $child_document['id'])
                ->where('borrower_child_documents.user_id', $borrower_document['user_id'])
                ->first();
        }
        return view(
            'borrower.documents.document_page',
            compact(
                'document',
                'useful_activities',
                'borrower_useful_activities_hours_sum',
                'useful_activities_hours',
                'child_documents',
            )
        );
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

    public function generateFile103(Request $request, $document_id)
    {
        $user_id = $request->session()->get('user_id','1');
        $generator = new GenerateFile();
        return $generator->teacherCommentDocument103($user_id, $document_id);
    }
}
