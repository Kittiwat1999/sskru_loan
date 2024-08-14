<?php

namespace App\Http\Controllers;

use setasign\Fpdi\Fpdi;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;


class GenerateDocController extends Controller
{
    function calculateAge($birthday) {
        list($year, $month, $day) = explode("-", $birthday);
        $gregorianYear = $year - 543;
        
        // Create Carbon instances for the birth date and the current date
        $birthDate = Carbon::create($gregorianYear, $month, $day);
        $currentDate = Carbon::now();
        
        // Calculate the age
        $age = $currentDate->diffInYears($birthDate);
        
        return $age;
    }
    function getThaiMonthName($monthNumber) {
        $thaiMonthNames = [
            1 => 'มกราคม',
            2 => 'กุมภาพันธ์',
            3 => 'มีนาคม',
            4 => 'เมษายน',
            5 => 'พฤษภาคม',
            6 => 'มิถุนายน',
            7 => 'กรกฎาคม',
            8 => 'สิงหาคม',
            9 => 'กันยายน',
            10 => 'ตุลาคม',
            11 => 'พฤศจิกายน',
            12 => 'ธันวาคม'
        ];

        return $thaiMonthNames[$monthNumber];
    }

   

}
