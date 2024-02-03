<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'addresses';

    protected $fillable = [
        'village',
        'house_no',
        'village_no',
        'street',
        'road',
        'tambon',
        'aumphure',
        'province',
        'postcode',
    ];
}
