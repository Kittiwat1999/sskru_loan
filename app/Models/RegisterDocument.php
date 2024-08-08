<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterDocument extends Model
{
    use HasFactory;
    protected $table = "register_documents";
    protected $fillable = ['title'];

    public $timestamps = false;
}
