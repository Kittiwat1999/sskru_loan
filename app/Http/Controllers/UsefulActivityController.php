<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsefulActivityRequest;
use App\Models\Config;
use App\Models\Documents;
use App\Models\UsefulActivitiyFile;
use App\Models\UsefulActivity;
use App\Models\UsefulActivityStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use iio\libmergepdf\Merger;


class UsefulActivityController extends Controller
{
    private function convert_date($inputDate)
    {
        $parsedDate = Carbon::createFromFormat('d-m-Y H:i', $inputDate);
        $isoDate = $parsedDate->format('Y-m-d H:i:s');
        return $isoDate;
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
    
    public function displayDefaultFile()
    {
        $path = storage_path('default-image.png');
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }

    public function showUsefulActivityFile($useful_activity_id)
    {
        $useful_activity_id = Crypt::decryptString($useful_activity_id);
        $useful_activity_file = UsefulActivitiyFile::where('useful_activity_id', $useful_activity_id)->first() ?? null;
        if($useful_activity_file != null) {
            return $this->displayFile($useful_activity_file['file_path'], $useful_activity_file['file_name']);
        } else {
            return $this->displayDefaultFile();
        }
    }

    public function storeUsefulActivity($document_id, UsefulActivityRequest $request)
    {
        $user_id = $request->session()->get('user_id', '1');
        $useful_activity = new UsefulActivity();
        $useful_activity['user_id'] = $user_id;
        $useful_activity['document_id'] = $document_id;
        $useful_activity['activity_name'] = $request->activity_name;
        $useful_activity['activity_location'] = $request->activity_location;
        $useful_activity['start_date'] = $this->convert_date($request->start_date);
        $useful_activity['end_date'] = $this->convert_date($request->end_date);
        $useful_activity['hour_count'] = $request->hour_count;
        $useful_activity['description'] = $request->description;

        $useful_activities_status = UsefulActivityStatus::where('document_id', $document_id)
            ->where('borrower_uid', $user_id)
            ->first() ?? new UsefulActivityStatus();
        if($useful_activities_status['status'] == 'delivered' || empty($useful_activities_status['status'])){
            $useful_activities_status['status'] = 'delivered';
        }elseif($useful_activities_status['status'] == 'rejected'){
            $useful_activities_status['status'] = 'response-reject';
        }
        $useful_activities_status['document_id'] = $document_id;
        $useful_activities_status['borrower_uid'] = $user_id;
        $useful_activities_status->save();

        $document = Documents::find($document_id);

        $rules = [
            'useful_activity_file' => 'required|file|mimes:jpg,png,jpeg,pdf|max:2048',
        ];
        $messages = [
            'useful_activity_file.required' => 'กรุณาเลือกไฟล์',
            'useful_activity_file.file' => 'ต้องเป็นไฟล์',
            'useful_activity_file.mimes' => 'ไฟล์ที่เลือกต้องเป็นประเภท: jpg, jpeg, png, pdf',
            'useful_activity_file.max' => 'ไฟล์ที่เลือกต้องมีขนาดไม่เกิน :max KB',
        ];
        $request->validate($rules, $messages);
        $useful_activity->save();

        $useful_activity_file_path = Config::where('variable', 'useful_activity_file_path')->value('value');
        $file_path = $useful_activity_file_path . '/' . $document['term'] . '-' . $document['year'] . '/' . $document_id . '/' . $user_id;
        $input_file = $request->file('useful_activity_file');

        //file
        $merger = new Merger(); 
        if(last(explode('.', $input_file->getClientOriginalName())) == 'pdf'){
            try {
                $merger->addFile($input_file);
                $merger->merge();
            } catch (\Exception $e) {
                return redirect()->back()->withErrors('ไฟล์ PDF ไม่รองรับเทคนิคการบีบอัดนี้ ลองเปลี่ยนเครื่องมือแสกน PDF');
            }
        }
        
        $file_name = $this->storeFile($file_path, $input_file);
        $useful_activity_file = new UsefulActivitiyFile();
        $useful_activity_file['useful_activity_id'] = $useful_activity['id'];
        $useful_activity_file['description'] = $useful_activity['activity_name'];
        $useful_activity_file['original_name'] = $input_file->getClientOriginalName();
        $useful_activity_file['file_path'] = $file_path;
        $useful_activity_file['file_name'] = $file_name;
        $useful_activity_file['file_type'] = last(explode('.', $file_name));
        $useful_activity_file['full_path'] = $file_path . '/' . $file_name;
        $useful_activity_file['upload_date'] = date('Y-m-d');
        $useful_activity_file->save();

        return redirect()->back()->with(['success' => 'เพิ่มข้อมูลกิจกรรมจิตอาสาเรียบร้อยแล้ว']);
    }

    public function editUsefulActivity($useful_activity_id, UsefulActivityRequest $request)
    {
        $user_id = $request->session()->get('user_id', '1');
        $useful_activity = UsefulActivity::find($useful_activity_id);
        $useful_activity['activity_name'] = $request->activity_name;
        $useful_activity['activity_location'] = $request->activity_location;
        $useful_activity['start_date'] = $this->convert_date($request->start_date);
        $useful_activity['end_date'] = $this->convert_date($request->end_date);
        $useful_activity['hour_count'] = $request->hour_count;
        $useful_activity['description'] = $request->description;

        $useful_activities_status = UsefulActivityStatus::where('document_id', $useful_activity['document_id'])
            ->where('borrower_uid', $user_id)
            ->first() ?? new UsefulActivityStatus();
        if($useful_activities_status['status'] == 'delivered' || empty($useful_activities_status['status'])){
            $useful_activities_status['status'] = 'delivered';
        }elseif($useful_activities_status['status'] == 'rejected'){
            $useful_activities_status['status'] = 'response-reject';
        }
        $useful_activities_status['document_id'] = $useful_activity['document_id'];
        $useful_activities_status['borrower_uid'] = $user_id;
        $useful_activities_status->save();

        $document = Documents::find($useful_activity['document_id']);

        if ($request->file('useful_activity_file') != null) {
            $rules = [
                'useful_activity_file' => 'required|file|mimes:jpg,png,jpeg,pdf|max:2048',
            ];
            $messages = [
                'useful_activity_file.required' => 'กรุณาเลือกไฟล์',
                'useful_activity_file.file' => 'ต้องเป็นไฟล์',
                'useful_activity_file.mimes' => 'ไฟล์ที่เลือกต้องเป็นประเภท: jpg, jpeg, png, pdf',
                'useful_activity_file.max' => 'ไฟล์ที่เลือกต้องมีขนาดไม่เกิน :max KB',
            ];
            $request->validate($rules, $messages);
            $useful_activity->save();

            $useful_activity_file_path = Config::where('variable', 'useful_activity_file_path')->value('value');
            $file_path = $useful_activity_file_path . '/' . $document['term'] . '-' . $document['year'] . '/' . $document['id'] . '/' . $user_id;
            $input_file = $request->file('useful_activity_file');
            //file
            $merger = new Merger(); 
            if(last(explode('.', $input_file->getClientOriginalName())) == 'pdf'){
                try {
                    $merger->addFile($input_file);
                    $merger->merge();
                } catch (\Exception $e) {
                    return redirect()->back()->withErrors('ไฟล์ PDF ไม่รองรับเทคนิคการบีบอัดนี้ ลองเปลี่ยนเครื่องมือแสกน PDF');
                }
            }

            $file_name = $this->storeFile($file_path, $input_file);
            $useful_activity_file = UsefulActivitiyFile::where('useful_activity_id', $useful_activity_id)->first() ?? new UsefulActivitiyFile();
            $this->deleteFile($useful_activity_file['file_path'], $useful_activity_file['file_name']);
            $useful_activity_file['useful_activity_id'] = $useful_activity['id'];
            $useful_activity_file['description'] = $useful_activity['activity_name'];
            $useful_activity_file['original_name'] = $input_file->getClientOriginalName();
            $useful_activity_file['file_path'] = $file_path;
            $useful_activity_file['file_name'] = $file_name;
            $useful_activity_file['file_type'] = last(explode('.', $file_name));
            $useful_activity_file['full_path'] = $file_path . '/' . $file_name;
            $useful_activity_file['upload_date'] = date('Y-m-d');
            $useful_activity_file->save();

            return redirect()->back()->with(['success' => 'แก้ใขข้อมูลกิจกรรมจิตอาสาเรียบร้อยแล้ว']);
        } else {
            $useful_activity->save();
            return redirect()->back()->with(['success' => 'แก้ใขข้อมูลกิจกรรมจิตอาสาเรียบร้อยแล้ว']);
        }
    }

    public function deleteUsefulActivity($useful_activity_id, Request $request)
    {
        $user_id = $request->session()->get('user_id', '1');
        $useful_activity = UsefulActivity::find($useful_activity_id);
        $useful_activity_name = $useful_activity['activity_name'];
        $useful_activity_file = UsefulActivitiyFile::where('useful_activity_id', $useful_activity_id)->first() ?? null;
        if($useful_activity_file != null){
            $this->deleteFile($useful_activity_file['file_path'], $useful_activity_file['file_name']);
            $useful_activity_file->delete();
        }
        $useful_activity->delete();

        return redirect()->back()->with(['success' => 'ลบข้อมูลกิจกรรมจิตอาสา' . $useful_activity_name . ' เรียบร้อยแล้ว']);
    }
}
