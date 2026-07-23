<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class RegisterToken extends Model
{
    use Auditable;
    use HasFactory;
    protected $fillable =['email','token','expired'];
    protected $table = "register_tokens";
    public $timestamps = false;
}
