<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use App\Models\UsefulActivities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class UsefulActivityController extends Controller
{
    public function deleteFile($file_path,$file_name){
        $path = storage_path($file_path.'/'.$file_name);
        if (File::exists($path)) {
            File::delete($path);
        }
    }

    private function storeFile($file_path,$file){
        $path = storage_path($file_path);
        !file_exists($path) && mkdir($path, 0777, true);
        $name = now()->format('Y-m-d_H-i-s') . '_' . $file->getClientOriginalName();
        $file->move($path, $name);
        return $name;
    }

    public function displayFile($file_path,$file_name){
        $path = storage_path($file_path.'/'.$file_name);
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }
    // public function getUsefulActivities($document_id){
    //     $user_id = Session::get('user_id','1');
    //     $useful_activities = UsefulActivities::join('useful_activity_files')
    //     where('user_id',$user_id)->where('document_id',$document_id)->get();
    //     $useful_activities_hour_count = UsefulActivities::where('user_id',$user_id)->where('document_id',$document_id)->count('hour_count') ?? 0;
    //     return json_encode($useful_activities_hour_count);
    // }

    public function storeUsefulActivity($document_id, Request $request){
        $user_id = Session::get('user_id');
        
    }
}
