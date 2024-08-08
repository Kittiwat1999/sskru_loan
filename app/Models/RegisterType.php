<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterType extends Model
{
    use HasFactory;
    protected $table = "register_types";
    protected $fillable = ['title'];

    public $timestamps = false;
}
