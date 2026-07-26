<?php

namespace App\Models;

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
}
