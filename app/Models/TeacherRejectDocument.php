<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class TeacherRejectDocument extends Model
{
    use Auditable;
    use HasFactory;
    protected $table = 'teacher_reject_documents';
    protected $fillable = ['teacher_uid', 'borrower_document_id', 'reject_comment'];
    public $timestamps = true;
}
