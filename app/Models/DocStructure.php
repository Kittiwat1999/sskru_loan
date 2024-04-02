<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocStructure extends Model
{
    use HasFactory;
    protected $fillable = ['child_document_id','document_id'];
    public $timestamps = true;
}
