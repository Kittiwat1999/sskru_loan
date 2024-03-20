<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\OldLoanRequestController;
use App\Models\OldLoanRequest;

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

Route::get('/admin/dashboard', function () {
    return view('/admin/dashboard');
});

Route::get('/admin/return_document', function () {
    return view('/admin/return_document');
});

Route::get('/admin/edit_informaion_request', function () {
    return view('/admin/edit_informaion_request');
});

Route::get('/admin/edit_informaion_request/to_edit/{id}', function ($id) {
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

Route::get('/admin/settime',function (){
    return view('/admin/settime');
});

Route::get('/admin/manage_account',[UsersController::class,'admin_getUsersData'])->name('admin_manage_account');
Route::get('/admin/manage_account/{privilage}',[UsersController::class,'admin_getUsersDataByPrivilage'])->name('admin.manageaccount.privilage');

Route::get('/admin/getUser/{id}',[UsersController::class,'admin_getUserById'])->name('admin.getUser');

Route::get('/admin/deleteUser/{id}',[UsersController::class,'admin_deleteUser'])->name('admin.deleteUser');

Route::post('/admin/createUser',[UsersController::class,'admin_createUser'])->name('admin.createUser');
Route::post('/admin/editAccount',[UsersController::class,'admin_editAccount'])->name('admin.editAccount');




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


Route::get('/search_document',function (){
    return view('search_document');
})->name('search_document');

Route::get('/search_document/borrower_documents',function (){
    return view('borrower_documents');
})->name('borrower_documents');


Route::get('/new_loan_submission', function () {
    $privilage = "employee";
    return view('new_loan_submission',compact('privilage'));
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

Route::get('/faculty/new_loan_submission', function () {
    $privilage = "employee";
    return view('faculty_new_loan_submission',compact('privilage'));
});



Route::get('/faculty/new_loan_submission/to_edit/{id}',function ($id){
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


Route::get('/teacher_index',function () {
    return view('teacher_index');
})->name('teacher_index');


Route::get('/borrower/index', function () {
    return view('/borrower/index');
});

Route::get('/borrower/information',[BorrowerController::class,'getBorrowerInformation']);

Route::get('/borrower/information/marital_img/{file_path}',[BorrowerController::class,'displayFile'])->name('marital.status.file');



Route::post('/store_information',[BorrowerController::class,'storeInformation']);

Route::post('/borrower/edit_data',[BorrowerController::class,'borrowerEditdata']);


Route::get('/borrower/new_loan_request', function () {
    //เปลี่ยนค่าตรงนี้เพื่อไปยังหน้าต่างๆของการยื่นกู้
    $page = "download";  //"document","samary","success","download"
    return view('/borrower/new_loan_request',compact('page'));
});



Route::get('/borrower/send_contract',function () {
    return view('/borrower/send_contract');
});

Route::get('/borrower/loan_over_course',function () {
    return view('/borrower/loan_over_course');
});

Route::get('/borrower/send_confirmation_form',function () {
    return view('/borrower/send_confirmation_form');
});

Route::get('/borrower/loan_request',[OldLoanRequestController::class,'index'])->name('old.loanrequest');

Route::get('/borrower/loan_request/upload/{doc_id}',[OldLoanRequestController::class,'upload_page']);

Route::get('/borrower/loan_request/edit/{doc_id}',[OldLoanRequestController::class,'edit_page']);

Route::post('borrower/create_oldloan_doc',[OldLoanRequestController::class,'create_doc'])->name('add.oldloan.request');

Route::post('borrower/delete_oldloan_doc',[OldLoanRequestController::class,'delete_loanrequest_doc'])->name('delete.oldloan.request');

Route::get('/borrower/getActivity/{id}',[OldLoanRequestController::class,'get_activity_by_id']);

Route::get('/borrower/show_actv_file/{filePath}',[OldLoanRequestController::class,'show_actv_file']);

Route::post('/store_activities',[OldLoanRequestController::class,'store_activits'])->name('store.activities');

Route::post('/borrower/edit_activity',[OldLoanRequestController::class,'edit_activity'])->name('edit.activity');

Route::post('/borrower/delete_activity',[OldLoanRequestController::class,'delete_activity'])->name('delete.activity');

Route::post('/borrower/store_citizencardfile',[OldLoanRequestController::class,'store_citizencardfile'])->name('store.citizencardfile');

Route::post('/borrower/store_gpafile',[OldLoanRequestController::class,'store_gpafile'])->name('store.gpafile');

Route::post('/borrower/loan_request/send_loanrequest_doc',[OldLoanRequestController::class,'send_loanrequest_doc'])->name('send.loanrequest.doc');

Route::get('/borrower/edit_borrower_information',function () {
    return view('/borrower/edit_borrower_information');
});

Route::get('/blank',function () {
    return view('/blank');
});

Route::get('/register_student',function () {
    return view('/register_student');
});

Route::get('/login_student',function () {
    return view('/login_student');
});

Route::get('/login_teacher',function () {
    return view('/login_teacher');
});

Route::get('/menu', function () {
    return view('/menu');
});

Route::get('/testGetdata',[BorrowerController::class,'testGetdata']);