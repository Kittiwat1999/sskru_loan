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
        return view('admin.manage_data_major' ,compact('majors'));
    }

    public function delete_major($major_id){
        $major = Majors::find($major_id);
        $major->isactive = false;
        $major->save();
        return redirect()->back()->with(['success'=>'ลบ'.$major->major_name.'แล้ว']);
    }
}