<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class TeacherComments extends Model
{
    use Auditable;
    use HasFactory;
    protected $table = 'teacher_comments';
    protected $fillable = ['comment', 'isactive'];
    public $timestamps = false;
}
