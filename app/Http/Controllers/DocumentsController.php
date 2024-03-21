<?php

namespace App\Http\Controllers;

use App\Models\ChildDocuments;
use App\Models\DocTypes;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    public function manage_documents(Request $request){
        $doc_types = DocTypes::where('isactive',true)->get();
        $child_documents = ChildDocuments::where('isactive',true)->get();

        return view('admin.manage_documents',compact('doc_types','child_documents'));
    }
}
