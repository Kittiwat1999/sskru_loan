<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class BorrowerProperties extends Model
{
    use Auditable;
    use HasFactory;
    protected $fillable = ['borrower_id', 'property_id'];
}
