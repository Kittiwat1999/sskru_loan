<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Parents;
use Carbon\Carbon;
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
        $this->seedDocTypes();
        $this->seedFaculties();
        $this->seedBorrowers();
        $this->seedParents();
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
        $this->seedAddOnDocumentExampleFiles();
        $this->seedChildDocumentExampleFiles();
        $this->seedRegisterDocuments();
        $this->seedRegisterTypes();
        $this->seedTeacherComments();
        $this->seedTeacher();

    }

    private function seedUsers()
    {
        DB::table('users')->insert([
            [
                'prefix' => 'นาย',
                'firstname' => 'กิตติวัฒน์',
                'lastname' => 'เทียนเพ็ชร',
                'email'=>'th.kittiwat1999@gmail.com',
                'password'=>Hash::make('1234567890'),
                'privilage' =>'borrower',
                'isactive'=>true,
                'activated'=>true,
                'created_at'=>Now(),
                'updated_at'=>Now(),
            ],
            [
                'prefix' => 'นาย',
                'firstname' => 'อาจารย์',
                'lastname' => 'ที่ปรึกษา',
                'email'=>'th.kittiwat-ooo@gmail.com',
                'password'=>Hash::make('1234567890'),
                'privilage' =>'teacher',
                'isactive'=>true,
                'activated'=>true,
                'created_at'=>Now(),
                'updated_at'=>Now(),
            ],
        ]);
    }

    private function seedTeacher(){
        DB::table('teacher_accounts')->insert([
            [
                'user_id' => 2,
                'faculty_id' => 6,
                'major_id' => 41,
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
            ['property_title' => 'มีอายุไม่เกิน 30 ปีบริบูรณ์'],
            ['property_title' => 'ไม่เป็นผู้มีงานประจำ'],
            ['property_title' => 'ไม่เป็นบุคคลล้มละลาย'],
            ['property_title' => 'ไม่เคยผิดหนี้ชำระกับกองทุน'],
            ['property_title' => 'ไม่เคยต้องโทษจำคุก'],
        ]);
    }

    private function seedDocTypes()
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
                'student_id' => '6410014103',
                'faculty_id' => 6,
                'major_id' => 41,
                'gpa' => 3.08,
                'marital_status' => json_encode(["status"=>"อยู่ด้วยกัน","file_name"=>""]),
                'phone' => '0931037881',
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
                'address_id' => 1,
                'borrower_relational' => 'บิดา',
                'nationality' => 'ไทย',
                'prefix' => 'นาย',
                'firstname' => 'ฉลอง',
                'lastname' => 'เทียนเพ็ชร',
                'birthday' => '2505-01-20',
                'citizen_id' => Crypt::encryptString('1-3394-04958-64-4'),
                'phone' => '+66931037881',
                'email' => 'chalong@gmail.com',
                'occupation' => 'รับจ้าง',
                'place_of_work' => 'ที่ทำงาน',
                'income' => '100,000',
                'alive' => 1,
                'is_main_parent' => 1,
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
                'citizen_id' => Crypt::encryptString('1-0394-33458-64-7'),
                'phone' => '+66931037881',
                'email' => 'jongrak@gmail.com',
                'occupation' => 'รับจ้าง',
                'place_of_work' => 'ที่ทำงาน',
                'income' => '10,000',
                'alive' => 1,
                'is_main_parent' => 0,
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
            ['child_document_title'=>'หนังสือยินยอมให้เปิดเผยข้อมูลผู้ปกครอง,ผู้แทนโดยชอบธรรม'],
            ['child_document_title'=>'หนังสือรับรองรายได้ครอบครัว'],
            ['child_document_title'=>'แบบคำร้องขอกู้ยืม (กยศ. 101)'],
            ['child_document_title'=>'ใบรายงานผลการเรียน'],
            ['child_document_title'=>'สัญญากู้ยืม'],
            ['child_document_title'=>'แบบยืนยันการเบิกเงิน'],
            ['child_document_title'=>'แบบคำร้องขอกู้ยืมเกินหลักสูตร'],
            ['child_document_title'=>'รูปถ่ายบ้านที่อยู่อาศัยของผู้ปกครองและนักศึกษา'],
            ['child_document_title'=>'อื่นๆ (ถ้ามี) เช่น สำเนาบัตรสวัสดิการแห่งรัฐ/สำเนาใบเปลี่ยนชื่อ-สกุล/ใบมรณบัตร'],
        ]);
    }

    private function seedConfig(){
        DB::table('configs')->insert([
            ['variable'=>'useful_activity_hour','value'=>36],
            ['variable'=>'child_document_files_path','value'=>'child_document_files'],
            ['variable'=>'child_document_example_files_path','value'=>'child_document_example_files'],
            ['variable'=>'addon_document_files_path','value'=>'add_on_document_files'],
            ['variable'=>'addon_document_example_files_path','value'=>'addon_document_example_files'],
            ['variable'=>'useful_activity_file_path','value'=>'useful_activitiy_files'],
            ['variable'=>'marital_file_path','value'=>'marital'],
        ]);
    }
    private function seedDocuments(){ 
        DB::table('documents')->insert([
            ['doctype_id'=>'1','last_access'=>'1','year'=>'2567','term'=>'2','need_useful_activity'=>'1','need_teacher_comment'=>'1','start_date'=>'2567-08-8','end_date'=>'2567-10-10'],
        ]);
    }

    private function seedDocStructure(){
        DB::table('doc_structures')->insert([
            ['document_id'=>'1','child_document_id'=>'1'],
            ['document_id'=>'1','child_document_id'=>'4'],
            ['document_id'=>'1','child_document_id'=>'10'],
            // ['document_id'=>'1','child_document_id'=>'4'],
            // ['document_id'=>'1','child_document_id'=>'5'],
        ]);
    }

    private function seedAddOnDocument(){
        DB::table('addon_documents')->insert([
            ['title'=>'สำเนาบัตรประจำตัวประชาชนผู้กู้','for_minors'=>false],
            ['title'=>'สำเนาบัตรประจำตัวประชาชนผู้ปกครอง บิดา มารดา ผู้แทนโดยชอบธรรม','for_minors'=>false],
            ['title'=>'สำเนาบัตรประจำตัวประชาชนผู้แทนโดยชอบธรรม','for_minors'=>true],
            ['title'=>'สำเนาบัตรประจำตัวเจ้าหน้าที่รัฐ','for_minors'=>false],

        ]);
    }

    private function seedAddonStructure(){
        DB::table('addon_structures')->insert([
            ['child_document_id'=>'1','addon_document_id'=>1],
            ['child_document_id'=>'2','addon_document_id'=>2],
            ['child_document_id'=>'7','addon_document_id'=>1],
            ['child_document_id'=>'7','addon_document_id'=>4],
        ]);
    }

    private function seedChildDocumentFiles(){
        DB::table('child_document_files')->insert([
            ['child_document_id'=>'3','original_name'=>'rabrongraidai.pdf','file_path'=>'child_document_files','file_name'=>'rabrongraidai.pdf','file_type'=>'pdf','full_path'=>'..'],
            ['child_document_id'=>'1','original_name'=>'yinyorm.pdf','file_path'=>'child_document_files','file_name'=>'yinyorm.pdf','file_type'=>'pdf','full_path'=>'..'],
            ['child_document_id'=>'2','original_name'=>'parent-yinyorm.pdf','file_path'=>'child_document_files','file_name'=>'parent-yinyorm.pdf','file_type'=>'pdf','full_path'=>'..'],
            ['child_document_id'=>'4','original_name'=>'borrower_101.pdf','file_path'=>'child_document_files','file_name'=>'borrower_101.pdf','file_type'=>'pdf','full_path'=>'..'],
        ]);
    }

    private function seedAddOnDocumentExampleFiles(){
        DB::table('addon_document_example_files')->insert([
            [
                'addon_document_id' => 1,
                'description' => '-',
                'original_name' => 'samnao bat.pdf',
                'file_path' => 'addon_document_example_files',
                'file_name' => '2024-07-26_07-06-44_samnao bat.pdf',
                'file_type' => 'pdf',
                'full_path' => 'addon_document_example_files/2024-07-26_07-06-44_samnao bat.pdf',
                'upload_date' => '2024-07-26',
                'created_at' => Carbon::parse('2024-07-26 00:06:44'),
                'updated_at' => Carbon::parse('2024-07-26 00:06:44'),
            ],
            [
                'addon_document_id' => 4,
                'description' => '-',
                'original_name' => 'smanao.pdf',
                'file_path' => 'addon_document_example_files',
                'file_name' => '2024-07-29_07-04-32_smanao.pdf',
                'file_type' => 'pdf',
                'full_path' => 'addon_document_example_files/2024-07-29_07-04-32_smanao.pdf',
                'upload_date' => '2024-07-29',
                'created_at' => Carbon::parse('2024-07-29 00:04:32'),
                'updated_at' => Carbon::parse('2024-07-29 00:04:32'),
            ],
        ]);
    }

    private function seedChildDocumentExampleFiles()
    {
        DB::table('child_document_example_files')->insert([
            [
                'child_document_id' => 9,
                'description' => '..',
                'file_for' => 'everyone',
                'original_name' => 'samnao bat.pdf',
                'file_path' => 'child_document_example_files',
                'file_name' => '2024-07-29_08-05-21_samnao bat.pdf',
                'file_type' => 'pdf',
                'full_path' => 'child_document_example_files/2024-07-29_08-05-21_samnao bat.pdf',
                'upload_date' => '2024-07-29',
                'created_at' => Carbon::parse('2024-07-29 01:05:21'),
                'updated_at' => Carbon::parse('2024-07-29 01:05:21'),
            ],
            [
                'child_document_id' => 9,
                'description' => '..',
                'file_for' => 'minors',
                'original_name' => 'samnao bat.pdf',
                'file_path' => 'child_document_example_files',
                'file_name' => '2024-07-29_08-05-36_samnao bat.pdf',
                'file_type' => 'pdf',
                'full_path' => 'child_document_example_files/2024-07-29_08-05-36_samnao bat.pdf',
                'upload_date' => '2024-07-29',
                'created_at' => Carbon::parse('2024-07-29 01:05:36'),
                'updated_at' => Carbon::parse('2024-07-29 01:05:36'),
            ],
            [
                'child_document_id' => 5,
                'description' => '-',
                'file_for' => 'everyone',
                'original_name' => 'gradePDF.pdf',
                'file_path' => 'child_document_example_files',
                'file_name' => '2024-07-29_08-08-48_gradePDF.pdf',
                'file_type' => 'pdf',
                'full_path' => 'child_document_example_files/2024-07-29_08-08-48_gradePDF.pdf',
                'upload_date' => '2024-07-29',
                'created_at' => Carbon::parse('2024-07-29 01:08:48'),
                'updated_at' => Carbon::parse('2024-07-29 01:08:48'),
            ],
            [
                'child_document_id' => 5,
                'description' => '-',
                'file_for' => 'minors',
                'original_name' => 'gradePDF.pdf',
                'file_path' => 'child_document_example_files',
                'file_name' => '2024-07-29_08-08-56_gradePDF.pdf',
                'file_type' => 'pdf',
                'full_path' => 'child_document_example_files/2024-07-29_08-08-56_gradePDF.pdf',
                'upload_date' => '2024-07-29',
                'created_at' => Carbon::parse('2024-07-29 01:08:56'),
                'updated_at' => Carbon::parse('2024-07-29 01:08:56'),
            ],
            [
                'child_document_id' => 7,
                'description' => '-',
                'file_for' => 'everyone',
                'original_name' => 'babyenyan.pdf',
                'file_path' => 'child_document_example_files',
                'file_name' => '2024-07-29_09-56-05_babyenyan.pdf',
                'file_type' => 'pdf',
                'full_path' => 'child_document_example_files/2024-07-29_09-56-05_babyenyan.pdf',
                'upload_date' => '2024-07-29',
                'created_at' => Carbon::parse('2024-07-29 02:56:05'),
                'updated_at' => Carbon::parse('2024-07-29 02:56:05'),
            ],
            [
                'child_document_id' => 7,
                'description' => '-',
                'file_for' => 'minors',
                'original_name' => 'babyenyan-20.pdf',
                'file_path' => 'child_document_example_files',
                'file_name' => '2024-07-29_09-56-15_babyenyan-20.pdf',
                'file_type' => 'pdf',
                'full_path' => 'child_document_example_files/2024-07-29_09-56-15_babyenyan-20.pdf',
                'upload_date' => '2024-07-29',
                'created_at' => Carbon::parse('2024-07-29 02:56:15'),
                'updated_at' => Carbon::parse('2024-07-29 02:56:15'),
            ],
        ]);
    }

    private function seedRegisterDocuments(){
        DB::table('register_documents')->insert([
            ['title'=>'1. สำเนาบัตรประชาชนของนักศึกษา รับรองสำเนาถูกต้อง เฉพาะหน้าบัตร'],
            ['title'=>'2. หนังสือให้ความยินยอมในการเปิดเผยข้อมูลของนักศึกษา'],
            ['title'=>'3. สำเนาบัตรประชาชนของบิดา มารดา ผู้แทนโดยชอบธรรม รับรองสำเนาถูกต้อง เฉพาะหน้าบัตร'],
            ['title'=>'4. หนังสือให้ความยินยอมในการเปิดเผยข้อมูลของบิดา มารดา ผู้แทนโดยชอบธรรม'],
            ['title'=>'5.1 มีรายได้ประจำ แนบหนังสือรับรองเงินเดือน/สลิปเงินเดือน'],
            ['title'=>'5.2 ไม่มีรายได้ประจำ (แบบกยศ.102 แนบสำเนาบัตรเจ้าหน้าที่ของรัฐ รับรองสำเนาถูกต้อง)'],
            ['title'=>'6. หนังสือแสดงความคิดเห็นของอาจารย์ที่ปรึกษา (กยศ. 103)'],
            ['title'=>'7. รูปถ่ายบ้านที่อยู่อาศัยของผู้ปกครองและนักศึกษา'],
            ['title'=>'8. สำเนาใบรายงานผลการเรียน/สำเร็จการศึกษาในปีการศึกษาที่ผ่านมา'],
            ['title'=>'9. บันทึกกิจกรรมจิตอาสา'],
            ['title'=>'10. อื่นๆ (ถ้ามี) เช่น สำเนาบัตรสวัสดิการแห่งรัฐ/สำเนาใบเปลี่ยนชื่อ-สกุล/ใบมรณบัตร/ใบหย่า....'],
        ]);
    }

    private function seedRegisterTypes(){
        DB::table('register_types')->insert([
            ['title'=>'เป็นผู้กู้ยืมรายใหม่'],
            ['title'=>'เป็นผู้กู้ยืมรายเก่า'],

        ]);
    }

    private function seedTeacherComments(){
        DB::table('teacher_comments')->insert([
            ['comment'=>'ครอบครัวของนักศึกษาขาดแคลนคุณทรัพย์'],
            ['comment'=>'เป็นสาขาที่เป็นความต้องการหลักของประเทศ'],
            ['comment'=>'เป็นสารขาที่ขาดแคลนของประเทศ'],
            ['comment'=>'เพื่อส่งต่อโอกาศทางการศึกษาให้นักศึกษาได้สำเร็จการศึกษา'],
            ['comment'=>'เห็นควรพิจารณาอนุมัติให้กู้ยืม'],
        ]);
    }
}
