<?php

namespace App\Http\Controllers;
use App\Models\BorrowerApprearanceType;
use App\Models\Faculties;
use App\Models\Majors;
use App\Models\Nessessities;
use App\Models\Properties;
use Illuminate\Http\Request;

class AdminManageDataController extends Controller
{
    public function index(){
        $faculties = Faculties::where('isactive',true)->get();
        $borrowerapprearancetype = BorrowerApprearanceType::where('isactive',true)->get();
        $properties = Properties::where('isactive',true)->get();
        $nessessities = Nessessities::where('isactive',true)->get();
        return view('admin.manage_data',compact('faculties' ,'borrowerapprearancetype' ,'properties' ,'nessessities'));
    }

    public function delete_faculty($faculty_id){
        $faculty = Faculties::find($faculty_id);
        $faculty->isactive = false;
        $faculty->save();
        return redirect()->back()->with(['success'=>'ลบ'.$faculty->faculty_name.'แล้ว']);
    }

    public function delete_apprearancetype($apprearancetype_id){
        $apprearancetype = BorrowerApprearanceType::find($apprearancetype_id);
        $apprearancetype->isactive = false;
        $apprearancetype->save();
        return redirect()->back()->with(['success'=>'ลบ'.$apprearancetype->title.'แล้ว']);
    }

    public function delete_property($property_id){
        $property = Properties::find($property_id);
        $property->isactive = false;
        $property->save();
        return redirect()->back()->with(['success'=>'ลบ'.$property->property_title.'แล้ว']);
    }

    public function delete_nessessity($nessessity_id){
        $nessessity = Nessessities::find($nessessity_id);
        $nessessity->isactive = false;
        $nessessity->save();
        return redirect()->back()->with(['success'=>'ลบ'.$nessessity->nessessity_title.'แล้ว']);
    }

    public function major_page($faculty_id){
        $majors = Majors::where('isactive',true)->where('faculty_id',$faculty_id)->get();
        $faculty = Faculties::find($faculty_id);
        return view('admin.manage_data_major' ,compact('majors','faculty'));
    }

    public function delete_major($major_id){
        $major = Majors::find($major_id);
        $major->isactive = false;
        $major->save();
        return redirect()->back()->with(['success'=>'ลบ'.$major->major_name.'แล้ว']);
    }

    public function add_faculty(Request $request){
        $faculty = new Faculties();
        $faculty->faculty_name = $request->faculty_name;
        $faculty->save();
        return redirect()->back()->with(['success'=>'เพิ่มคณะ '.$faculty->faculty_name.' เรียบร้อยแล้ว']);
    }

    public function add_apprearancetype(Request $request){
        $apprearancetype = new BorrowerApprearanceType();
        $apprearancetype->title = $request->apprearancetype_title;
        $apprearancetype->save();
        return redirect()->back()->with(['success'=>'เพิ่มประเภทผู้กู้ '.$apprearancetype->title.' เรียบร้อยแล้ว']);
    }

    public function add_property(Request $request){
        $property = new Properties();
        $property->property_title = $request->property_title;
        $property->save();
        return redirect()->back()->with(['success'=>'เพิ่มคุณสมบัติผู้กู้ '.$property->property_title.' เรียบร้อยแล้ว']);
    }

    
    public function add_nessessity(Request $request){
        $nessessity = new Nessessities();
        $nessessity->nessessity_title = $request->nessessity_title;
        $nessessity->save();
        return redirect()->back()->with(['success'=>'เพิ่มคุณสมบัติผู้กู้ '.$nessessity->nessessity_title.' เรียบร้อยแล้ว']);
    }

    public function add_major(Request $request,$faculty_id){
        $major = new majors();
        $major->major_name = $request->major_name;
        $major->faculty_id = $faculty_id;
        $major->save();
        return redirect()->back()->with(['success'=>'เพิ่มสาขา '.$major->major_name.' เรียบร้อยแล้ว']);
    }
}