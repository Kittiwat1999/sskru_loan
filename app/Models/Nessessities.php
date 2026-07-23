<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class Nessessities extends Model
{
    use Auditable;
    use HasFactory;
    protected $table = "nessessities";
    protected $fillable = ['nessessity_title','isactive'];
    public $timestamps = false;
}
