<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Auditable;

class BorrowerRegisterType extends Model
{
    use Auditable;
    use HasFactory;
    protected $table = "borrower_register_types";
    protected $fillable = ['user_id', 'type_id', 'times'];

    public $timestamps = false;
}
