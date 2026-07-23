<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class BorrowerChildDocument extends Model
{
    use Auditable;
    use HasFactory;

    protected $table = 'borrower_child_documents';
    protected $fillable = ['user_id', 'document_id', 'child_document_id', 'borrower_file_id', 'checker_id', 'education_fee', 'living_exprenses', 'status'];
    public $timestamps = true;
    
    public function doc_structure(){
        return $this->hasMany(DocStructure::class);
    }
}
