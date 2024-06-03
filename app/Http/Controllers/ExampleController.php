<?php

namespace App\Http\Controllers;

use setasign\Fpdi\Fpdi;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExampleController extends Controller
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

    public function generate_rabrongraidai(){
        $official = [
            'prefix'=>'นาย',
            'firstname' => 'เฉลิมเดช',
            'lastname' => 'ประพิณไพโรจน',
            'position'=>'ผู้ใหญ่บ้าน',
            'office' => 'บ้านกินแตง',
            'phone' => '0123456789',
        ];

        $borrower = [
            'prefix'=>'นาย',
            'firstname' => 'กิตติวัฒน์',
            'lastname' => 'เทียนเพ็ชร',
            'birthday' => Carbon::now()
        ];

        $dad = [
            'prefix'=>'นาย',
            'firstname' => 'ประพล',
            'lastname' => 'รุจิพร',
            'career'=>'ชาวไร่',
            'office' => 'บ้านกินแตง',
            'phone' => '0123456789',
            'earnings' => '100,000',
        ];

        $mom = [
            'prefix'=>'นาง',
            'firstname' => 'เยื้อน',
            'lastname' => 'เทียนเพ็ชร',
            'career'=>'ชาวไร่',
            'office' => 'บ้านกินแตง',
            'phone' => '0123456789',
            'earnings' => '100,000',
        ];

        $parent = [
            'prefix'=>'นาย',
            'firstname' => 'ธนาวุฒิ',
            'lastname' => 'อาจกิจโกศล',
            'relative' => 'น้า',
            'career'=>'ชาวไร่',
            'office' => 'บ้านกินแตง',
            'phone' => '0123456789',
            'earnings' => '100,000',
        ];

        $decrypData = [
            'official_prefix' => iconv('UTF-8', 'cp874', $official['prefix']),
            'official_firstname' => iconv('UTF-8', 'cp874', $official['firstname']),
            'official_lastname' => iconv('UTF-8', 'cp874', $official['lastname']),
            'official_position' => iconv('UTF-8', 'cp874', $official['position']),
            'official_office' => iconv('UTF-8', 'cp874', $official['office']),
            'official_phone' => iconv('UTF-8', 'cp874', $official['phone']),
            
            'borrower_prefix' => iconv('UTF-8', 'cp874', $borrower['prefix']),
            'borrower_firstname' => iconv('UTF-8', 'cp874', $borrower['firstname']),
            'borrower_lastname' => iconv('UTF-8', 'cp874', $borrower['lastname']),
            
            'dad_prefix' => iconv('UTF-8', 'cp874', $dad['prefix']),
            'dad_firstname' => iconv('UTF-8', 'cp874', $dad['firstname']),
            'dad_lastname' => iconv('UTF-8', 'cp874', $dad['lastname']),
            'dad_career' => iconv('UTF-8', 'cp874', $dad['career']),
            'dad_office' => iconv('UTF-8', 'cp874', $dad['office']),
            'dad_phone' => iconv('UTF-8', 'cp874', $dad['phone']),
            'dad_earnings' => iconv('UTF-8', 'cp874', $dad['earnings']),

            'mom_prefix' => iconv('UTF-8', 'cp874', $mom['prefix']),
            'mom_firstname' => iconv('UTF-8', 'cp874', $mom['firstname']),
            'mom_lastname' => iconv('UTF-8', 'cp874', $mom['lastname']),
            'mom_career' => iconv('UTF-8', 'cp874', $mom['career']),
            'mom_office' => iconv('UTF-8', 'cp874', $mom['office']),
            'mom_phone' => iconv('UTF-8', 'cp874', $mom['phone']),
            'mom_earnings' => iconv('UTF-8', 'cp874', $mom['earnings']),

            'parent_prefix' => iconv('UTF-8', 'cp874', $parent['prefix']),
            'parent_firstname' => iconv('UTF-8', 'cp874', $parent['firstname']),
            'parent_lastname' => iconv('UTF-8', 'cp874', $parent['lastname']),
            'parent_relative' => iconv('UTF-8', 'cp874', $parent['relative']),
            'parent_career' => iconv('UTF-8', 'cp874', $parent['career']),
            'parent_office' => iconv('UTF-8', 'cp874', $parent['office']),
            'parent_phone' => iconv('UTF-8', 'cp874', $parent['phone']),
            'parent_earnings' => iconv('UTF-8', 'cp874', $parent['earnings']),

            'total_income' => iconv('UTF-8', 'cp874', '200,000'),
        ];

        // Create a StreamedResponse
        return new StreamedResponse(function () use ($decrypData) {
            // Initialize the PDF
            $pdf = new Fpdi();
            
            // Add the page
            $pdf->AddPage();
            $pdf->setSourceFile(public_path('child_document_files/rabrongraidai.pdf')); // Import an existing PDF form
            $templateId = $pdf->importPage(1);
            $pdf->useTemplate($templateId, 0, 0);

            //date
            $gregorianDate = Carbon::now();
            $buddhistYear = $gregorianDate->year + 543;
            
            // Set the font and add text at specific locations
            $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
            $pdf->SetFont('THSarabunNew', '', 12);

            //write date
            $pdf->Text(118, 42,$gregorianDate->day);
            $month = iconv('UTF-8', 'cp874', $this->getThaiMonthName($gregorianDate->month));
            $pdf->Text(140, 42,$month);
            $pdf->Text(172, 42,$buddhistYear);

            $official_name_input = 76;
            $fullname_official_lenght = strlen($decrypData['official_prefix'].$decrypData['official_firstname'].'   '.$decrypData['official_lastname']);
            $official_name_x = 50+($official_name_input/2 - $fullname_official_lenght/2)-6;
            $pdf->Text($official_name_x, 53,$decrypData['official_prefix'].$decrypData['official_firstname'].'   '.$decrypData['official_lastname']);
            
            $official_position_input = 45;
            $position_official_lenght = strlen($decrypData['official_position']);
            $official_position_x = 139+($official_position_input/2 - $position_official_lenght/2)-2;
            $pdf->Text($official_position_x, 53,$decrypData['official_position']);

            $official_office_input = 78;
            $office_official_lenght = strlen($decrypData['official_office']);
            $official_office_x = 48+($official_office_input/2 - $office_official_lenght/2)-2;
            $pdf->Text($official_office_x, 61,$decrypData['official_office']);

            $official_phone_input = 44;
            $phone_official_lenght = strlen($decrypData['official_phone']);
            $official_phone_x = 140+($official_phone_input/2 - $phone_official_lenght/2)-2;
            $pdf->Text($official_phone_x, 61,$decrypData['official_phone']);

            $borrower_name_input = 85;//lenght of input (name>..................<)
            $fullname_borrower_lenght = strlen($decrypData['borrower_prefix'].$decrypData['borrower_firstname'].'   '.$decrypData['borrower_lastname']);//lenght of string(prefix,firstname,lastname)
            $borrower_name_x = 77+($borrower_name_input/2 - $fullname_borrower_lenght/2)-6; // x position in tamplate = first_x_position_of_input_line(name.......... , first "." is value of this) + (lenght_of_input/2 - lenght_of_string/2) - be_incorrect
            $pdf->Text($borrower_name_x, 68.5,$decrypData['borrower_prefix'].$decrypData['borrower_firstname'].'   '.$decrypData['borrower_lastname']);
            
            $dad_name_input = 75;
            $fullname_dad_lenght = strlen($decrypData['dad_prefix'].$decrypData['dad_firstname'].'   '.$decrypData['dad_lastname']);
            $dad_name_x = 58+($dad_name_input/2 - $fullname_dad_lenght/2)-3;
            $pdf->Text($dad_name_x, 76,$decrypData['dad_prefix'].$decrypData['dad_firstname'].'   '.$decrypData['dad_lastname']);

            $dad_career_input = 51;
            $career_dad_lenght = strlen($decrypData['dad_career']);
            $dad_career_x = 49+($dad_career_input/2 - $career_dad_lenght/2)-2;
            $pdf->Text($dad_career_x, 84,$decrypData['dad_career']);

            $dad_office_input = 61;
            $office_dad_lenght = strlen($decrypData['dad_office']);
            $dad_office_x = 123+($dad_office_input/2 - $office_dad_lenght/2)-2;
            $pdf->Text($dad_office_x, 84,$decrypData['dad_office']);

            $dad_phone_input = 61;
            $phone_dad_lenght = strlen($decrypData['dad_phone']);
            $dad_phone_x = 39+($dad_phone_input/2 - $phone_dad_lenght/2)-2;
            $pdf->Text($dad_phone_x, 91,$decrypData['dad_phone']);

            $dad_earnings_input = 55;
            $earnings_dad_lenght = strlen($decrypData['dad_earnings']);
            $dad_earnings_x = 120+($dad_earnings_input/2 - $earnings_dad_lenght/2)-2;
            $pdf->Text($dad_earnings_x, 91,$decrypData['dad_earnings']);

            $mom_name_input = 59;
            $fullname_mom_lenght = strlen($decrypData['borrower_prefix'].$decrypData['borrower_firstname'].'   '.$decrypData['borrower_lastname']);
            $mom_name_x = 75+($mom_name_input/2 - $fullname_mom_lenght/2)-3;
            $pdf->Text($mom_name_x, 99,$decrypData['mom_prefix'].$decrypData['mom_firstname'].'   '.$decrypData['mom_lastname']);

            $mom_career_input = 51;
            $career_mom_lenght = strlen($decrypData['mom_career']);
            $mom_career_x = 49+($mom_career_input/2 - $career_mom_lenght/2)-2;
            $pdf->Text($mom_career_x, 106,$decrypData['mom_career']);

            $mom_office_input = 63;
            $office_mom_lenght = strlen($decrypData['mom_office']);
            $mom_office_x = 121+($mom_office_input/2 - $office_mom_lenght/2)-2;
            $pdf->Text($mom_office_x, 106,$decrypData['mom_office']);

            $mom_phone_input = 60;
            $phone_mom_lenght = strlen($decrypData['mom_phone']);
            $mom_phone_x = 39+($mom_phone_input/2 - $phone_mom_lenght/2)-2;
            $pdf->Text($mom_phone_x, 114,$decrypData['mom_phone']);

            $mom_earnings_input = 54;
            $earnings_mom_lenght = strlen($decrypData['mom_earnings']);
            $mom_earnings_x = 119+($mom_earnings_input/2 - $earnings_mom_lenght/2)-2;
            $pdf->Text($mom_earnings_x, 114,$decrypData['mom_earnings']);

            $parent_name_input = 62;
            $fullname_parent_lenght = strlen($decrypData['borrower_prefix'].$decrypData['borrower_firstname'].'   '.$decrypData['borrower_lastname']);
            $parent_name_x = 67+($parent_name_input/2 - $fullname_parent_lenght/2)-3;
            $pdf->Text($parent_name_x, 137,$decrypData['parent_prefix'].$decrypData['parent_firstname'].'   '.$decrypData['parent_lastname']);

            $parent_relative_input = 27;
            $relative_parent_lenght = strlen($decrypData['parent_relative']);
            $parent_relative_x = 156+($parent_relative_input/2 - $relative_parent_lenght/2)-1;
            $pdf->Text($parent_relative_x, 137,$decrypData['parent_relative']);

            $parent_career_input = 51;
            $career_parent_lenght = strlen($decrypData['parent_career']);
            $parent_career_x = 49+($parent_career_input/2 - $career_parent_lenght/2)-2;
            $pdf->Text($parent_career_x, 145,$decrypData['parent_career']);

            $parent_office_input = 61;
            $office_parent_lenght = strlen($decrypData['parent_office']);
            $parent_office_x = 123+($parent_office_input/2 - $office_parent_lenght/2)-2;
            $pdf->Text($parent_office_x, 145,$decrypData['parent_office']);

            $parent_phone_input = 61;
            $phone_parent_lenght = strlen($decrypData['parent_phone']);
            $parent_phone_x = 39+($parent_phone_input/2 - $phone_parent_lenght/2)-2;
            $pdf->Text($parent_phone_x, 152,$decrypData['parent_phone']);
            
            $parent_earnings_input = 55;
            $earnings_parent_lenght = strlen($decrypData['parent_earnings']);
            $parent_earnings_x = 120+($parent_earnings_input/2 - $earnings_parent_lenght/2)-2;
            $pdf->Text($parent_earnings_x, 152,$decrypData['parent_earnings']);

            $total_income_input = 48;
            $total_income_lenght = strlen($decrypData['total_income']);
            $total_income_x = 68+($total_income_input/2 - $total_income_lenght/2)-2;
            $pdf->Text($total_income_x, 160,$decrypData['total_income']);

            //signature
            $official_firstname_input = 48;
            $firstname_official_lenght = strlen($decrypData['official_firstname']);
            $official_firstname_x = 111+($official_firstname_input/2 - $firstname_official_lenght/2)-2;
            $pdf->Text($official_firstname_x, 213,$decrypData['official_firstname']);

            $official_name_input = 77;
            $fullname_official_lenght = strlen($decrypData['official_prefix'].$decrypData['official_firstname'].'   '.$decrypData['official_lastname']);
            $official_name_x = 103+($official_name_input/2 - $fullname_official_lenght/2)-3;
            $pdf->Text($official_name_x, 221,$decrypData['official_prefix'].$decrypData['official_firstname'].'   '.$decrypData['official_lastname']);
            
            $official_position_input = 65;
            $position_official_lenght = strlen($decrypData['official_position']);
            $official_position_x = 115+($official_position_input/2 - $position_official_lenght/2)-2;
            $pdf->Text($official_position_x, 228,$decrypData['official_position']);
            
            //tick mark
            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 161, 73.5, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 135, 73.5, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 161, 96, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 135, 96, 4, 4);

            $pdf->Output(); 
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="generated_form.pdf"',
        ]);
    }

    public function generate_yinyorm(){
        $dad = [
            'prefix'=>'นาย',
            'firstname' => 'เฉลิมเดช',
            'lastname' => 'ประพิณไพโรจน',
            'age' => '20',
            'thai_id' => '1234567890123',
            'home_id'=>'157',
            'village' => '10',
            'subdistrict' => 'กลางป่า',
            'district' => 'เมือง',
            'province' => 'ศรีสะเกษ',
            'zip_code' => '33000',
            'phone' => '1234567890',
            'email' => 'qwertyuu@gmail.com',
        ];

        $borrower = [
            'prefix'=>'นาย',
            'firstname' => 'กิตติวัฒน์',
            'lastname' => 'เทียนเพ็ชร',
        ];

        $decrypData = [
            'write_at' => iconv('UTF-8', 'cp874', 'กินแตง'),

            'dad_prefix' => iconv('UTF-8', 'cp874', $dad['prefix']),
            'dad_firstname' => iconv('UTF-8', 'cp874', $dad['firstname']),
            'dad_lastname' => iconv('UTF-8', 'cp874', $dad['lastname']),
            'dad_age' => iconv('UTF-8', 'cp874', $dad['age']),
            'dad_thai_id' => iconv('UTF-8', 'cp874', $dad['thai_id']),
            'dad_home_id' => iconv('UTF-8', 'cp874', $dad['home_id']),
            'dad_village' => iconv('UTF-8', 'cp874', $dad['village']),
            'dad_subdistrict' => iconv('UTF-8', 'cp874', $dad['subdistrict']),
            'dad_district' => iconv('UTF-8', 'cp874', $dad['district']),
            'dad_province' => iconv('UTF-8', 'cp874', $dad['province']),
            'dad_zip_code' => iconv('UTF-8', 'cp874', $dad['zip_code']),
            'dad_phone' => iconv('UTF-8', 'cp874', $dad['phone']),
            'dad_email' => iconv('UTF-8', 'cp874', $dad['email']),

            'borrower_prefix' => iconv('UTF-8', 'cp874', $borrower['prefix']),
            'borrower_firstname' => iconv('UTF-8', 'cp874', $borrower['firstname']),
            'borrower_lastname' => iconv('UTF-8', 'cp874', $borrower['lastname']),
        ];

        // Create a StreamedResponse
        return new StreamedResponse(function () use ($decrypData) {
            // Initialize the PDF
            $pdf = new Fpdi();
            
            // Add the page
            $pdf->AddPage();
            $pdf->setSourceFile(public_path('child_document_files/yinyorm.pdf')); // Import an existing PDF form
            $templateId = $pdf->importPage(1);
            $pdf->useTemplate($templateId, 0, 0);

            //date
            $gregorianDate = Carbon::now();
            $buddhistYear = $gregorianDate->year + 543;
            
            // Set the font and add text at specific locations
            $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
            $pdf->SetFont('THSarabunNew', '', 12);

            //Write at
            $write_at_input = 36;
            $write_at_lenght = strlen($decrypData['write_at']);
            $write_at_x = 148+($write_at_input/2 - $write_at_lenght/2)-2;
            $pdf->Text($write_at_x, 42,$decrypData['write_at']);

            //write date
            $pdf->Text(114, 50,$gregorianDate->day);
            $month = iconv('UTF-8', 'cp874', $this->getThaiMonthName($gregorianDate->month));
            $pdf->Text(139, 50,$month);
            $pdf->Text(173, 50,$buddhistYear);

            $dad_name_input = 80;
            $fullname_dad_lenght = strlen($decrypData['dad_prefix'].$decrypData['dad_firstname'].'   '.$decrypData['dad_lastname']);
            $dad_name_x = 79+($dad_name_input/2 - $fullname_dad_lenght/2)-3;
            $pdf->Text($dad_name_x, 62,$decrypData['dad_prefix'].$decrypData['dad_firstname'].'   '.$decrypData['dad_lastname']);
            
            $dad_age_input = 15;
            $age_dad_lenght = strlen($decrypData['dad_age']);
            $dad_age_x = 166+($dad_age_input/2 - $age_dad_lenght/2);
            $pdf->Text($dad_age_x, 62,$decrypData['dad_age']);

            $dad_thai_id_input = 94;
            $thai_id_dad_lenght = strlen($decrypData['dad_thai_id']);
            $dad_thai_id_x = 89+($dad_thai_id_input/2 - $thai_id_dad_lenght/2)-3;
            $pdf->Text($dad_thai_id_x, 70,$decrypData['dad_thai_id']);

            $dad_home_id_input = 29;
            $home_id_dad_lenght = strlen($decrypData['dad_home_id']);
            $dad_home_id_x = 54+($dad_home_id_input/2 - $home_id_dad_lenght/2)-2;
            $pdf->Text($dad_home_id_x, 79,$decrypData['dad_home_id']);

            $dad_village_input = 12;
            $dad_village_lenght = strlen($decrypData['dad_village']);
            $dad_village_x = 89+($dad_village_input/2 - $dad_village_lenght/2)-1;
            $pdf->Text($dad_village_x, 79,$decrypData['dad_village']);

            $dad_subdistrict_input = 31;
            $dad_subdistrict_lenght = strlen($decrypData['dad_subdistrict']);
            $dad_subdistrict_x = 111+($dad_subdistrict_input/2 - $dad_subdistrict_lenght/2)-2;
            $pdf->Text($dad_subdistrict_x, 79,$decrypData['dad_subdistrict']);

            $dad_district_input = 30;
            $dad_district_lenght = strlen($decrypData['dad_district']);
            $dad_district_x = 153+($dad_district_input/2 - $dad_district_lenght/2)-1;
            $pdf->Text($dad_district_x, 79,$decrypData['dad_district']);

            $dad_province_input = 35;
            $dad_province_lenght = strlen($decrypData['dad_province']);
            $dad_province_x = 36+($dad_province_input/2 - $dad_province_lenght/2)-2;
            $pdf->Text($dad_province_x, 86,$decrypData['dad_province']);

            $dad_zip_code_input = 27;
            $dad_zip_code_lenght = strlen($decrypData['dad_zip_code']);
            $dad_zip_code_x = 93+($dad_zip_code_input/2 - $dad_zip_code_lenght/2)-2;
            $pdf->Text($dad_zip_code_x, 86,$decrypData['dad_zip_code']);

            $dad_phone_input = 49;
            $dad_phone_lenght = strlen($decrypData['dad_phone']);
            $dad_phone_x = 134+($dad_phone_input/2 - $dad_phone_lenght/2)-2;
            $pdf->Text($dad_phone_x, 86,$decrypData['dad_phone']);

            $dad_email_input = 150;
            $dad_email_lenght = strlen($decrypData['dad_email']);
            $dad_email_x = 34+($dad_email_input/2 - $dad_email_lenght/2)-10;
            $pdf->Text($dad_email_x, 94,$decrypData['dad_email']);

            $borrower_name_input = 76;
            $fullname_borrower_lenght = strlen($decrypData['borrower_prefix'].$decrypData['borrower_firstname'].'   '.$decrypData['borrower_lastname']);
            $borrower_name_x = 50+($borrower_name_input/2 - $fullname_borrower_lenght/2)-3;
            $pdf->Text($borrower_name_x, 109,$decrypData['borrower_prefix'].$decrypData['borrower_firstname'].'   '.$decrypData['borrower_lastname']);
            
            //signature
            $pdf->Text(103, 245,"I");
            $pdf->Text(180, 245,"I");
            $dad_firstname_input = 48;
            $firstname_dad_lenght = strlen($decrypData['dad_firstname']);
            $dad_firstname_x = 110+($dad_firstname_input/2 - $firstname_dad_lenght/2)-2;
            $pdf->Text($dad_firstname_x, 238,$decrypData['dad_firstname']);

            $dad_name_input = 77;
            $fullname_dad_lenght = strlen($decrypData['dad_prefix'].$decrypData['dad_firstname'].'   '.$decrypData['dad_lastname']);
            $dad_name_x = 103+($dad_name_input/2 - $fullname_dad_lenght/2)-3;
            $pdf->Text($dad_name_x, 245,$decrypData['dad_prefix'].$decrypData['dad_firstname'].'   '.$decrypData['dad_lastname']);

            //tick mark
            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 58, 99, 4, 4);

            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 90, 99, 4, 4);

            $pdf->Output(); 
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="generated_form.pdf"',
        ]);
    }
    
}