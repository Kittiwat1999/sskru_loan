<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class AddOnStructure extends Model
{
    use Auditable;
    use HasFactory;
    protected $table = 'addon_structures';
    protected $fillable = ['child_document_id','addon_document_id'];
    public $timestamps = false;
}
