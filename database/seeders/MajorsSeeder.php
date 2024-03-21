<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class MajorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //majors
        $majorSeed = [
            ['faculty_id' => 1, 'major_name' => 'หลักสูตรศิลปศาสตรบัณฑิต'],
            ['faculty_id' => 1, 'major_name' => 'สาขาวิชาการพัฒนาชุมชน'],
            ['faculty_id' => 1, 'major_name' => 'สาขาวิชาภาษาอังกฤษธุรกิจ'],
            ['faculty_id' => 1, 'major_name' => 'สาขาวิชาภาษาญี่ปุ่น'],
            ['faculty_id' => 1, 'major_name' => 'สาขาวิชาภาษาจีน'],
            ['faculty_id' => 1, 'major_name' => 'สาขาวิชาการจัดการสารสนเทศดิจิทัล'],
            ['faculty_id' => 1, 'major_name' => 'สาขาวิชาศิลปะและการออกแบบ'],
            ['faculty_id' => 1, 'major_name' => 'สาขาวิชาประวัติศาสตร์'],
            ['faculty_id' => 1, 'major_name' => 'สาขาวิชาภาษาไทยเพื่อการสื่อสาร'],
            ['faculty_id' => 1, 'major_name' => 'หลักสูตรนิเทศาสตรบัณฑิต'],
            ['faculty_id' => 1, 'major_name' => 'สาขาวิชานิเทศศาสตร์'],
            ['faculty_id' => 2, 'major_name' => 'หลักสูตรพยาบาลศาสตรบัณฑิต'],
            ['faculty_id' => 3, 'major_name' => 'หลักสูตรสาขาวิชานิติศาสตรบัณฑิต'],
            ['faculty_id' => 3, 'major_name' => 'หลักสูตรสาขาวิชารัฐศาสตรบัณฑิต'],
            ['faculty_id' => 3, 'major_name' => 'หลักสูตรสาขาวิชารัฐประศาสนศาสตรบัณฑิต'],
            ['faculty_id' => 4, 'major_name' => 'สาขาวิชาการจัดการ'],
            ['faculty_id' => 4, 'major_name' => 'สาขาวิชาการตลาด'],
            ['faculty_id' => 4, 'major_name' => 'สาขาวิชาคอมพิวเตอร์ธุรกิจดิจิทัล'],
            ['faculty_id' => 4, 'major_name' => 'สาขาวิชาการบริหารธุรกิจระหว่างประเทศ'],
            ['faculty_id' => 4, 'major_name' => 'สาขาวิชาการจัดการธุรกิจการค้าสมัยใหม่'],
            ['faculty_id' => 4, 'major_name' => 'สาขาวิชาบัญชี'],
            ['faculty_id' => 4, 'major_name' => 'สาขาวิชาการท่องเที่ยวและการโรงแรม'],
            ['faculty_id' => 5, 'major_name' => 'สาขาวิชาภาษาอังกฤษ'],
            ['faculty_id' => 5, 'major_name' => 'สาขาวิชาการศึกษาปฐมวัย'],
            ['faculty_id' => 5, 'major_name' => 'สาขาวิชาคอมพิวเตอร์ศึกษา'],
            ['faculty_id' => 5, 'major_name' => 'สาขาวิชาคณิตศาสตร์'],
            ['faculty_id' => 5, 'major_name' => 'สาขาวิชาประถมศึกษา'],
            ['faculty_id' => 5, 'major_name' => 'สาขาวิชาภาษาไทย'],
            ['faculty_id' => 5, 'major_name' => 'สาขาวิชาสังคมศึกษา'],
            ['faculty_id' => 5, 'major_name' => 'สาขาวิชาวิทยาศาสตร์ทั่วไป'],
            ['faculty_id' => 5, 'major_name' => 'สาขาวิชาพลศึกษา'],
            ['faculty_id' => 5, 'major_name' => 'สาขาวิชาดนตรีศึกษา'],
            ['faculty_id' => 5, 'major_name' => 'สาขาวิชาการสอนภาษาจีน'],
            ['faculty_id' => 5, 'major_name' => 'สาขาวิชนาฏศิลป์ศึกษา'],
            ['faculty_id' => 5, 'major_name' => 'สาขาการบริหารการศึกษา'],
            ['faculty_id' => 6, 'major_name' => 'สาขาวิชาวิทยาการคอมพิวเตอร์'],
            ['faculty_id' => 6, 'major_name' => 'สาขาวิชาเทคโนโลยีคอมพิวเตอร์และดิจิทัล'],
            ['faculty_id' => 6, 'major_name' => 'สาขาวิชาสาธารณสุขชุมชน'],
            ['faculty_id' => 6, 'major_name' => 'สาขาวิชาวิทยาศาสตร์การกีฬา'],
            ['faculty_id' => 6, 'major_name' => 'สาขาวิชาเทคโนโลยีการเกษตร'],
            ['faculty_id' => 6, 'major_name' => 'สาขาวิชาเทคโนโลยีและนวัตกรรมอาหาร'],
            ['faculty_id' => 6, 'major_name' => 'สาขาวิชาอาชีวอนามัยและความปลอดภัย'],
            ['faculty_id' => 6, 'major_name' => 'สาขาวิชาวิศวกรรมซอฟต์แวร์'],
            ['faculty_id' => 6, 'major_name' => 'สาขาวิชาวิศวกรรมโลจิสติกส์'],
            ['faculty_id' => 6, 'major_name' => 'สาขาวิชาวิศวกรรมการจัดการอุตสาหกรรมและสิ่งแวดล้อม'],
            ['faculty_id' => 6, 'major_name' => 'สาขาวิชาการออกแบบผลิตภัณฑ์และนวัตกรรมวัสดุ'],
            ['faculty_id' => 6, 'major_name' => 'สาขาวิชาเทคโนโลยีโยธาและสถาปัตยกรรม'],
        ];
        
        foreach ($majorSeed as $major) {
            DB::table('majors')->insert($major);
        }

    }
}
