<?php

namespace App\Models;

use App\Enums\PolicyStatus;
use App\Enums\PolicyType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'title',
        'version',
        'content_html',
        'status',
        'effective_at',
        'published_at',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'effective_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(
            Users::class,
            'created_by'
        );
    }


    public function updater()
    {
        return $this->belongsTo(
            Users::class,
            'updated_by'
        );
    }


    public function logs()
    {
        return $this->hasMany(
            PolicyChangeLog::class
        );
    }

    public function getStatusEnumAttribute(): PolicyStatus
    {
        return PolicyStatus::from(
            $this->status
        );
    }

    public function getTypeEnumAttribute(): PolicyType
    {
        return PolicyType::from(
            $this->type
        );
    }

    public function isDraft(): bool
    {
        return $this->status === PolicyStatus::DRAFT->value;
    }

    public function isPublished(): bool
    {
        return $this->status === PolicyStatus::PUBLISHED->value;
    }

    public function isArchived(): bool
    {
        return $this->status === PolicyStatus::ARCHIVED->value;
    }

    public function scopePublished($query)
    {
        return $query->where(
            'status',
            PolicyStatus::PUBLISHED->value
        );
    }

    public function acceptances()
    {
        return $this->hasMany(
            PolicyAcceptance::class
        );
    }
}
