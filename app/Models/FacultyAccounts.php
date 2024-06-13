<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacultyAccounts extends Model
{
    use HasFactory;
    protected $table = 'faculty_accounts';
    protected $fillable = ['user_id','faculty_id','isactive'];
    public $timestamps = false;
}
