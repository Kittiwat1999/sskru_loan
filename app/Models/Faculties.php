<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculties extends Model
{
    use HasFactory;
    protected $table = "faculties";
    protected $fillable = ['faculty_name','isactive'];
    public $timestamps = false;

}
