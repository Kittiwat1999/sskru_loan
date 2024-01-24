<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    use HasFactory;

    public function getBorrowerData(){
        return $this->belongsTo('App\Models\Users');
    }
}
