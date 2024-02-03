<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    use HasFactory;

    protected $table = 'files';
    protected $fillable = ['id','borrower_id','store_path','display_path','term','year','original_filename','description'];

    public function borrower(){
        return $this->belongsTo(Borrower::class);
    }
}