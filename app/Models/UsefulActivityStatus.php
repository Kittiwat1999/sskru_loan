<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class UsefulActivityStatus extends Model
{
    use Auditable;
    use HasFactory;
    protected $table = 'useful_activity_statuses';
    protected $fillable = ['document_id', 'borrower_uid', 'status', 'checker_id'];
    public $timestamps = false;
}
