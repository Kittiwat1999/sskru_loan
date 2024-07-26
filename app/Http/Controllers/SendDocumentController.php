<?php

namespace App\Http\Controllers;

use App\Models\AddOnDocumentExampleFile;
use App\Models\AddOnStructure;
use App\Models\Borrower;
use App\Models\ChildDocumentExampleFiles;
use Illuminate\Http\Request;
use Carbon\Carbon;
use iio\libmergepdf\Merger;
use iio\libmergepdf\Pages;
use App\Models\Documents;
use App\Models\DocStructure;
use App\Models\ChildDocuments;
use App\Models\Config;
use App\Models\UsefulActivity;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class SendDocumentController extends Controller
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

    public function displayFile($file_path,$file_name){
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
        $current_date = Carbon::today()->addYears(543); // Get the current date and time and add year 543 its meen buddhist year
        $documents = Documents::join('doc_types','doc_types.id','=','documents.doctype_id')
            ->where('documents.isactive',true)
            ->where('documents.start_date', '<=', $current_date)
            ->where('documents.end_date', '>=', $current_date)
            ->select('documents.*', 'doc_types.doctype_title')
            ->get();

        return view('borrower.list_document',compact('documents'));
    }

    public function upload_document_page($document_id){
        // dd($document_id);
        $user_id = session()->get('user_id','1');
        $budhist_date = Carbon::today()->addYears(543); // Get the current date and time and add year 543 its meen buddhist year
        $document = Documents::find($document_id);
        $borrower_birthday = Borrower::where('user_id',$user_id)->value('birthday');
        $parse_birthday = Carbon::parse($borrower_birthday)->subYears(543);
        $borrower_age = $parse_birthday->age;
        $useful_activities = UsefulActivity::where('user_id',$user_id)->get();
        $useful_activities_hours_sum = UsefulActivity::where('user_id',$user_id)->where('document_id',$document_id)->sum('hour_count') ?? 0 ;
        $useful_activities_hours = Config::where('variable','useful_activity_hour')->value('value');
        if($document == null){
            return redirect()->back()->withErrors('ไม่น่ารักเลยนะ');
        }

        if(Carbon::parse($document['end_date']) < $budhist_date || $budhist_date < Carbon::parse($document['start_date'])){
            return redirect()->back()->withErrors('เอกสารดังกล่าวได้ปิดรับแล้ว');
        }

        $child_documents = DocStructure::join('child_documents','doc_structures.child_document_id','=','child_documents.id')
            ->where('doc_structures.document_id',$document_id)
            ->get();

        foreach($child_documents as $child_document){
            $child_document['addon_documents'] = AddOnStructure::join('addon_documents','addon_structures.addon_document_id','=','addon_documents.id')
                ->where('addon_structures.child_document_id',$child_document['id'])
                ->get();
            // dd($child_document['addon_documents']);
        }

        return view('borrower.upload_document',compact('document','child_documents','borrower_age','useful_activities','useful_activities_hours_sum','useful_activities_hours'));
    }

    public function mergeExampleFile($child_document_id, $file_for){
        $child_document_example_files = ChildDocumentExampleFiles::where('child_document_id',$child_document_id)->where('file_for', $file_for)->get();
        $addon_document_example_files = AddOnStructure::join('addon_documents', 'addon_structures.addon_document_id' ,'=', 'addon_documents.id')
            ->join('addon_document_example_files', 'addon_structures.addon_document_id' ,'=', 'addon_document_example_files.addon_document_id')
            ->where('addon_structures.child_document_id', $child_document_id)
            ->select('addon_documents.for_minors','addon_document_example_files.file_name')
            ->get();
        
        $child_document_example_files_path = Config::where('variable','child_document_example_files_path')->value('value');
        $addon_document_example_files_path = Config::where('variable','addon_document_example_files_path')->value('value');

        $merger = new Merger();

        foreach ($child_document_example_files as $child_document_example){
            $file_path = public_path($child_document_example_files_path . '/' .$child_document_example['file_name']);
            $merger->addFile($file_path);
        }

        foreach ($addon_document_example_files as $addon_document_example){
            if($addon_document_example['for_minors'] == ($file_for == 'minors' ? true : false)) continue ;
            $file_path = public_path($addon_document_example_files_path . '/' .$addon_document_example['file_name']);
            $merger->addFile($file_path);
        }

        $createdPdf = $merger->merge();

        return response($createdPdf, 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="ตัวอย่าง.pdf"')
                ->header('note', 'Files have been merged');
    }
}
