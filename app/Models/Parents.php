<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class Parents extends Model
{
    use Auditable;
    use HasFactory;
    protected $table = 'parents';

    protected $fillable = [
        'borrower_id',
        'borrower_relational',
        'nationality',
        'prefix',
        'firstname',
        'lastname',
        'birthday',
        'citizen_id',
        'phone',
        'occupation',
        'income',
        'alive',
        'address_id',
        'is_main_parent',
        'main_parent_only',
    ];
    public $timestamps = true;
}
