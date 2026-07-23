<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class TeacherAccounts extends Model
{
    use Auditable;
    use HasFactory;
    protected $table = 'teacher_accounts';
    protected $fillable = ['user_id','faculty_id','major_id','isactive'];
    public $timestamps = false;
}
