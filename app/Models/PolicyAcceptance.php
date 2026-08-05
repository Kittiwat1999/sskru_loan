<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicyAcceptance extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'policy_id',
        'policy_type',
        'policy_version',
        'accepted_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'accepted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    public function policy()
    {
        return $this->belongsTo(Policy::class, 'policy_id');
    }
}
