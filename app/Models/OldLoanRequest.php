<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldLoanRequest extends Model
{
    use HasFactory;

    protected $table = 'old_loanrequest';


    protected $fillable =
    [
        'borrower_id',
        'citizen_card_file',
        'gpa_file',
        'year',
        'term',
        'status',
        'comment',
    ];

    function borrower(){
        return $this->belongsTo(Borrower::class);
    }
}
