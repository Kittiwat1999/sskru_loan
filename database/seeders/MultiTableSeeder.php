<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Parents;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class MultiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run():void
    {
         $this->seedUsers();
         $this->seedBorrowerApprearanceTypes();
         $this->seedNeesessities();
         $this->seedProperties();
         $this->seedDouTypes();
         $this->seedFaculties();
         $this->seedBorrowers();
        //  $this->seedParents();
         $this->seedAddresses();
         $this->seedBorrowerNecessities();
         $this->seedBorrowerProperties();
         $this->seedChildDocuments();
         $this->seedConfig();
         $this->seedDocuments();
         $this->seedDocStructure();
         $this->seedAddOnDocument();
         $this->seedAddonStructure();
         $this->seedChildDocumentFiles();

    }

    private function seedUsers()
    {
        DB::table('users')->insert([
            [
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
            ],
        ]);
    }

    private function seedBorrowerApprearanceTypes()
    {
        DB::table('borrower_apprearance_types')->insert([
            ['title' => 'ขาดแคลนคุณทรัพย์'],
            ['title' => 'สาขาที่ขาดแคลน'],
            ['title' => 'สาขาที่เป็นความต้องการหลัก'],
            ['title' => 'เรียนดีสร้างความเป็นเลิศ'],
        ]);
    }

    private function seedNeesessities()
    {
        DB::table('nessessities')->insert([
            ['nessessity_title' => 'เพื่อให้ได้เรียนในสาขาที่ชอบ'],
            ['nessessity_title' => 'ขาดแคลนคุณทรัพย์'],
            ['nessessity_title' => 'ลดภาระผู้ปกครอง'],
            ['nessessity_title' => 'สาขาที่เป็นความต้องการหลัก'],
            ['nessessity_title' => 'สาขาที่ขาดแคลน'],
        ]);
    }

    private function seedProperties()
    {
        DB::table('properties')->insert([
            ['property_title' => 'มีรายได้ไม่เกิน 360,000 บาทต่อปี'],
            ['property_title' => 'ไม่เคยสำเร็จการศึกษาระดับปริญญาตรีสาขาใดๆมาก่อน'],
            ['property_title' => 'จบการศึกษาระดับมัธยมหรือเทียบเท่าแล้ว'],
            ['property_title' => 'ไม่เป็นผู้มีงานประจำ'],
            ['property_title' => 'มีอายุไม่เกิน 30 ปีบริบูรณ์'],
            ['property_title' => 'ไม่เป็นบุคคลล้มละลาย'],
            ['property_title' => 'ไม่เคยผิดหนี้ชำระกับกองทุน'],
            ['property_title' => 'ไม่เคยต้องโทษจำคุก'],
        ]);
    }

    private function seedDouTypes()
    {
        DB::table('doc_types')->insert([
            ['doctype_title' => 'ยื่นกู้รายใหม่'],
            ['doctype_title' => 'ยื่นกู้รายเก่าเลื่อนชั้นปี'],
            ['doctype_title' => 'ยื่นกู้เกินหลักสูตร'],
            ['doctype_title' => 'สัญญาและแบบยืนยันการเบิกเงิน'],
            ['doctype_title' => 'แบบยืนยันการเบิกเงิน'],
        ]);
    }

    private function seedFaculties()
    {
        DB::table('faculties')->insert([
            ['faculty_name' => 'คณะมนุษยศาสตร์และสังคมศาสตร์'],
            ['faculty_name' => 'คณะพยาบาลศาสตร์'],
            ['faculty_name' => 'วิทยาลัยกฎหมายและการปกครอง'],
            ['faculty_name' => 'คณะบริหารธุรกิจและการบัญชี'],
            ['faculty_name' => 'คณะครุศาสตร์'],
            ['faculty_name' => 'คณะศิลปศาสตร์และวิทยาศาสตร์'],
        ]);
    }

    private function seedBorrowers()
    {
        DB::table('borrowers')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'address_id' => 1,
                'borrower_appearance_id' => 1,
                'birthday' => '2542-04-26',
                'citizen_id' => Crypt::encryptString('1-3304-00570-61-6'),
                'student_id' => '1231231231',
                'faculty_id' => 6,
                'major_id' => 41,
                'grade' => 2,
                'gpa' => 3.08,
                'marital_status' => '{"status":"\u0e2d\u0e22\u0e39\u0e48\u0e14\u0e49\u0e27\u0e22\u0e01\u0e31\u0e19","file_path":""}',
                'phone' => '+66931037881',
                'created_at' => '2024-03-20 19:40:05',
                'updated_at' => '2024-03-20 19:48:08',
            ],
        ]);
    }

    private function seedAddresses()
    {
        DB::table('addresses')->insert([
            'id' => 1,
            'village' => 'ก่อ',
            'house_no' => '44',
            'village_no' => '7',
            'street' => '-',
            'road' => '-',
            'tambon' => 'บึงมะลู',
            'aumphure' => 'กันทรลักษ์',
            'province' => 'ศรีสะเกษ',
            'postcode' => '33110',
            'created_at' => '2024-03-20 19:40:05',
            'updated_at' => '2024-03-20 19:43:39'
        ]);
    }

    private function seedParents()
    {
        DB::table('parents')->insert([
            [
                'id' => 1,
                'borrower_id' => 1,
                'address_id' => null,
                'borrower_relational' => 'บิดา',
                'nationality' => 'ไทย',
                'prefix' => 'นาย',
                'firstname' => 'ฉลอง',
                'lastname' => 'เทียนเพ็ชร',
                'birthday' => '2505-01-20',
                'citizen_id' => '23413421423',
                'phone' => '+66931037881',
                'email' => 'chalong@gmail.com',
                'occupation' => 'รับจ้าง',
                'place_of_work' => 'ที่ทำงาน',
                'income' => '10000',
                'alive' => 1,
                'is_main_parent' => 0,
                'created_at' => '2024-03-20 19:40:05',
                'updated_at' => '2024-03-20 19:48:08'
            ],
            [
                'id' => 2,
                'borrower_id' => 1,
                'address_id' => 1,
                'borrower_relational' => 'มารดา',
                'nationality' => 'ไทย',
                'prefix' => 'นางสาว',
                'firstname' => 'จงรักษ์',
                'lastname' => 'นาคยอง',
                'birthday' => '2521-08-20',
                'citizen_id' => '1231513421423',
                'phone' => '+66931037881',
                'email' => 'jongrak@gmail.com',
                'occupation' => 'รับจ้าง',
                'place_of_work' => 'ที่ทำงาน',
                'income' => '100',
                'alive' => 1,
                'is_main_parent' => 1,
                'created_at' => '2024-03-20 19:40:05',
                'updated_at' => '2024-03-20 19:48:08'
            ],
        ]);
    }

    private function seedBorrowerNecessities()
    {
        DB::table('borrower_nessessities')->insert([
            ['id' => 11, 'borrower_id' => 1, 'nessessity_id' => 1, 'other' => '-', 'created_at' => '2024-03-20 19:48:08', 'updated_at' => '2024-03-20 19:48:08'],
            ['id' => 12, 'borrower_id' => 1, 'nessessity_id' => 4, 'other' => '-', 'created_at' => '2024-03-20 19:48:08', 'updated_at' => '2024-03-20 19:48:08'],
            ['id' => 13, 'borrower_id' => 1, 'nessessity_id' => 5, 'other' => '-', 'created_at' => '2024-03-20 19:48:08', 'updated_at' => '2024-03-20 19:48:08'],
        ]);
    }

    private function seedBorrowerProperties()
    {
        DB::table('borrower_properties')->insert([
            ['id' => 25, 'borrower_id' => 1, 'property_id' => 1, 'created_at' => '2024-03-20 19:48:08', 'updated_at' => '2024-03-20 19:48:08'],
            ['id' => 26, 'borrower_id' => 1, 'property_id' => 2, 'created_at' => '2024-03-20 19:48:08', 'updated_at' => '2024-03-20 19:48:08'],
            ['id' => 27, 'borrower_id' => 1, 'property_id' => 3, 'created_at' => '2024-03-20 19:48:08', 'updated_at' => '2024-03-20 19:48:08'],
            ['id' => 28, 'borrower_id' => 1, 'property_id' => 4, 'created_at' => '2024-03-20 19:48:08', 'updated_at' => '2024-03-20 19:48:08'],
            ['id' => 29, 'borrower_id' => 1, 'property_id' => 5, 'created_at' => '2024-03-20 19:48:08', 'updated_at' => '2024-03-20 19:48:08'],
            ['id' => 30, 'borrower_id' => 1, 'property_id' => 6, 'created_at' => '2024-03-20 19:48:08', 'updated_at' => '2024-03-20 19:48:08'],
            ['id' => 31, 'borrower_id' => 1, 'property_id' => 7, 'created_at' => '2024-03-20 19:48:08', 'updated_at' => '2024-03-20 19:48:08'],
            ['id' => 32, 'borrower_id' => 1, 'property_id' => 8, 'created_at' => '2024-03-20 19:48:08', 'updated_at' => '2024-03-20 19:48:08'],
        ]);
    }

    private function seedChildDocuments(){
        DB::table('child_documents')->insert([
            ['child_document_title'=>'หนังสือยินยอมให้เปิดเผยข้อมูลผู้กู้'],
            ['child_document_title'=>'หนังสือยินยอมให้เปิดเผยข้อมูลผู้แทนโดยชอบธรรม'],
            ['child_document_title'=>'หนังสือรับรองรายได้ครอบครัว'],
            ['child_document_title'=>'แบบคำร้องขอกู้ยืม (กยศ. 101)'],
            ['child_document_title'=>'ใบรายงานผลการเรียน'],
            ['child_document_title'=>'สัญญากู้ยืม'],
            ['child_document_title'=>'แบบยืนยันการเบิกเงิน'],
            ['child_document_title'=>'แบบคำร้องขอกู้ยืมเกินหลักสูตร'],
            ['child_document_title'=>'สำเนาบัตรประชาชนผผู้กู้'],
        ]);
    }

    private function seedConfig(){
        DB::table('configs')->insert([
            ['variable'=>'useful_activity_hour','value'=>36],
            ['variable'=>'child_document_files_path','value'=>'child_document_files'],
            ['variable'=>'child_document_example_files_path','value'=>'child_document_example_files'],
            ['variable'=>'addon_document_files_path','value'=>'add_on_document_files'],
            ['variable'=>'addon_document_example_files_path','value'=>'addon_document_example_files'],
            ['variable'=>'marital_file_path','value'=>'app/public/marital'],
        ]);
    }
    private function seedDocuments(){ 
        DB::table('documents')->insert([
            ['doctype_id'=>'2','last_access'=>'1','year'=>'2566','term'=>'2','need_useful_activity'=>'1','need_teacher_comment'=>'0','start_date'=>'2567-02-19','end_date'=>'2567-03-01'],
        ]);
    }

    private function seedDocStructure(){
        DB::table('doc_structures')->insert([
            ['document_id'=>'1','child_document_id'=>'9'],
            ['document_id'=>'1','child_document_id'=>'5'],
        ]);
    }

    private function seedAddOnDocument(){
        DB::table('addon_documents')->insert([
            ['title'=>'สำเนาบัตรประจำตัวประชาชนผู้กู้','for_minors'=>false],
            ['title'=>'สำเนาบัตรประจำตัวประชาชนบิดา','for_minors'=>false],
            ['title'=>'สำเนาบัตรประจำตัวประชาชนมารดา','for_minors'=>false],
            ['title'=>'สำเนาบัตรประจำตัวประชาชนผู้แทนโดยชอบธรรม','for_minors'=>true],
            ['title'=>'สำเนาบัตรประจำตัวเจ้าหน้าที่รัฐ','for_minors'=>false],

        ]);
    }

    private function seedAddonStructure(){
        DB::table('addon_structures')->insert([
            ['child_document_id'=>'7','addon_document_id'=>1],
            ['child_document_id'=>'7','addon_document_id'=>4],
        ]);
    }

    private function seedChildDocumentFiles(){
        DB::table('child_document_files')->insert([
            ['child_document_id'=>'5','original_name'=>'rabrongraidai.pdf','file_path'=>'child_document_files','file_name'=>'rabrongraidai.pdf','file_type'=>'pdf','full_path'=>'..'],
            ['child_document_id'=>'1','original_name'=>'yinyorm.pdf','file_path'=>'child_document_files','file_name'=>'yinyorm.pdf','file_type'=>'pdf','full_path'=>'..'],
        ]);
    }
}
