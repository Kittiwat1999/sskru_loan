<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowerDocument extends Model
{
    use HasFactory;

    protected $table = 'borrower_documents';
    protected $fillable = ['document_id', 'user_id', 'status'];
    public $timestamps = true;

    public function document(){
        return $this->hasOne(Documents::class);
    }
}
