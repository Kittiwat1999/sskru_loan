<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class Properties extends Model
{
    use Auditable;
    use HasFactory;
    protected $table = "properties";
    protected $fillable = ['property_title','isactive'];
    public $timestamps = false;
}