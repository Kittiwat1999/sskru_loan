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
        $borrower = [
            'prefix'=>'นาย',
            'firstname' => 'กิตติวัฒน์',
            'lastname' => 'เทียนเพ็ชร',
            'birthday' => Carbon::now()
        ];

        $decrypData = [
            'borrower_prefix' => iconv('UTF-8', 'cp874', $borrower['prefix']),
            'borrower_firstname' => iconv('UTF-8', 'cp874', $borrower['firstname']),
            'borrower_lastname' => iconv('UTF-8', 'cp874', $borrower['lastname']),
            'mom_prefix' => iconv('UTF-8', 'cp874', 'นาง'),
            'mom_firstname' => iconv('UTF-8', 'cp874', 'เยื้อน'),
            'mom_lastname' => iconv('UTF-8', 'cp874', 'เทียนเพ็ชร'),
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
            $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php', public_path('fonts'),true);
            $pdf->SetFont('THSarabunNew', '', 12);

            //write date
            $pdf->Text(118, 42,$gregorianDate->day);
            $month = iconv('UTF-8', 'cp874', $this->getThaiMonthName($gregorianDate->month));
            $pdf->Text(140, 42,$month);
            $pdf->Text(172, 42,$buddhistYear);

            $borrower_name_input = 85;//lenght of input (name>..................<)
            $fullname_borrower_lenght = strlen($decrypData['borrower_prefix'].$decrypData['borrower_firstname'].'   '.$decrypData['borrower_lastname']);//lenght of string(prefix,firstname,lastname)
            $borrower_name_x = 77+($borrower_name_input/2 - $fullname_borrower_lenght/2)-6; // x position in tamplate = first_x_position_of_input_line(name.......... , first "." is value of this) + (lenght_of_input/2 - lenght_of_string/2) - be_incorrect
            $pdf->Text($borrower_name_x, 68.5,$decrypData['borrower_prefix'].$decrypData['borrower_firstname'].'   '.$decrypData['borrower_lastname']);
            
            $mom_name_input = 59;
            $fullname_mom_lenght = strlen($decrypData['borrower_prefix'].$decrypData['borrower_firstname'].'   '.$decrypData['borrower_lastname']);
            $mom_name_x = 75+($mom_name_input/2 - $fullname_mom_lenght/2)-3;
            $pdf->Text($mom_name_x, 99,$decrypData['mom_prefix'].$decrypData['mom_firstname'].'   '.$decrypData['mom_lastname']);
            
            //tick mark
            $tick_alp = public_path('icon_png/tick.png');
            $pdf->Image($tick_alp, 161, 73.5, 4, 4);

            $pdf->Output(); 
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="generated_form.pdf"',
        ]);
    }



}
