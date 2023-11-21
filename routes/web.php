<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/borrower_index', function () {
    return view('borrower_index');
})->name('borrower_index');

Route::get('/borrower_loan_request', function () {
    return view('borrower_loan_request');
})->name('borrower_loan_request');

Route::get('/admin_index', function () {
    return view('admin_index');
})->name('admin_index');


Route::get('/contract', function () {
    return view('contract');
})->name('contract');

Route::get('/contract/to_edit/{id}', function ($id) {
    $loan_request = array(
        array('id'=>'6410014103','name'=>'กิตติวัฒน์ เทียนเพ็ชร','faculty'=>'คณะศิลปศาสตร์และวิทยาศาสตร์','major'=>'สาขาวิชาวิทยาการคอมพิวเตอร์','professor'=>'อลงกรณ์','faculty_check'=>'อนุมัติ','ckeker_name'=>'ปกรณ์','grade'=>'3','date_return'=>date("Y-m-d H:i:s"),'comment'=>array(['comname'=>'คำยินยอมผู้แทน','comdescript'=>'ลายเซ็นไม่ตรงสำเนาบัตร'],['comname'=>'สัญญา','comdescript'=>'เอกสารไม่ชัดเจน']),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์','age'=>'24'),
        array('id'=>'6410014102','name'=>'กฤษณะ ภารสุวรรณ','faculty'=>'คณะมนุษยศาสตร์และสังคมศาสตร์','major'=>'สาขาวิชาภาษาญี่ปุ่น','professor'=>'มักกานากัล','faculty_check'=>'อนุมัติ','ckeker_name'=>'กรวี','grade'=>'1','date_return'=>date("Y-m-d H:i:s"),'comment'=>array(['comname'=>'คำยินยอมผู้แทน','comdescript'=>'ลายเซ็นไม่ตรงสำเนาบัตร'],['comname'=>'สัญญา','comdescript'=>'เอกสารไม่ชัดเจน']),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์','age'=>'23'),
        array('id'=>'6410014101','name'=>'กฤษดา เจริญวิเชียรฉาย','faculty'=>'คณะบริหารธุรกิจและการบัญชี','major'=>'สาขาวิชาการบริหารธุรกิจ','professor'=>'ซเนป','faculty_check'=>'อนุมัติ','ckeker_name'=>'มาโนช','grade'=>'1','date_return'=>date("Y-m-d H:i:s"),'comment'=>array(['comname'=>'คำยินยอมผู้แทน','comdescript'=>'ลายเซ็นไม่ตรงสำเนาบัตร'],['comname'=>'สัญญา','comdescript'=>'เอกสารไม่ชัดเจน']),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์','age'=>'21'),
        array('id'=>'6410014106','name'=>'ภัทรนันท์ ประสานสุข','faculty'=>'วิทยาลัยกฎหมายและการปกครอง','major'=>'สาขาวิชารัฐประศาสนศาสตร์','professor'=>'ดัมเบิ้ลดอว์','faculty_check'=>'อนุมัติ','ckeker_name'=>'สถาพร','grade'=>'4','date_return'=>date("Y-m-d H:i:s"),'comment'=>array(['comname'=>'คำยินยอมผู้แทน','comdescript'=>'ลายเซ็นไม่ตรงสำเนาบัตร'],['comname'=>'สัญญา','comdescript'=>'เอกสารไม่ชัดเจน'],['comname'=>'สำเนาบัตรผู้กู้','comdescript'=>'เอกสารไม่ชัดเจน']),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์','tel'=>'0931037881','age'=>'21'),
    );
    // $i = 0;
    for($i=0; $i<sizeof($loan_request); $i++){
        if($id == $loan_request[$i]['id']){
            return json_encode($loan_request[$i]);
        }
    }
    return json_encode(array('msg'=>'no filed '.$id));
});

Route::get('/confirm_money_withdraw', function () {
    return view('confirm_money_withdraw');
})->name('confirm_money_withdraw');

Route::get('/confirm_money_withdraw/to_edit/{id}', function ($id) {
    $loan_request = array(
        array('id'=>'6410014103','name'=>'กิตติวัฒน์ เทียนเพ็ชร','faculty'=>'คณะศิลปศาสตร์และวิทยาศาสตร์','major'=>'สาขาวิชาวิทยาการคอมพิวเตอร์','professor'=>'อลงกรณ์','faculty_check'=>'อนุมัติ','ckeker_name'=>'ปกรณ์','grade'=>'3','date_return'=>date("Y-m-d H:i:s"),'comment'=>array(['comname'=>'สำเนาบัตรประชาชน','comdescript'=>'ลายเซ็นไม่ตรงสำเนาบัตร'],['comname'=>'แบบยืนยันการเบิกเงิน','comdescript'=>'เอกสารไม่ชัดเจน']),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์','age'=>'24'),
        array('id'=>'6410014102','name'=>'กฤษณะ ภารสุวรรณ','faculty'=>'คณะมนุษยศาสตร์และสังคมศาสตร์','major'=>'สาขาวิชาภาษาญี่ปุ่น','professor'=>'มักกานากัล','faculty_check'=>'อนุมัติ','ckeker_name'=>'กรวี','grade'=>'1','date_return'=>date("Y-m-d H:i:s"),'comment'=>array(['comname'=>'สำเนาบัตรประชาชน','comdescript'=>'ลายเซ็นไม่ตรงสำเนาบัตร'],['comname'=>'แบบยืนยันการเบิกเงิน','comdescript'=>'เอกสารไม่ชัดเจน']),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์','age'=>'23'),
        array('id'=>'6410014101','name'=>'กฤษดา เจริญวิเชียรฉาย','faculty'=>'คณะบริหารธุรกิจและการบัญชี','major'=>'สาขาวิชาการบริหารธุรกิจ','professor'=>'ซเนป','faculty_check'=>'อนุมัติ','ckeker_name'=>'มาโนช','grade'=>'1','date_return'=>date("Y-m-d H:i:s"),'comment'=>array(['comname'=>'สำเนาบัตรประชาชน','comdescript'=>'ลายเซ็นไม่ตรงสำเนาบัตร'],['comname'=>'แบบยืนยันการเบิกเงิน','comdescript'=>'เอกสารไม่ชัดเจน']),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์','age'=>'21'),
        array('id'=>'6410014106','name'=>'ภัทรนันท์ ประสานสุข','faculty'=>'วิทยาลัยกฎหมายและการปกครอง','major'=>'สาขาวิชารัฐประศาสนศาสตร์','professor'=>'ดัมเบิ้ลดอว์','faculty_check'=>'อนุมัติ','ckeker_name'=>'สถาพร','grade'=>'4','date_return'=>date("Y-m-d H:i:s"),'comment'=>array(['comname'=>'สำเนาบัตรประชาชน','comdescript'=>'ลายเซ็นไม่ตรงสำเนาบัตร'],['comname'=>'แบบยืนยันการเบิกเงิน','comdescript'=>'เอกสารไม่ชัดเจน'],['comname'=>'สำเนาบัตรผู้กู้','comdescript'=>'เอกสารไม่ชัดเจน']),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์','tel'=>'0931037881','age'=>'21'),
      );
    // $i = 0;
    for($i=0; $i<sizeof($loan_request); $i++){
        if($id == $loan_request[$i]['id']){
            return json_encode($loan_request[$i]);
        }
    }
    return json_encode(array('msg'=>'no filed '.$id));
});

Route::get('/over_course', function () {
    return view('over_course');
})->name('over_course');

Route::get('/over_course/to_edit/{id}', function ($id) {
    $loan_request = array(
        array('id'=>'6410014103','name'=>'กิตติวัฒน์ เทียนเพ็ชร','faculty'=>'คณะศิลปศาสตร์และวิทยาศาสตร์','major'=>'สาขาวิชาวิทยาการคอมพิวเตอร์','professor'=>'อลงกรณ์','faculty_check'=>'อนุมัติ','ckeker_name'=>'ปกรณ์','grade'=>'3','date_return'=>date("Y-m-d H:i:s"),'comment'=>array(['comname'=>'สำเนาบัตรประชาชน','comdescript'=>'ลายเซ็นไม่ตรงสำเนาบัตร'],['comname'=>'คำขอกู้เกินหลักสูตร','comdescript'=>'เอกสารไม่ชัดเจน']),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์','age'=>'24'),
        array('id'=>'6410014102','name'=>'กฤษณะ ภารสุวรรณ','faculty'=>'คณะมนุษยศาสตร์และสังคมศาสตร์','major'=>'สาขาวิชาภาษาญี่ปุ่น','professor'=>'มักกานากัล','faculty_check'=>'อนุมัติ','ckeker_name'=>'กรวี','grade'=>'1','date_return'=>date("Y-m-d H:i:s"),'comment'=>array(['comname'=>'สำเนาบัตรประชาชน','comdescript'=>'ลายเซ็นไม่ตรงสำเนาบัตร'],['comname'=>'คำขอกู้เกินหลักสูตร','comdescript'=>'เอกสารไม่ชัดเจน']),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์','age'=>'23'),
        array('id'=>'6410014101','name'=>'กฤษดา เจริญวิเชียรฉาย','faculty'=>'คณะบริหารธุรกิจและการบัญชี','major'=>'สาขาวิชาการบริหารธุรกิจ','professor'=>'ซเนป','faculty_check'=>'อนุมัติ','ckeker_name'=>'มาโนช','grade'=>'1','date_return'=>date("Y-m-d H:i:s"),'comment'=>array(['comname'=>'สำเนาบัตรประชาชน','comdescript'=>'ลายเซ็นไม่ตรงสำเนาบัตร'],['comname'=>'คำขอกู้เกินหลักสูตร','comdescript'=>'เอกสารไม่ชัดเจน']),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์','age'=>'21'),
        array('id'=>'6410014106','name'=>'ภัทรนันท์ ประสานสุข','faculty'=>'วิทยาลัยกฎหมายและการปกครอง','major'=>'สาขาวิชารัฐประศาสนศาสตร์','professor'=>'ดัมเบิ้ลดอว์','faculty_check'=>'อนุมัติ','ckeker_name'=>'สถาพร','grade'=>'4','date_return'=>date("Y-m-d H:i:s"),'comment'=>array(['comname'=>'สำเนาบัตรประชาชน','comdescript'=>'ลายเซ็นไม่ตรงสำเนาบัตร'],['comname'=>'คำขอกู้เกินหลักสูตร','comdescript'=>'เอกสารไม่ชัดเจน'],['comname'=>'ใบแสดงผลการเรียน','comdescript'=>'เอกสารไม่ชัดเจน']),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์','tel'=>'0931037881','age'=>'21'),
      );
    // $i = 0;
    for($i=0; $i<sizeof($loan_request); $i++){
        if($id == $loan_request[$i]['id']){
            return json_encode($loan_request[$i]);
        }
    }
    return json_encode(array('msg'=>'no filed '.$id));
});

Route::get('/admin_return_document', function () {
    return view('admin_return_document');
})->name('admin_return_document');

Route::get('/admin_edit_informaion_request', function () {
    return view('admin_edit_informaion_request');
})->name('admin_edit_informaion_request');

Route::get('/admin_edit_informaion_request/to_edit/{id}', function ($id) {
    $loan_request = array(
        array('id'=>'6410014103','name'=>'กิตติวัฒน์ เทียนเพ็ชร','faculty'=>'คณะศิลปศาสตร์และวิทยาศาสตร์','major'=>'สาขาวิชาวิทยาการคอมพิวเตอร์','professor'=>'อลงกรณ์','faculty_check'=>'อนุมัติ','ckeker_name'=>'ปกรณ์','grade'=>'3','date_return'=>date("Y-m-d H:i:s"),'comment'=>array(['comname'=>'เอกสารที่ส่งมาด้วย','comdescript'=>'ลายเซ็นไม่ตรงสำเนาบัตร']),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์','age'=>'24','edit_type'=>'นามสกุล','edit_data'=>['old_data'=>'เทียนเพ็ชร','new_data'=>'เทียนทอง']),
        array('id'=>'6410014102','name'=>'กฤษณะ ภารสุวรรณ','faculty'=>'คณะมนุษยศาสตร์และสังคมศาสตร์','major'=>'สาขาวิชาภาษาญี่ปุ่น','professor'=>'มักกานากัล','faculty_check'=>'อนุมัติ','ckeker_name'=>'กรวี','grade'=>'1','date_return'=>date("Y-m-d H:i:s"),'comment'=>array(['comname'=>'เอกสารที่ส่งมาด้วย','comdescript'=>'เอกสารไม่ชัดเจน']),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์','age'=>'23','edit_type'=>'ชื่อจริง','edit_data'=>['old_data'=>'กฤษณะ','new_data'=>'กฤษณะครับ']),
        array('id'=>'6410014101','name'=>'กฤษดา เจริญวิเชียรฉาย','faculty'=>'คณะบริหารธุรกิจและการบัญชี','major'=>'สาขาวิชาการบริหารธุรกิจ','professor'=>'ซเนป','faculty_check'=>'อนุมัติ','ckeker_name'=>'มาโนช','grade'=>'1','date_return'=>date("Y-m-d H:i:s"),'comment'=>array(['comname'=>'เอกสารที่ส่งมาด้วย','comdescript'=>'ลายเซ็นไม่ตรงสำเนาบัตร']),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์','age'=>'21','edit_type'=>'ชื่อจริง','edit_data'=>['old_data'=>'กฤษดา','new_data'=>'กฤษฎา']),
        array('id'=>'6410014106','name'=>'ภัทรนันท์ ประสานสุข','faculty'=>'วิทยาลัยกฎหมายและการปกครอง','major'=>'สาขาวิชารัฐประศาสนศาสตร์','professor'=>'ดัมเบิ้ลดอว์','faculty_check'=>'อนุมัติ','ckeker_name'=>'สถาพร','grade'=>'4','date_return'=>date("Y-m-d H:i:s"),'comment'=>array(['comname'=>'เอกสารที่ส่งมาด้วย','comdescript'=>'เอกสารไม่ชัดเจน']),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์','tel'=>'0931037881','age'=>'21','edit_type'=>'ชื่อจริง','edit_data'=>['old_data'=>'ภัทรนันท์','new_data'=>'เสี่ยโป้']),
      );
    // $i = 0;
    for($i=0; $i<sizeof($loan_request); $i++){
        if($id == $loan_request[$i]['id']){
            return json_encode($loan_request[$i]);
        }
    }
    return json_encode(array('msg'=>'no filed '.$id));
});

Route::get('/admin_settime',function (){
    return view('admin_settime');
})->name('admin_settime');

Route::get('/search_document',function (){
    return view('search_document');
})->name('search_document');

Route::get('/search_document/borrower_documents',function (){
    return view('borrower_documents');
})->name('borrower_documents');


Route::get('/new_loan_submission', function () {
    return view('new_loan_submission');
})->name('new_loan_submission');

Route::get('/new_loan_submission/to_edit/{id}',function ($id){
    $loan_request = array(
        array('id'=>'6410014103','name'=>'กิตติวัฒน์ เทียนเพ็ชร','faculty'=>'คณะศิลปศาสตร์และวิทยาศาสตร์','major'=>'สาขาวิชาวิทยาการคอมพิวเตอร์','professor'=>'อลงกรณ์','faculty_check'=>'อนุมัติ','ckeker_name'=>'ปกรณ์','grade'=>'3','date_return'=>date("Y-m-d H:i:s"),'comment'=>array(['comname'=>'คำยินยอมผู้แทน','comdescript'=>'ลายเซ็นไม่ตรงสำเนาบัตร'],['comname'=>'หนังสือรับรองรายได้','comdescript'=>'เอกสารไม่ชัดเจน']),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์','age'=>'24'),
        array('id'=>'6410014102','name'=>'กฤษณะ ภารสุวรรณ','faculty'=>'คณะมนุษยศาสตร์และสังคมศาสตร์','major'=>'สาขาวิชาภาษาญี่ปุ่น','professor'=>'มักกานากัล','faculty_check'=>'อนุมัติ','ckeker_name'=>'กรวี','grade'=>'1','date_return'=>date("Y-m-d H:i:s"),'comment'=>array(['comname'=>'คำยินยอมผู้แทน','comdescript'=>'ลายเซ็นไม่ตรงสำเนาบัตร'],['comname'=>'หนังสือรับรองรายได้','comdescript'=>'เอกสารไม่ชัดเจน']),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์','age'=>'23'),
        array('id'=>'6410014101','name'=>'กฤษดา เจริญวิเชียรฉาย','faculty'=>'คณะบริหารธุรกิจและการบัญชี','major'=>'สาขาวิชาการบริหารธุรกิจ','professor'=>'ซเนป','faculty_check'=>'อนุมัติ','ckeker_name'=>'มาโนช','grade'=>'1','date_return'=>date("Y-m-d H:i:s"),'comment'=>array(['comname'=>'คำยินยอมผู้แทน','comdescript'=>'ลายเซ็นไม่ตรงสำเนาบัตร'],['comname'=>'หนังสือรับรองรายได้','comdescript'=>'เอกสารไม่ชัดเจน']),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์','age'=>'21'),
        array('id'=>'6410014106','name'=>'ภัทรนันท์ ประสานสุข','faculty'=>'วิทยาลัยกฎหมายและการปกครอง','major'=>'สาขาวิชารัฐประศาสนศาสตร์','professor'=>'ดัมเบิ้ลดอว์','faculty_check'=>'อนุมัติ','ckeker_name'=>'สถาพร','grade'=>'4','date_return'=>date("Y-m-d H:i:s"),'comment'=>array(['comname'=>'คำยินยอมผู้แทน','comdescript'=>'ลายเซ็นไม่ตรงสำเนาบัตร'],['comname'=>'หนังสือรับรองรายได้','comdescript'=>'เอกสารไม่ชัดเจน'],['comname'=>'สำเนาบัตรผู้แทน','comdescript'=>'เอกสารไม่ชัดเจน']),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์','tel'=>'0931037881','age'=>'21'),
    );
    // $i = 0;
    for($i=0; $i<sizeof($loan_request); $i++){
        if($id == $loan_request[$i]['id']){
            return json_encode($loan_request[$i]);
        }
    }
    return json_encode(array('msg'=>'no filed '.$id));
});

Route::get('/loan_submission', function () {
    return view('loan_submission');
})->name('loan_submission');

Route::get('/loan_submission/to_edit/{id}',function ($id){
    $loan_request = array(
        array('id'=>'6410014103','name'=>'กิตติวัฒน์ เทียนเพ็ชร','faculty'=>'คณะศิลปศาสตร์และวิทยาศาสตร์','major'=>'สาขาวิชาวิทยาการคอมพิวเตอร์','professor'=>'อลงกรณ์','faculty_check'=>'อนุมัติ','ckeker_name'=>'ปกรณ์','grade'=>'3','date_return'=>date("Y-m-d H:i:s"),'comment'=>array(['comname'=>'สำเนาบัตรประชาชน','comdescript'=>'ลงลายมือชื่อไม่ถูกต้อง'],['comname'=>'ใบแสดงผลการเรียน','comdescript'=>'เอกสารไม่ชัดเจน']),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์','age'=>'24'),
        array('id'=>'6410014102','name'=>'กฤษณะ ภารสุวรรณ','faculty'=>'คณะมนุษยศาสตร์และสังคมศาสตร์','major'=>'สาขาวิชาภาษาญี่ปุ่น','professor'=>'มักกานากัล','faculty_check'=>'อนุมัติ','ckeker_name'=>'กรวี','grade'=>'1','date_return'=>date("Y-m-d H:i:s"),'comment'=>array(['comname'=>'สำเนาบัตรประชาชน','comdescript'=>'ลงลายมือชื่อไม่ถูกต้อง'],['comname'=>'ใบแสดงผลการเรียน','comdescript'=>'เอกสารไม่ชัดเจน']),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์','age'=>'23'),
        array('id'=>'6410014101','name'=>'กฤษดา เจริญวิเชียรฉาย','faculty'=>'คณะบริหารธุรกิจและการบัญชี','major'=>'สาขาวิชาการบริหารธุรกิจ','professor'=>'ซเนป','faculty_check'=>'อนุมัติ','ckeker_name'=>'มาโนช','grade'=>'1','date_return'=>date("Y-m-d H:i:s"),'comment'=>array(['comname'=>'สำเนาบัตรประชาชน','comdescript'=>'ลงลายมือชื่อไม่ถูกต้อง'],['comname'=>'ใบแสดงผลการเรียน','comdescript'=>'เอกสารไม่ชัดเจน']),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์','age'=>'21'),
        array('id'=>'6410014106','name'=>'ภัทรนันท์ ประสานสุข','faculty'=>'วิทยาลัยกฎหมายและการปกครอง','major'=>'สาขาวิชารัฐประศาสนศาสตร์','professor'=>'ดัมเบิ้ลดอว์','faculty_check'=>'อนุมัติ','ckeker_name'=>'สถาพร','grade'=>'4','date_return'=>date("Y-m-d H:i:s"),'comment'=>array(['comname'=>'สำเนาบัตรประชาชน','comdescript'=>'ลงลายมือชื่อไม่ถูกต้อง'],['comname'=>'ใบแสดงผลการเรียน','comdescript'=>'เอกสารไม่ชัดเจน'],['comname'=>'สำเนาบัตรผู้แทน','comdescript'=>'เอกสารไม่ชัดเจน']),'tel'=>'0931037881','type'=>'ขาดแคลนคุณทรัพย์','tel'=>'0931037881','age'=>'21'),
      );
    // $i = 0;
    for($i=0; $i<sizeof($loan_request); $i++){
        if($id == $loan_request[$i]['id']){
            return json_encode($loan_request[$i]);
        }
    }
    return json_encode(array('msg'=>'no filed '.$id));
});


Route::get('/admin_manage_account',[UsersController::class,'getUsersData'])->name('admin_manage_account');

Route::get('/getUser/{id}',[UsersController::class,'getUserById']);

Route::get('/deleteUser/{id}',[UsersController::class,'deleteUser']);

Route::post('/createUser',[UsersController::class,'createUser']);
Route::post('/editAccount',[UsersController::class,'editAccount']);


Route::get('/teacher_index',function () {
    return view('teacher_index');
})->name('teacher_index');

Route::get('/employee/index',function () {
    return view('/employee/index');
});



