<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use App\Models\Parents;
use App\Models\Users;
use setasign\Fpdi\Fpdi;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GenerateFile extends Controller
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

    public function generate_rabrongraidai($user_id){
        $borrower = Users::join('borrowers','users.id','=','borrowers.user_id')
            ->where('users.id',$user_id)
            ->select('users.prefix','users.firstname','users.lastname','borrowers.birthday','borrowers.id')
            ->first();
        $father = Parents::where('borrower_id',$borrower['id'])->where('borrower_relational','บิดา')->select('prefix','firstname','lastname','occupation','place_of_work','phone','income','alive')->first();
        $mother = Parents::where('borrower_id',$borrower['id'])->where('borrower_relational','มารดา')->select('prefix','firstname','lastname','occupation','place_of_work','phone','income','alive')->first();
        $parent = Parents::where('borrower_id',$borrower['id'])->where('borrower_relational','!=','มารดา')->where('borrower_relational','!=','บิดา')->select('prefix','firstname','lastname','occupation','place_of_work','phone','income','alive','borrower_relational')->first();

        $borrower['prefix'] = iconv('UTF-8', 'cp874', $borrower['prefix']);
        $borrower['firstname'] = iconv('UTF-8', 'cp874', $borrower['firstname']);
        $borrower['lastname'] = iconv('UTF-8', 'cp874', $borrower['lastname']);
        $borrower['birthday'] = iconv('UTF-8', 'cp874', $borrower['birthday']);

        if($father != null){
            $father['prefix'] = iconv('UTF-8', 'cp874', $father['prefix']);
            $father['firstname'] = iconv('UTF-8', 'cp874', $father['firstname']);
            $father['lastname'] = iconv('UTF-8', 'cp874', $father['lastname']);
            $father['occupation'] = iconv('UTF-8', 'cp874', $father['occupation']);
            $father['place_of_work'] = iconv('UTF-8', 'cp874', $father['place_of_work']);
            $father['phone'] = iconv('UTF-8', 'cp874', $father['phone']);
            $father['income'] = iconv('UTF-8', 'cp874', $father['income']);
        }

        if($mother != null){
            $mother['prefix'] = iconv('UTF-8', 'cp874', $mother['prefix']);
            $mother['firstname'] = iconv('UTF-8', 'cp874', $mother['firstname']);
            $mother['lastname'] = iconv('UTF-8', 'cp874', $mother['lastname']);
            $mother['occupation'] = iconv('UTF-8', 'cp874', $mother['occupation']);
            $mother['place_of_work'] = iconv('UTF-8', 'cp874', $mother['place_of_work']);
            $mother['phone'] = iconv('UTF-8', 'cp874', $mother['phone']);
            $mother['income'] = iconv('UTF-8', 'cp874', $mother['income']);
        }

        if($parent != null){
            $parent['prefix'] = iconv('UTF-8', 'cp874', $parent['prefix']);
            $parent['firstname'] = iconv('UTF-8', 'cp874', $parent['firstname']);
            $parent['lastname'] = iconv('UTF-8', 'cp874', $parent['lastname']);
            $parent['occupation'] = iconv('UTF-8', 'cp874', $parent['occupation']);
            $parent['place_of_work'] = iconv('UTF-8', 'cp874', $parent['place_of_work']);
            $parent['phone'] = iconv('UTF-8', 'cp874', $parent['phone']);
            $parent['income'] = iconv('UTF-8', 'cp874', $parent['income']);
            $parent['borrower_relational'] = iconv('UTF-8', 'cp874', $parent['borrower_relational']);
        }

        // Create a StreamedResponse
        $response = new StreamedResponse(function () use ($borrower,$father,$mother,$parent) {
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
            //tick apb
            $tick_alp = public_path('icon_png/tick.png');
            // Set the font and add text at specific locations
            $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
            $pdf->SetFont('THSarabunNew', '', 14);

            //write date
            $pdf->Text(118, 42,$gregorianDate->day);
            $month = iconv('UTF-8', 'cp874', $this->getThaiMonthName($gregorianDate->month));
            $pdf->Text(140, 42,$month);
            $pdf->Text(172, 42,$buddhistYear);

            $borrower_name_input = 85;//length of input (name>..................<)
            $fullname_borrower_length = strlen($borrower['prefix'].$borrower['firstname'].'   '.$borrower['lastname']);//length of string(prefix,firstname,lastname)
            $borrower_name_x = 77+($borrower_name_input/2 - $fullname_borrower_length/2)-6; // x position in tamplate = first_x_position_of_input_line(name.......... , first "." is value of this) + (length_of_input/2 - length_of_string/2) - be_incorrect
            $pdf->Text($borrower_name_x, 68.5,$borrower['prefix'].$borrower['firstname'].'   '.$borrower['lastname']);
            
            $total_income = 0;
            //father
            if($father != null){
                $father_name_input = 75;
                $fullname_father_length = strlen($father['prefix'].$father['firstname'].'   '.$father['lastname']);
                $father_name_x = 58+($father_name_input/2 - $fullname_father_length/2)-3;
                $pdf->Text($father_name_x, 76,$father['prefix'].$father['firstname'].'   '.$father['lastname']);
    
                $father_occupation_input = 51;
                $father_occupation_length = strlen($father['occupation']);
                $father_occupation_x = 49+($father_occupation_input/2 - $father_occupation_length/2)-2;
                $pdf->Text($father_occupation_x, 84,$father['occupation']);
    
                $father_place_of_work_input = 61;
                $father_place_of_work_length = strlen($father['place_of_work']);
                $father_place_of_work_x = 123+($father_place_of_work_input/2 - $father_place_of_work_length/2)-2;
                $pdf->Text($father_place_of_work_x, 84,$father['place_of_work']);
    
                $father_phone_input = 61;
                $father_phone_length = strlen($father['phone']);
                $father_phone_x = 39+($father_phone_input/2 - $father_phone_length/2)-2;
                $pdf->Text($father_phone_x, 91,$father['phone']);
    
                $father_input = 55;
                $father_income_length = strlen($father['income']);
                $father_income_x = 120+($father_input/2 - $father_income_length/2)-2;
                $pdf->Text($father_income_x, 91,$father['income']);

                $total_income += (int) str_replace(',', '', $father['income']);

                //tick mark
                if($father['alive']){
                    $pdf->Image($tick_alp, 161, 73.5, 4, 4);
                }else{
                    $pdf->Image($tick_alp, 135, 73.5, 4, 4);
                }
            }

            //mother
            if($mother != null){
                $mother_name_input = 59;
                $mother_fullname_length = strlen($mother['perfix'].$mother['firstname'].'   '.$mother['lastname']);
                $mother_name_x = 75+($mother_name_input/2 - $mother_fullname_length/2)-3;
                $pdf->Text($mother_name_x, 99,$mother['prefix'].$mother['firstname'].'   '.$mother['lastname']);
    
                $mother_occupation = 51;
                $mother_occupation_length = strlen($mother['occupation']);
                $mother_occupation_x = 49+($mother_occupation/2 - $mother_occupation_length/2)-2;
                $pdf->Text($mother_occupation_x, 106,$mother['occupation']);
    
                $mother_place_of_work_input = 63;
                $mother_place_of_work_length = strlen($mother['place_of_work']);
                $mother_place_of_work_x = 121+($mother_place_of_work_input/2 - $mother_place_of_work_length/2)-2;
                $pdf->Text($mother_place_of_work_x, 106,$mother['place_of_work']);
    
                $mother_phone_input = 60;
                $mother_phone_length = strlen($mother['phone']);
                $mother_phone_x = 39+($mother_phone_input/2 - $mother_phone_length/2)-2;
                $pdf->Text($mother_phone_x, 114,$mother['phone']);
    
                $mother_income_input = 54;
                $mother_income_length = strlen($mother['income']);
                $mother_income_x = 119+($mother_income_input/2 - $mother_income_length/2)-2;
                $pdf->Text($mother_income_x, 114,$mother['income']);

                $total_income += (int) str_replace(',', '', $mother['income']);
    
                //tick mark
                if($mother['alive']){
                    $pdf->Image($tick_alp, 161, 96, 4, 4);
                }else{
                    $pdf->Image($tick_alp, 135, 96, 4, 4);
                }
            }

            if($parent != null){
                $parent_fullname_input = 62;
                $parent_fullname_length = strlen($parent['prefix'].$parent['firstname'].'   '.$parent['lastname']);
                $parent_fullname_x = 67+($parent_fullname_input/2 - $parent_fullname_length/2)-3;
                $pdf->Text($parent_fullname_x, 137,$parent['prefix'].$parent['firstname'].'   '.$parent['lastname']);
    
                $parent_relational_input = 27;
                $parent_relational_length = strlen($parent['borrower_relational']);
                $parent_relational_x = 156+($parent_relational_input/2 - $parent_relational_length/2)-1;
                $pdf->Text($parent_relational_x, 137,$parent['borrower_relational']);
    
                $parent_occupation_input = 51;
                $parent_occupation_length = strlen($parent['occupation']);
                $parent_occupation_x = 49+($parent_occupation_input/2 - $parent_occupation_length/2)-2;
                $pdf->Text($parent_occupation_x, 145,$parent['occupation']);
    
                $parent_place_of_work_input = 61;
                $parent_place_of_work_length = strlen($parent['place_of_work']);
                $parent_place_of_work_x = 123+($parent_place_of_work_input/2 - $parent_place_of_work_length/2)-2;
                $pdf->Text($parent_place_of_work_x, 145,$parent['place_of_work']);
    
                $parent_phone_input = 61;
                $parent_phone_length = strlen($parent['phone']);
                $parent_phone_x = 39+($parent_phone_input/2 - $parent_phone_length/2)-2;
                $pdf->Text($parent_phone_x, 152,$parent['phone']);
                
                $parent_income_input = 55;
                $parent_income_length = strlen($parent['income']);
                $parent_income_x = 120+($parent_income_input/2 - $parent_income_length/2)-2;
                $pdf->Text($parent_income_x, 152,$parent['income']);

                $total_income += (int) str_replace(',', '', $parent['income']);

            }
            $formattedNumber = number_format($total_income);

            $total_income_input = 48;
            $total_income_length = strlen($formattedNumber);
            $total_income_x = 68+($total_income_input/2 - $total_income_length/2)-2;
            $pdf->Text($total_income_x, 160,$formattedNumber);

            $filename = 'หนังสือรับรองรายได้ครอบครัว.pdf';
            // Encode the filename
            $encodedFilename = rawurlencode($filename);
            $pdf->Output('D', $encodedFilename);
        });

        $response->headers->set('Content-Type', 'application/octet-stream');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . 'rabrongraidai.pdf' . '"');
        return $response;
    }

    public function generate_yinyorm_student(){
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

    public function teachers_comment(){
        $teachers = [
            'prefix'=>'นาย',
            'firstname' => 'เฉลิมเดช',
            'lastname' => 'ประพิณไพโรจน',
            'position'=>'อาจารย์',
            'field_of_study' => 'วิศวกรรมซอฟต์แวร์',
            'faculty' => 'ศิลปศาสตร์และวิทยาศาสตร์',
            'comment' => 'รสนิยมทางดนตรีเราจะเริ่มเป็นอัมพาตหลังจากอายุ 30 แน่นอนว่าไม่ใช่ทุกคนหรือทุกครั้งที่จะรู้สึกว่าเพลงสมัยใหม่ไม่เพราะ แต่โดยส่วนใหญ่ รสนิยมทางดนตรีเราจะเริ่มเป็นอัมพาตหลังจากอายุ 30 ปี และจะยิ่งเป็นหนักมากขึ้น ถ้าไม่นับว่าเราทำงานเกี่ยวข้องกับด้านดนตรี ซึ่งไม่เพียงแค่เรื่องของเพลง แต่อาจเรียกได้ว่า เราจะเริ่มเป็น “อัมพาตทางรสนิยม” ด้วยเลยก็ได้ เช่นเรื่องการแต่งตัว การไปตามสถานที่ อาหารการกิน ยิ่งอายุมากขึ้นเราจะชอบแต่อะไรเดิม ๆ หรือคิดถึงแต่สิ่งเก่า ๆ',
        ];

        $borrower = [
            'prefix'=>'นาย',
            'firstname' => 'กิตติวัฒน์',
            'lastname' => 'เทียนเพ็ชร',
            'grade' => 'ปี 4',
        ];

        $decrypData = [
            'teachers_prefix' => iconv('UTF-8', 'cp874', $teachers['prefix']),
            'teachers_firstname' => iconv('UTF-8', 'cp874', $teachers['firstname']),
            'teachers_lastname' => iconv('UTF-8', 'cp874', $teachers['lastname']),
            'teachers_position' => iconv('UTF-8', 'cp874', $teachers['position']),
            'teachers_field_of_study' => iconv('UTF-8', 'cp874', $teachers['field_of_study']),
            'teachers_faculty' => iconv('UTF-8', 'cp874', $teachers['faculty']),
            'teachers_comment' => iconv('UTF-8', 'cp874', $teachers['comment']),

            'borrower_prefix' => iconv('UTF-8', 'cp874', $borrower['prefix']),
            'borrower_firstname' => iconv('UTF-8', 'cp874', $borrower['firstname']),
            'borrower_lastname' => iconv('UTF-8', 'cp874', $borrower['lastname']),
            'borrower_grade' => iconv('UTF-8', 'cp874', $borrower['grade']),
        ];

        // Create a StreamedResponse
        return new StreamedResponse(function () use ($decrypData) {
            // Initialize the PDF
            $pdf = new Fpdi();
            
            // Add the page
            $pdf->AddPage();
            $pdf->setSourceFile(public_path('child_document_files/teachers_comment.pdf')); // Import an existing PDF form
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
            $pdf->Text(141, 42,$month);
            $pdf->Text(173, 42,$buddhistYear);

            $teachers_name_input = 74;
            $fullname_teachers_lenght = strlen($decrypData['teachers_prefix'].$decrypData['teachers_firstname'].'   '.$decrypData['teachers_lastname']);
            $teachers_name_x = 51+($teachers_name_input/2 - $fullname_teachers_lenght/2)-3;
            $pdf->Text($teachers_name_x, 58,$decrypData['teachers_prefix'].$decrypData['teachers_firstname'].'   '.$decrypData['teachers_lastname']);
            
            $teachers_position_input = 43;
            $position_teachers_lenght = strlen($decrypData['teachers_position']);
            $teachers_position_x = 140+($teachers_position_input/2 - $position_teachers_lenght/2);
            $pdf->Text($teachers_position_x, 58,$decrypData['teachers_position']);

            $teachers_field_of_study_input = 114;
            $field_of_study_teachers_lenght = strlen($decrypData['teachers_field_of_study']);
            $teachers_field_of_study_x = 69+($teachers_field_of_study_input/2 - $field_of_study_teachers_lenght/2)-3;
            $pdf->Text($teachers_field_of_study_x, 66,$decrypData['teachers_field_of_study']);

            $teachers_faculty_input = 89;
            $faculty_teachers_lenght = strlen($decrypData['teachers_faculty']);
            $teachers_faculty_x = 48+($teachers_faculty_input/2 - $faculty_teachers_lenght/2)-2;
            $pdf->Text($teachers_faculty_x, 75,$decrypData['teachers_faculty']);

            $borrower_name_input = 83;
            $fullname_borrower_lenght = strlen($decrypData['borrower_prefix'].$decrypData['borrower_firstname'].'   '.$decrypData['borrower_lastname']);
            $borrower_name_x = 65+($borrower_name_input/2 - $fullname_borrower_lenght/2)-3;
            $pdf->Text($borrower_name_x, 83,$decrypData['borrower_prefix'].$decrypData['borrower_firstname'].'   '.$decrypData['borrower_lastname']);

            $borrower_grade_input = 7;
            $grade_borrower_lenght = strlen($decrypData['borrower_grade']);
            $borrower_grade_x = 176+($borrower_grade_input/2 - $grade_borrower_lenght/2);
            $pdf->Text($borrower_grade_x, 83,$decrypData['borrower_grade']);

            //comment
            $pdf->SetXY(26, 93);
            $pdf->MultiCell(158, 8,$decrypData['teachers_comment']);
            
            //signature
            $teachers_firstname_input = 65;
            $firstname_teachers_lenght = strlen($decrypData['teachers_firstname']);
            $teachers_firstname_x = 116+($teachers_firstname_input/2 - $firstname_teachers_lenght/2)-2;
            $pdf->Text($teachers_firstname_x, 140,$decrypData['teachers_firstname']);

            $teachers_name_input = 73;
            $grade_teachers_lenght = strlen($decrypData['teachers_prefix'].$decrypData['teachers_firstname'].'   '.$decrypData['teachers_lastname']);
            $teachers_name_x = 108+($teachers_name_input/2 - $grade_teachers_lenght/2)-3;
            $pdf->Text($teachers_name_x, 147,$decrypData['teachers_prefix'].$decrypData['teachers_firstname'].'   '.$decrypData['teachers_lastname']);
            
            $teachers_position_input = 63;
            $position_teachers_lenght = strlen($decrypData['teachers_position']);
            $teachers_position_x = 120+($teachers_position_input/2 - $position_teachers_lenght/2)-2;
            $pdf->Text($teachers_position_x, 155,$decrypData['teachers_position']);

            $pdf->Output(); 
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="generated_form.pdf"',
        ]);
    }
    
}