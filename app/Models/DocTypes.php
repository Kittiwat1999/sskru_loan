<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocTypes extends Model
{
    use HasFactory;
    protected $fillable = ['doctype_title', 'isactive', 'updated_at', 'created_at'];
    public $timestamps = false;

    public function documents(){
        return $this->hasMany(Documents::class);
    }
}
