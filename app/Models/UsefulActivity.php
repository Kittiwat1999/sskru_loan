<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsefulActivity extends Model
{

    use HasFactory;
    protected $table = 'useful_activities';
    protected $fillable = [
        'user_id',
        'document_id',
        'activity_name',
        'activity_location',
        'start_date',
        'end_date',
        'hour_count',
        'description',
    ];

    public $timestamps = true;

    public function borrower(){
        return $this->belongsTo(Borrower::class);
    }
}
