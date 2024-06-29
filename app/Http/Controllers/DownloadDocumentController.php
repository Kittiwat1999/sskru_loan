<?php

namespace App\Http\Controllers;

use App\Models\ChildDocuments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\GenerateFile;
use App\Models\Parents;
use Illuminate\Contracts\Session\Session as SessionSession;
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
        $user_id = Session::get('user_id','1');
        $borrower_id = Session::get('borrower_id','1');
        $documents = ChildDocuments::join('child_document_files','child_documents.id','=','child_document_files.child_document_id')
            ->where('child_documents.isactive',true)
            ->where('child_documents.id','!=','2')
            ->select('child_documents.child_document_title','child_documents.id',)
            ->get();
        // dd($documents);
        $parents = Parents::where('borrower_id',$borrower_id)->get();
        return view('borrower.download_document',compact('documents','parents'));
    }

    public function download_file($document_id){
        $user_id = Session::get('user_id','1');
        $borrower_id = Session::get('borrower_id','1');
        $document = ChildDocuments::join('child_document_files','child_documents.id','=','child_document_files.child_document_id')
            ->where('child_documents.isactive',true)
            ->where('child_documents.id' ,$document_id)
            ->select('child_document_files.file_path','child_document_files.file_name','child_document_files.file_type','child_documents.child_document_title','child_documents.generate_file','child_documents.id')
            ->first();

        if($document['generate_file']){
            $generate = new GenerateFile();

            switch ($document['id']) {
                case '1':
                    $response = $generate->generate_yinyorm_student($user_id);
                    return $response;
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

    public function download_parent_file($parent_id){
        $user_id = Session::get('user_id','1');
        $document_id = 2; //id ของหนังสือยินยอมให้เปิดเผยข้อมูลผู้ปกครอง
        $document = ChildDocuments::join('child_document_files','child_documents.id','=','child_document_files.child_document_id')
            ->where('child_documents.isactive',true)
            ->where('child_documents.id',$document_id)
            ->select('child_document_files.file_path','child_document_files.file_name','child_document_files.file_type','child_documents.child_document_title','child_documents.generate_file','child_documents.id')
            ->first();

        if($document['generate_file']){
            $generate = new GenerateFile();
            $response = $generate->generate_yinyorm_parent($parent_id, $user_id);
                return $response;

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
