<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherCommentDocuments extends Model
{
    use HasFactory;
    protected $table = 'teacher_comment_documents';
    protected $fillable = ['teacher_uid', 'borrower_document_id', 'teacher_comment_id', 'custom_comment'];
    public $timestamps = true;
}
