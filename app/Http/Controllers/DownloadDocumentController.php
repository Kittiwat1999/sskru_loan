<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadDocumentController extends Controller
{
    public function index(){
        return view('borrower.download_document');
    }
}
