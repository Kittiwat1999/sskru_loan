<?php

namespace App\Http\Controllers;

use App\Models\Faculties;
use App\Models\Majors;
use Illuminate\Http\Request;

class AdminManageDataController extends Controller
{
    public function index(){
        $faculties = Faculties::where('isactive',true)->get();
        
        return view('admin.manage_data',compact('faculties'));
    }

    public function major_page($faculty_id){
        $majors = Majors::where('isactive',true)->where('faculty_id',$faculty_id)->get();
        dd($majors);
    }

}
