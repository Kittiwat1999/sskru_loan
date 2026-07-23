<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\Auditable;
class Users extends Authenticatable
{
    use HasFactory;
    use Auditable;

    protected $table = "users";
    protected $fillable = ['prefix','firstname','lastname','email','password','privilege','isactive'];


}
