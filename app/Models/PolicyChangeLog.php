<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicyChangeLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'policy_id',
        'action',
        'description',
        'created_by',
    ];


    /**
     * Policy ที่ถูกเปลี่ยนแปลง
     */
    public function policy()
    {
        return $this->belongsTo(
            Policy::class,
            'policy_id'
        );
    }


    /**
     * User ที่ทำรายการ
     */
    public function creator()
    {
        return $this->belongsTo(
            Users::class,
            'created_by'
        );
    }
}