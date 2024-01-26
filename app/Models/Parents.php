<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'borrower_relational',
        'nationality',
        'prefix',
        'fname',
        'lname',
        'birthday',
        'citizen_id',
        'phone',
        'occupation',
        'income',
        'alive',
        'address_id'
    ];
}
