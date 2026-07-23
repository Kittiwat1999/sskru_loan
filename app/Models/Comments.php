<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class Comments extends Model
{
    use Auditable;
    use HasFactory;
    protected $table = 'comments';
    protected $fillable = ['comment', 'isactive'];
    public $timestamps = false;
}
