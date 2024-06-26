<?php

namespace App\Http\Controllers;

use setasign\Fpdi\Fpdi;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GenerateDocController extends Controller
{
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

    public function borrower_101_page_1(){
        $borrower = [
            'prefix'=>'นาย',
            'firstname' => 'กิตติวัฒน์',
            'lastname' => 'เทียนเพ็ชร',
            'student_id' => '6410014103',
            'grade' => '4',
            'field_of_study' => 'วิศวกรรมซอฟต์แวร์',
            'faculty' => 'ศิลปศาสตร์และวิทยาศาสตร์',
            'gpa' => '3.88',
            'home_id'=>'157',
            'village' => '10',
            'subdistrict' => 'กลางป่า',
            'district' => 'เมือง',
            'province' => 'ศรีสะเกษ',
            'zip_code' => '33000',
            'phone' => '1234567890',
        ];

        $dad = [
            'prefix'=>'นาย',
            'firstname' => 'ประพล',
            'lastname' => 'รุจิพร',
            'career'=>'ชาวไร่',
            'phone' => '0123456789',
            'earnings' => '100,000',
        ];

        $mom = [
            'prefix'=>'นาง',
            'firstname' => 'เยื้อน',
            'lastname' => 'เทียนเพ็ชร',
            'career'=>'ชาวไร่',
            'phone' => '0123456789',
            'earnings' => '100,000',
        ];

        $parent = [
            'prefix'=>'นาย',
            'firstname' => 'ธนาวุฒิ',
            'lastname' => 'อาจกิจโกศล',
            'career'=>'ชาวไร่',
            'phone' => '0123456789',
            'earnings' => '100,000',
        ];

        $spouse_parents = [
            'prefix'=>'นาง',
            'firstname' => 'กุลจิรา',
            'lastname' => 'ขวัญขยาดี',
            'career'=>'ชาวไร่',
            'phone' => '0123456789',
            'earnings' => '100,000',
        ];

        $decrypData = [
            'borrower_session' => iconv('UTF-8', 'cp874', '2'),
            'school_year' => iconv('UTF-8', 'cp874', '2567'),

            'borrower_prefix' => iconv('UTF-8', 'cp874', $borrower['prefix']),
            'borrower_firstname' => iconv('UTF-8', 'cp874', $borrower['firstname']),
            'borrower_lastname' => iconv('UTF-8', 'cp874', $borrower['lastname']),
            'borrower_student_id' => iconv('UTF-8', 'cp874', $borrower['student_id']),
            'borrower_grade' => iconv('UTF-8', 'cp874', $borrower['grade']),
            'borrower_field_of_study' => iconv('UTF-8', 'cp874', $borrower['field_of_study']),
            'borrower_faculty' => iconv('UTF-8', 'cp874', $borrower['faculty']),
            'borrower_gpa' => iconv('UTF-8', 'cp874', $borrower['gpa']),
            'borrower_home_id' => iconv('UTF-8', 'cp874', $borrower['home_id']),
            'borrower_village' => iconv('UTF-8', 'cp874', $borrower['village']),
            'borrower_subdistrict' => iconv('UTF-8', 'cp874', $borrower['subdistrict']),
            'borrower_district' => iconv('UTF-8', 'cp874', $borrower['district']),
            'borrower_province' => iconv('UTF-8', 'cp874', $borrower['province']),
            'borrower_zip_code' => iconv('UTF-8', 'cp874', $borrower['zip_code']),
            'borrower_phone' => iconv('UTF-8', 'cp874', $borrower['phone']),

            'dad_prefix' => iconv('UTF-8', 'cp874', $dad['prefix']),
            'dad_firstname' => iconv('UTF-8', 'cp874', $dad['firstname']),
            'dad_lastname' => iconv('UTF-8', 'cp874', $dad['lastname']),
            'dad_career' => iconv('UTF-8', 'cp874', $dad['career']),
            'dad_phone' => iconv('UTF-8', 'cp874', $dad['phone']),
            'dad_earnings' => iconv('UTF-8', 'cp874', $dad['earnings']),

            'mom_prefix' => iconv('UTF-8', 'cp874', $mom['prefix']),
            'mom_firstname' => iconv('UTF-8', 'cp874', $mom['firstname']),
            'mom_lastname' => iconv('UTF-8', 'cp874', $mom['lastname']),
            'mom_career' => iconv('UTF-8', 'cp874', $mom['career']),
            'mom_phone' => iconv('UTF-8', 'cp874', $mom['phone']),
            'mom_earnings' => iconv('UTF-8', 'cp874', $mom['earnings']),

            'other' => iconv('UTF-8', 'cp874', 'อะไรอะไรอะไรอะไรอะไรอะไร'),

            'parent_prefix' => iconv('UTF-8', 'cp874', $parent['prefix']),
            'parent_firstname' => iconv('UTF-8', 'cp874', $parent['firstname']),
            'parent_lastname' => iconv('UTF-8', 'cp874', $parent['lastname']),
            'parent_career' => iconv('UTF-8', 'cp874', $parent['career']),
            'parent_phone' => iconv('UTF-8', 'cp874', $parent['phone']),
            'parent_earnings' => iconv('UTF-8', 'cp874', $parent['earnings']),

            'spouse_parents_prefix' => iconv('UTF-8', 'cp874', $spouse_parents['prefix']),
            'spouse_parents_firstname' => iconv('UTF-8', 'cp874', $spouse_parents['firstname']),
            'spouse_parents_lastname' => iconv('UTF-8', 'cp874', $spouse_parents['lastname']),
            'spouse_parents_career' => iconv('UTF-8', 'cp874', $spouse_parents['career']),
            'spouse_parents_phone' => iconv('UTF-8', 'cp874', $spouse_parents['phone']),
            'spouse_parents_earnings' => iconv('UTF-8', 'cp874', $spouse_parents['earnings']),

            'activities' => iconv('UTF-8', 'cp874', '50'),
        ];

        // Create a StreamedResponse
        return new StreamedResponse(function () use ($decrypData) {
            // Initialize the PDF
            $pdf = new Fpdi();

            // Add the page
            $pdf->AddPage();
            $pdf->setSourceFile(public_path('child_document_files/borrower_101.pdf')); // Import an existing PDF form
            $templateId = $pdf->importPage(1);
            $pdf->useTemplate($templateId, 0, 0);

            //date
            $gregorianDate = Carbon::now();
            $buddhistYear = $gregorianDate->year + 543;

            // Set the font and add text at specific locations
            $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
            $pdf->SetFont('THSarabunNew', '', 12);

            //BorrowerSession
            $pdf->Text(176, 60, $decrypData['borrower_session']);

            //SchoolYear
            $pdf->Text(150, 85, $decrypData['school_year']);

            $borrower_name_input = 60;//lenght of input (name>..................<)
            $fullname_borrower_lenght = strlen($decrypData['borrower_prefix'].$decrypData['borrower_firstname'].'   '.$decrypData['borrower_lastname']);//lenght of string(prefix,firstname,lastname)
            $borrower_name_x = 52+($borrower_name_input/2 - $fullname_borrower_lenght/2)-6; // x position in tamplate = first_x_position_of_input_line(name.......... , first "." is value of this) + (lenght_of_input/2 - lenght_of_string/2) - be_incorrect
            $pdf->Text($borrower_name_x, 101,$decrypData['borrower_prefix'].$decrypData['borrower_firstname'].'   '.$decrypData['borrower_lastname']);

            $borrower_student_id_input = 31;
            $student_id_borrower_lenght = strlen($decrypData['borrower_student_id']);
            $borrower_student_id_x = 135+($borrower_student_id_input/2 - $student_id_borrower_lenght/2)-3;
            $pdf->Text($borrower_student_id_x, 101,$decrypData['borrower_student_id']);

            $pdf->Text(179, 101, $decrypData['borrower_grade']);

            $borrower_field_of_study_input = 40;
            $field_of_study_borrower_lenght = strlen($decrypData['borrower_field_of_study']);
            $borrower_field_of_study_x = 46+($borrower_field_of_study_input/2 - $field_of_study_borrower_lenght/2)-3;
            $pdf->Text($borrower_field_of_study_x, 109,$decrypData['borrower_field_of_study']);

            $borrower_faculty_input = 37;
            $faculty_borrower_lenght = strlen($decrypData['borrower_faculty']);
            $borrower_faculty_x = 109+($borrower_faculty_input/2 - $faculty_borrower_lenght/2)-3;
            $pdf->Text($borrower_faculty_x, 109,$decrypData['borrower_faculty']);

            $pdf->Text(177, 109, $decrypData['borrower_gpa']);

            $borrower_home_id_input = 24;
            $home_id_borrower_lenght = strlen($decrypData['borrower_home_id']);
            $borrower_home_id_x = 75+($borrower_home_id_input/2 - $home_id_borrower_lenght/2)-1;
            $pdf->Text($borrower_home_id_x, 117,$decrypData['borrower_home_id']);

            $pdf->Text(107, 117, $decrypData['borrower_village']);

            $borrower_subdistrict_input = 24;
            $subdistrict_borrower_lenght = strlen($decrypData['borrower_subdistrict']);
            $borrower_subdistrict_x = 122+($borrower_subdistrict_input/2 - $subdistrict_borrower_lenght/2)-1;
            $pdf->Text($borrower_subdistrict_x, 117,$decrypData['borrower_subdistrict']);

            $borrower_district_input = 26;
            $district_borrower_lenght = strlen($decrypData['borrower_district']);
            $borrower_district_x = 157+($borrower_district_input/2 - $district_borrower_lenght/2)-1;
            $pdf->Text($borrower_district_x, 117,$decrypData['borrower_district']);

            $borrower_province_input = 35;
            $province_borrower_lenght = strlen($decrypData['borrower_province']);
            $borrower_province_x = 43+($borrower_province_input/2 - $province_borrower_lenght/2)-1;
            $pdf->Text($borrower_province_x, 124,$decrypData['borrower_province']);

            $borrower_zip_code_input = 27;
            $zip_code_borrower_lenght = strlen($decrypData['borrower_zip_code']);
            $borrower_zip_code_x = 100+($borrower_zip_code_input/2 - $zip_code_borrower_lenght/2)-1;
            $pdf->Text($borrower_zip_code_x, 124,$decrypData['borrower_zip_code']);

            $borrower_phone_input = 42;
            $phone_borrower_lenght = strlen($decrypData['borrower_phone']);
            $borrower_phone_x = 141+($borrower_phone_input/2 - $phone_borrower_lenght/2)-2;
            $pdf->Text($borrower_phone_x, 124,$decrypData['borrower_phone']);

            $dad_name_input = 73;
            $fullname_dad_lenght = strlen($decrypData['dad_prefix'].$decrypData['dad_firstname'].'   '.$decrypData['dad_lastname']);
            $dad_name_x = 60+($dad_name_input/2 - $fullname_dad_lenght/2)-3;
            $pdf->Text($dad_name_x, 131,$decrypData['dad_prefix'].$decrypData['dad_firstname'].'   '.$decrypData['dad_lastname']);

            $dad_career_input = 34;
            $career_dad_lenght = strlen($decrypData['dad_career']);
            $dad_career_x = 55+($dad_career_input/2 - $career_dad_lenght/2)-2;
            $pdf->Text($dad_career_x, 139,$decrypData['dad_career']);

            $dad_phone_input = 28;
            $phone_dad_lenght = strlen($decrypData['dad_phone']);
            $dad_phone_x = 103+($dad_phone_input/2 - $phone_dad_lenght/2)-2;
            $pdf->Text($dad_phone_x, 139,$decrypData['dad_phone']);

            $dad_earnings_input = 24;
            $earnings_dad_lenght = strlen($decrypData['dad_earnings']);
            $dad_earnings_x = 152+($dad_earnings_input/2 - $earnings_dad_lenght/2)-2;
            $pdf->Text($dad_earnings_x, 139,$decrypData['dad_earnings']);

            $mom_name_input = 69;
            $fullname_mom_lenght = strlen($decrypData['mom_prefix'].$decrypData['mom_firstname'].'   '.$decrypData['mom_lastname']);
            $mom_name_x = 64+($mom_name_input/2 - $fullname_mom_lenght/2)-3;
            $pdf->Text($mom_name_x, 146,$decrypData['mom_prefix'].$decrypData['mom_firstname'].'   '.$decrypData['mom_lastname']);

            $mom_career_input = 34;
            $career_mom_lenght = strlen($decrypData['mom_career']);
            $mom_career_x = 55+($mom_career_input/2 - $career_mom_lenght/2)-2;
            $pdf->Text($mom_career_x, 154,$decrypData['mom_career']);

            $mom_phone_input = 28;
            $phone_mom_lenght = strlen($decrypData['mom_phone']);
            $mom_phone_x = 103+($mom_phone_input/2 - $phone_mom_lenght/2)-2;
            $pdf->Text($mom_phone_x, 154,$decrypData['mom_phone']);

            $mom_earnings_input = 24;
            $earnings_mom_lenght = strlen($decrypData['mom_earnings']);
            $mom_earnings_x = 152+($mom_earnings_input/2 - $earnings_mom_lenght/2)-2;
            $pdf->Text($mom_earnings_x, 154,$decrypData['mom_earnings']);

            $other_input = 130;
            $other_lenght = strlen($decrypData['other']);
            $other_x = 53+($other_input/2 - $other_lenght/2)-3;
            $pdf->Text($other_x, 177,$decrypData['other']);

            $parent_name_input = 88;
            $fullname_parent_lenght = strlen($decrypData['parent_prefix'].$decrypData['parent_firstname'].'   '.$decrypData['parent_lastname']);
            $parent_name_x = 96+($parent_name_input/2 - $fullname_parent_lenght/2)-3;
            $pdf->Text($parent_name_x, 184,$decrypData['parent_prefix'].$decrypData['parent_firstname'].'   '.$decrypData['parent_lastname']);

            $parent_career_input = 33;
            $career_parent_lenght = strlen($decrypData['parent_career']);
            $parent_career_x = 55+($parent_career_input/2 - $career_parent_lenght/2)-2;
            $pdf->Text($parent_career_x, 192,$decrypData['parent_career']);

            $parent_phone_input = 29;
            $phone_parent_lenght = strlen($decrypData['parent_phone']);
            $parent_phone_x = 102+($parent_phone_input/2 - $phone_parent_lenght/2)-2;
            $pdf->Text($parent_phone_x, 192,$decrypData['parent_phone']);

            $parent_earnings_input = 24;
            $earnings_parent_lenght = strlen($decrypData['parent_earnings']);
            $parent_earnings_x = 152+($parent_earnings_input/2 - $earnings_parent_lenght/2)-2;
            $pdf->Text($parent_earnings_x, 192,$decrypData['parent_earnings']);

            $spouse_parents_name_input = 69;
            $fullname_spouse_parents_lenght = strlen($decrypData['spouse_parents_prefix'].$decrypData['spouse_parents_firstname'].'   '.$decrypData['spouse_parents_lastname']);
            $spouse_parents_name_x = 114+($spouse_parents_name_input/2 - $fullname_spouse_parents_lenght/2)-3;
            $pdf->Text($spouse_parents_name_x, 199,$decrypData['spouse_parents_prefix'].$decrypData['spouse_parents_firstname'].'   '.$decrypData['spouse_parents_lastname']);

            $spouse_parents_career_input = 33;
            $career_spouse_parents_lenght = strlen($decrypData['spouse_parents_career']);
            $spouse_parents_career_x = 55+($spouse_parents_career_input/2 - $career_spouse_parents_lenght/2)-2;
            $pdf->Text($spouse_parents_career_x, 207,$decrypData['spouse_parents_career']);

            $spouse_parents_phone_input = 29;
            $phone_spouse_parents_lenght = strlen($decrypData['spouse_parents_phone']);
            $spouse_parents_phone_x = 102+($spouse_parents_phone_input/2 - $phone_spouse_parents_lenght/2)-2;
            $pdf->Text($spouse_parents_phone_x, 207,$decrypData['spouse_parents_phone']);

            $spouse_parents_earnings_input = 24;
            $earnings_spouse_parents_lenght = strlen($decrypData['spouse_parents_earnings']);
            $spouse_parents_earnings_x = 152+($spouse_parents_earnings_input/2 - $earnings_spouse_parents_lenght/2)-2;
            $pdf->Text($spouse_parents_earnings_x, 207,$decrypData['spouse_parents_earnings']);

            $pdf->Text(146, 249, $decrypData['activities']);

            //tick mark
            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 119, 49, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 120, 65, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 135, 129, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 161, 129, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 135, 144, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 161, 144, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 33, 167, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 77, 167, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 141, 167, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 33, 175, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 33, 219, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 128, 219, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 33, 226, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 128, 226, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 33, 233, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 128, 233, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 33, 240, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 128, 240, 4, 4);

            $pdf->Output();
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="generated_form.pdf"',
        ]);
    }

    public function borrower_101_page_2(){
        $borrower = [
            'prefix'=>'นาย',
            'firstname' => 'กิตติวัฒน์',
            'lastname' => 'เทียนเพ็ชร',
        ];

        $official = [
            'prefix'=>'นาย',
            'firstname' => 'เฉลิมเดช',
            'lastname' => 'ประพิณไพโรจน',
        ];

        $teachers = [
            'prefix'=>'นาง',
            'firstname' => 'กุลจิรา',
            'lastname' => 'ขวัญขยาดี',
        ];

        $decrypData = [
            'reason' => iconv('UTF-8', 'cp874', 'รสนิยมทางดนตรีเราจะเริ่มเป็นอัมพาตหลังจากอายุ 30 แน่นอนว่าไม่ใช่ทุกคนหรือทุกครั้งที่จะรู้สึกว่าเพลงสมัยใหม่ไม่เพราะ แต่โดยส่วนใหญ่ รสนิยมทางดนตรีเราจะเริ่มเป็นอัมพาตหลังจากอายุ 30 ปี และจะยิ่งเป็นหนักมากขึ้น ถ้าไม่นับว่าเราทำงานเกี่ยวข้องกับด้านดนตรี ซึ่งไม่เพียงแค่เรื่องของเพลง แต่อาจเรียกได้ว่า เราจะเริ่มเป็น “อัมพาตทางรสนิยม” ด้วยเลยก็ได้ เช่นเรื่องการแต่งตัว การไปตามสถานที่ อาหารการกิน ยิ่งอายุมากขึ้นเราจะชอบแต่อะไรเดิม ๆ หรือคิดถึงแต่สิ่งเก่า ๆ'),

            'other_documents' => iconv('UTF-8', 'cp874', 'อะไรก็ได้'),

            'borrower_prefix' => iconv('UTF-8', 'cp874', $borrower['prefix']),
            'borrower_firstname' => iconv('UTF-8', 'cp874', $borrower['firstname']),
            'borrower_lastname' => iconv('UTF-8', 'cp874', $borrower['lastname']),

            'official_prefix' => iconv('UTF-8', 'cp874', $official['prefix']),
            'official_firstname' => iconv('UTF-8', 'cp874', $official['firstname']),
            'official_lastname' => iconv('UTF-8', 'cp874', $official['lastname']),

            'not_approved' => iconv('UTF-8', 'cp874', 'ไม่บอกหมก'),

            'teachers_prefix' => iconv('UTF-8', 'cp874', $teachers['prefix']),
            'teachers_firstname' => iconv('UTF-8', 'cp874', $teachers['firstname']),
            'teachers_lastname' => iconv('UTF-8', 'cp874', $teachers['lastname']),
        ];

        // Create a StreamedResponse
        return new StreamedResponse(function () use ($decrypData) {
            // Initialize the PDF
            $pdf = new Fpdi();

            // Add the page
            $pdf->AddPage();
            $pdf->setSourceFile(public_path('child_document_files/borrower_101.pdf')); // Import an existing PDF form
            $templateId = $pdf->importPage(2);
            $pdf->useTemplate($templateId, 0, 0);

            //date
            $gregorianDate = Carbon::now();
            $buddhistYear = $gregorianDate->year + 543;

            // Set the font and add text at specific locations
            $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
            $pdf->SetFont('THSarabunNew', '', 12);

            //reason
            $pdf->SetXY(26, 31);
            $pdf->MultiCell(158, 8,$decrypData['reason']);

            //other documents
            $other_documents_input = 12;
            $other_documents_lenght = strlen($decrypData['other_documents']);
            $other_documents_x = 171+($other_documents_input/2 - $other_documents_lenght/2);
            $pdf->Text($other_documents_x, 193,$decrypData['other_documents']);

            //signature borrower
            $borrower_firstname_input = 48;
            $firstname_borrower_lenght = strlen($decrypData['borrower_firstname']);
            $borrower_firstname_x = 35+($borrower_firstname_input/2 - $firstname_borrower_lenght/2)-2;
            $pdf->Text($borrower_firstname_x, 204,$decrypData['borrower_firstname']);

            $borrower_name_input = 60;
            $borrower_lenght = strlen($decrypData['borrower_prefix'].$decrypData['borrower_firstname'].'   '.$decrypData['borrower_lastname']);
            $borrower_name_x = 27+($borrower_name_input/2 - $borrower_lenght/2)-3;
            $pdf->Text($borrower_name_x, 211,$decrypData['borrower_prefix'].$decrypData['borrower_firstname'].'   '.$decrypData['borrower_lastname']);

            $pdf->Text(48, 219,$gregorianDate->day);
            $month = iconv('UTF-8', 'cp874', $this->getThaiMonthName($gregorianDate->month));
            $pdf->Text(54, 219,$month);
            $pdf->Text(66, 219,$buddhistYear);

            //signature official
            $official_firstname_input = 37;
            $firstname_official_lenght = strlen($decrypData['official_firstname']);
            $official_firstname_x = 123+($official_firstname_input/2 - $firstname_official_lenght/2)-2;
            $pdf->Text($official_firstname_x, 204,$decrypData['official_firstname']);

            $official_name_input = 61;
            $official_lenght = strlen($decrypData['official_prefix'].$decrypData['official_firstname'].'   '.$decrypData['official_lastname']);
            $official_name_x = 115+($official_name_input/2 - $official_lenght/2)-3;
            $pdf->Text($official_name_x, 211,$decrypData['official_prefix'].$decrypData['official_firstname'].'   '.$decrypData['official_lastname']);

            $pdf->Text(138, 219,$gregorianDate->day);
            $month = iconv('UTF-8', 'cp874', $this->getThaiMonthName($gregorianDate->month));
            $pdf->Text(144, 219,$month);
            $pdf->Text(157, 219,$buddhistYear);

            //not approved
            $not_approved_input = 43;
            $not_approved_lenght = strlen($decrypData['not_approved']);
            $not_approved_x = 140+($not_approved_input/2 - $not_approved_lenght/2)-2;
            $pdf->Text($not_approved_x, 230,$decrypData['not_approved']);

            //signature teachers
            $teachers_firstname_input = 67;
            $firstname_teachers_lenght = strlen($decrypData['teachers_firstname']);
            $teachers_firstname_x = 85+($teachers_firstname_input/2 - $firstname_teachers_lenght/2)-2;
            $pdf->Text($teachers_firstname_x, 246,$decrypData['teachers_firstname']);

            $teachers_name_input = 77;
            $teachers_lenght = strlen($decrypData['teachers_prefix'].$decrypData['teachers_firstname'].'   '.$decrypData['teachers_lastname']);
            $teachers_name_x = 78+($teachers_name_input/2 - $teachers_lenght/2)-3;
            $pdf->Text($teachers_name_x, 253,$decrypData['teachers_prefix'].$decrypData['teachers_firstname'].'   '.$decrypData['teachers_lastname']);

            $pdf->Text(105, 261,$gregorianDate->day);
            $month = iconv('UTF-8', 'cp874', $this->getThaiMonthName($gregorianDate->month));
            $pdf->Text(112, 261,$month);
            $pdf->Text(126, 261,$buddhistYear);

            //tick mark
            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 39, 117, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 39, 124, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 39, 131, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 39, 137, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 39, 144, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 51, 150, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 51, 157, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 39, 164, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 39, 170, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 39, 177, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 39, 184, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 39, 190, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 81, 228, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 103, 228, 4, 4);

            $pdf->Output();
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="generated_form.pdf"',
        ]);
    }
}
