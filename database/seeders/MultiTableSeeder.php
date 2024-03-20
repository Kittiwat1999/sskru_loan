<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            'firstname' => 'กิตติวัฒน์',
            'lastname' => 'เทียนเพ็ชร',
            'username'=>'th.kittiwat1999',
            'email'=>'th.kittiwat1999@gmai.com',
            'password'=>Hash::make('1234567890'),
            'privilage' =>'borrower',
            'isactive'=>true,
            'created_at'=>Now(),
            'updated_at'=>Now(),
        ]);

        //borrower_apprearance_types
        DB::table('borrower_apprearance_types')->insert([
            'title' => 'ขาดแคลนคุณทรัพย์',
            'isactive' => true,
        ]);
        DB::table('borrower_apprearance_types')->insert([
            'title' => 'สาขาที่ขาดแคลน',
            'isactive' => true,
        ]);
        DB::table('borrower_apprearance_types')->insert([
            'title' => 'สาขาที่เป็นความต้องการหลัก',
            'isactive' => true,
        ]);
        DB::table('borrower_apprearance_types')->insert([
            'title' => 'เรียนดีสร้างความเป็นเลิศ',
            'isactive' => true,
        ]);
        //nessessities
        DB::table('nessessities')->insert([
            'nessessity_title' => 'เพื่อให้ได้เรียนในสาขาที่ชอบ',
            'isactive' => true,
        ]);
        DB::table('nessessities')->insert([
            'nessessity_title' => 'ขาดแคลนคุณทรัพย์',
            'isactive' => true,
        ]);
        DB::table('nessessities')->insert([
            'nessessity_title' => 'ลดภาระผู้ปกครอง',
            'isactive' => true,
        ]);
        DB::table('nessessities')->insert([
            'nessessity_title' => 'สาขาที่เป็นความต้องการหลัก',
            'isactive' => true,
        ]);
        DB::table('nessessities')->insert([
            'nessessity_title' => 'สาขาที่ขาดแคลน',
            'isactive' => true,
        ]);

        //properties
        DB::table('properties')->insert([
            'property_title' => 'มีรายได้ไม่เกิน 360,000 บาทต่อปี',
            'isactive' => true,
        ]);
        DB::table('properties')->insert([
            'property_title' => 'ไม่เคยสำเร็จการศึกษาระดับปริญญาตรีสาขมใดๆมาก่อน',
            'isactive' => true,
        ]);
        DB::table('properties')->insert([
            'property_title' => 'จบการศึกษาระดับมัธยมหรือเทียบเท่าแล้ว',
            'isactive' => true,
        ]);
        DB::table('properties')->insert([
            'property_title' => 'ไม่เป็นผู้มีงานประจำ',
            'isactive' => true,
        ]);
        DB::table('properties')->insert([
            'property_title' => 'มีอายุไม่เกิน 30 ปีบริบูรณ์',
            'isactive' => true,
        ]);
        DB::table('properties')->insert([
            'property_title' => 'ไม่เป็นบุคคลล้มละลาย',
            'isactive' => true,
        ]);
        DB::table('properties')->insert([
            'property_title' => 'ไม่เคยผิดหนี้ชำระกับกองทุน',
            'isactive' => true,
        ]);
        DB::table('properties')->insert([
            'property_title' => 'ไม่เคยต้องโทษจำคุก',
            'isactive' => true,
        ]);


        //doctypes
        DB::table('doc_types')->insert([
            'doctype_title' => 'ยื่นกู้รายใหม่',
            'isactive' => true,
        ]);
        DB::table('doc_types')->insert([
            'doctype_title' => 'ยื่นกู้รายเก่าเลื่อนชั้นปี',
            'isactive' => true,
        ]);
        DB::table('doc_types')->insert([
            'doctype_title' => 'ยื่นกู้เกินหลักสูตร',
            'isactive' => true,
        ]);
        DB::table('doc_types')->insert([
            'doctype_title' => 'สัญญาและแบบยืนยันการเบิกเงิน',
            'isactive' => true,
        ]);
        DB::table('doc_types')->insert([
            'doctype_title' => 'แบบยืนยันการเบิกเงิน',
            'isactive' => true,
        ]);


    }
}
