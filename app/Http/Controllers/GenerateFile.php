<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Borrower;
use App\Models\BorrowerChildDocument;
use App\Models\BorrowerDocument;
use App\Models\BorrowerFiles;
use App\Models\BorrowerNessessities;
use App\Models\BorrowerProperties;
use App\Models\BorrowerRegisterDocument;
use App\Models\BorrowerRegisterType;
use App\Models\Documents;
use App\Models\Faculties;
use App\Models\Majors;
use App\Models\Parents;
use App\Models\TeacherCommentDocuments;
use App\Models\UsefulActivity;
use App\Models\Users;
use setasign\Fpdi\Fpdi;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class GenerateFile extends Controller
{
    function getThaiMonthName($monthNumber)
    {
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

    function calculateAge($birthday)
    {
        list($year, $month, $day) = explode("-", $birthday);
        $gregorianYear = $year - 543;

        // Create Carbon instances for the birth date and the current date
        $birthDate = Carbon::create($gregorianYear, $month, $day);
        $currentDate = Carbon::now();

        // Calculate the age
        $age = $currentDate->diffInYears($birthDate);

        return $age;
    }

    function calculateGrade($student_id)
    {
        $date = date('Y') + 543;
        $firstTwoDigits = floor($date / 100);
        $buddhistCurrentYear = intval(floor($date));
        $beginYear = intval($firstTwoDigits . substr($student_id, 0, 2));
        $grade = ($buddhistCurrentYear - $beginYear) + 1;
        return $grade;
    }

    public function generate_rabrongraidai($user_id, $document)
    {
        $borrower = Users::join('borrowers', 'users.id', '=', 'borrowers.user_id')
            ->where('users.id', $user_id)
            ->select('users.prefix', 'users.firstname', 'users.lastname', 'borrowers.birthday', 'borrowers.id')
            ->first();
        $father = Parents::where('borrower_id', $borrower['id'])->where('borrower_relational', 'บิดา')->select('prefix', 'firstname', 'lastname', 'occupation', 'place_of_work', 'phone', 'income', 'alive')->first();
        $mother = Parents::where('borrower_id', $borrower['id'])->where('borrower_relational', 'มารดา')->select('prefix', 'firstname', 'lastname', 'occupation', 'place_of_work', 'phone', 'income', 'alive')->first();
        $parent = Parents::where('borrower_id', $borrower['id'])->where('borrower_relational', '!=', 'มารดา')->where('borrower_relational', '!=', 'บิดา')->select('prefix', 'firstname', 'lastname', 'occupation', 'place_of_work', 'phone', 'income', 'alive', 'borrower_relational')->first();


        $borrower['prefix'] = iconv('UTF-8', 'cp874', $borrower['prefix']);
        $borrower['firstname'] = iconv('UTF-8', 'cp874', $borrower['firstname']);
        $borrower['lastname'] = iconv('UTF-8', 'cp874', $borrower['lastname']);
        $borrower['birthday'] = iconv('UTF-8', 'cp874', $borrower['birthday']);

        if ($father != null) {
            $father['prefix'] = iconv('UTF-8', 'cp874', $father['prefix']);
            $father['firstname'] = iconv('UTF-8', 'cp874', $father['firstname']);
            $father['lastname'] = iconv('UTF-8', 'cp874', $father['lastname']);
            $father['occupation'] = iconv('UTF-8', 'cp874', $father['occupation']);
            $father['place_of_work'] = iconv('UTF-8', 'cp874', $father['place_of_work']);
            $father['phone'] = iconv('UTF-8', 'cp874', $father['phone']);
            $father['income'] = iconv('UTF-8', 'cp874', $father['income']);
        }

        if ($mother != null) {
            $mother['prefix'] = iconv('UTF-8', 'cp874', $mother['prefix']);
            $mother['firstname'] = iconv('UTF-8', 'cp874', $mother['firstname']);
            $mother['lastname'] = iconv('UTF-8', 'cp874', $mother['lastname']);
            $mother['occupation'] = iconv('UTF-8', 'cp874', $mother['occupation']);
            $mother['place_of_work'] = iconv('UTF-8', 'cp874', $mother['place_of_work']);
            $mother['phone'] = iconv('UTF-8', 'cp874', $mother['phone']);
            $mother['income'] = iconv('UTF-8', 'cp874', $mother['income']);
        }

        if ($parent != null) {
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
        return new StreamedResponse(function () use ($borrower, $father, $mother, $parent, $document) {
            // Initialize the PDF
            $pdf = new Fpdi();

            // Add the page
            $pdf->AddPage();
            $pdf->setSourceFile(public_path($document['file_path'] . '/' . $document['file_name'])); // Import an existing PDF form
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
            $pdf->Text(118, 42, $gregorianDate->day);
            $month = iconv('UTF-8', 'cp874', $this->getThaiMonthName($gregorianDate->month));
            $pdf->Text(140, 42, $month);
            $pdf->Text(172, 42, $buddhistYear);

            $borrower_name_input = 85; //length of input (name>..................<)
            $fullname_borrower_length = strlen($borrower['prefix'] . $borrower['firstname'] . '   ' . $borrower['lastname']); //length of string(prefix,firstname,lastname)
            $borrower_name_x = 77 + ($borrower_name_input / 2 - $fullname_borrower_length / 2) - 6; // x position in tamplate = first_x_position_of_input_line(name.......... , first "." is value of this) + (length_of_input/2 - length_of_string/2) - be_incorrect
            $pdf->Text($borrower_name_x, 68.5, $borrower['prefix'] . $borrower['firstname'] . '   ' . $borrower['lastname']);

            $total_income = 0;
            //father
            if ($father != null) {
                $father_name_input = 75;
                $fullname_father_length = strlen($father['prefix'] . $father['firstname'] . '   ' . $father['lastname']);
                $father_name_x = 58 + ($father_name_input / 2 - $fullname_father_length / 2) - 3;
                $pdf->Text($father_name_x, 76, $father['prefix'] . $father['firstname'] . '   ' . $father['lastname']);

                $father_occupation_input = 51;
                $father_occupation_length = strlen($father['occupation']);
                $father_occupation_x = 49 + ($father_occupation_input / 2 - $father_occupation_length / 2) - 2;
                $pdf->Text($father_occupation_x, 84, $father['occupation']);

                $father_place_of_work_input = 61;
                $father_place_of_work_length = strlen($father['place_of_work']);
                $father_place_of_work_x = 123 + ($father_place_of_work_input / 2 - $father_place_of_work_length / 2) - 2;
                $pdf->Text($father_place_of_work_x, 84, $father['place_of_work']);

                $father_phone_input = 61;
                $father_phone_length = strlen($father['phone']);
                $father_phone_x = 39 + ($father_phone_input / 2 - $father_phone_length / 2) - 2;
                $pdf->Text($father_phone_x, 91, $father['phone']);

                $father_input = 55;
                $father_income_length = strlen($father['income']);
                $father_income_x = 120 + ($father_input / 2 - $father_income_length / 2) - 2;
                $pdf->Text($father_income_x, 91, $father['income']);

                $total_income += (int) str_replace(',', '', $father['income']);

                //tick mark
                if ($father['alive']) {
                    $pdf->Image($tick_alp, 161, 73.5, 4, 4);
                } else {
                    $pdf->Image($tick_alp, 135, 73.5, 4, 4);
                }
            }

            //mother
            if ($mother != null) {
                $mother_name_input = 59;
                $mother_fullname_length = strlen($mother['perfix'] . $mother['firstname'] . '   ' . $mother['lastname']);
                $mother_name_x = 75 + ($mother_name_input / 2 - $mother_fullname_length / 2) - 3;
                $pdf->Text($mother_name_x, 99, $mother['prefix'] . $mother['firstname'] . '   ' . $mother['lastname']);

                $mother_occupation = 51;
                $mother_occupation_length = strlen($mother['occupation']);
                $mother_occupation_x = 49 + ($mother_occupation / 2 - $mother_occupation_length / 2) - 2;
                $pdf->Text($mother_occupation_x, 106, $mother['occupation']);

                $mother_place_of_work_input = 63;
                $mother_place_of_work_length = strlen($mother['place_of_work']);
                $mother_place_of_work_x = 121 + ($mother_place_of_work_input / 2 - $mother_place_of_work_length / 2) - 2;
                $pdf->Text($mother_place_of_work_x, 106, $mother['place_of_work']);

                $mother_phone_input = 60;
                $mother_phone_length = strlen($mother['phone']);
                $mother_phone_x = 39 + ($mother_phone_input / 2 - $mother_phone_length / 2) - 2;
                $pdf->Text($mother_phone_x, 114, $mother['phone']);

                $mother_income_input = 54;
                $mother_income_length = strlen($mother['income']);
                $mother_income_x = 119 + ($mother_income_input / 2 - $mother_income_length / 2) - 2;
                $pdf->Text($mother_income_x, 114, $mother['income']);

                $total_income += (int) str_replace(',', '', $mother['income']);

                //tick mark
                if ($mother['alive']) {
                    $pdf->Image($tick_alp, 161, 96, 4, 4);
                } else {
                    $pdf->Image($tick_alp, 135, 96, 4, 4);
                }
            }

            if ($parent != null) {
                $parent_fullname_input = 62;
                $parent_fullname_length = strlen($parent['prefix'] . $parent['firstname'] . '   ' . $parent['lastname']);
                $parent_fullname_x = 67 + ($parent_fullname_input / 2 - $parent_fullname_length / 2) - 3;
                $pdf->Text($parent_fullname_x, 137, $parent['prefix'] . $parent['firstname'] . '   ' . $parent['lastname']);

                $parent_relational_input = 27;
                $parent_relational_length = strlen($parent['borrower_relational']);
                $parent_relational_x = 156 + ($parent_relational_input / 2 - $parent_relational_length / 2) - 1;
                $pdf->Text($parent_relational_x, 137, $parent['borrower_relational']);

                $parent_occupation_input = 51;
                $parent_occupation_length = strlen($parent['occupation']);
                $parent_occupation_x = 49 + ($parent_occupation_input / 2 - $parent_occupation_length / 2) - 2;
                $pdf->Text($parent_occupation_x, 145, $parent['occupation']);

                $parent_place_of_work_input = 61;
                $parent_place_of_work_length = strlen($parent['place_of_work']);
                $parent_place_of_work_x = 123 + ($parent_place_of_work_input / 2 - $parent_place_of_work_length / 2) - 2;
                $pdf->Text($parent_place_of_work_x, 145, $parent['place_of_work']);

                $parent_phone_input = 61;
                $parent_phone_length = strlen($parent['phone']);
                $parent_phone_x = 39 + ($parent_phone_input / 2 - $parent_phone_length / 2) - 2;
                $pdf->Text($parent_phone_x, 152, $parent['phone']);

                $parent_income_input = 55;
                $parent_income_length = strlen($parent['income']);
                $parent_income_x = 120 + ($parent_income_input / 2 - $parent_income_length / 2) - 2;
                $pdf->Text($parent_income_x, 152, $parent['income']);

                $total_income += (int) str_replace(',', '', $parent['income']);
            }
            $formattedNumber = number_format($total_income);

            $total_income_input = 48;
            $total_income_length = strlen($formattedNumber);
            $total_income_x = 68 + ($total_income_input / 2 - $total_income_length / 2) - 2;
            $pdf->Text($total_income_x, 160, $formattedNumber);

            $filename = 'หนังสือรับรองรายได้ครอบครัว.pdf';
            // Encode the filename
            $encodedFilename = rawurlencode($filename);
            $pdf->Output('I', $encodedFilename);
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="generated_form.pdf"',
        ]);
    }

    public function generate_yinyorm_student($user_id, $document)
    {
        $borrower = Users::join('borrowers', 'users.id', '=', 'borrowers.user_id')
            ->where('users.id', $user_id)
            ->select('users.prefix', 'users.firstname', 'users.lastname', 'users.email', 'borrowers.birthday', 'borrowers.citizen_id', 'borrowers.phone', 'borrowers.address_id')
            ->first();

        // dd($borrower['lastname']);
        $borrower['prefix'] = iconv('UTF-8', 'cp874', $borrower['prefix']);
        $borrower['firstname'] = iconv('UTF-8', 'cp874', $borrower['firstname']);
        $borrower['lastname'] = iconv('UTF-8', 'cp874', $borrower['lastname']);
        $borrower['age'] = iconv('UTF-8', 'cp874', $this->calculateAge($borrower['birthday']));
        $borrower['citizen_id'] = iconv('UTF-8', 'cp874', Crypt::decryptString($borrower['citizen_id']));
        $borrower['phone'] = iconv('UTF-8', 'cp874', $borrower['phone']);
        $borrower['email'] = iconv('UTF-8', 'cp874', $borrower['email']);

        $address = Address::find($borrower['address_id']);
        $address['house_no'] = iconv('UTF-8', 'cp874', $address['house_no']);
        $address['village'] = iconv('UTF-8', 'cp874', $address['village']);
        $address['tambon'] = iconv('UTF-8', 'cp874', $address['tambon']);
        $address['aumphure'] = iconv('UTF-8', 'cp874', $address['aumphure']);
        $address['province'] = iconv('UTF-8', 'cp874', $address['province']);
        $address['post_code'] = iconv('UTF-8', 'cp874', $address['post_code']);

        // Create a StreamedResponse
        return new StreamedResponse(function () use ($borrower, $address, $document) {
            // Initialize the PDF
            $pdf = new Fpdi();

            // Add the page
            $pdf->AddPage();
            $pdf->setSourceFile(public_path($document['file_path'] . '/' . $document['file_name'])); // Import an existing PDF form
            $templateId = $pdf->importPage(1);
            $pdf->useTemplate($templateId, 0, 0);

            //date
            $gregorianDate = Carbon::now();
            $buddhistYear = $gregorianDate->year + 543;

            // Set the font and add text at specific locations
            $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
            $pdf->SetFont('THSarabunNew', '', 14);

            //Write at
            $write_at_input = 36;
            $write_at_length = strlen($address['village']);
            $write_at_x = 148 + ($write_at_input / 2 - $write_at_length / 2) - 2;
            $pdf->Text($write_at_x, 42, $address['village']);

            //write date
            $pdf->Text(114, 50, $gregorianDate->day);
            $month = iconv('UTF-8', 'cp874', $this->getThaiMonthName($gregorianDate->month));
            $pdf->Text(139, 50, $month);
            $pdf->Text(173, 50, $buddhistYear);

            $name_input = 80;
            $fullname_length = strlen($borrower['prefix'] . $borrower['firstname'] . '   ' . $borrower['lastname']);
            $name_x = 79 + ($name_input / 2 - $fullname_length / 2) - 3;
            $pdf->Text($name_x, 62, $borrower['prefix'] . $borrower['firstname'] . '   ' . $borrower['lastname']);

            $age_input = 15;
            $age_length = strlen($borrower['age']);
            $age_x = 166 + ($age_input / 2 - $age_length / 2);
            $pdf->Text($age_x, 62, $borrower['age']);

            $citizen_id_input = 94;
            $citizen_id_length = strlen($borrower['citizen_id']);
            $citizen_id_x = 89 + ($citizen_id_input / 2 - $citizen_id_length / 2) - 3;
            $pdf->Text($citizen_id_x, 70.5, $borrower['citizen_id']);

            $house_no_input = 29;
            $house_no_length = strlen($address['house_no']);
            $house_no_x = 54 + ($house_no_input / 2 - $house_no_length / 2) - 2;
            $pdf->Text($house_no_x, 79, $address['house_no']);

            $village_input = 12;
            $village_length = strlen($address['village']);
            $village_x = 89 + ($village_input / 2 - $village_length / 2) - 1;
            $pdf->Text($village_x, 79, $address['village']);

            $tambon_input = 31;
            $tambon_length = strlen($address['tambon']);
            $tambon_x = 111 + ($tambon_input / 2 - $tambon_length / 2) - 2;
            $pdf->Text($tambon_x, 79, $address['tambon']);

            $aumphure_input = 30;
            $aumphure_length = strlen($address['aumphure']);
            $aumphure_x = 153 + ($aumphure_input / 2 - $aumphure_length / 2) - 1;
            $pdf->Text($aumphure_x, 79, $address['aumphure']);

            $province_input = 35;
            $province_length = strlen($address['province']);
            $province_x = 36 + ($province_input / 2 - $province_length / 2) - 2;
            $pdf->Text($province_x, 86, $address['province']);

            $postcode_input = 27;
            $postcode_length = strlen($address['postcode']);
            $postcode_x = 93 + ($postcode_input / 2 - $postcode_length / 2) - 2;
            $pdf->Text($postcode_x, 86, $address['postcode']);

            $phone_input = 49;
            $phone_length = strlen($borrower['phone']);
            $phone_x = 134 + ($phone_input / 2 - $phone_length / 2) - 2;
            $pdf->Text($phone_x, 86, $borrower['phone']);

            $email_input = 150;
            $email_length = strlen($borrower['email']);
            $email_x = 34 + ($email_input / 2 - $email_length / 2) - 10;
            $pdf->Text($email_x, 94, $borrower['email']);

            $signature = 77;
            $signature_x = 103 + ($signature / 2 - $fullname_length / 2) - 3;
            $pdf->Text($signature_x, 245, $borrower['prefix'] . $borrower['firstname'] . '   ' . $borrower['lastname']);

            //tick mark
            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 58, 99, 4, 4);

            $filename = 'หนังสือยินยอมให้เปิดเผยข้อมูลผู้กู้.pdf';
            // Encode the filename
            $encodedFilename = rawurlencode($filename);

            $pdf->Output('I', $encodedFilename);
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="generated_form.pdf"',
        ]);
    }

    public function generate_yinyorm_parent($parent_id, $user_id, $document)
    {
        $parent = Parents::where('id', $parent_id)
            ->select('prefix', 'firstname', 'lastname', 'email', 'birthday', 'citizen_id', 'phone', 'address_id', 'borrower_id')
            ->first();

        $borrower = Users::join('borrowers', 'users.id', '=', 'borrowers.user_id')
            ->where('users.id', $user_id)
            ->select('users.prefix', 'users.firstname', 'users.lastname')
            ->first();

        // dd($borrower['lastname']);
        $parent['prefix'] = iconv('UTF-8', 'cp874', $parent['prefix']);
        $parent['firstname'] = iconv('UTF-8', 'cp874', $parent['firstname']);
        $parent['lastname'] = iconv('UTF-8', 'cp874', $parent['lastname']);
        $parent['age'] = iconv('UTF-8', 'cp874', $this->calculateAge($parent['birthday']));
        $parent['citizen_id'] = iconv('UTF-8', 'cp874', Crypt::decryptString($parent['citizen_id']));
        $parent['phone'] = iconv('UTF-8', 'cp874', $parent['phone']);
        $parent['email'] = iconv('UTF-8', 'cp874', $parent['email']);

        $address = Address::find($parent['address_id']);
        $address['house_no'] = iconv('UTF-8', 'cp874', $address['house_no']);
        $address['village'] = iconv('UTF-8', 'cp874', $address['village']);
        $address['tambon'] = iconv('UTF-8', 'cp874', $address['tambon']);
        $address['aumphure'] = iconv('UTF-8', 'cp874', $address['aumphure']);
        $address['province'] = iconv('UTF-8', 'cp874', $address['province']);
        $address['post_code'] = iconv('UTF-8', 'cp874', $address['post_code']);

        $borrower['prefix'] = iconv('UTF-8', 'cp874', $borrower['prefix']);
        $borrower['firstname'] = iconv('UTF-8', 'cp874', $borrower['firstname']);
        $borrower['lastname'] = iconv('UTF-8', 'cp874', $borrower['lastname']);

        // Create a StreamedResponse
        return new StreamedResponse(function () use ($parent, $address, $borrower, $document) {
            // Initialize the PDF
            $pdf = new Fpdi();

            // Add the page
            $pdf->AddPage();
            $pdf->setSourceFile(public_path($document['file_path'] . '/' . $document['file_name'])); // Import an existing PDF form
            $templateId = $pdf->importPage(1);
            $pdf->useTemplate($templateId, 0, 0);

            //date
            $gregorianDate = Carbon::now();
            $buddhistYear = $gregorianDate->year + 543;

            // Set the font and add text at specific locations
            $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
            $pdf->SetFont('THSarabunNew', '', 14);

            //Write at
            $write_at_input = 36;
            $write_at_length = strlen($address['village']);
            $write_at_x = 148 + ($write_at_input / 2 - $write_at_length / 2) - 2;
            $pdf->Text($write_at_x, 42, $address['village']);

            //write date
            $pdf->Text(114, 50, $gregorianDate->day);
            $month = iconv('UTF-8', 'cp874', $this->getThaiMonthName($gregorianDate->month));
            $pdf->Text(139, 50, $month);
            $pdf->Text(173, 50, $buddhistYear);

            $name_input = 80;
            $fullname_length = strlen($parent['prefix'] . $parent['firstname'] . '   ' . $parent['lastname']);
            $name_x = 79 + ($name_input / 2 - $fullname_length / 2) - 3;
            $pdf->Text($name_x, 62, $parent['prefix'] . $parent['firstname'] . '   ' . $parent['lastname']);

            $age_input = 15;
            $age_length = strlen($parent['age']);
            $age_x = 166 + ($age_input / 2 - $age_length / 2);
            $pdf->Text($age_x, 62, $parent['age']);

            $citizen_id_input = 94;
            $citizen_id_length = strlen($parent['citizen_id']);
            $citizen_id_x = 89 + ($citizen_id_input / 2 - $citizen_id_length / 2) - 3;
            $pdf->Text($citizen_id_x, 70.5, $parent['citizen_id']);

            $house_no_input = 29;
            $house_no_length = strlen($address['house_no']);
            $house_no_x = 54 + ($house_no_input / 2 - $house_no_length / 2) - 2;
            $pdf->Text($house_no_x, 79, $address['house_no']);

            $village_input = 12;
            $village_length = strlen($address['village']);
            $village_x = 89 + ($village_input / 2 - $village_length / 2) - 1;
            $pdf->Text($village_x, 79, $address['village']);

            $tambon_input = 31;
            $tambon_length = strlen($address['tambon']);
            $tambon_x = 111 + ($tambon_input / 2 - $tambon_length / 2) - 2;
            $pdf->Text($tambon_x, 79, $address['tambon']);

            $aumphure_input = 30;
            $aumphure_length = strlen($address['aumphure']);
            $aumphure_x = 153 + ($aumphure_input / 2 - $aumphure_length / 2) - 1;
            $pdf->Text($aumphure_x, 79, $address['aumphure']);

            $province_input = 35;
            $province_length = strlen($address['province']);
            $province_x = 36 + ($province_input / 2 - $province_length / 2) - 2;
            $pdf->Text($province_x, 86, $address['province']);

            $postcode_input = 27;
            $postcode_length = strlen($address['postcode']);
            $postcode_x = 93 + ($postcode_input / 2 - $postcode_length / 2) - 2;
            $pdf->Text($postcode_x, 86, $address['postcode']);

            $phone_input = 49;
            $phone_length = strlen($parent['phone']);
            $phone_x = 134 + ($phone_input / 2 - $phone_length / 2) - 2;
            $pdf->Text($phone_x, 86, $parent['phone']);

            $email_input = 150;
            $email_length = strlen($parent['email']);
            $email_x = 34 + ($email_input / 2 - $email_length / 2) - 10;
            $pdf->Text($email_x, 94, $parent['email']);

            $borrower_name_input = 76;
            $fullname_borrower_length = strlen($borrower['prefix'] . $borrower['firstname'] . '   ' . $borrower['lastname']);
            $borrower_name_x = 50 + ($borrower_name_input / 2 - $fullname_borrower_length / 2) - 3;
            $pdf->Text($borrower_name_x, 109, $borrower['prefix'] . $borrower['firstname'] . '   ' . $borrower['lastname']);


            $signature = 77;
            $signature_x = 103 + ($signature / 2 - $fullname_length / 2) - 3;
            $pdf->Text($signature_x, 245, $parent['prefix'] . $parent['firstname'] . '   ' . $parent['lastname']);


            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 90, 99, 4, 4);

            $filename = 'หนังสือยินยอมให้เปิดเผยข้อมูลผู้ปกครอง' . '.pdf';
            // Encode the filename
            $encodedFilename = rawurlencode($filename);
            $pdf->Output('I', $encodedFilename);
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="generated_form.pdf"',
        ]);
    }

    public function teacherCommentDocument103($borrower_uid, $borrower_document_id)
    {
        // $document = Documents::find($document_id);
        $teacher_uid = TeacherCommentDocuments::where('borrower_document_id', $borrower_document_id)->value('teacher_uid');
        $borrower = Users::join('borrowers', 'users.id', '=', 'borrowers.user_id')
            ->where('users.id', $borrower_uid)
            ->select('users.prefix', 'users.firstname', 'users.lastname', 'borrowers.id', 'borrowers.student_id')
            ->first();

        $borrower['prefix'] = iconv('UTF-8', 'cp874', $borrower['prefix']);
        $borrower['firstname'] = iconv('UTF-8', 'cp874', $borrower['firstname']);
        $borrower['lastname'] = iconv('UTF-8', 'cp874', $borrower['lastname']);
        $borrower['grade'] = iconv('UTF-8', 'cp874', $this->calculateGrade($borrower['student_id']));

        $teacher = Users::join('teacher_accounts', 'teacher_accounts.user_id', '=', 'users.id')
            ->join('faculties', 'faculties.id', '=', 'teacher_accounts.faculty_id')
            ->join('majors', 'majors.id', '=', 'teacher_accounts.major_id')
            ->where('users.id', $teacher_uid)
            ->select('users.*', 'faculties.faculty_name', 'majors.major_name')
            ->first() ?? null;


        $teacher_comments = TeacherCommentDocuments::join('teacher_comments', 'teacher_comments.id', '=', 'teacher_comment_documents.teacher_comment_id')
            ->where('teacher_comment_documents.borrower_document_id', $borrower_document_id)
            ->select('teacher_comments.comment', 'teacher_comment_documents.updated_at')
            ->get() ?? null;

        $teacher_other_comment = TeacherCommentDocuments::where('borrower_document_id', $borrower_document_id)->where('teacher_comment_id', null)->first() ?? null;
        $strconcat_teacher_comments = '';

        if (($teacher_comments != null || $teacher_other_comment != null) && $teacher != null) {
            $faculty = str_replace("คณะ", "", $teacher['faculty_name']);
            $faculty = str_replace("วิทยาลัย", "", $teacher['faculty_name']);
            $major = str_replace("สาขาวิชา", "", $teacher['major_name']);
            $commented_date = $teacher_comments[0]['updated_at'] ?? $teacher_other_comment['updated_at'];
            $teacher['prefix'] = iconv('UTF-8', 'cp874', $teacher['prefix']);
            $teacher['firstname'] = iconv('UTF-8', 'cp874', $teacher['firstname']);
            $teacher['lastname'] = iconv('UTF-8', 'cp874', $teacher['lastname']);
            $teacher['faculty_name'] = iconv('UTF-8', 'cp874', $faculty);
            $teacher['major_name'] = iconv('UTF-8', 'cp874', $major);

            foreach ($teacher_comments as $teacher_comment) {
                $strconcat_teacher_comments .= $teacher_comment->comment;
            }
            $strconcat_teacher_comments .= $teacher_other_comment->custom_comment ?? '';
            $strconcat_teacher_comments = iconv('UTF-8', 'cp874', $strconcat_teacher_comments);
            $commented = true;
        } else {
            $commented = false;
            $commented_date = null;
        }

        // Create a StreamedResponse
        return new StreamedResponse(function () use ($borrower, $teacher, $strconcat_teacher_comments, $commented, $commented_date) {
            // Initialize the PDF
            $pdf = new Fpdi();

            // Add the page
            $pdf->AddPage();
            $pdf->setSourceFile(public_path('child_document_files/teachers_comment.pdf')); // Import an existing PDF form
            $templateId = $pdf->importPage(1);
            $pdf->useTemplate($templateId, 0, 0);


            // Set the font and add text at specific locations
            $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
            $pdf->SetFont('THSarabunNew', '', 12);

            $position = iconv('UTF-8', 'cp874', 'อาจาร์ที่ปรึกษา');
            //date
            if ($commented) {
                $gregorianDate = Carbon::createFromFormat('Y-m-d H:i:s', $commented_date);
                $buddhistYear = $gregorianDate->year + 543;

                // write date
                $pdf->Text(118, 42, $gregorianDate->day);
                $month = iconv('UTF-8', 'cp874', $this->getThaiMonthName($gregorianDate->month));
                $pdf->Text(141, 42, $month);
                $pdf->Text(173, 42, $buddhistYear);

                $teacher_fullname_input = 74;
                $teacher_fullname_length = strlen($teacher['prefix'] . $teacher['firstname'] . '   ' . $teacher['lastname']);
                $teacher_fullname_x = 51 + ($teacher_fullname_input / 2 - $teacher_fullname_length / 2) - 3;
                $pdf->Text($teacher_fullname_x, 58, $teacher['prefix'] . $teacher['firstname'] . '   ' . $teacher['lastname']);

                $teacher_position_input = 43;
                $teacher_position_length = strlen($position);
                $teacher_position_x = 140 + ($teacher_position_input / 2 - $teacher_position_length / 2);
                $pdf->Text($teacher_position_x, 58, $position);

                $teacher_major_input = 114;
                $teacher_major_length = strlen($teacher['major_name']);
                $teacher_major_x = 69 + ($teacher_major_input / 2 - $teacher_major_length / 2) - 3;
                $pdf->Text($teacher_major_x, 66, $teacher['major_name']);

                $teacher_faculty_input = 89;
                $teacher_faculty_length = strlen($teacher['faculty_name']);
                $teacher_faculty_x = 48 + ($teacher_faculty_input / 2 - $teacher_faculty_length / 2) - 2;
                $pdf->Text($teacher_faculty_x, 74.5, $teacher['faculty_name']);

                // comment  
                $pdf->SetXY(26, 94);
                $pdf->MultiCell(158, 8, $strconcat_teacher_comments);

                // signature
                $teacher_firstname_input = 65;
                $teacher_firstname_length = strlen($teacher['firstname']);
                $teacher_firstname_x = 116 + ($teacher_firstname_input / 2 - $teacher_firstname_length / 2) - 2;
                $pdf->Text($teacher_firstname_x, 140, $teacher['firstname']);

                $teacher_fullname_input = 73;
                $teacher_fullname_length = strlen($teacher['prefix'] . $teacher['firstname'] . '   ' . $teacher['lastname']);
                $teacher_fullname_x = 108 + ($teacher_fullname_input / 2 - $teacher_fullname_length / 2) - 3;
                $pdf->Text($teacher_fullname_x, 147, $teacher['prefix'] . $teacher['firstname'] . '   ' . $teacher['lastname']);

                $teacher_position_input = 63;
                $teacher_position_length = strlen($position);
                $teacher_position_x = 120 + ($teacher_position_input / 2 - $teacher_position_length / 2) - 2;
                $pdf->Text($teacher_position_x, 155, $position);
            }

            $borrower_fullname_input = 83;
            $borrower_fullname_length = strlen($borrower['prefix'] . $borrower['firstname'] . '   ' . $borrower['lastname']);
            $borrower_fullname_x = 65 + ($borrower_fullname_input / 2 - $borrower_fullname_length / 2) - 3;
            $pdf->Text($borrower_fullname_x, 83, $borrower['prefix'] . $borrower['firstname'] . '   ' . $borrower['lastname']);

            $pdf->Text(178, 83, $borrower['grade']);

            $pdf->Output();
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="generated_form.pdf"',
        ]);
    }

    public function saveDocument103($borrower_uid, $borrower_document_id){
        // $document = Documents::find($document_id);
        $teacher_uid = TeacherCommentDocuments::where('borrower_document_id', $borrower_document_id)->value('teacher_uid');
        $borrower = Users::join('borrowers', 'users.id', '=', 'borrowers.user_id')
            ->where('users.id', $borrower_uid)
            ->select('users.prefix', 'users.firstname', 'users.lastname', 'borrowers.id', 'borrowers.student_id')
            ->first();

        $borrower['prefix'] = iconv('UTF-8', 'cp874', $borrower['prefix']);
        $borrower['firstname'] = iconv('UTF-8', 'cp874', $borrower['firstname']);
        $borrower['lastname'] = iconv('UTF-8', 'cp874', $borrower['lastname']);
        $borrower['grade'] = iconv('UTF-8', 'cp874', $this->calculateGrade($borrower['student_id']));

        $teacher = Users::join('teacher_accounts', 'teacher_accounts.user_id', '=', 'users.id')
            ->join('faculties', 'faculties.id', '=', 'teacher_accounts.faculty_id')
            ->join('majors', 'majors.id', '=', 'teacher_accounts.major_id')
            ->where('users.id', $teacher_uid)
            ->select('users.*', 'faculties.faculty_name', 'majors.major_name')
            ->first() ?? null;


        $teacher_comments = TeacherCommentDocuments::join('teacher_comments', 'teacher_comments.id', '=', 'teacher_comment_documents.teacher_comment_id')
            ->where('teacher_comment_documents.borrower_document_id', $borrower_document_id)
            ->select('teacher_comments.comment', 'teacher_comment_documents.updated_at')
            ->get() ?? null;

        $teacher_other_comment = TeacherCommentDocuments::where('borrower_document_id', $borrower_document_id)->where('teacher_comment_id', null)->first() ?? null;
        $strconcat_teacher_comments = '';

        if (($teacher_comments != null || $teacher_other_comment != null) && $teacher != null) {
            $faculty = str_replace("คณะ", "", $teacher['faculty_name']);
            $faculty = str_replace("วิทยาลัย", "", $teacher['faculty_name']);
            $major = str_replace("สาขาวิชา", "", $teacher['major_name']);
            $commented_date = $teacher_comments[0]['updated_at'] ?? $teacher_other_comment['updated_at'];
            $teacher['prefix'] = iconv('UTF-8', 'cp874', $teacher['prefix']);
            $teacher['firstname'] = iconv('UTF-8', 'cp874', $teacher['firstname']);
            $teacher['lastname'] = iconv('UTF-8', 'cp874', $teacher['lastname']);
            $teacher['faculty_name'] = iconv('UTF-8', 'cp874', $faculty);
            $teacher['major_name'] = iconv('UTF-8', 'cp874', $major);

            foreach ($teacher_comments as $teacher_comment) {
                $strconcat_teacher_comments .= $teacher_comment->comment;
            }
            $strconcat_teacher_comments .= $teacher_other_comment->custom_comment ?? '';
            $strconcat_teacher_comments = iconv('UTF-8', 'cp874', $strconcat_teacher_comments);
            $commented = true;
        } else {
            $commented = false;
            $commented_date = null;
        }
        //generate file
        $pdf = new Fpdi();

        // Add the page
        $pdf->AddPage();
        $pdf->setSourceFile(public_path('child_document_files/teachers_comment.pdf')); // Import an existing PDF form
        $templateId = $pdf->importPage(1);
        $pdf->useTemplate($templateId, 0, 0);


        // Set the font and add text at specific locations
        $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
        $pdf->SetFont('THSarabunNew', '', 12);

        $position = iconv('UTF-8', 'cp874', 'อาจาร์ที่ปรึกษา');
        //date
        if ($commented) {
            $gregorianDate = Carbon::createFromFormat('Y-m-d H:i:s', $commented_date);
            $buddhistYear = $gregorianDate->year + 543;

            // write date
            $pdf->Text(118, 42, $gregorianDate->day);
            $month = iconv('UTF-8', 'cp874', $this->getThaiMonthName($gregorianDate->month));
            $pdf->Text(141, 42, $month);
            $pdf->Text(173, 42, $buddhistYear);

            $teacher_fullname_input = 74;
            $teacher_fullname_length = strlen($teacher['prefix'] . $teacher['firstname'] . '   ' . $teacher['lastname']);
            $teacher_fullname_x = 51 + ($teacher_fullname_input / 2 - $teacher_fullname_length / 2) - 3;
            $pdf->Text($teacher_fullname_x, 58, $teacher['prefix'] . $teacher['firstname'] . '   ' . $teacher['lastname']);

            $teacher_position_input = 43;
            $teacher_position_length = strlen($position);
            $teacher_position_x = 140 + ($teacher_position_input / 2 - $teacher_position_length / 2);
            $pdf->Text($teacher_position_x, 58, $position);

            $teacher_major_input = 114;
            $teacher_major_length = strlen($teacher['major_name']);
            $teacher_major_x = 69 + ($teacher_major_input / 2 - $teacher_major_length / 2) - 3;
            $pdf->Text($teacher_major_x, 66, $teacher['major_name']);

            $teacher_faculty_input = 89;
            $teacher_faculty_length = strlen($teacher['faculty_name']);
            $teacher_faculty_x = 48 + ($teacher_faculty_input / 2 - $teacher_faculty_length / 2) - 2;
            $pdf->Text($teacher_faculty_x, 74.5, $teacher['faculty_name']);

            // comment  
            $pdf->SetXY(26, 94);
            $pdf->MultiCell(158, 8, $strconcat_teacher_comments);

            // signature
            $teacher_firstname_input = 65;
            $teacher_firstname_length = strlen($teacher['firstname']);
            $teacher_firstname_x = 116 + ($teacher_firstname_input / 2 - $teacher_firstname_length / 2) - 2;
            $pdf->Text($teacher_firstname_x, 140, $teacher['firstname']);

            $teacher_fullname_input = 73;
            $teacher_fullname_length = strlen($teacher['prefix'] . $teacher['firstname'] . '   ' . $teacher['lastname']);
            $teacher_fullname_x = 108 + ($teacher_fullname_input / 2 - $teacher_fullname_length / 2) - 3;
            $pdf->Text($teacher_fullname_x, 147, $teacher['prefix'] . $teacher['firstname'] . '   ' . $teacher['lastname']);

            $teacher_position_input = 63;
            $teacher_position_length = strlen($position);
            $teacher_position_x = 120 + ($teacher_position_input / 2 - $teacher_position_length / 2) - 2;
            $pdf->Text($teacher_position_x, 155, $position);
        }

        $borrower_fullname_input = 83;
        $borrower_fullname_length = strlen($borrower['prefix'] . $borrower['firstname'] . '   ' . $borrower['lastname']);
        $borrower_fullname_x = 65 + ($borrower_fullname_input / 2 - $borrower_fullname_length / 2) - 3;
        $pdf->Text($borrower_fullname_x, 83, $borrower['prefix'] . $borrower['firstname'] . '   ' . $borrower['lastname']);

        $pdf->Text(178, 83, $borrower['grade']);
        //outpufile
        $custom_filename = now()->format('Y-m-d_H-i-s') . '_' . 'กยศ 103_' . $borrower_uid . '.pdf';
        $tempPath = storage_path('app/temp/' . $custom_filename);

        if (!File::exists(storage_path('app/temp'))) {
            File::makeDirectory(storage_path('app/temp'), 0755, true);
        }
        $pdf->Output($tempPath, 'F');
        return $tempPath;
    }

    public function saveTeacherCommentDocument103($borrower_uid, $borrower_document_id){
        // $document = Documents::find($document_id);
        $teacher_uid = TeacherCommentDocuments::where('borrower_document_id', $borrower_document_id)->value('teacher_uid');
        $borrower = Users::join('borrowers', 'users.id', '=', 'borrowers.user_id')
            ->where('users.id', $borrower_uid)
            ->select('users.prefix', 'users.firstname', 'users.lastname', 'borrowers.id', 'borrowers.student_id')
            ->first();

        $borrower['prefix'] = iconv('UTF-8', 'cp874', $borrower['prefix']);
        $borrower['firstname'] = iconv('UTF-8', 'cp874', $borrower['firstname']);
        $borrower['lastname'] = iconv('UTF-8', 'cp874', $borrower['lastname']);
        $borrower['grade'] = iconv('UTF-8', 'cp874', $this->calculateGrade($borrower['student_id']));

        $teacher = Users::join('teacher_accounts', 'teacher_accounts.user_id', '=', 'users.id')
            ->join('faculties', 'faculties.id', '=', 'teacher_accounts.faculty_id')
            ->join('majors', 'majors.id', '=', 'teacher_accounts.major_id')
            ->where('users.id', $teacher_uid)
            ->select('users.*', 'faculties.faculty_name', 'majors.major_name')
            ->first() ?? null;


        $teacher_comments = TeacherCommentDocuments::join('teacher_comments', 'teacher_comments.id', '=', 'teacher_comment_documents.teacher_comment_id')
            ->where('teacher_comment_documents.borrower_document_id', $borrower_document_id)
            ->select('teacher_comments.comment', 'teacher_comment_documents.updated_at')
            ->get() ?? null;

        $teacher_other_comment = TeacherCommentDocuments::where('borrower_document_id', $borrower_document_id)->where('teacher_comment_id', null)->first() ?? null;
        $strconcat_teacher_comments = '';

        if (($teacher_comments != null || $teacher_other_comment != null) && $teacher != null) {
            $faculty = str_replace("คณะ", "", $teacher['faculty_name']);
            $faculty = str_replace("วิทยาลัย", "", $teacher['faculty_name']);
            $major = str_replace("สาขาวิชา", "", $teacher['major_name']);
            $commented_date = $teacher_comments[0]['updated_at'] ?? $teacher_other_comment['updated_at'];
            $teacher['prefix'] = iconv('UTF-8', 'cp874', $teacher['prefix']);
            $teacher['firstname'] = iconv('UTF-8', 'cp874', $teacher['firstname']);
            $teacher['lastname'] = iconv('UTF-8', 'cp874', $teacher['lastname']);
            $teacher['faculty_name'] = iconv('UTF-8', 'cp874', $faculty);
            $teacher['major_name'] = iconv('UTF-8', 'cp874', $major);

            foreach ($teacher_comments as $teacher_comment) {
                $strconcat_teacher_comments .= $teacher_comment->comment;
            }
            $strconcat_teacher_comments .= $teacher_other_comment->custom_comment ?? '';
            $strconcat_teacher_comments = iconv('UTF-8', 'cp874', $strconcat_teacher_comments);
            $commented = true;
        } else {
            $commented = false;
            $commented_date = null;
        }
        //generate file
        $pdf = new Fpdi();

        // Add the page
        $pdf->AddPage();
        $pdf->setSourceFile(public_path('child_document_files/teachers_comment.pdf')); // Import an existing PDF form
        $templateId = $pdf->importPage(1);
        $pdf->useTemplate($templateId, 0, 0);


        // Set the font and add text at specific locations
        $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
        $pdf->SetFont('THSarabunNew', '', 12);

        $position = iconv('UTF-8', 'cp874', 'อาจาร์ที่ปรึกษา');
        //date
        if ($commented) {
            $gregorianDate = Carbon::createFromFormat('Y-m-d H:i:s', $commented_date);
            $buddhistYear = $gregorianDate->year + 543;

            // write date
            $pdf->Text(118, 42, $gregorianDate->day);
            $month = iconv('UTF-8', 'cp874', $this->getThaiMonthName($gregorianDate->month));
            $pdf->Text(141, 42, $month);
            $pdf->Text(173, 42, $buddhistYear);

            $teacher_fullname_input = 74;
            $teacher_fullname_length = strlen($teacher['prefix'] . $teacher['firstname'] . '   ' . $teacher['lastname']);
            $teacher_fullname_x = 51 + ($teacher_fullname_input / 2 - $teacher_fullname_length / 2) - 3;
            $pdf->Text($teacher_fullname_x, 58, $teacher['prefix'] . $teacher['firstname'] . '   ' . $teacher['lastname']);

            $teacher_position_input = 43;
            $teacher_position_length = strlen($position);
            $teacher_position_x = 140 + ($teacher_position_input / 2 - $teacher_position_length / 2);
            $pdf->Text($teacher_position_x, 58, $position);

            $teacher_major_input = 114;
            $teacher_major_length = strlen($teacher['major_name']);
            $teacher_major_x = 69 + ($teacher_major_input / 2 - $teacher_major_length / 2) - 3;
            $pdf->Text($teacher_major_x, 66, $teacher['major_name']);

            $teacher_faculty_input = 89;
            $teacher_faculty_length = strlen($teacher['faculty_name']);
            $teacher_faculty_x = 48 + ($teacher_faculty_input / 2 - $teacher_faculty_length / 2) - 2;
            $pdf->Text($teacher_faculty_x, 74.5, $teacher['faculty_name']);

            // comment  
            $pdf->SetXY(26, 94);
            $pdf->MultiCell(158, 8, $strconcat_teacher_comments);

            // signature
            $teacher_firstname_input = 65;
            $teacher_firstname_length = strlen($teacher['firstname']);
            $teacher_firstname_x = 116 + ($teacher_firstname_input / 2 - $teacher_firstname_length / 2) - 2;
            $pdf->Text($teacher_firstname_x, 140, $teacher['firstname']);

            $teacher_fullname_input = 73;
            $teacher_fullname_length = strlen($teacher['prefix'] . $teacher['firstname'] . '   ' . $teacher['lastname']);
            $teacher_fullname_x = 108 + ($teacher_fullname_input / 2 - $teacher_fullname_length / 2) - 3;
            $pdf->Text($teacher_fullname_x, 147, $teacher['prefix'] . $teacher['firstname'] . '   ' . $teacher['lastname']);

            $teacher_position_input = 63;
            $teacher_position_length = strlen($position);
            $teacher_position_x = 120 + ($teacher_position_input / 2 - $teacher_position_length / 2) - 2;
            $pdf->Text($teacher_position_x, 155, $position);
        }

        $borrower_fullname_input = 83;
        $borrower_fullname_length = strlen($borrower['prefix'] . $borrower['firstname'] . '   ' . $borrower['lastname']);
        $borrower_fullname_x = 65 + ($borrower_fullname_input / 2 - $borrower_fullname_length / 2) - 3;
        $pdf->Text($borrower_fullname_x, 83, $borrower['prefix'] . $borrower['firstname'] . '   ' . $borrower['lastname']);

        $pdf->Text(178, 83, $borrower['grade']);
        //outpufile
        $custom_filename = now()->format('Y-m-d_H-i-s') . '_' . 'กยศ 103_' . $borrower_uid . '.pdf';
        $tempPath = storage_path('app/temp/' . $custom_filename);

        if (!File::exists(storage_path('app/temp'))) {
            File::makeDirectory(storage_path('app/temp'), 0755, true);
        }
        $pdf->Output($tempPath, 'F');
        return $tempPath;
    }

    public function borrowerDocument101($user_id, $child_document, $document_id)
    {

        $document = Documents::find($document_id);

        $borrower = Users::join('borrowers', 'users.id', '=', 'borrowers.user_id')
            ->where('users.id', $user_id)
            ->select('users.prefix', 'users.firstname', 'users.lastname', 'borrowers.id', 'borrowers.address_id', 'borrowers.student_id', 'borrowers.faculty_id', 'borrowers.major_id', 'borrowers.gpa', 'borrowers.marital_status', 'borrowers.phone',)
            ->first();
        $father = Parents::where('borrower_id', $borrower['id'])->where('borrower_relational', 'บิดา')->select('prefix', 'firstname', 'lastname', 'occupation', 'place_of_work', 'phone', 'income', 'alive')->first();
        $mother = Parents::where('borrower_id', $borrower['id'])->where('borrower_relational', 'มารดา')->select('prefix', 'firstname', 'lastname', 'occupation', 'place_of_work', 'phone', 'income', 'alive')->first();
        $parents = Parents::where('borrower_id', $borrower['id'])->where('borrower_relational', '!=', 'มารดา')->where('borrower_relational', '!=', 'บิดา')->select('prefix', 'firstname', 'lastname', 'occupation', 'place_of_work', 'phone', 'income', 'alive', 'borrower_relational')->get();
        $borrower_address = Address::find($borrower['address_id']);
        $borrower_register_documents = BorrowerRegisterDocument::where('user_id', $user_id)->pluck('register_document_id')->toArray();

        $faculty = Faculties::where('id', $borrower['faculty_id'])->value('faculty_name');
        $faculty = str_replace("คณะ", "", $faculty);
        $faculty = str_replace("วิทยาลัย", "", $faculty);
        $major = Majors::where('id', $borrower['major_id'])->value('major_name');
        $major = str_replace("สาขาวิชา", "", $major);

        $useful_activities_hours_sum = UsefulActivity::where('user_id', $user_id)->where('document_id', $document->id)->sum('hour_count') ?? 0;
        $borrower_properties = BorrowerProperties::where('borrower_id', $borrower['id'])->pluck('property_id')->toArray();
        $borrower_nesseessities = BorrowerNessessities::join('nessessities', 'borrower_nessessities.nessessity_id', '=', 'nessessities.id')
            ->where('borrower_nessessities.borrower_id', $borrower['id'])
            ->select('nessessities.nessessity_title')
            ->get();
        $borrower_nesseessity_other = BorrowerNessessities::where('borrower_id', $borrower['id'])->where('nessessity_id', null)->first();
        $borrower_nesseessity_concat = '';
        foreach ($borrower_nesseessities as $nessessity) {
            $borrower_nesseessity_concat .= $nessessity['nessessity_title'] . ' ';
        }
        $borrower_nesseessity_concat .= $borrower_nesseessity_other['other'] ?? ' ';
        $borrower_nesseessity_concat = iconv('UTF-8', 'cp874', $borrower_nesseessity_concat);

        $borrower['prefix'] = iconv('UTF-8', 'cp874', $borrower['prefix']);
        $borrower['firstname'] = iconv('UTF-8', 'cp874', $borrower['firstname']);
        $borrower['lastname'] = iconv('UTF-8', 'cp874', $borrower['lastname']);
        $borrower['grade'] = iconv('UTF-8', 'cp874', $this->calculateGrade($borrower['student_id']));
        $borrower['student_id'] = iconv('UTF-8', 'cp874', $borrower['student_id']);
        $borrower['gpa'] = iconv('UTF-8', 'cp874', $borrower['gpa']);
        $borrower['phone'] = iconv('UTF-8', 'cp874', $borrower['phone']);
        $borrower['faculty'] = iconv('UTF-8', 'cp874', $faculty);
        $borrower['major'] = iconv('UTF-8', 'cp874', $major);
        $maritalstatus = json_decode($borrower['marital_status']);
        $borrower['marital_status'] = $maritalstatus->status;

        $borrower_address['tambon'] = iconv('UTF-8', 'cp874', $borrower_address['tambon']);
        $borrower_address['aumphure'] = iconv('UTF-8', 'cp874', $borrower_address['aumphure']);
        $borrower_address['province'] = iconv('UTF-8', 'cp874', $borrower_address['province']);

        $register_type = BorrowerRegisterType::where('user_id', $user_id)->first();
        if ($father != null) {
            $father['prefix'] = iconv('UTF-8', 'cp874', $father['prefix']);
            $father['firstname'] = iconv('UTF-8', 'cp874', $father['firstname']);
            $father['lastname'] = iconv('UTF-8', 'cp874', $father['lastname']);
            $father['occupation'] = iconv('UTF-8', 'cp874', $father['occupation']);
            $father['place_of_work'] = iconv('UTF-8', 'cp874', $father['place_of_work']);
            $father['phone'] = iconv('UTF-8', 'cp874', $father['phone']);
            $father['income'] = iconv('UTF-8', 'cp874', $father['income']);
        }

        if ($mother != null) {
            $mother['prefix'] = iconv('UTF-8', 'cp874', $mother['prefix']);
            $mother['firstname'] = iconv('UTF-8', 'cp874', $mother['firstname']);
            $mother['lastname'] = iconv('UTF-8', 'cp874', $mother['lastname']);
            $mother['occupation'] = iconv('UTF-8', 'cp874', $mother['occupation']);
            $mother['place_of_work'] = iconv('UTF-8', 'cp874', $mother['place_of_work']);
            $mother['phone'] = iconv('UTF-8', 'cp874', $mother['phone']);
            $mother['income'] = iconv('UTF-8', 'cp874', $mother['income']);
        }

        if ($parents != null) {
            foreach ($parents as $parent) {
                $parent['prefix'] = iconv('UTF-8', 'cp874', $parent['prefix']);
                $parent['firstname'] = iconv('UTF-8', 'cp874', $parent['firstname']);
                $parent['lastname'] = iconv('UTF-8', 'cp874', $parent['lastname']);
                $parent['occupation'] = iconv('UTF-8', 'cp874', $parent['occupation']);
                $parent['place_of_work'] = iconv('UTF-8', 'cp874', $parent['place_of_work']);
                $parent['phone'] = iconv('UTF-8', 'cp874', $parent['phone']);
                $parent['income'] = iconv('UTF-8', 'cp874', $parent['income']);
                $parent['borrower_relational'] = iconv('UTF-8', 'cp874', $parent['borrower_relational']);
            }
        }

        // Create a StreamedResponse
        return new StreamedResponse(function ()
        use (
            $borrower,
            $borrower_address,
            $father,
            $mother,
            $parents,
            $document,
            $child_document,
            $register_type,
            $useful_activities_hours_sum,
            $borrower_properties,
            $borrower_nesseessity_concat,
            $borrower_register_documents,
        ) {
            // Initialize the PDF
            $pdf = new Fpdi();

            // Add the page
            $pdf->AddPage();
            $pdf->setSourceFile(public_path($child_document['file_path'] . '/' . $child_document['file_name'])); // Import an existing PDF form

            $templateId = $pdf->importPage(1);
            $pdf->useTemplate($templateId, 0, 0);

            //date
            $gregorianDate = Carbon::now();
            $buddhistYear = $gregorianDate->year + 543;

            // Set the font and add text at specific locations
            $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
            $pdf->SetFont('THSarabunNew', '', 12);

            $tick_alp = public_path('icon_png/tick.png');

            if ($register_type['type_id'] == 1) {
                $pdf->Image($tick_alp, 120, 65, 4, 4);
            } else if ($register_type['type_id'] == 2) {
                $pdf->Image($tick_alp, 119, 49, 4, 4);
            }
            //BorrowerSession
            if ($register_type['times'] != null) {
                $pdf->Text(176, 60, $register_type['times']);
            }

            //SchoolYear
            $pdf->Text(149, 85, $document['year']);

            $fullname_borrower_input = 60;
            $fullname_borrower_length = strlen($borrower['prefix'] . $borrower['firstname'] . '   ' . $borrower['lastname']);
            $fullname_borrower_x = 52 + ($fullname_borrower_input / 2 - $fullname_borrower_length / 2) - 3;
            $pdf->Text($fullname_borrower_x, 101, $borrower['prefix'] . $borrower['firstname'] . '   ' . $borrower['lastname']);

            $borrower_student_id_input = 31;
            $borrower_student_id_length = strlen($borrower['student_id']);
            $borrower_student_id_x = 135 + ($borrower_student_id_input / 2 - $borrower_student_id_length / 2) - 3;
            $pdf->Text($borrower_student_id_x, 101, $borrower['student_id']);

            $pdf->Text(179, 101, $borrower['grade']);

            $borrower_major_input = 40;
            $borrower_major_length = strlen($borrower['major']);
            $borrower_major_x = 46 + ($borrower_major_input / 2 - $borrower_major_length / 2) - 3;
            $pdf->Text($borrower_major_x, 109, $borrower['major']);

            $borrower_faculty_input = 36;
            $borrower_faculty_length = strlen($borrower['faculty']);
            $borrower_faculty_x = 106 + ($borrower_faculty_input / 2 - $borrower_faculty_length / 2);
            $pdf->Text($borrower_faculty_x, 109, $borrower['faculty']);

            $pdf->Text(176, 109, $borrower['gpa']);

            $borrower_house_no_input = 24;
            $borrower_house_no_length = strlen($borrower_address['house_no']);
            $borrower_house_no_x = 75 + ($borrower_house_no_input / 2 - $borrower_house_no_length / 2) - 1;
            $pdf->Text($borrower_house_no_x, 116.5, $borrower_address['house_no']);

            $pdf->Text(107, 116.5, $borrower_address['village_no']);

            $borrower_tambon_input = 24;
            $borrower_tambon_length = strlen($borrower_address['tambon']);
            $borrower_tambon_x = 122 + ($borrower_tambon_input / 2 - $borrower_tambon_length / 2) - 1;
            $pdf->Text($borrower_tambon_x, 116.5, $borrower_address['tambon']);

            $borrower_aumphure_input = 26;
            $borrower_aumphure_length = strlen($borrower_address['aumphure']);
            $borrower_aumphure_x = 157 + ($borrower_aumphure_input / 2 - $borrower_aumphure_length / 2) - 1;
            $pdf->Text($borrower_aumphure_x, 116.5, $borrower_address['aumphure']);

            $borrower_province_input = 35;
            $borrower_province_length = strlen($borrower_address['province']);
            $borrower_province_x = 43 + ($borrower_province_input / 2 - $borrower_province_length / 2) - 1;
            $pdf->Text($borrower_province_x, 124, $borrower_address['province']);

            $borrower_postcode_input = 27;
            $borrower_postcode_length = strlen($borrower_address['postcode']);
            $borrower_postcode_x = 100 + ($borrower_postcode_input / 2 - $borrower_postcode_length / 2) - 1;
            $pdf->Text($borrower_postcode_x, 124, $borrower_address['postcode']);

            $borrower_phone_input = 42;
            $borrower_phone_length = strlen($borrower['phone']);
            $borrower_phone_x = 141 + ($borrower_phone_input / 2 - $borrower_phone_length / 2) - 3;
            $pdf->Text($borrower_phone_x, 124, $borrower['phone']);

            if ($father != null) {
                $father_fullname_input = 73;
                $father_fullname_length = strlen($father['prefix'] . $father['firstname'] . '   ' . $father['lastname']);
                $father_fullname_x = 60 + ($father_fullname_input / 2 - $father_fullname_length / 2) - 3;
                $pdf->Text($father_fullname_x, 131, $father['prefix'] . $father['firstname'] . '   ' . $father['lastname']);

                $father_occupation_input = 34;
                $father_occupation_length = strlen($father['occupation']);
                $father_occupation_x = 55 + ($father_occupation_input / 2 - $father_occupation_length / 2) - 2;
                $pdf->Text($father_occupation_x, 139, $father['occupation']);

                $father_phone_input = 28;
                $father_phone_length = strlen($father['phone']);
                $father_phone_x = 103 + ($father_phone_input / 2 - $father_phone_length / 2) - 3;
                $pdf->Text($father_phone_x, 139, $father['phone']);

                $father_income_input = 24;
                $father_income_length = strlen($father['income']);
                $father_income_x = 152 + ($father_income_input / 2 - $father_income_length / 2) - 2;
                $pdf->Text($father_income_x, 139, $father['income']);

                if ($father['alive']) {
                    $pdf->Image($tick_alp, 161, 129, 4, 4);
                } else {
                    $pdf->Image($tick_alp, 135, 129, 4, 4);
                }
            }

            if ($mother != null) {

                $mother_fullname_input = 69;
                $fullname_mother_length = strlen($mother['prefix'] . $mother['firstname'] . '   ' . $mother['lastname']);
                $mother_name_x = 64 + ($mother_fullname_input / 2 - $fullname_mother_length / 2) - 3;
                $pdf->Text($mother_name_x, 146.5, $mother['prefix'] . $mother['firstname'] . '   ' . $mother['lastname']);

                $mother_occupation_input = 34;
                $mother_occupation_length = strlen($mother['occupation']);
                $mother_occupation_x = 55 + ($mother_occupation_input / 2 - $mother_occupation_length / 2) - 2;
                $pdf->Text($mother_occupation_x, 154, $mother['occupation']);

                $mother_phone_input = 28;
                $mother_phone_length = strlen($mother['phone']);
                $mother_phone_x = 103 + ($mother_phone_input / 2 - $mother_phone_length / 2) - 3;
                $pdf->Text($mother_phone_x, 154, $mother['phone']);

                $mother_income_input = 24;
                $income_mother_length = strlen($mother['income']);
                $mother_income_x = 152 + ($mother_income_input / 2 - $income_mother_length / 2) - 2;
                $pdf->Text($mother_income_x, 154, $mother['income']);

                if ($mother['alive']) {
                    $pdf->Image($tick_alp, 161, 144, 4, 4);
                } else {
                    $pdf->Image($tick_alp, 135, 144, 4, 4);
                }
            }

            if ($borrower['marital_status'] == 'อยู่ด้วยกัน') {
                $pdf->Image($tick_alp, 33, 167, 4, 4);
            } else if ($borrower['marital_status'] == 'หย่า') {
                $pdf->Image($tick_alp, 77, 167, 4, 4);
            } else if ($borrower['marital_status'] == 'แยกกันอยู่ตามอาชีพ') {
                $pdf->Image($tick_alp, 141, 167, 4, 4);
            } else {
                $pdf->Image($tick_alp, 33, 175, 4, 4);
                // $other_input = 130;
                $other_length = strlen($borrower['marital_status']);
                $other_x = 55 + ($other_length / 2) - 6;
                $pdf->Text($other_x, 177, $borrower['marital_status']);
            }

            if (isset($parents[0])) {
                $parent1_fullname_input = 88;
                $parent1_fullname_length = strlen($parents[0]['prefix'] . $parents[0]['firstname'] . '   ' . $parents[0]['lastname']);
                $parent1_fullname_x = 96 + ($parent1_fullname_input / 2 - $parent1_fullname_length / 2) - 3;
                $pdf->Text($parent1_fullname_x, 184.5, $parents[0]['prefix'] . $parents[0]['firstname'] . '   ' . $parents[0]['lastname']);

                $parent1_occupation_input = 33;
                $parent1_occupation_length = strlen($parents[0]['occupation']);
                $parent1_occupation_x = 55 + ($parent1_occupation_input / 2 - $parent1_occupation_length / 2) - 2;
                $pdf->Text($parent1_occupation_x, 192, $parents[0]['occupation']);

                $parent1_phone_input = 29;
                $parent1_phone_length = strlen($parents[0]['phone']);
                $parent1_phone_x = 102 + ($parent1_phone_input / 2 - $parent1_phone_length / 2) - 3;
                $pdf->Text($parent1_phone_x, 192, $parents[0]['phone']);

                $parent1_income_input = 24;
                $parent1_income_length = strlen($parents[0]['income']);
                $parent1_income_x = 152 + ($parent1_income_input / 2 - $parent1_income_length / 2) - 2;
                $pdf->Text($parent1_income_x, 192, $parents[0]['income']);
            }

            if (isset($parents[1])) {
                $parent2_fullname_input = 69;
                $parent2_fullname_length = strlen($parents[1]['prefix'] . $parents[1]['firstname'] . '   ' . $parents[1]['lastname']);
                $parent2_fullname_x = 114 + ($parent2_fullname_input / 2 - $parent2_fullname_length / 2) - 3;
                $pdf->Text($parent2_fullname_x, 199, $parents[1]['prefix'] . $parents[1]['firstname'] . '   ' . $parents[1]['lastname']);

                $parent2_occupation_input = 33;
                $parent2_occupation_length = strlen($parents[1]['occupation']);
                $parent2_occupation_x = 55 + ($parent2_occupation_input / 2 - $parent2_occupation_length / 2) - 2;
                $pdf->Text($parent2_occupation_x, 207, $parents[1]['occupation']);

                $parent2_phone_input = 29;
                $parent2_phone_length = strlen($parents[1]['phone']);
                $parent2_phone_x = 102 + ($parent2_phone_input / 2 - $parent2_phone_length / 2) - 3;
                $pdf->Text($parent2_phone_x, 207, $parents[1]['phone']);

                $parent2_income_input = 24;
                $parent2_income_length = strlen($parents[1]['income']);
                $parent2_income_x = 152 + ($parent2_income_input / 2 - $parent2_income_length / 2) - 2;
                $pdf->Text($parent2_income_x, 207, $parents[1]['income']);
            }
            //tick mark
            if (in_array('1', $borrower_properties)) $pdf->Image($tick_alp, 33, 219, 4, 4);
            if (in_array('2', $borrower_properties)) $pdf->Image($tick_alp, 33, 226, 4, 4);
            if (in_array('3', $borrower_properties)) $pdf->Image($tick_alp, 33, 233, 4, 4);
            if (in_array('4', $borrower_properties)) $pdf->Image($tick_alp, 33, 239, 4, 4);
            if (in_array('5', $borrower_properties)) $pdf->Image($tick_alp, 128, 219, 4, 4);
            if (in_array('6', $borrower_properties)) $pdf->Image($tick_alp, 128, 226, 4, 4);
            if (in_array('7', $borrower_properties)) $pdf->Image($tick_alp, 128, 233, 4, 4);
            if (in_array('8', $borrower_properties)) $pdf->Image($tick_alp, 128, 239, 4, 4);

            $pdf->Text(146, 249, $useful_activities_hours_sum);

            $pdf->AddPage();
            $templateId = $pdf->importPage(2);
            $pdf->useTemplate($templateId, 0, 0);

            //reason
            $pdf->SetXY(26, 31);
            $pdf->MultiCell(158, 8, $borrower_nesseessity_concat);

            if (in_array('1', $borrower_register_documents)) $pdf->Image($tick_alp, 39, 117, 4, 4);
            if (in_array('2', $borrower_register_documents)) $pdf->Image($tick_alp, 39, 124, 4, 4);
            if (in_array('3', $borrower_register_documents)) $pdf->Image($tick_alp, 39, 131, 4, 4);
            if (in_array('4', $borrower_register_documents)) $pdf->Image($tick_alp, 39, 137, 4, 4);

            //5 หนังสือรับรองรายได้ครอบครัว
            $pdf->Image($tick_alp, 39, 144, 4, 4);

            if (in_array('5', $borrower_register_documents)) $pdf->Image($tick_alp, 51, 150, 4, 4);
            if (in_array('6', $borrower_register_documents)) $pdf->Image($tick_alp, 51, 157, 4, 4);
            if (in_array('7', $borrower_register_documents)) $pdf->Image($tick_alp, 39, 164, 4, 4);
            if (in_array('8', $borrower_register_documents)) $pdf->Image($tick_alp, 39, 170, 4, 4);
            if (in_array('9', $borrower_register_documents)) $pdf->Image($tick_alp, 39, 177, 4, 4);
            if (in_array('10', $borrower_register_documents)) $pdf->Image($tick_alp, 39, 184, 4, 4);
            if (in_array('11', $borrower_register_documents)) $pdf->Image($tick_alp, 39, 190, 4, 4);


            //signature borrower
            $borrower_firstname_input = 48;
            $borrower_firstname_length = strlen($borrower['firstname']);
            $borrower_firstname_x = 35 + ($borrower_firstname_input / 2 - $borrower_firstname_length / 2) - 3;
            $pdf->Text($borrower_firstname_x, 204, $borrower['firstname']);

            $fullname_borrower_input = 60;
            $fullname_borrower_length = strlen($borrower['prefix'] . $borrower['firstname'] . '   ' . $borrower['lastname']);
            $fullname_borrower_x = 27 + ($fullname_borrower_input / 2 - $fullname_borrower_length / 2) - 3;
            $pdf->Text($fullname_borrower_x, 211, $borrower['prefix'] . $borrower['firstname'] . '   ' . $borrower['lastname']);

            $month = iconv('UTF-8', 'cp874', $this->getThaiMonthName($gregorianDate->month));
            $pdf->Text(47, 219, $gregorianDate->day . '   ' . $month . '   ' . $buddhistYear);
            $pdf->Output();
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="generated_form.pdf"',
        ]);
    }

    public function saveBorrowerDocument101($user_id, $child_document, $document_id)
    {
        $document = Documents::find($document_id);
        $borrower_document = BorrowerDocument::where('user_id', $user_id)->where('document_id', $document_id)->first();
        $sign_date = BorrowerChildDocument::where('child_document_id', 4)->where('user_id', $user_id)->where('document_id', $document_id)->value('created_at') ?? null;

        $teacher_uid = TeacherCommentDocuments::where('borrower_document_id', $borrower_document['id'])->value('teacher_uid');
        $teacher = Users::find($teacher_uid) ?? null;
        $teacher_comments = TeacherCommentDocuments::where('teacher_comment_documents.borrower_document_id', $borrower_document['id'])
            ->select('updated_at')
            ->first() ?? null;
        if ($teacher != null) {
            $teacher['prefix'] = iconv('UTF-8', 'cp874', $teacher['prefix']);
            $teacher['firstname'] = iconv('UTF-8', 'cp874', $teacher['firstname']);
            $teacher['lastname'] = iconv('UTF-8', 'cp874', $teacher['lastname']);
            $teacher_sign_date = $teacher_comments['updated_at'];
        }

        $borrower = Users::join('borrowers', 'users.id', '=', 'borrowers.user_id')
            ->where('users.id', $user_id)
            ->select('users.prefix', 'users.firstname', 'users.lastname', 'borrowers.id', 'borrowers.address_id', 'borrowers.student_id', 'borrowers.faculty_id', 'borrowers.major_id', 'borrowers.gpa', 'borrowers.marital_status', 'borrowers.phone',)
            ->first();
        $father = Parents::where('borrower_id', $borrower['id'])->where('borrower_relational', 'บิดา')->select('prefix', 'firstname', 'lastname', 'occupation', 'place_of_work', 'phone', 'income', 'alive')->first();
        $mother = Parents::where('borrower_id', $borrower['id'])->where('borrower_relational', 'มารดา')->select('prefix', 'firstname', 'lastname', 'occupation', 'place_of_work', 'phone', 'income', 'alive')->first();
        $parents = Parents::where('borrower_id', $borrower['id'])->where('borrower_relational', '!=', 'มารดา')->where('borrower_relational', '!=', 'บิดา')->select('prefix', 'firstname', 'lastname', 'occupation', 'place_of_work', 'phone', 'income', 'alive', 'borrower_relational')->get();
        $borrower_address = Address::find($borrower['address_id']);
        $borrower_register_documents = BorrowerRegisterDocument::where('user_id', $user_id)->pluck('register_document_id')->toArray();

        $faculty = Faculties::where('id', $borrower['faculty_id'])->value('faculty_name');
        $faculty = str_replace("คณะ", "", $faculty);
        $faculty = str_replace("วิทยาลัย", "", $faculty);
        $major = Majors::where('id', $borrower['major_id'])->value('major_name');
        $major = str_replace("สาขาวิชา", "", $major);

        $useful_activities_hours_sum = UsefulActivity::where('user_id', $user_id)->where('document_id', $document->id)->sum('hour_count') ?? 0;
        $borrower_properties = BorrowerProperties::where('borrower_id', $borrower['id'])->pluck('property_id')->toArray();
        $borrower_nesseessities = BorrowerNessessities::join('nessessities', 'borrower_nessessities.nessessity_id', '=', 'nessessities.id')
            ->where('borrower_nessessities.borrower_id', $borrower['id'])
            ->select('nessessities.nessessity_title')
            ->get();
        $borrower_nesseessity_other = BorrowerNessessities::where('borrower_id', $borrower['id'])->where('nessessity_id', null)->first();
        $borrower_nesseessity_concat = '';
        foreach ($borrower_nesseessities as $nessessity) {
            $borrower_nesseessity_concat .= $nessessity['nessessity_title'] . ' ';
        }
        $borrower_nesseessity_concat .= $borrower_nesseessity_other['other'] ?? ' ';
        $borrower_nesseessity_concat = iconv('UTF-8', 'cp874', $borrower_nesseessity_concat);

        $borrower['prefix'] = iconv('UTF-8', 'cp874', $borrower['prefix']);
        $borrower['firstname'] = iconv('UTF-8', 'cp874', $borrower['firstname']);
        $borrower['lastname'] = iconv('UTF-8', 'cp874', $borrower['lastname']);
        $borrower['grade'] = iconv('UTF-8', 'cp874', $this->calculateGrade($borrower['student_id']));
        $borrower['student_id'] = iconv('UTF-8', 'cp874', $borrower['student_id']);
        $borrower['gpa'] = iconv('UTF-8', 'cp874', $borrower['gpa']);
        $borrower['phone'] = iconv('UTF-8', 'cp874', $borrower['phone']);
        $borrower['faculty'] = iconv('UTF-8', 'cp874', $faculty);
        $borrower['major'] = iconv('UTF-8', 'cp874', $major);
        $maritalstatus = json_decode($borrower['marital_status']);
        $borrower['marital_status'] = $maritalstatus->status;

        $borrower_address['tambon'] = iconv('UTF-8', 'cp874', $borrower_address['tambon']);
        $borrower_address['aumphure'] = iconv('UTF-8', 'cp874', $borrower_address['aumphure']);
        $borrower_address['province'] = iconv('UTF-8', 'cp874', $borrower_address['province']);

        $register_type = BorrowerRegisterType::where('user_id', $user_id)->first();
        if ($father != null) {
            $father['prefix'] = iconv('UTF-8', 'cp874', $father['prefix']);
            $father['firstname'] = iconv('UTF-8', 'cp874', $father['firstname']);
            $father['lastname'] = iconv('UTF-8', 'cp874', $father['lastname']);
            $father['occupation'] = iconv('UTF-8', 'cp874', $father['occupation']);
            $father['place_of_work'] = iconv('UTF-8', 'cp874', $father['place_of_work']);
            $father['phone'] = iconv('UTF-8', 'cp874', $father['phone']);
            $father['income'] = iconv('UTF-8', 'cp874', $father['income']);
        }

        if ($mother != null) {
            $mother['prefix'] = iconv('UTF-8', 'cp874', $mother['prefix']);
            $mother['firstname'] = iconv('UTF-8', 'cp874', $mother['firstname']);
            $mother['lastname'] = iconv('UTF-8', 'cp874', $mother['lastname']);
            $mother['occupation'] = iconv('UTF-8', 'cp874', $mother['occupation']);
            $mother['place_of_work'] = iconv('UTF-8', 'cp874', $mother['place_of_work']);
            $mother['phone'] = iconv('UTF-8', 'cp874', $mother['phone']);
            $mother['income'] = iconv('UTF-8', 'cp874', $mother['income']);
        }

        if ($parents != null) {
            foreach ($parents as $parent) {
                $parent['prefix'] = iconv('UTF-8', 'cp874', $parent['prefix']);
                $parent['firstname'] = iconv('UTF-8', 'cp874', $parent['firstname']);
                $parent['lastname'] = iconv('UTF-8', 'cp874', $parent['lastname']);
                $parent['occupation'] = iconv('UTF-8', 'cp874', $parent['occupation']);
                $parent['place_of_work'] = iconv('UTF-8', 'cp874', $parent['place_of_work']);
                $parent['phone'] = iconv('UTF-8', 'cp874', $parent['phone']);
                $parent['income'] = iconv('UTF-8', 'cp874', $parent['income']);
                $parent['borrower_relational'] = iconv('UTF-8', 'cp874', $parent['borrower_relational']);
            }
        }

        // Initialize the PDF
        $pdf = new Fpdi();

        // Add the page
        $pdf->AddPage();
        $pdf->setSourceFile(public_path($child_document['file_path'] . '/' . $child_document['file_name'])); // Import an existing PDF form

        $templateId = $pdf->importPage(1);
        $pdf->useTemplate($templateId, 0, 0);

        //date
        if ($sign_date != null) {
            $gregorianDate = Carbon::createFromFormat('Y-m-d H:i:s', $sign_date);
        } else {
            $gregorianDate = Carbon::now();
        }
        $buddhistYear = $gregorianDate->year + 543;

        // Set the font and add text at specific locations
        $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
        $pdf->SetFont('THSarabunNew', '', 12);

        $tick_alp = public_path('icon_png/tick.png');

        if ($register_type['type_id'] == 1) {
            $pdf->Image($tick_alp, 120, 65, 4, 4);
        } else if ($register_type['type_id'] == 2) {
            $pdf->Image($tick_alp, 119, 49, 4, 4);
        }
        //BorrowerSession
        if ($register_type['times'] != null) {
            $pdf->Text(176, 60, $register_type['times']);
        }

        //SchoolYear
        $pdf->Text(149, 85, $document['year']);

        $fullname_borrower_input = 60;
        $fullname_borrower_length = strlen($borrower['prefix'] . $borrower['firstname'] . '   ' . $borrower['lastname']);
        $fullname_borrower_x = 52 + ($fullname_borrower_input / 2 - $fullname_borrower_length / 2) - 3;
        $pdf->Text($fullname_borrower_x, 101, $borrower['prefix'] . $borrower['firstname'] . '   ' . $borrower['lastname']);

        $borrower_student_id_input = 31;
        $borrower_student_id_length = strlen($borrower['student_id']);
        $borrower_student_id_x = 135 + ($borrower_student_id_input / 2 - $borrower_student_id_length / 2) - 3;
        $pdf->Text($borrower_student_id_x, 101, $borrower['student_id']);

        $pdf->Text(179, 101, $borrower['grade']);

        $borrower_major_input = 40;
        $borrower_major_length = strlen($borrower['major']);
        $borrower_major_x = 46 + ($borrower_major_input / 2 - $borrower_major_length / 2) - 3;
        $pdf->Text($borrower_major_x, 109, $borrower['major']);

        $borrower_faculty_input = 36;
        $borrower_faculty_length = strlen($borrower['faculty']);
        $borrower_faculty_x = 106 + ($borrower_faculty_input / 2 - $borrower_faculty_length / 2);
        $pdf->Text($borrower_faculty_x, 109, $borrower['faculty']);

        $pdf->Text(176, 109, $borrower['gpa']);

        $borrower_house_no_input = 24;
        $borrower_house_no_length = strlen($borrower_address['house_no']);
        $borrower_house_no_x = 75 + ($borrower_house_no_input / 2 - $borrower_house_no_length / 2) - 1;
        $pdf->Text($borrower_house_no_x, 116.5, $borrower_address['house_no']);

        $pdf->Text(107, 116.5, $borrower_address['village_no']);

        $borrower_tambon_input = 24;
        $borrower_tambon_length = strlen($borrower_address['tambon']);
        $borrower_tambon_x = 122 + ($borrower_tambon_input / 2 - $borrower_tambon_length / 2) - 1;
        $pdf->Text($borrower_tambon_x, 116.5, $borrower_address['tambon']);

        $borrower_aumphure_input = 26;
        $borrower_aumphure_length = strlen($borrower_address['aumphure']);
        $borrower_aumphure_x = 157 + ($borrower_aumphure_input / 2 - $borrower_aumphure_length / 2) - 1;
        $pdf->Text($borrower_aumphure_x, 116.5, $borrower_address['aumphure']);

        $borrower_province_input = 35;
        $borrower_province_length = strlen($borrower_address['province']);
        $borrower_province_x = 43 + ($borrower_province_input / 2 - $borrower_province_length / 2) - 1;
        $pdf->Text($borrower_province_x, 124, $borrower_address['province']);

        $borrower_postcode_input = 27;
        $borrower_postcode_length = strlen($borrower_address['postcode']);
        $borrower_postcode_x = 100 + ($borrower_postcode_input / 2 - $borrower_postcode_length / 2) - 1;
        $pdf->Text($borrower_postcode_x, 124, $borrower_address['postcode']);

        $borrower_phone_input = 42;
        $borrower_phone_length = strlen($borrower['phone']);
        $borrower_phone_x = 141 + ($borrower_phone_input / 2 - $borrower_phone_length / 2) - 3;
        $pdf->Text($borrower_phone_x, 124, $borrower['phone']);

        if ($father != null) {
            $father_fullname_input = 73;
            $father_fullname_length = strlen($father['prefix'] . $father['firstname'] . '   ' . $father['lastname']);
            $father_fullname_x = 60 + ($father_fullname_input / 2 - $father_fullname_length / 2) - 3;
            $pdf->Text($father_fullname_x, 131, $father['prefix'] . $father['firstname'] . '   ' . $father['lastname']);

            $father_occupation_input = 34;
            $father_occupation_length = strlen($father['occupation']);
            $father_occupation_x = 55 + ($father_occupation_input / 2 - $father_occupation_length / 2) - 2;
            $pdf->Text($father_occupation_x, 139, $father['occupation']);

            $father_phone_input = 28;
            $father_phone_length = strlen($father['phone']);
            $father_phone_x = 103 + ($father_phone_input / 2 - $father_phone_length / 2) - 3;
            $pdf->Text($father_phone_x, 139, $father['phone']);

            $father_income_input = 24;
            $father_income_length = strlen($father['income']);
            $father_income_x = 152 + ($father_income_input / 2 - $father_income_length / 2) - 2;
            $pdf->Text($father_income_x, 139, $father['income']);

            if ($father['alive']) {
                $pdf->Image($tick_alp, 161, 129, 4, 4);
            } else {
                $pdf->Image($tick_alp, 135, 129, 4, 4);
            }
        }

        if ($mother != null) {

            $mother_fullname_input = 69;
            $fullname_mother_length = strlen($mother['prefix'] . $mother['firstname'] . '   ' . $mother['lastname']);
            $mother_name_x = 64 + ($mother_fullname_input / 2 - $fullname_mother_length / 2) - 3;
            $pdf->Text($mother_name_x, 146.5, $mother['prefix'] . $mother['firstname'] . '   ' . $mother['lastname']);

            $mother_occupation_input = 34;
            $mother_occupation_length = strlen($mother['occupation']);
            $mother_occupation_x = 55 + ($mother_occupation_input / 2 - $mother_occupation_length / 2) - 2;
            $pdf->Text($mother_occupation_x, 154, $mother['occupation']);

            $mother_phone_input = 28;
            $mother_phone_length = strlen($mother['phone']);
            $mother_phone_x = 103 + ($mother_phone_input / 2 - $mother_phone_length / 2) - 3;
            $pdf->Text($mother_phone_x, 154, $mother['phone']);

            $mother_income_input = 24;
            $income_mother_length = strlen($mother['income']);
            $mother_income_x = 152 + ($mother_income_input / 2 - $income_mother_length / 2) - 2;
            $pdf->Text($mother_income_x, 154, $mother['income']);

            if ($mother['alive']) {
                $pdf->Image($tick_alp, 161, 144, 4, 4);
            } else {
                $pdf->Image($tick_alp, 135, 144, 4, 4);
            }
        }

        if ($borrower['marital_status'] == 'อยู่ด้วยกัน') {
            $pdf->Image($tick_alp, 33, 167, 4, 4);
        } else if ($borrower['marital_status'] == 'หย่า') {
            $pdf->Image($tick_alp, 77, 167, 4, 4);
        } else if ($borrower['marital_status'] == 'แยกกันอยู่ตามอาชีพ') {
            $pdf->Image($tick_alp, 141, 167, 4, 4);
        } else {
            $pdf->Image($tick_alp, 33, 175, 4, 4);
            // $other_input = 130;
            $other_length = strlen($borrower['marital_status']);
            $other_x = 53 + ($other_length / 2) - 6;
            $pdf->Text($other_x, 177, $borrower['marital_status']);
        }

        if (isset($parents[0])) {
            $parent1_fullname_input = 88;
            $parent1_fullname_length = strlen($parents[0]['prefix'] . $parents[0]['firstname'] . '   ' . $parents[0]['lastname']);
            $parent1_fullname_x = 96 + ($parent1_fullname_input / 2 - $parent1_fullname_length / 2) - 3;
            $pdf->Text($parent1_fullname_x, 184.5, $parents[0]['prefix'] . $parents[0]['firstname'] . '   ' . $parents[0]['lastname']);

            $parent1_occupation_input = 33;
            $parent1_occupation_length = strlen($parents[0]['occupation']);
            $parent1_occupation_x = 55 + ($parent1_occupation_input / 2 - $parent1_occupation_length / 2) - 2;
            $pdf->Text($parent1_occupation_x, 192, $parents[0]['occupation']);

            $parent1_phone_input = 29;
            $parent1_phone_length = strlen($parents[0]['phone']);
            $parent1_phone_x = 102 + ($parent1_phone_input / 2 - $parent1_phone_length / 2) - 3;
            $pdf->Text($parent1_phone_x, 192, $parents[0]['phone']);

            $parent1_income_input = 24;
            $parent1_income_length = strlen($parents[0]['income']);
            $parent1_income_x = 152 + ($parent1_income_input / 2 - $parent1_income_length / 2) - 2;
            $pdf->Text($parent1_income_x, 192, $parents[0]['income']);
        }

        if (isset($parents[1])) {
            $parent2_fullname_input = 69;
            $parent2_fullname_length = strlen($parents[1]['prefix'] . $parents[1]['firstname'] . '   ' . $parents[1]['lastname']);
            $parent2_fullname_x = 114 + ($parent2_fullname_input / 2 - $parent2_fullname_length / 2) - 3;
            $pdf->Text($parent2_fullname_x, 199, $parents[1]['prefix'] . $parents[1]['firstname'] . '   ' . $parents[1]['lastname']);

            $parent2_occupation_input = 33;
            $parent2_occupation_length = strlen($parents[1]['occupation']);
            $parent2_occupation_x = 55 + ($parent2_occupation_input / 2 - $parent2_occupation_length / 2) - 2;
            $pdf->Text($parent2_occupation_x, 207, $parents[1]['occupation']);

            $parent2_phone_input = 29;
            $parent2_phone_length = strlen($parents[1]['phone']);
            $parent2_phone_x = 102 + ($parent2_phone_input / 2 - $parent2_phone_length / 2) - 3;
            $pdf->Text($parent2_phone_x, 207, $parents[1]['phone']);

            $parent2_income_input = 24;
            $parent2_income_length = strlen($parents[1]['income']);
            $parent2_income_x = 152 + ($parent2_income_input / 2 - $parent2_income_length / 2) - 2;
            $pdf->Text($parent2_income_x, 207, $parents[1]['income']);
        }
        //tick mark
        if (in_array('1', $borrower_properties)) $pdf->Image($tick_alp, 33, 219, 4, 4);
        if (in_array('2', $borrower_properties)) $pdf->Image($tick_alp, 33, 226, 4, 4);
        if (in_array('3', $borrower_properties)) $pdf->Image($tick_alp, 33, 233, 4, 4);
        if (in_array('4', $borrower_properties)) $pdf->Image($tick_alp, 33, 239, 4, 4);
        if (in_array('5', $borrower_properties)) $pdf->Image($tick_alp, 128, 219, 4, 4);
        if (in_array('6', $borrower_properties)) $pdf->Image($tick_alp, 128, 226, 4, 4);
        if (in_array('7', $borrower_properties)) $pdf->Image($tick_alp, 128, 233, 4, 4);
        if (in_array('8', $borrower_properties)) $pdf->Image($tick_alp, 128, 239, 4, 4);

        $pdf->Text(146, 249, $useful_activities_hours_sum);

        $pdf->AddPage();
        $templateId = $pdf->importPage(2);
        $pdf->useTemplate($templateId, 0, 0);

        //reason
        $pdf->SetXY(26, 31);
        $pdf->MultiCell(158, 8, $borrower_nesseessity_concat);

        if (in_array('1', $borrower_register_documents)) $pdf->Image($tick_alp, 39, 117, 4, 4);
        if (in_array('2', $borrower_register_documents)) $pdf->Image($tick_alp, 39, 124, 4, 4);
        if (in_array('3', $borrower_register_documents)) $pdf->Image($tick_alp, 39, 131, 4, 4);
        if (in_array('4', $borrower_register_documents)) $pdf->Image($tick_alp, 39, 137, 4, 4);

        //5 หนังสือรับรองรายได้ครอบครัว
        $pdf->Image($tick_alp, 39, 144, 4, 4);

        if (in_array('5', $borrower_register_documents)) $pdf->Image($tick_alp, 51, 150, 4, 4);
        if (in_array('6', $borrower_register_documents)) $pdf->Image($tick_alp, 51, 157, 4, 4);
        if (in_array('7', $borrower_register_documents)) $pdf->Image($tick_alp, 39, 164, 4, 4);
        if (in_array('8', $borrower_register_documents)) $pdf->Image($tick_alp, 39, 170, 4, 4);
        if (in_array('9', $borrower_register_documents)) $pdf->Image($tick_alp, 39, 177, 4, 4);
        if (in_array('10', $borrower_register_documents)) $pdf->Image($tick_alp, 39, 184, 4, 4);
        if (in_array('11', $borrower_register_documents)) $pdf->Image($tick_alp, 39, 190, 4, 4);


        //signature borrower
        $borrower_firstname_input = 48;
        $borrower_firstname_length = strlen($borrower['firstname']);
        $borrower_firstname_x = 35 + ($borrower_firstname_input / 2 - $borrower_firstname_length / 2) - 3;
        $pdf->Text($borrower_firstname_x, 204, $borrower['firstname']);

        $fullname_borrower_input = 60;
        $fullname_borrower_length = strlen($borrower['prefix'] . $borrower['firstname'] . '   ' . $borrower['lastname']);
        $fullname_borrower_x = 27 + ($fullname_borrower_input / 2 - $fullname_borrower_length / 2) - 3;
        $pdf->Text($fullname_borrower_x, 211, $borrower['prefix'] . $borrower['firstname'] . '   ' . $borrower['lastname']);

        $month = iconv('UTF-8', 'cp874', $this->getThaiMonthName($gregorianDate->month));
        $pdf->Text(47, 219, $gregorianDate->day . '   ' . $month . '   ' . $buddhistYear);

        //signature official
        // $official_firstname_input = 37;
        // $firstname_official_length = strlen($decrypData['official_firstname']);
        // $official_firstname_x = 123+($official_firstname_input/2 - $firstname_official_length/2)-2;
        // $pdf->Text($official_firstname_x, 204,$decrypData['official_firstname']);

        // $official_name_input = 61;
        // $official_length = strlen($decrypData['official_prefix'].$decrypData['official_firstname'].'   '.$decrypData['official_lastname']);
        // $official_name_x = 115+($official_name_input/2 - $official_length/2)-5;
        // $pdf->Text($official_name_x, 211,$decrypData['official_prefix'].$decrypData['official_firstname'].'   '.$decrypData['official_lastname']);

        // $month = iconv('UTF-8', 'cp874', $this->getThaiMonthName($gregorianDate->month));
        // $pdf->Text(135, 219,$gregorianDate->day.'   '.$month.'   '.$buddhistYear);

        // $pdf->Image($tick_alp, 81, 228, 4, 4);
        // $pdf->Image($tick_alp, 103, 228, 4, 4);

        //not approved
        // $not_approved_input = 43;
        // $not_approved_length = strlen($decrypData['not_approved']);
        // $not_approved_x = 140+($not_approved_input/2 - $not_approved_length/2)-2;
        // $pdf->Text($not_approved_x, 230,$decrypData['not_approved']);


        //signature teachers
        if ($teacher != null) {
            //approve
            $pdf->Image($tick_alp, 81, 228, 4, 4);
            //not approve
            // $pdf->Image($tick_alp, 103, 228, 4, 4);
            $gregorianDate = Carbon::createFromFormat('Y-m-d H:i:s', $teacher_sign_date);
            $buddhistYear = $gregorianDate->year + 543;
            $teacher_firstname_input = 67;
            $teacher_firstname_length = strlen($teacher['firstname']);
            $teacher_firstname_x = 85 + ($teacher_firstname_input / 2 - $teacher_firstname_length / 2) - 3;
            $pdf->Text($teacher_firstname_x, 245.5, $teacher['firstname']);

            $teacher_fullname_input = 77;
            $teacher_fullanme_length = strlen($teacher['prefix'] . $teacher['firstname'] . '   ' . $teacher['lastname']);
            $teacher_fullname_x = 78 + ($teacher_fullname_input / 2 - $teacher_fullanme_length / 2) - 3;
            $pdf->Text($teacher_fullname_x, 253, $teacher['prefix'] . $teacher['firstname'] . '   ' . $teacher['lastname']);

            $month = iconv('UTF-8', 'cp874', $this->getThaiMonthName($gregorianDate->month));
            $pdf->Text(105, 261, $gregorianDate->day . '   ' . $month . '   ' . $buddhistYear);
        }
        //outpufile
        $custom_filename = now()->format('Y-m-d_H-i-s') . '_' . 'กยศ 101_' . $user_id . '.pdf';
        $tempPath = storage_path('app/temp/' . $custom_filename);

        if (!File::exists(storage_path('app/temp'))) {
            File::makeDirectory(storage_path('app/temp'), 0755, true);
        }
        $pdf->Output($tempPath, 'F');
        return $tempPath;
    }

    public function teacherCommentDocument101($user_id, $borrower_file_101_id)
    {

        $borrower_file = BorrowerFiles::find($borrower_file_101_id);
        $teacher = Users::find($user_id);
        $teacher['prefix'] = iconv('UTF-8', 'cp874', $teacher['prefix']);
        $teacher['firstname'] = iconv('UTF-8', 'cp874', $teacher['firstname']);
        $teacher['lastname'] = iconv('UTF-8', 'cp874', $teacher['lastname']);
        // Initialize the PDF
        $pdf = new Fpdi();

        // Add the page
        $pdf->AddPage();
        $pdf->setSourceFile(storage_path($borrower_file['file_path'] . '/' . $borrower_file['file_name'])); // Import an existing PDF form

        $templateId = $pdf->importPage(1);
        $pdf->useTemplate($templateId, 0, 0);

        $pdf->AddPage();
        $templateId = $pdf->importPage(2);
        $pdf->useTemplate($templateId, 0, 0);

        //date
        $gregorianDate = Carbon::now();
        $buddhistYear = $gregorianDate->year + 543;

        // Set the font and add text at specific locations
        $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
        $pdf->SetFont('THSarabunNew', '', 12);

        $tick_alp = public_path('icon_png/tick.png');

        //signature official
        // $official_firstname_input = 37;
        // $firstname_official_length = strlen($decrypData['official_firstname']);
        // $official_firstname_x = 123+($official_firstname_input/2 - $firstname_official_length/2)-2;
        // $pdf->Text($official_firstname_x, 204,$decrypData['official_firstname']);

        // $official_name_input = 61;
        // $official_length = strlen($decrypData['official_prefix'].$decrypData['official_firstname'].'   '.$decrypData['official_lastname']);
        // $official_name_x = 115+($official_name_input/2 - $official_length/2)-5;
        // $pdf->Text($official_name_x, 211,$decrypData['official_prefix'].$decrypData['official_firstname'].'   '.$decrypData['official_lastname']);

        // $month = iconv('UTF-8', 'cp874', $this->getThaiMonthName($gregorianDate->month));
        // $pdf->Text(135, 219,$gregorianDate->day.'   '.$month.'   '.$buddhistYear);

        //approve
        $pdf->Image($tick_alp, 81, 228, 4, 4);
        //not approve
        // $pdf->Image($tick_alp, 103, 228, 4, 4);

        //signature teachers
        $teacher_firstname_input = 67;
        $teacher_firstname_length = strlen($teacher['firstname']);
        $teacher_firstname_x = 85 + ($teacher_firstname_input / 2 - $teacher_firstname_length / 2) - 3;
        $pdf->Text($teacher_firstname_x, 245.5, $teacher['firstname']);

        $teacher_fullname_input = 77;
        $teacher_fullanme_length = strlen($teacher['prefix'] . $teacher['firstname'] . '   ' . $teacher['lastname']);
        $teacher_fullname_x = 78 + ($teacher_fullname_input / 2 - $teacher_fullanme_length / 2) - 3;
        $pdf->Text($teacher_fullname_x, 253, $teacher['prefix'] . $teacher['firstname'] . '   ' . $teacher['lastname']);

        $month = iconv('UTF-8', 'cp874', $this->getThaiMonthName($gregorianDate->month));
        $pdf->Text(105, 261, $gregorianDate->day . '   ' . $month . '   ' . $buddhistYear);

        $custom_filename = now()->format('Y-m-d_H-i-s') . '_' . 'กยศ 101_.pdf';
        $tempPath = storage_path('app/temp/' . $custom_filename);

        if (!File::exists(storage_path('app/temp'))) {
            File::makeDirectory(storage_path('app/temp'), 0755, true);
        }
        $pdf->Output($tempPath, 'F');
        return $tempPath;
    }
}
