<?php

namespace App\Http\Controllers;

use App\Models\DocTypes;
use App\Models\Documents;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CheckDocumentController extends Controller
{
    private function convert_date($inputDate){
        $parsedDate = Carbon::createFromFormat('d-m-Y', $inputDate);
        $isoDate = $parsedDate->format('Y-m-d');

        return $isoDate;
    }

    public function index(){
        $documents = Documents::join('doc_types', 'documents.doctype_id', '=', 'doc_types.id')
            ->where('documents.isactive',true)
            ->select('documents.*', 'doc_types.doctype_title')
            ->orderBy('created_at', 'desc')
            ->get();

        foreach($documents as $document){
            $document['last_access'] = Users::where('id',$document['last_access'])->value('firstname');
        }

        return view('check_document.index',compact('documents'));
    }
}
