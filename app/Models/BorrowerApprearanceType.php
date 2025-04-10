<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowerApprearanceType extends Model
{
    use HasFactory;
    protected $table = "borrower_apprearance_types";
    protected $fillable = ['title','isactive'];
    public $timestamps = false;

}
