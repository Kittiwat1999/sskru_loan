<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use App\Models\Parents;
use Illuminate\Http\Request;

class CheckBorrowerInformation extends Controller
{
    public static function check($user_id){
        $borrower_id = Borrower::where('user_id', $user_id)->value('id');
        $parents = Parents::where('borrower_id', $borrower_id)->select(['id'])->get();
        $main_parent = Parents::where('borrower_id', $borrower_id)->where('is_main_parent', true)->select(['id'])->get();
        if($borrower_id != null && (count($parents) != 0 && count($main_parent) != 0) ){
            return true;
        }else{
            return false;
        }
    }
}
