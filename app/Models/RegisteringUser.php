<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisteringUser extends Model
{
    use HasFactory;
    protected $table = "registering_users";
    protected $fillable = ['prefix','firstname','lastname','username','email','password','privilage','isactive'];
    public $timestamps = true; 
}
