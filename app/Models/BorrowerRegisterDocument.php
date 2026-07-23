<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class BorrowerRegisterDocument extends Model
{
    use Auditable;
    use HasFactory;

    protected $table = "borrower_register_documents";
    protected $fillable = ['user_id', 'register_document_id'];

    public $timestamps = false;
}
