<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowerChildDocument extends Model
{
    use HasFactory;

    public function doc_structure(){
        return $this->hasMany(DocStructure::class);
    }
}
