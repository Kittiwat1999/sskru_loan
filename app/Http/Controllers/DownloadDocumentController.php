<?php

namespace App\Http\Controllers;

use App\Models\ChildDocuments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\GenerateFile;
use Illuminate\Support\Facades\Session;

class DownloadDocumentController extends Controller
{
    public function deleteFile($file_path,$file_name){
        $path = public_path($file_path.'/'.$file_name);
        if (File::exists($path)) {
            File::delete($path);
        }
    }

    private function storeFile($file_path,$file){
        $path = public_path($file_path);
        !file_exists($path) && mkdir($path, 0777, true);
        $name = now()->format('Y-m-d_H-i-s') . '_' . $file->getClientOriginalName();
        $file->move($path, $name);
        return $name;
    }

    public function displayFile($file_path, $file_name){
        $path = public_path($file_path.'/'.$file_name);
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }

    public function index(){
        $documents = ChildDocuments::join('child_document_files','child_documents.id','=','child_document_files.child_document_id')
            ->where('child_documents.isactive',true)
            ->select('child_documents.child_document_title','child_documents.id',)
            ->get();
        // dd($documents);
        return view('borrower.download_document',compact('documents'));
    }

    public function download_file($docuemnt_id){
        $user_id = Session::get('user_id','1');
        $document = ChildDocuments::join('child_document_files','child_documents.id','=','child_document_files.child_document_id')
            ->where('child_documents.isactive',true)
            ->where('child_documents.id',$docuemnt_id)
            ->select('child_document_files.file_path','child_document_files.file_name','child_document_files.file_type','child_documents.child_document_title','child_documents.generate_file','child_documents.id')
            ->first();

        if($document['generate_file']){
            $generate = new GenerateFile();

            switch ($document['id']) {
                case '1':
                    $response = $generate->generate_yinyorm_student($user_id);
                    return $response;
                    break;
                case '2':
                    dd('2');
                    break;
                case '3':
                    $response = $generate->generate_rabrongraidai($user_id);
                    return $response;
                    break;
                default:
                    $filePath = public_path($document['file_path'].'/'.$document['file_name']);
                    if (!File::exists($filePath)) {
                        abort(404, 'File not found');
                    }
            
                    $fileContent = File::get($filePath);
                    $mimeType = File::mimeType($filePath);
            
                    // Create a response with the file's content and set the appropriate headers
                    return Response::make($fileContent, 200, [
                        'Content-Type' => $mimeType,
                        'Content-Disposition' => 'attachment; filename="' . $document['child_document_title'] .'.'. $document['file_type'] . '"',
                    ]);
            }

        }else{
            $filePath = public_path($document['file_path'].'/'.$document['file_name']);
            if (!File::exists($filePath)) {
                abort(404, 'File not found');
            }
    
            $fileContent = File::get($filePath);
            $mimeType = File::mimeType($filePath);
    
            // Create a response with the file's content and set the appropriate headers
            return Response::make($fileContent, 200, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'attachment; filename="' . $document['child_document_title'] .'.'. $document['file_type'] . '"',
            ]);
        }
    }
}
