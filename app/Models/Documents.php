<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    use HasFactory;
    protected $fillable = ['doctype_id','last_access','year','term','need_useful_activity','need_teacher_comment','start_date','end_date','isactive','description'];
    public $timestamps = true;

    public function user(){
        return $this->belongsTo(Users::class);
    }


    public function doc_type(){
        return $this->belongsTo(DocTypes::class);
    }

}
