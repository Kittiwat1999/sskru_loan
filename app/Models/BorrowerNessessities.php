<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class BorrowerNessessities extends Model
{
    use Auditable;
    use HasFactory;
    protected $fillable = ['borrower_id', 'nessessity_id'];
}
