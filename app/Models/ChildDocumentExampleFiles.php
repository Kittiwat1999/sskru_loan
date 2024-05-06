<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildDocumentExampleFiles extends Model
{
    use HasFactory;
    protected $fillable = ['child_document_id','desciption','file_for','file_path','file_name','file_type','full_path','upload_date'];
    public $timestamps = true;
}
