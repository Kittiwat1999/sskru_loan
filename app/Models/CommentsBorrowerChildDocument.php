<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentsBorrowerChildDocument extends Model
{
    use HasFactory;
    protected $table = 'comments_borrower_child_documents';
    protected $fillable = ['comment_id', 'borrower_child_document_id', 'other_comment'];
    public $timestamps = true;
}
