<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowerNessessities extends Model
{
    use HasFactory;
    protected $fillable = ['borrower_id', 'nessessity_id'];
}
