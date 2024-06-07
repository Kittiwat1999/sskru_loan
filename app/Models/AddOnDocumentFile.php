<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddOnDocumentFile extends Model
{
    use HasFactory;
    protected $table = 'addon_document_files';
    protected $fillable = ['addon_document_id','desciption','file_path','file_name','file_type','full_path','upload_date'];
    public $timestamps = true;
}
