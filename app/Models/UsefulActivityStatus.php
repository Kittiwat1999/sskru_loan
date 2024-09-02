<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsefulActivityStatus extends Model
{
    use HasFactory;
    protected $table = 'useful_activity_statuses';
    protected $fillable = ['document_id', 'borrower_uid', 'status', 'checker_id'];
    public $timestamps = false;
}
