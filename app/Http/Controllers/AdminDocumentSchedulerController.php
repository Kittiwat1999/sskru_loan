<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocTypes;
use App\Models\ChildDocuments;

class AdminDocumentSchedulerController extends Controller
{
    public function index(){
        $doc_types = DocTypes::where('isactive',true)->get();
        $child_documents = ChildDocuments::where('isactive',true)->get();

        return view('admin.document_scheduler',compact('doc_types','child_documents'));
    }
}
