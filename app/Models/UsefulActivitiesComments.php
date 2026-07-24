<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsefulActivitiesComments extends Model
{
    use HasFactory;
    protected $table = 'useful_activities_comments';
    protected $fillable = ['document_id', 'borrower_uid', 'comment_id', 'custom_comment'];
    public $timestamps = false;
}
