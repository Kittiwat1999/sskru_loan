<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminManageAccountController;
use App\Http\Controllers\AdminManageDocumentsController;
use App\Http\Controllers\AdminDocumentSchedulerController;
use App\Http\Controllers\AdminManageBorrowerData;
use App\Http\Controllers\AdminManageDataController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BorrowerDocumentController;
use App\Http\Controllers\SendDocumentController;
use App\Http\Controllers\BorrowerDownloadDocument;
use App\Http\Controllers\BorrowerInforamtionController;
use App\Http\Controllers\BorrowerRegister;
use App\Http\Controllers\CacheAndCommentController;
use App\Http\Controllers\CheckDocumentController;
use App\Http\Controllers\DashboadController;
use App\Http\Controllers\ExportBorrowerDocumentController;
use App\Http\Controllers\MainParentInfomationController;
use App\Http\Controllers\ParentInformationController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetpasswordController;
use App\Http\Controllers\SearchDocuments;
use App\Http\Controllers\TeacherComment;
use App\Http\Controllers\UsefulActivityController;
use App\Http\Controllers\UsersProfileController;
// use App\Http\Controllers\CheckBorrowerInformation;
// use App\Http\Controllers\GenerateFile;
// use App\Http\Controllers\GenerateDocController;

//admin
Route::middleware(['session.expire', 'privilege:admin'])->group(function () {
    //dashboard
    Route::get('/admin/dashboard', [DashboadController::class, 'index']);
    Route::get('/admin/dashboard/{faculty_id}/get-major/', [DashboadController::class, 'geMajorByFacultyId']);
    Route::post('/admin/dashboard/set-data', [DashboadController::class, 'setData'])->name('admin.dashboard.set-data');
    Route::get('/admin/dashboard/get-data', [DashboadController::class, 'getData'])->name('admin.dashboard.get-data');
    Route::get('/admin/dashboard/get-xcel', [ExportBorrowerDocumentController::class, 'exportBorrowerDocument']);
    
    //chache and comment data
    Route::get('/admin/cache-comment', [CacheAndCommentController::class, 'index']);
    Route::get('/admin/clear-cache/all', [CacheAndCommentController::class, 'clearBorrowerDocumentCacheAll'])->name('admin.clear.cache.all');
    Route::get('/admin/clear-cache/one/{borrower_document_id}', [CacheAndCommentController::class, 'clearBorrowerDocumentCache'])->name('admin.clear.cache.one');
    //teacher comment
    Route::put('/admin/edit/techer-comment/{teacher_comment_id}', [CacheAndCommentController::class, 'editTeacherComment'])->name('admin.edit.teahcer.comment');
    Route::post('/admin/add/techer-comment', [CacheAndCommentController::class, 'addTeacherComment'])->name('admin.add.teahcer.comment');
    Route::get('/admin/delete/techer-comment/{teacher_comment_id}', [CacheAndCommentController::class, 'deleteTeacherComment'])->name('admin.delete.teahcer.comment');
    // comment
    Route::put('/admin/edit/comment/{comment_id}', [CacheAndCommentController::class, 'editComment'])->name('admin.edit.comment');
    Route::post('/admin/add/comment', [CacheAndCommentController::class, 'addComment'])->name('admin.add.comment');
    Route::get('/admin/delete/comment/{comment_id}', [CacheAndCommentController::class, 'deleteComment'])->name('admin.delete.comment');
    
    //document shceduler
    Route::get('/admin/document_scheduler', [AdminDocumentSchedulerController::class, 'index']);
    Route::put('/admin/document_scheduler/putdata', [AdminDocumentSchedulerController::class, 'putDocSchedulerData'])->name('admin.doc.scheduler.putdata');
    Route::get('/admin/document_scheduler/get/document/{document_id}', [AdminDocumentSchedulerController::class, 'getDocumentById'])->name('admin.doc.scheduler.get.document');
    Route::post('/admin/document_scheduler/postdata/{document_id}', [AdminDocumentSchedulerController::class, 'postDocSchedulerData'])->name('admin.doc.scheduler.postdata');
    Route::delete('/admin/document_scheduler/deletedata/{document_id}', [AdminDocumentSchedulerController::class, 'deleteDocSchedulerData'])->name('admin.doc.scheduler.deletedata');
    
    //manage account 
    Route::get('/admin/manage_account', [AdminManageAccountController::class, 'index'])->name('admin_manage_account');
    Route::get('/admin/manage_account/select_privilege/{select_privilege}', [AdminManageAccountController::class, 'admin_getUsersDataByPrivilege'])->name('admin.manageaccount.privilege');
    Route::get('/admin/manage_account/get-users', [AdminManageAccountController::class, 'getUsers'])->name('admin.get.users');
    Route::get('/admin/get_user_by_id/{user_id}', [AdminManageAccountController::class, 'admin_get_user_by_id'])->name('admin.get_ser_by_id');
    Route::get('/admin/deleteUser/{id}', [AdminManageAccountController::class, 'admin_deleteUser'])->name('admin.deleteUser');
    Route::post('/admin/createUser', [AdminManageAccountController::class, 'admin_createUser'])->name('admin.createUser');
    Route::post('/admin/editAccount/{user_id}', [AdminManageAccountController::class, 'admin_editAccount'])->name('admin.editAccount');
    Route::get('/admin/manage_account/get_major_by_faculty_id/{faculty_id}', [AdminManageAccountController::class, 'get_major_by_faculty_id']);
    
    Route::controller(AdminManageDocumentsController::class)->group(function () {
        //manage document page
        Route::get('/admin/manage_documents', 'manage_documents')->name('admin.manage.documents');
        // child document crud
        Route::put('/admin/manage_documents/store_child_document', 'storeChildDocument')->name('admin.store.child_document');
        Route::post('/admin/manage_documents/edit_child_document/{child_document_id}', 'editChildDocument')->name('admin.edit.child_document');
        Route::delete('/admin/manage_documents/delete_child_document/{child_document_id}', 'deleteChildDocument')->name('admin.delete.child_document');
        
        // addon crud
        Route::post('/admin/manage_documents/store_addon_document', 'store_addon_document')->name('admin.store.addon_document');
        Route::put('/admin/manage_documents/edit_addon_document/{addon_document_id}', 'edit_addon_document')->name('admin.edit.addon_document');
        Route::delete('/admin/manage_documents/delete_addon_document/{addon_document_id}', 'delete_addon_document')->name('admin.delete.addon_document');
        
        //document crud
        Route::put('/admin/manage_documents/store_document', 'sotoreDocument')->name('admin.store.document');
        Route::post('/admin/manage_documents/edit_document/{doc_type_id}', 'editDocument')->name('admin.edit.document');
        Route::delete('/admin/manage_documents/delete_document/{doc_type_id}', 'deleteDocument')->name('admin.delete.document');
        Route::post('/admin/manage_documents/update_useful_activity_hour', 'updateUsefulActivitytHour')->name('admin.update.useful.hour');
        
        //child doc files
        Route::get('/admin/manage_documents/files/{child_document_id}', 'mange_file_page')->name('admin.manage.file.document');
        //crud downlaod file
        Route::post('/admin/manage_child_document/file/store/{child_document_id}', 'store_child_document_file')->name('admin.store.child.document.file');
        Route::delete('/admin/manage_child_document/file/delete/{child_document_file_id}', 'delete_child_document_file')->name('admin.delete.child.document.file');
        Route::put('/admin/manage_child_document/update/generate_file/{child_document_id}', 'update_child_document_generate_file')->name('admim.child.document.update.generatefile');
        //crud example file
        Route::post('/admin/manage_child_document/example_file/store/{child_document_id}', 'store_example_file')->name('admin.store.example.file');
        Route::delete('/admin/manage_child_document/example_file/delete/{example_file_id}', 'delete_example_file')->name('admin.delete.example.file');
        Route::post('/admin/manage_child_document/minors_example_file/store/{child_document_id}', 'stroe_minors_example_file')->name('admin.store.minors.example.file');
        //document add-on file
        Route::put('/admin/manage_child_document/child_document/update/addon/{child_document_id}', 'update_child_document_addon')->name('admim.child.document.update.addon');
        
        // addon file
        Route::get('/admin/manage_documents/addon/files/{addon_document_id}', 'mange_addon_file_page')->name('admin.manage.addon.file.document');
        //crud download file
        Route::post('/admin/manage_addon_document/file/store/{addon_document_id}', 'store_addon_document_file')->name('admin.store.addon.document.file');
        Route::delete('/admin/manage_addon_document/file/delete/{addon_document_file_id}', 'delete_addon_document_file')->name('admin.delete.addon.document.file');
        Route::put('/admin/manage_addon_document/update/generate_file/{addon_document_id}', 'update_addon_document_generate_file')->name('admim.addon.document.update.generatefile');
        //crud example file
        Route::post('/admin/manage_addon_document/example_addon_file/store/{addon_document_id}', 'store_example_addon_file')->name('admin.store.example.addon.file');
        Route::delete('/admin/manage_addon_document/example_addon_file/delete/{example_addon_file_id}', 'delete_example_addon_file')->name('admin.delete.example.addon.file');
        //admin manage account display all file
        Route::get('/admin/manage_documents/deisplayfile/file/{file_path}/{file_name}', 'displayFile')->name('admin.display.file');
    });
    
    Route::controller(AdminManageDataController::class)->group(function () {
        //admin manage data
        Route::get('/admin/manage_data', 'index');
        Route::get('/admin/manage_data/major/{faculty_id}', 'major_page')->name('admin.manage.data.major');
        Route::delete('/admin/manage_data/faculty/delete/{faculty_id}', 'delete_faculty')->name('admin.manage.data.delete.faculty');
        Route::delete('/admin/manage_data/apprearancetype/delete/{apprearancetype_id}', 'delete_apprearancetype')->name('admin.manage.data.delete.apprearancetype');
        Route::delete('/admin/manage_data/property/delete/{property_id}', 'delete_property')->name('admin.manage.data.delete.property');
        Route::delete('/admin/manage_data/nessessity/delete/{nessessity_id}', 'delete_nessessity')->name('admin.manage.data.delete.nessessity');
        Route::delete('/admin/manage_data/major/delete/{major_id}', 'delete_major')->name('admin.manage.data.delete.major');
        Route::post('/admin/manage_data/faculty/add/', 'add_faculty')->name('admin.manage.data.add.faculty');
        Route::post('/admin/manage_data/apprearancetype/add/', 'add_apprearancetype')->name('admin.manage.data.add.apprearancetype');
        Route::post('/admin/manage_data/property/add/', 'add_property')->name('admin.manage.data.add.property');
        Route::post('/admin/manage_data/nessessity/add/', 'add_nessessity')->name('admin.manage.data.add.nessessity');
        Route::post('/admin/manage_data/major/add/{faculty_id}', 'add_major')->name('admin.manage.data.add.major');
        Route::put('/admin/manage_data/faculty/edit/{faculty_id}', 'edit_faculty')->name('admin.manage.data.edit.faculty');
        Route::put('/admin/manage_data/apprearancetype/edit/{apprearancetype_id}', 'edit_apprearancetype')->name('admin.manage.data.edit.apprearancetype');
        Route::put('/admin/manage_data/property/edit/{property_id}', 'edit_property')->name('admin.manage.data.edit.property');
        Route::put('/admin/manage_data/nessessity/edit/{nessessity_id}', 'edit_nessessity')->name('admin.manage.data.edit.nessessity');
        Route::put('/admin/manage_data/major/edit/{major_id}', 'edit_major')->name('admin.manage.data.edit.major');
    });

    Route::get('/admin/borrowers_data', [AdminManageBorrowerData::class, 'index']);
    Route::post('/admin/borrowers_data/export', [AdminManageBorrowerData::class, 'exportBorrowers'])->name('admin.borrowers_data.export');
    Route::post('/admin/borrowers_data/import', [AdminManageBorrowerData::class, 'importCsv'])->name('admin.borrowers_data.import');
});
//end-admin
//admin,employee
Route::middleware(['session.expire', 'privilege:admin,employee'])->group(function () {
    //search document
    Route::get('/search_document', function () {
        return view('search_document');
    })->name('search_document');
    Route::get('/search_document', [SearchDocuments::class, 'index']);
    
    Route::get('/search', [SearchDocuments::class, 'search'])->name('search');
    Route::get('/search_document/get_student_id', [SearchDocuments::class, 'serachBorrowerDocuments'])->name('search.document.borrower.student_id');
    Route::get('/search_document/list_document/{borrower_uid}', [SearchDocuments::class, 'listDocument'])->name('serach.document.list.document');
    Route::get('/search_document/document/{borrower_document_id}', [SearchDocuments::class, 'viewBorrowerDocument'])->name('serach.document.view.document.page');
    Route::get('/search_document/preview/borrower_file/{borrower_child_document_id}', [SearchDocuments::class, 'previewBorrowerFile'])->name('serach.document.preview.file');
    Route::get('/search_document/preview/teacher-comment/{document_id}', [SearchDocuments::class, 'generateFile103'])->name('serach.document.preview.teacher.comment');
    Route::get('/search_document/download_document/{borrower_uid}/{document_id}', [SearchDocuments::class, 'downloadBorrowerDocuments'])->name('search.document.download.document');
    
    Route::controller(CheckDocumentController::class)->group(function (){
        Route::get('/check_document/index', 'index');
        Route::get('/check_document/select_document/{document_id}', 'selectDocument')->name('check_document.select_document');
        Route::get('/check_document/select_document/borrower_documents/get/{document_id}', 'getBorrowerDocuments')->name('select_document.borrower_documents.get');
        Route::get('/check_document/select_document/get-major-by-faculty-id/{faculty_id}', 'selectMajorByFacultyId');
        // Route::get('/check_document/select_document/test-data/{document_id}', 'multipleQuery');
        Route::post('/check_document/select_document/post/status/{document_id}', 'selectStatusDocument')->name('check_document.select.status');
        
        Route::get('/check_document/check_borrower_document/view/{borrower_document_id}', 'viewBorrowerDocument')->name('check_document.view.borrower.document');
        
        Route::get('/check_document/borrower_child_document_list/{borrower_document_id}', 'borrowerChildDocumentList')->name('check_document.borrower_child_document.list');
        Route::get('/check_document/borrower_child_document/get/{borrower_child_document_id}/{borrower_document_id}', 'getBorrowerChildDocument')->name('check_document.get.borrower_child_document');
        Route::post('/check_document/borrower_child_document/post/{borrower_child_document_id}/{borrower_document_id}', 'postBorrowerChildDocument')->name('check_document.post.borrower_child_document');
        Route::get('/check_document/get_useful_activity/{borrower_document_id}', 'getBorrowerUsefulActivities')->name('check_document.get.borrower.useful_activity');
        Route::post('/check_document/post_useful_activity/{borrower_document_id}', 'postBorrowerUsefulActivities')->name('check_document.post.borrower.useful_activity');
        Route::get('/check_document/borrower_document/result/{borrower_document_id}', 'checkDocumentResult')->name('check_document.document.result');
        Route::get('/check_document/borrower_document/download/{borrower_document_id}', 'downloadBorrowerDocuments')->name('check_document.document.download');
        Route::post('/check_document/borrower_document/submit/{borrower_document_id}', 'submitCheckDocument')->name('check_document.document.submit');
        Route::get('/check_document/check_borrower_document/preview/borrower_file/{borrower_child_document_id}', 'previewBorrowerFile')->name('check.document.preview.borrower_child_document_file');
    });
});
//end - admin,employee
//teacher
Route::middleware(['session.expire', 'privilege:teacher'])->group(function () {
    Route::get('/teacher/index', [TeacherComment::class, 'index'])->name('teacher.index');
    Route::post('/teacher/select-option', [TeacherComment::class, 'selectOption'])->name('teacher.select.option');
    Route::get('/teacher/get_borrower_documents', [TeacherComment::class, 'getBorrowerDocuments'])->name('teacher.get.borrower.document');
    
    Route::post('/teacher/sotre/comment/{borrower_document_id}', [TeacherComment::class, 'storeComment'])->name('tacher.store.commnet');
    Route::get('/teacher/borrower_document/comment/{borrower_document_id}', [TeacherComment::class, 'commnetBorrowerDocument'])->name('teacher.comment.borrower.document');
    Route::get('/teacher/borrower_document/view/{borrower_document_id}', [TeacherComment::class, 'viewBorrowerDocument'])->name('teacher.view.borrower.document');
    Route::get('/teacher/borrower_document/preview/borrower_file/{borrower_child_document_id}', [TeacherComment::class, 'previewBorrowerFile'])->name('teacher.comment.preview.file');
    Route::get('/teacher/borrower_document/preview/teacher-comment/{borrower_document_id}/{borrower_uid}', [TeacherComment::class, 'generateFile103'])->name('teacher.comment.preview.teacher.comment');

});
//end - teacher

//borrower
Route::middleware(['session.expire', 'privilege:borrower'])->group(function () {
    Route::get('/borrower/borrower_document/index', [BorrowerDocumentController::class, 'index']);
    Route::get('/borrower/borrower_document/document/{borrower_document_id}', [BorrowerDocumentController::class, 'viewBorrowerDocument'])->name('borrower.view.document.page');
    Route::get('/borrower/borrower_document/preview/borrower_file/{borrower_child_document_id}', [BorrowerDocumentController::class, 'previewBorrowerFile'])->name('borrower.document.preview.file');
    Route::get('/borrower/borrower_document/preview/teacher-comment/{document_id}', [BorrowerDocumentController::class, 'generateFile103'])->name('borrower.document.preview.teacher.comment');
    
    Route::get('/borrower/information/information_list', [BorrowerInforamtionController::class, 'index']);
    //borrower information
    Route::get('/borrower/input/information', [BorrowerInforamtionController::class, 'borrower_input_information'])->name('borrower.input.information');
    Route::get('/borrower/edit/information/page', [BorrowerInforamtionController::class, 'borrower_edit_information_page'])->name('borrower.edit.information.page');
    Route::put('/borrower/edit/information', [BorrowerInforamtionController::class, 'borrower_edit_information'])->name('borrower.edit.information');
    Route::post('/borrower/store/information/borrower', [BorrowerInforamtionController::class, 'borrower_store_information'])->name('borrower.store.information');
    Route::get('/borrower/major_by_faculty/{faculty}', [BorrowerInforamtionController::class, 'getMajorByFaculty']);
    //parent information
    Route::get('/borrower/input/parent/information', [ParentInformationController::class, 'borrower_input_parent_information'])->name('borrower.input.parent.information');
    Route::post('/borrower/store/parent/information', [ParentInformationController::class, 'borrower_store_parent_information'])->name('borrower.store.parent.information');
    Route::get('/borrower/edit/parent/information/page', [ParentInformationController::class, 'borrower_edit_parent_information_page'])->name('borrower.edit.parent.information.page');
    Route::put('/borrower/edit/parent/information', [ParentInformationController::class, 'borrower_edit_parent_information'])->name('borrower.edit.parent.information');
    Route::get('/borrower/information/marital_file/{file_name}', [ParentInformationController::class, 'display_marital_status_file'])->name('marital.status.file');
    //3nd parent or select main parent
    Route::get('/borrower/input/main_parent/information', [MainParentInfomationController::class, 'borrower_input_main_parent_information'])->name('borrower.input.main_parent.information');
    Route::post('/borrower/store/main_parent/information', [MainParentInfomationController::class, 'borrower_store_main_parent_information'])->name('borrower.store.main_parent.information');
    Route::get('/borrower/edit/main_parent/information/page', [MainParentInfomationController::class, 'borrower_edit_main_parent_information_page'])->name('borrower.edit.main_parent.information.page');
    Route::put('/borrower/edit/main_parent/information', [MainParentInfomationController::class, 'borrower_edit_main_parent_information'])->name('borrower.edit.main_parent.information');

    Route::get('/borrower/upload_document', [SendDocumentController::class, 'index']);
    Route::get('/borrower/upload_document/page/{document_id}', [SendDocumentController::class, 'uploadDocumentPage'])->name('borrower.upload.document.page');
    Route::get('/borrower/upload_document/get_examplefile/{child_document_id}/{file_for}', [SendDocumentController::class, 'mergeExampleFile'])->name('borrower.get.examplefile');
    Route::post('/borrower/upload_document/upload_file/{document_id}/{child_document_id}', [SendDocumentController::class, 'uploadDocument'])->name('borrower.upload.document');
    Route::put('/borrower/upload_document/edit_file/{document_id}/{child_document_id}', [SendDocumentController::class, 'editDocument'])->name('borrower.edit.document');
    Route::get('/borrower/upload_document/previe/borrower_file/{borrower_child_document_id}', [SendDocumentController::class, 'previewBorrowerFile'])->name('borrower.upload.document.preview.file');
    Route::get('/borrower/upload_document/result/{document_id}', [SendDocumentController::class, 'result'])->name('borrower.upload.document.result.page');
    Route::get('/borrower/upload_document/submit/{document_id}', [SendDocumentController::class, 'submitDocument'])->name('borrower.upload.document.submit');

    //useful activity
    Route::post('/borrower/usefulactivity/store/{document_id}', [UsefulActivityController::class, 'storeUsefulActivity'])->name('borrower.store.usefulactivity');
    Route::put('/borrower/usefulactivity/edit/{useful_activity_id}', [UsefulActivityController::class, 'editUsefulActivity'])->name('borrower.edit.usefulactivity');
    Route::delete('/borrower/usefulactivity/delete/{useful_activity_id}', [UsefulActivityController::class, 'deleteUsefulActivity'])->name('borrower.delete.usefulactivity');

    //borrower download docuemnt
    Route::get('/borrower/download_document', [BorrowerDownloadDocument::class, 'index']);
    Route::get('/borrower/download_document/recheck_document/{child_document_id}', [BorrowerDownloadDocument::class, 'recheck_document'])->name('borrower.recheck.document');
    Route::get('/borrower/download_document/response_document/{child_document_id}', [BorrowerDownloadDocument::class, 'response_file'])->name('borrower.response.document');
    Route::get('/borrower/download_document/recheck_document/parent/{parent_id}', [BorrowerDownloadDocument::class, 'recheck_parent_document'])->name('borrower.recheck.parent.document');
    Route::get('/borrower/download_document/response_document/parent/{parent_id}', [BorrowerDownloadDocument::class, 'response_parent_file'])->name('borrower.response.parent.document');
    
    //borrower-register
    Route::get('/borrower/borrower_register', [BorrowerRegister::class, 'index'])->name('borrower.register');
    Route::get('/borrower/borrower_register/register_type', [BorrowerRegister::class, 'registerType'])->name('borrower.register.type');
    Route::post('/borrower/borrower_register/regeister_type/submit', [BorrowerRegister::class, 'storeRegisterType'])->name('borrower.register.store.type');

    Route::get('/borrower/borrower_register/upload_document', [BorrowerRegister::class, 'uploadDocumentPage'])->name('borrower.register.upload_document');
    Route::get('/borrower/borrower_register/get_examplefile/{child_document_id}/{file_for}', [BorrowerRegister::class, 'mergeExampleFile'])->name('borrower.register.get.examplefile');
    //upload document
    Route::post('/borrower/borrower_register/upload_file/{document_id}/{child_document_id}', [BorrowerRegister::class, 'uploadDocument'])->name('borrower.register.upload.document');
    Route::put('/borrower/borrower_register/edit_file/{document_id}/{child_document_id}', [BorrowerRegister::class, 'editDocument'])->name('borrower.register.edit.document');
    Route::get('/borrower/borrower_register/previe/borrower_file/{borrower_child_document_id}', [BorrowerRegister::class, 'previewBorrowerFile'])->name('borrower.register.preview.file');
    //result
    Route::get('/borrower/borrower_register/result/page', [BorrowerRegister::class, 'result'])->name('borrower.register.result');
    Route::post('/borrower/borrower_register/result/store/', [BorrowerRegister::class, 'storeBorrowerRegisterDocument'])->name('borrower.register.result.store');
    Route::get('/borrower/borrower_register/recheck', [BorrowerRegister::class, 'recheckDocument'])->name('borrower.register.recheck');
    Route::post('/borrower/borrower_register/sumit/document', [BorrowerRegister::class, 'submitDocument'])->name('borrower.register.sumit.document');
    //preview file
    Route::get('/borrower/borrower_register/recheck/document/{document_id}/{child_document_id}', [BorrowerRegister::class, 'showFile101'])->name('borrower.register.generate.document');
    Route::get('/borrower/borrower_register/recheck/teacher-comment/{borrower_document_id}', [BorrowerRegister::class, 'generateFile103'])->name('borrower.register.generate.teacher.comment');
    //status
    Route::get('/borrower/borrower_register/status', [BorrowerRegister::class, 'status'])->name('borrower.register.status');
});

Route::middleware(['session.expire'])->group(function () {
    Route::get('/users_profile', [UsersProfileController::class, 'index']);
    Route::put('/users_profile/edit', [UsersProfileController::class, 'edit_profile'])->name('users.profile.edit');
    Route::post('/users_profile/password/change', [UsersProfileController::class, 'change_password'])->name('users.password.change');

    //useful activity
    Route::get('/borrower/usefulactivities/file/get/{useful_activity_id}', [UsefulActivityController::class, 'showUsefulActivityFile'])->name('borrower.show.usefulactivity.file');
});

Route::get('/register_student', [RegisterController::class, 'index']);
Route::put('/register_student/student/register/', [RegisterController::class, 'register_student'])->name('register.student');

Route::get('/register_teacher', [RegisterController::class, 'register_teacher_page']);
Route::put('/register_teacher/teacher/register/', [RegisterController::class, 'register_teacher'])->name('register.teacher');
Route::get('/register_teacher/getMajorsByFacultyId/{faculty_id}', [RegisterController::class, 'getMajorsByFacultyId']);

Route::get('/', [AuthenticationController::class, 'index']);
Route::get('/login', [AuthenticationController::class, 'loginPage'])->name('login');
Route::post('/post/login', [AuthenticationController::class, 'login'])->name('post.login');
Route::get('/signout', [AuthenticationController::class, 'signout']);
Route::post('/verify_email/post', [AuthenticationController::class, 'email_confirm'])->name('verify.email.post');
Route::get('/send_email', [AuthenticationController::class, 'send_email'])->name('send.email');

Route::get('/register_success', function () {
    return view('register_success');
})->name('register.success');

Route::get('/email_comfirm_success', function () {
    return view('email_confirm_success');
})->name('email_comfirm_success');


Route::get('/reset_password/email', function () {
    return view('/input_email_reset_password');
});
Route::post('/check_email', [ResetpasswordController::class, 'check_email'])->name('check_email.reset_password');
Route::get('/verify_reset_password', function () {
    return view('verify_reset_password');
});

Route::post('/verify_reset_password/post', [ResetpasswordController::class, 'email_confirm'])->name('verify.reset_password');
Route::get('/send_email/reset_password', [ResetpasswordController::class, 'send_email'])->name('send.email.reset_password');
Route::put('/change_password', [ResetpasswordController::class, 'change_password'])->name('change.password');
Route::get('/reset_password_success', function () {
    return view('/reset_password_success');
});

Route::get('/verify_email', function () {
    return view('/verify_email');
});

Route::get('/errors/400', function () {
    return view('errors.400');
});

Route::get('/errors/500', function () {
    return view('errors.500');
});

Route::get('/errors/404', function () {
    return view('errors.404');
});

// test generate file
// Route::get('/generate_rabrongraidai', [GenerateFile::class, 'generate_rabrongraidai']);
// Route::get('/generate_yinyorm', [GenerateFile::class, 'generate_yinyorm_student']);
// Route::get('/teachers_comment', [GenerateFile::class, 'teachers_comment']);

// Route::get('/borrower_101', [GenerateDocController::class, 'borrower_101']);

Route::get('/expired_page', function () {
    return view('/expired_page');
});

Route::get('/input_thai_id', function () {
    return view('/input_thai_id');
});