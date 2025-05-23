<?php

namespace App\Http\Controllers;

use App\Models\ChildDocuments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\GenerateFile;
use App\Models\Borrower;
use App\Models\Parents;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Support\Facades\Session;

class BorrowerDownloadDocument extends Controller
{
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

    public function index()
    {
        $user_id = Session::get('user_id', '1');

        if (!CheckBorrowerInformation::check($user_id)) {
            return view('borrower/borrower_information_not_complete');
        }
        $borrower_id = Borrower::where('user_id', $user_id)->value('id');
        $child_documents = ChildDocuments::join('child_document_files', 'child_documents.id', '=', 'child_document_files.child_document_id')
            ->where('child_documents.isactive', true)
            ->where('child_documents.id', '!=', '2')
            ->where('child_documents.id', '!=', '4')
            ->select('child_documents.child_document_title', 'child_documents.id',)
            ->get();
        // dd($documents);
        $parents = Parents::where('borrower_id', $borrower_id)->get();
        return view('borrower.download_document.download_document', compact('child_documents', 'parents'));
    }

    public function recheck_document($child_document_id)
    {
        $child_document = ChildDocuments::find($child_document_id);
        return view('borrower.download_document.recheck_document', compact('child_document'));
    }

    public function response_file($child_document_id)
    {
        $user_id = Session::get('user_id', '1');
        $child_document = ChildDocuments::join('child_document_files', 'child_documents.id', '=', 'child_document_files.child_document_id')
            ->where('child_documents.isactive', true)
            ->where('child_documents.id', $child_document_id)
            ->select('child_document_files.file_path', 'child_document_files.file_name', 'child_document_files.file_type', 'child_documents.child_document_title', 'child_documents.generate_file', 'child_documents.id')
            ->first();

        if ($child_document['generate_file']) {
            $generate = new GenerateFile();

            switch ($child_document['id']) {
                case '1':
                    return  $generate->generate_yinyorm_student($user_id, $child_document);
                    break;
                case '3':
                    return $generate->generate_rabrongraidai($user_id, $child_document);
                    break;
                case '4':
                    return $generate->borrower_101($user_id, $child_document, 1);
                    break;
                default:
                    $filePath = public_path($child_document['file_path'] . '/' . $child_document['file_name']);
                    if (!File::exists($filePath)) {
                        abort(404, 'File not found');
                    }

                    $fileContent = File::get($filePath);
                    $mimeType = File::mimeType($filePath);
                    $response = Response::make($fileContent, 200);
                    $response->header("Content-Type", $mimeType);
                    return $response;
            }
        } else {
            $filePath = public_path($child_document['file_path'] . '/' . $child_document['file_name']);
            if (!File::exists($filePath)) {
                abort(404, 'File not found');
            }

            $fileContent = File::get($filePath);
            $mimeType = File::mimeType($filePath);
            $response = Response::make($fileContent, 200);
            $response->header("Content-Type", $mimeType);
            return $response;
        }
    }

    public function recheck_parent_document($parent_id)
    {
        $child_document_id = 2;
        $child_document = ChildDocuments::find($child_document_id);
        return view('borrower.download_document.recheck_parent_document', compact('child_document', 'parent_id'));
    }

    public function response_parent_file($parent_id)
    {
        $user_id = Session::get('user_id', '1');
        $child_document_id = 2; //id ของหนังสือยินยอมให้เปิดเผยข้อมูลผู้ปกครอง
        $child_document = ChildDocuments::join('child_document_files', 'child_documents.id', '=', 'child_document_files.child_document_id')
            ->where('child_documents.isactive', true)
            ->where('child_documents.id', $child_document_id)
            ->select('child_document_files.file_path', 'child_document_files.file_name', 'child_document_files.file_type', 'child_documents.child_document_title', 'child_documents.generate_file', 'child_documents.id')
            ->first();

        if ($child_document['generate_file']) {
            $generate = new GenerateFile();
            $response = $generate->generate_yinyorm_parent($parent_id, $user_id, $child_document);
            return $response;
        } else {
            $filePath = public_path($child_document['file_path'] . '/' . $child_document['file_name']);
            if (!File::exists($filePath)) {
                abort(404, 'File not found');
            }

            $fileContent = File::get($filePath);
            $mimeType = File::mimeType($filePath);
            $response = Response::make($fileContent, 200);
            $response->header("Content-Type", $mimeType);
            return $response;
        }
    }
}
