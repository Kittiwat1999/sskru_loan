<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MultiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run():void
    {
         // Seed data for table1
         DB::table('users')->insert([
            'prefix' => 'นาย',
            'fname' => 'กิตติวัฒน์',
            'lname' => 'เทียนเพ็ชร',
            'username'=>'th.kittiwat1999',
            'email'=>'th.kittiwat1999@gmai.com',
            'password'=>'$2y$12$m.DymzXgAlTuxshscgTOquNSBiJ2kBmN9v48YEqmL3Fpo8MeIMzuy',
            'privilage' =>'borrower',
            'created_at'=>Now(),
            'updated_at'=>Now(),
        ]);

        // Seed data for table2
        DB::table('old_loanrequest')->insert([
            'borrower_id'=>'1',
            'citizen_card_file'=>0,
            'gpa_file'=>0,
            'year'=>'2567',
            'status'=>'nonsent',
            'comment'=>null,
            'created_at'=>Now(),
            'updated_at'=>Now(),
        ]);

    }
}
