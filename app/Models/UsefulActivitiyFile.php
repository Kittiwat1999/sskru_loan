<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsefulActivitiyFile extends Model
{
    use HasFactory;
    protected $table = "useful_activity_files";
    protected $fillables = ['useful_activity_id','description','original_name','file_path','file_name','file_type','full_path','upload_date'];
    public $timestamps = true;
}
