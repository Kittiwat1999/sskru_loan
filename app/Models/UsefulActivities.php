<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsefulActivities extends Model
{

    use HasFactory;
    protected $table = 'useful_activities';
    protected $fillable = [
        'borrower_id',
        'year',
        'project_name',
        'project_location',
        'date',
        'time',
        'hour_count',
        'description',
        'store_path',
        'display_path',
    ];

    public function borrower(){
        return $this->belongsTo(Borrower::class);
    }
}
