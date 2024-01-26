<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'birthday',
        'citizen_id',
        'student_id',
        'faculty',
        'major',
        'grade',
        'gpa',
        'borrower_appearance',
        'borrower_properties',
        'borrower_necessity',
        'marital_status',
        'phone_number',
        'address_id',
        'parents_id',
    ];

    public function users(){
        return $this->belongsTo(Users::class);
    }
}
