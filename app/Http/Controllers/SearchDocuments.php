<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use App\Models\BorrowerChildDocument;
use App\Models\BorrowerDocument;
use App\Models\BorrowerFiles;
use App\Models\Config;
use App\Models\DocStructure;
use App\Models\DocTypes;
use App\Models\Documents;
use App\Models\UsefulActivity;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Contracts\Encryption\DecryptException;
use iio\libmergepdf\Merger;
use Illuminate\Support\Facades\DB;

class SearchDocuments extends Controller
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

    function calculateGrade($student_id)
    {
        $date = date('Y') + 543;
        $firstTwoDigits = floor($date / 100);
        $buddhistCurrentYear = intval(floor($date));
        $beginYear = intval($firstTwoDigits . substr($student_id, 0, 2));
        $grade = ($buddhistCurrentYear - $beginYear) + 1;
        return $grade;
    }

    private function checkDataNotNull($data)
    {
        if (!$data) {
            abort(404);
        }
    }

    private function dectyptParam($enctypted_param)
    {
        try {
            return Crypt::decryptString($enctypted_param);
        } catch (DecryptException $e) {
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function index()
    {
        return view('search_document.index');
    }
    public function serachBorrowerDocuments(Request $request)
    {
        $fullname = $request->fullname;
        $borrowers = Users::join('borrowers', 'users.id', '=', 'borrowers.user_id')
            ->join('faculties', 'borrowers.faculty_id', '=', 'faculties.id')
            ->join('majors', 'borrowers.major_id', '=', 'majors.id')
            ->where(DB::raw("CONCAT(firstname, ' ', lastname)"), 'like', $fullname . '%')
            ->select(
                'users.prefix',
                'users.id as user_id',
                'users.firstname',
                'users.lastname',
                'borrowers.student_id',
                'faculties.faculty_name',
                'majors.major_name',
            )
            ->get();

        foreach ($borrowers as $borrower) {
            $borrower['grade'] = $this->calculateGrade($borrower['student_id']);
        }
        return view('search_document.index', compact('borrowers', 'fullname'));
    }

    public function listDocument($borrower_uid)
    {
        $borrower_uid = Crypt::decryptString($borrower_uid);
        $borrower = Users::join('borrowers', 'users.id', '=', 'borrowers.user_id')
            ->join('faculties', 'borrowers.faculty_id', '=', 'faculties.id')
            ->join('majors', 'borrowers.major_id', '=', 'majors.id')
            ->where('borrowers.user_id', $borrower_uid)
            ->select(
                'users.prefix',
                'users.firstname',
                'users.lastname',
                'borrowers.student_id',
            )
            ->first();

        $borrower_documents = DocTypes::join('documents', 'doc_types.id', '=', 'documents.doctype_id')
            ->join('borrower_documents', 'documents.id', '=', 'borrower_documents.document_id')
            ->where('borrower_documents.user_id', $borrower_uid)
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
        return view('search_document.document_list', compact('borrower_documents', 'borrower'));
    }

    public function viewBorrowerDocument($borrower_document_id, Request $request)
    {
        $borrower_document_id = $this->dectyptParam($borrower_document_id);
        $borrower_document = BorrowerDocument::find($borrower_document_id);
        $this->checkDataNotNull($borrower_document);
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
        $borrower = Borrower::join('users', 'users.id', '=', 'borrowers.user_id')
            ->join('faculties', 'faculties.id', '=', 'borrowers.faculty_id')
            ->join('majors', 'majors.id', '=', 'borrowers.major_id')
            ->join('borrower_apprearance_types', 'borrower_apprearance_types.id', '=', 'borrowers.borrower_appearance_id')
            ->where('user_id', $borrower_document['user_id'])
            ->select(
                'users.prefix',
                'users.firstname',
                'users.lastname',
                'users.email',
                'borrower_apprearance_types.title',
                'borrowers.user_id',
                'borrowers.birthday',
                'borrowers.student_id',
                'borrowers.citizen_id',
                'borrowers.phone',
                'borrowers.gpa',
                'borrowers.birthday',
                'faculties.faculty_name',
                'majors.major_name',
            )
            ->first();
        $borrower['citizen_id'] = Crypt::decryptString($borrower['citizen_id']);
        foreach ($child_documents as $child_document) {
            $child_document['borrower_child_document'] =  BorrowerFiles::join('borrower_child_documents', 'borrower_files.id', '=', 'borrower_child_documents.borrower_file_id')
                ->where('borrower_child_documents.document_id', $document->id)
                ->where('borrower_child_documents.child_document_id', $child_document['id'])
                ->where('borrower_child_documents.user_id', $borrower_document['user_id'])
                ->first();
        }
        return view(
            'search_document.document_page',
            compact(
                'document',
                'useful_activities',
                'borrower_useful_activities_hours_sum',
                'useful_activities_hours',
                'child_documents',
                'borrower_document',
                'borrower',
            )
        );
    }

    public function previewBorrowerFile($borrower_child_document_id)
    {
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
            $borrower_file['file_path'],
            $borrower_file['file_name']
        );

        return $response;
    }

    public function generateFile103(Request $request, $document_id)
    {
        $user_id = $request->session()->get('user_id', '1');
        $generator = new GenerateFile();
        return $generator->teacherCommentDocument103($user_id, $document_id);
    }

    public function downloadBorrowerDocuments($borrower_uid, $document_id)
    {
        $borrower_uid = Crypt::decryptString($borrower_uid);
        $document_id = Crypt::decryptString($document_id);
        $borrower = Users::find($borrower_uid);
        $borrower_fullname = $borrower['firstname'] .' ' . $borrower['lastname'];
        
        $borrower_child_documents = DocStructure::join('documents', 'doc_structures.document_id', '=', 'documents.id')
            ->join('borrower_child_documents', 'doc_structures.child_document_id', '=', 'borrower_child_documents.child_document_id')
            ->where('doc_structures.document_id', $document_id)
            ->where('borrower_child_documents.document_id', $document_id)
            ->where('borrower_child_documents.user_id', $borrower_uid)
            ->select('borrower_child_documents.borrower_file_id')
            ->get();

        $borrower_document_code = BorrowerChildDocument::where('document_id', $document_id)
            ->where('user_id', $borrower_uid)
            ->where('document_code', '!=', '-')
            ->value('document_code');
        
        $merger = new Merger(); //merger instant
        foreach($borrower_child_documents as $item)
        {
            $borrower_file = BorrowerFiles::find($item['borrower_file_id']);
            $file_path = storage_path($borrower_file['file_path']. '/' .$borrower_file['file_name']);
            $merger->addFile($file_path); //stack file
        }

        $createdPdf = $merger->merge();

        return response($createdPdf)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' .$borrower_document_code .' '. $borrower_fullname .'.pdf"');
    }
}
