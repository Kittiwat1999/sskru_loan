<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class Faculties extends Model
{
    use Auditable;
    use HasFactory;
    protected $table = "faculties";
    protected $fillable = ['faculty_name','isactive'];
    public $timestamps = false;

}
