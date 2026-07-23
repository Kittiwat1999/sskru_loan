<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;
class AddOnDocument extends Model
{
    use Auditable;
    use HasFactory;
    protected $table = 'addon_documents';
    protected $fillable = ['isactive','title','for_minors','generate_file'];
    public $timestamps = true;
}
