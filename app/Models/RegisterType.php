<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class RegisterType extends Model
{
    use Auditable;
    use HasFactory;
    protected $table = "register_types";
    protected $fillable = ['title'];

    public $timestamps = false;
}
