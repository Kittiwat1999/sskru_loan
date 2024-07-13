<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\AdminManageDocumentsController;
use App\Http\Controllers\OldLoanRequestController;
use App\Http\Controllers\AdminDocumentSchedulerController;
use App\Http\Controllers\AdminManageDataController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\SendDocumentController;
use App\Http\Controllers\DownloadDocumentController;
use App\Http\Controllers\BorrowerInforamtionController;
use App\Http\Controllers\GenerateFile;
use App\Http\Controllers\GenerateDocController;
use App\Http\Controllers\MainParentInfomationController;
use App\Http\Controllers\ParentInformationController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetpasswordController;
use App\Http\Controllers\UsersProfileController;
use App\Http\Requests\borrowerInformationValidationRequest;
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

Route::get('/admin/document_scheduler',[AdminDocumentSchedulerController::class, 'index']);
Route::put('/admin/document_scheduler/putdata',[AdminDocumentSchedulerController::class, 'putDocSchedulerData'])->name('admin.doc.scheduler.putdata');
Route::get('/admin/document_scheduler/get/document/{document_id}',[AdminDocumentSchedulerController::class, 'getDocumentById'])->name('admin.doc.scheduler.get.document');
Route::post('/admin/document_scheduler/postdata/{document_id}',[AdminDocumentSchedulerController::class, 'postDocSchedulerData'])->name('admin.doc.scheduler.postdata');
Route::delete('/admin/document_scheduler/deletedata/{document_id}',[AdminDocumentSchedulerController::class, 'deleteDocSchedulerData'])->name('admin.doc.scheduler.deletedata');


Route::get('/admin/manage_account',[UsersController::class,'index'])->name('admin_manage_account');
Route::get('/admin/manage_account/{select_privilage}',[UsersController::class,'admin_getUsersDataByPrivilage'])->name('admin.manageaccount.privilage');

Route::get('/admin/get_user_by_id/{user_id}',[UsersController::class,'admin_get_user_by_id'])->name('admin.get_ser_by_id');

Route::get('/admin/deleteUser/{id}',[UsersController::class,'admin_deleteUser'])->name('admin.deleteUser');

Route::post('/admin/createUser',[UsersController::class,'admin_createUser'])->name('admin.createUser');
Route::post('/admin/editAccount',[UsersController::class,'admin_editAccount'])->name('admin.editAccount');

Route::get('/admin/manage_account/get_major_by_faculty_id/{faculty_id}',[UsersController::class,'get_major_by_faculty_id']);

//manage document page
Route::get('/admin/manage_documents',[AdminManageDocumentsController::class,'manage_documents'])->name('admin.manage.documents');
// child doc crud
Route::put('/admin/manage_documents/store_document',[AdminManageDocumentsController::class,'storeDocument'])->name('admin.manage.documents.storedocument');
Route::post('/admin/manage_documents/edit_document/{child_document_id}',[AdminManageDocumentsController::class,'edit_child_document'])->name('admin.manage.documents.editdocument');
Route::delete('/admin/manage_documents/delete_document/{child_document_id}',[AdminManageDocumentsController::class,'DeleteChildDoc'])->name('admin.manage.documents.deletedocument');

// addon crud
Route::post('/admin/manage_documents/store_addon_document',[AdminManageDocumentsController::class,'store_addon_document'])->name('admin.manage.documents.store.addon_document');
Route::put('/admin/manage_documents/edit_addon_document/{addon_document_id}',[AdminManageDocumentsController::class,'edit_addon_document'])->name('admin.manage.documents.edit.addon_document');
Route::delete('/admin/manage_documents/delete_addon_document/{addon_document_id}',[AdminManageDocumentsController::class,'delete_addon_document'])->name('admin.manage.documents.delete.addon_document');

//doctype crud
Route::put('/admin/manage_documents/store_doctype',[AdminManageDocumentsController::class,'sotoreDocType'])->name('admin.manage.documents.storedoctype');
Route::post('/admin/manage_documents/edit_doctype/{doc_type_id}',[AdminManageDocumentsController::class,'editDocType'])->name('admin.manage.documents.editdoctype');
Route::delete('/admin/manage_documents/delete_doctype/{doc_type_id}',[AdminManageDocumentsController::class,'deleteDocType'])->name('admin.manage.documents.deletedoctype');

Route::post('/admin/manage_documents/update_useful_activity_hour',[AdminManageDocumentsController::class,'updateUsefulActivitytHour'])->name('admin.manage.documents.update.useful.hour');

//child doc files
Route::get('/admin/manage_documents/files/{child_document_id}',[AdminManageDocumentsController::class,'mange_file_page'])->name('admin.manage.file.document');
//crud downlaod file
Route::post('/admin/manage_child_document/file/store/{child_document_id}',[AdminManageDocumentsController::class,'store_child_document_file'])->name('admin.store.child.document.file');
Route::delete('/admin/manage_child_document/file/delete/{child_document_file_id}',[AdminManageDocumentsController::class,'delete_child_document_file'])->name('admin.delete.child.document.file');
Route::put('/admin/manage_child_document/update/generate_file/{child_document_id}',[AdminManageDocumentsController::class,'update_child_document_generate_file'])->name('admim.child.document.update.generatefile');
//crud example file
Route::post('/admin/manage_child_document/example_file/store/{child_document_id}',[AdminManageDocumentsController::class,'store_example_file'])->name('admin.store.example.file');
Route::delete('/admin/manage_child_document/example_file/delete/{example_file_id}',[AdminManageDocumentsController::class,'delete_example_file'])->name('admin.delete.example.file');
Route::post('/admin/manage_child_document/minors_example_file/store/{child_document_id}',[AdminManageDocumentsController::class,'stroe_minors_example_file'])->name('admin.store.minors.example.file');
//document add-on file
Route::put('/admin/manage_child_document/child_document/update/addon/{child_document_id}',[AdminManageDocumentsController::class,'update_child_document_addon'])->name('admim.child.document.update.addon');



// addon file
Route::get('/admin/manage_documents/addon/files/{addon_document_id}',[AdminManageDocumentsController::class,'mange_addon_file_page'])->name('admin.manage.addon.file.document');
//crud download file
Route::post('/admin/manage_addon_document/file/store/{addon_document_id}',[AdminManageDocumentsController::class,'store_addon_document_file'])->name('admin.store.addon.document.file');
Route::delete('/admin/manage_addon_document/file/delete/{addon_document_file_id}',[AdminManageDocumentsController::class,'delete_addon_document_file'])->name('admin.delete.addon.document.file');
Route::put('/admin/manage_addon_document/update/generate_file/{addon_document_id}',[AdminManageDocumentsController::class,'update_addon_document_generate_file'])->name('admim.addon.document.update.generatefile');
//crud example file
Route::post('/admin/manage_addon_document/example_addon_file/store/{addon_document_id}',[AdminManageDocumentsController::class,'store_example_addon_file'])->name('admin.store.example.addon.file');
Route::delete('/admin/manage_addon_document/example_addon_file/delete/{example_addon_file_id}',[AdminManageDocumentsController::class,'delete_example_addon_file'])->name('admin.delete.example.addon.file');
//admin manage account display all file
Route::get('/admin/manage_documents/deisplayfile/file/{file_path}/{file_name}',[AdminManageDocumentsController::class,'displayFile'])->name('admin.display.file');


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

Route::get('/borrower/information/information_list',[BorrowerInforamtionController::class,'index']);

Route::get('/borrower/input/information',[BorrowerInforamtionController::class,'borrower_input_information'])->name('borrower.input.information');
Route::get('/borrower/edit/information/page',[BorrowerInforamtionController::class,'borrower_edit_information_page'])->name('borrower.edit.information.page');
Route::put('/borrower/edit/information',[BorrowerInforamtionController::class,'borrower_edit_information'])->name('borrower.edit.information');
Route::post('/borrower/store/information/borrower',[BorrowerInforamtionController::class,'borrower_store_information'])->name('borrower.store.information');
Route::get('/borrower/major_by_faculty/{faculty}',[BorrowerInforamtionController::class,'getMajorByFaculty']);

Route::get('/borrower/input/parent/information',[ParentInformationController::class,'borrower_input_parent_information'])->name('borrower.input.parent.information');
Route::post('/borrower/store/parent/information',[ParentInformationController::class,'borrower_store_parent_information'])->name('borrower.store.parent.information');
Route::get('/borrower/edit/parent/information/page',[ParentInformationController::class,'borrower_edit_parent_information_page'])->name('borrower.edit.parent.information.page');
Route::put('/borrower/edit/parent/information',[ParentInformationController::class,'borrower_edit_parent_information'])->name('borrower.edit.parent.information');
Route::get('/borrower/information/marital_file/{student_id}/{file_name}',[ParentInformationController::class,'display_marital_status_file'])->name('marital.status.file');

Route::get('/borrower/input/main_parent/information',[MainParentInfomationController::class,'borrower_input_main_parent_information'])->name('borrower.input.main_parent.information');
Route::post('/borrower/store/main_parent/information',[MainParentInfomationController::class,'borrower_store_main_parent_information'])->name('borrower.store.main_parent.information');
Route::get('/borrower/edit/main_parent/information/page',[MainParentInfomationController::class,'borrower_edit_main_parent_information_page'])->name('borrower.edit.main_parent.information.page');
Route::put('/borrower/edit/main_parent/information',[MainParentInfomationController::class,'borrower_edit_main_parent_information'])->name('borrower.edit.main_parent.information');
Route::get('/borrower/information',[BorrowerController::class,'getBorrowerInformation']);



Route::post('/store_information',[BorrowerController::class,'storeInformation']);

Route::post('/borrower/edit_data',[BorrowerController::class,'borrowerEditdata']);


Route::get('/borrower/edit_borrower_information',function () {
    return view('/borrower/edit_borrower_information');
});

Route::get('/blank',function () {
    return view('/blank');
});

Route::get('/register_student',[RegisterController::class,'index']);
Route::put('/register_student/student/register/',[RegisterController::class,'register_student'])->name('register.student');

Route::get('/login',[AuthenticationController::class,'index']);
Route::post('/post/login',[AuthenticationController::class,'authenticate'])->name('post.login');

Route::get('/register-success', function () {
    return view('register-success');
})->name('register.success');

Route::get('/login_student',[ResetpasswordController::class,'index']);
Route::put('/login_student/student/send_otp_email',[ResetpasswordController::class,'send_otp_email'])->name('send.otp.email.student');
Route::get('/send_otp_email',function () {return view('/send_otp_email');});
Route::put('/login_student/student/verify_resetpassword',[ResetpasswordController::class,'verify_resetpassword'])->name('verify.resetpassword.student');
Route::get('/verify_resetpassword',function () {return view('/verify_resetpassword');});
Route::post('/login_student/student/change_password',[ResetpasswordController::class,'change_password'])->name('change.password.student');
Route::get('/change_password',function () {return view('/change_password');});
Route::get('/success_page',function () {return view('/success_page');});

Route::get('/login_teacher',function () {
    return view('/login_teacher');
});

Route::get('/borrower/upload_document',[SendDocumentController::class,'index']);
Route::get('/borrower/upload_document/page/{document_id}',[SendDocumentController::class,'upload_document_page'])->name('borrower.upload.document.page');

Route::get('/borrower/download_document',[DownloadDocumentController::class,'index']);
Route::get('/borrower/download_document/{document_id}',[DownloadDocumentController::class,'download_file'])->name('borrower.download.document');
Route::get('/borrower/download_document/parent/{parent_id}',[DownloadDocumentController::class,'download_parent_file'])->name('borrower.download.parent.document');
Route::get('/testGetdata',[BorrowerController::class,'testGetdata']);

Route::get('/generate_rabrongraidai',[GenerateFile::class,'generate_rabrongraidai']);
Route::get('/generate_yinyorm',[GenerateFile::class,'generate_yinyorm_student']);
Route::get('/teachers_comment',[GenerateFile::class,'teachers_comment']);

Route::get('/borrower_101_page_1',[GenerateDocController::class,'borrower_101_page_1']);
Route::get('/borrower_101_page_2',[GenerateDocController::class,'borrower_101_page_2']);

Route::get('/admin/manage_data',[AdminManageDataController::class,'index']);
Route::get('/admin/manage_data/major/{faculty_id}',[AdminManageDataController::class,'major_page'])->name('admin.manage.data.major');
Route::delete('/admin/manage_data/faculty/delete/{faculty_id}',[AdminManageDataController::class,'delete_faculty'])->name('admin.manage.data.delete.faculty');
Route::delete('/admin/manage_data/apprearancetype/delete/{apprearancetype_id}',[AdminManageDataController::class,'delete_apprearancetype'])->name('admin.manage.data.delete.apprearancetype');
Route::delete('/admin/manage_data/property/delete/{property_id}',[AdminManageDataController::class,'delete_property'])->name('admin.manage.data.delete.property');
Route::delete('/admin/manage_data/nessessity/delete/{nessessity_id}',[AdminManageDataController::class,'delete_nessessity'])->name('admin.manage.data.delete.nessessity');
Route::delete('/admin/manage_data/major/delete/{major_id}',[AdminManageDataController::class,'delete_major'])->name('admin.manage.data.delete.major');
Route::post('/admin/manage_data/faculty/add/',[AdminManageDataController::class,'add_faculty'])->name('admin.manage.data.add.faculty');
Route::post('/admin/manage_data/apprearancetype/add/',[AdminManageDataController::class,'add_apprearancetype'])->name('admin.manage.data.add.apprearancetype');
Route::post('/admin/manage_data/property/add/',[AdminManageDataController::class,'add_property'])->name('admin.manage.data.add.property');
Route::post('/admin/manage_data/nessessity/add/',[AdminManageDataController::class,'add_nessessity'])->name('admin.manage.data.add.nessessity');
Route::post('/admin/manage_data/major/add/{faculty_id}',[AdminManageDataController::class,'add_major'])->name('admin.manage.data.add.major');
Route::put('/admin/manage_data/faculty/edit/{faculty_id}',[AdminManageDataController::class,'edit_faculty'])->name('admin.manage.data.edit.faculty');
Route::put('/admin/manage_data/apprearancetype/edit/{apprearancetype_id}',[AdminManageDataController::class,'edit_apprearancetype'])->name('admin.manage.data.edit.apprearancetype');
Route::put('/admin/manage_data/property/edit/{property_id}',[AdminManageDataController::class,'edit_property'])->name('admin.manage.data.edit.property');
Route::put('/admin/manage_data/nessessity/edit/{nessessity_id}',[AdminManageDataController::class,'edit_nessessity'])->name('admin.manage.data.edit.nessessity');
Route::put('/admin/manage_data/major/edit/{major_id}',[AdminManageDataController::class,'edit_major'])->name('admin.manage.data.edit.major');

Route::get('/verify_email',function () {
    return view('/verify_email');
});

Route::post('/verify_email/post',[AuthenticationController::class,'email_confirm'])->name('verify.email.post');
Route::get('/send_email',[AuthenticationController::class,'send_mail'])->name('send.email');

Route::get('/users_profile',[UsersProfileController::class,'index']);
Route::put('/users_profile/edit',[UsersProfileController::class,'edit_profile'])->name('users.profile.edit');
Route::post('/users_profile/password/change', [UsersProfileController::class, 'change_password'])->name('users.password.change');
