<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherAccounts extends Model
{
    use HasFactory;
    protected $table = 'teacher_accounts';
    protected $fillable = ['user_id','faculty_id','major_id','isactive'];
    public $timestamps = false;
}
