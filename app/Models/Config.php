<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class Config extends Model
{
    use Auditable;
    use HasFactory;
    protected $fillable = ['useful_activity_hour'];
    public $timestamps = false;
}
