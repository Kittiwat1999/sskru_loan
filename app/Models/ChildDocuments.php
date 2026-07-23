<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class ChildDocuments extends Model
{
    use Auditable;
    use HasFactory;
    protected $fillable = ['child_document_title','isactive','need_laon_balance','generate_fiel'];
    public $timestamps = true;
}
