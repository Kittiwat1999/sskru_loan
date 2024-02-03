<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    use HasFactory;

    protected $table = 'borrowers';
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

    public function useful_activities(){
        return $this->hasMany(UsefulActivities::class);
    }

    public function old_loanrequest(){
        return $this->hasMany(OldLoanRequest::class);
    }

    public function files(){
        return $this->hasMany(Files::class);
    }

}
