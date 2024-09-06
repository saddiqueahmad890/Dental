<?php

use App\Models\FrontEnd;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\HistoryOfChiefComplaintsController;
use App\Http\Controllers\ExamInvestigationController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/lang',[
    'uses' => 'App\Http\Controllers\HomeController@lang',
    'as' => 'lang.index'
]);

Route::get('/', function () {
    return redirect('/login');
    try {
        DB::connection()->getPdo();
        if (!Schema::hasTable('application_settings'))
        return redirect('/install');
} catch (\Exception $e) {
    return redirect('/install');
}

return view('frontend.index', ['contents' => json_decode(FrontEnd::find(1)->content)]);
});

Route::get('/about', function () {
    return redirect('/login');
    return view('frontend.about', ['contents' => json_decode(FrontEnd::find(2)->content)]);
});

Route::get('/services', function () {
    return redirect('/login');
    return view('frontend.services', ['contents' => json_decode(FrontEnd::find(3)->content)]);
});

Route::get('/contact', function () {
    return redirect('/login');
    return view('frontend.contact', ['contents' => json_decode(FrontEnd::find(4)->content)]);
});

Route::post('/contact-form', [App\Http\Controllers\ContactUsFormController::class, 'store'])->name('contact-form.store');

Auth::routes(['register' => false]);

// Add patient treatment Notes
Route::post('/treatmentnotes',[App\Http\Controllers\PatientTreatmentPlanController::class,'treatmentNotes']);
Route::get('/showtreatmentNotes',[App\Http\Controllers\PatientTreatmentPlanController::class,'showtreatmentNotes']);
// Add patient treatment Notes

// Patient treatment plan procedure show hide checkbox
Route::post('/showhidepost',[App\Http\Controllers\PatientTreatmentPlanController::class,'showhidepost']);
// Patient treatment plan procedure show hide checkbox

// Update Show Price of Checkbox
Route::post('/update-show-price', [App\Http\Controllers\PatientTreatmentPlanController::class, 'updateShowPrice'])->name('updateShowPrice');
// Update Show Price of Checkbox

// History Chief Insert
Route::post('/storechief',[ExamInvestigationController::class,'storechief']);
// History Chief Insert

// Extra Oral
Route::post('/extraOral',[ExamInvestigationController::class,'extraOral']);
// Extra Oral

// Intra Oral
Route::post('/intraOral',[ExamInvestigationController::class,'intraOral']);
// Intra Oral

// Soft Tissue
Route::post('/softTissue',[ExamInvestigationController::class,'softTissue']);
// Soft Tissue

// Hard Tissue
Route::post('/hardTissue',[ExamInvestigationController::class,'hardTissue']);
// Hard Tissue


Route::group(['middleware' => ['auth']], function() {
    Route::get('/company/companyAccountSwitch', [
        'uses' => 'App\Http\Controllers\CompanyController@companyAccountSwitch',
        'as' => 'company.companyAccountSwitch'
    ]);

    Route::get('/financial-reports', [App\Http\Controllers\FinancialReportController::class, 'index'])->name('financial-reports.index');
    Route::get('/new-reports', [App\Http\Controllers\NewReportController::class, 'index'])->name('new-reports.index');


    Route::resources([
        'hard-tissues' => App\Http\Controllers\HardTissueController::class,
        'soft-tissues' => App\Http\Controllers\SoftTissuesController::class,
        'intra-orals' => App\Http\Controllers\IntraOralController::class,
        'extra-orals' => App\Http\Controllers\ExtraOralController::class,
        'chief-complaints' => App\Http\Controllers\HistoryOfChiefComplaintsController::class,
        'account-headers' => App\Http\Controllers\AccountHeaderController::class,
        'student' => App\Http\Controllers\StudentController::class,
        'payments' => App\Http\Controllers\PaymentController::class,
        'hospital-departments' => App\Http\Controllers\HospitalDepartmentController::class,
        'doctor-details' => App\Http\Controllers\DoctorDetailController::class,
        'patient-details' => App\Http\Controllers\PatientDetailController::class,
        'doctor-schedules' => App\Http\Controllers\DoctorScheduleController::class,
        'dd-blood-groups' => App\Http\Controllers\DdBloodGroupController::class,
        'dd-medicine' => App\Http\Controllers\DdMedicineController::class,
        'dd-medicine-types' => App\Http\Controllers\DdMedicineTypeController::class,
        'dd-diagnoses' => App\Http\Controllers\DdDiagnosisController::class,
        'appointment-statuses' => App\Http\Controllers\AppointmentStatusController::class,
        'marital-statuses' => App\Http\Controllers\MaritalStatusController::class,
        'dropdowns' => App\Http\Controllers\MainDropdownController::class,
        'patient-appointments' => App\Http\Controllers\PatientAppointmentController::class,
        'patient-case-studies' => App\Http\Controllers\PatientCaseStudyController::class,
        'prescriptions' => App\Http\Controllers\PrescriptionController::class,
        'lab-report-templates' => App\Http\Controllers\LabReportTemplateController::class,
        'dd-enquirysource' => App\Http\Controllers\EnquirySourceController::class,
        'lab-reports' => App\Http\Controllers\LabReportController::class,
        'labs' => App\Http\Controllers\LabController::class,
        'front-ends' => App\Http\Controllers\FrontEndController::class,
        'contacts' => App\Http\Controllers\ContactUsController::class,
        'sms-apis' => App\Http\Controllers\SmsApiController::class,
        'sms-templates' => App\Http\Controllers\SmsTemplateController::class,
        'sms-campaigns' => App\Http\Controllers\SmsCampaignController::class,
        'email-templates' => App\Http\Controllers\EmailTemplateController::class,
        'email-campaigns' => App\Http\Controllers\EmailCampaignController::class,
        'insurances' => App\Http\Controllers\InsuranceController::class,
        'invoices' => App\Http\Controllers\InvoiceController::class,
        'exam-investigations' => App\Http\Controllers\ExamInvestigationController::class,
        'roles' => App\Http\Controllers\RoleController::class,
        'medical-history' => App\Http\Controllers\PatientMedicalHistoryController::class,
        'users' => App\Http\Controllers\UserController::class,
        'currency' => App\Http\Controllers\CurrencyController::class,
        'teeth-procedures' => App\Http\Controllers\TeethProcedureController::class,
        'tax' => App\Http\Controllers\TaxController::class,
        'patient-teeths' => App\Http\Controllers\PatientTeethController::class,
        'smtp-configurations' => App\Http\Controllers\SmtpConfigurationController::class,
        'company' => App\Http\Controllers\CompanyController::class,
        'dd-procedure-categories' => App\Http\Controllers\DdProcedureCategoryController::class,
        'dd-procedures' => App\Http\Controllers\DdProcedureController::class,
        'categories' =>  App\Http\Controllers\CategoryController::class,
        'subcategories' =>  App\Http\Controllers\SubCategoryController::class,
        'dd-social-history' => App\Http\Controllers\DdSocialHistoryController::class,
        'dd-drug-history' => App\Http\Controllers\DdDrugHistoryController::class,
        'dd-task-type' => App\Http\Controllers\DdTaskTypeController::class,
        'dd-task-priority' => App\Http\Controllers\DdTaskPriorityController::class,
        'dd-task-action' => App\Http\Controllers\DdTaskActionController::class,
        'dd-task-status' => App\Http\Controllers\DdTaskStatusController::class,
        'dd-dental-history' => App\Http\Controllers\DdDentalHistoryController::class,
        'patient-treatment-plans' => App\Http\Controllers\PatientTreatmentPlanController::class,
        'patient-drug-histories'=> App\Http\Controllers\PatientDrugHistoryController::class,
        'patient-medical-histories'=> App\Http\Controllers\PatientMedicalHistoryController::class,
        'patient-dental-histories'=> App\Http\Controllers\PatientDentalHistoryController::class,
        'patient-social-histories'=> App\Http\Controllers\PatientSocialHistoryController::class,
        'items' =>  App\Http\Controllers\ItemController::class,
        'tasks' =>  App\Http\Controllers\TaskController::class,
        'patient-treatment-processes'=> App\Http\Controllers\PatientTreatmentProcessController::class,
        'dd-medical-history' =>  App\Http\Controllers\DdMedicalHistoryController::class,
        'dd-examinations' => App\Http\Controllers\DdExaminationController::class,
        'dd-investigations' => App\Http\Controllers\DdInvestigationController::class,
        'dd-treatment-plans' => App\Http\Controllers\DdTreatmentPlanController::class,
        'consultancey-fees' => App\Http\Controllers\ConsultanceyFeeController::class,
        'patient-treatment-plan-procedures' => App\Http\Controllers\PatientTreatmentPlanProcedureController::class,
        'inventories' => App\Http\Controllers\InventoryController::class,
        'insurance-providers' => App\Http\Controllers\InsuranceProviderController::class,

    ]);

    Route::resource('chats', ChatController::class)->only(['store']);
    Route::get('tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');


// routes/web.php

    Route::get('/api/getTeethProcedures/{patientId}', [App\Http\Controllers\PatientTreatmentPlanController::class, 'getTeethProcedures']);
    Route::get('/api/getDoctorByPatient/{patientId}', [App\Http\Controllers\PatientTreatmentPlanController::class, 'getDoctorByPatient']);
    Route::get('/api/getToothIds/{teethProcedureId}', [App\Http\Controllers\PatientTreatmentPlanController::class, 'getToothIds']);


    Route::delete('/subcategories/{subcategory}', [App\Http\Controllers\SubCategoryController::class, 'destroy'])->name('subcategories.destroy');
    Route::put('/front-ends/updateHome/{frontEnd}', [App\Http\Controllers\FrontEndController::class, 'updateHome'])->name('front-ends.updateHome');
    Route::put('/front-ends/updateContact/{frontEnd}', [App\Http\Controllers\FrontEndController::class, 'updateContact'])->name('front-ends.updateContact');
    Route::put('/front-ends/updateAbout/{frontEnd}', [App\Http\Controllers\FrontEndController::class, 'updateAbout'])->name('front-ends.updateAbout');
    Route::put('/front-ends/updateServices/{frontEnd}', [App\Http\Controllers\FrontEndController::class, 'updateServices'])->name('front-ends.updateServices');

    Route::get('/patient-appointments/get-schedule/doctorwise', [App\Http\Controllers\PatientAppointmentController::class, 'getScheduleDoctorWise'])->name('patient-appointments.getScheduleDoctorWise');
    Route::post('/labreport/generateTemplateData', [
        'uses' => 'App\Http\Controllers\LabReportController@generateTemplateData',
        'as' => 'labreport.generateTemplateData'
    ]);

    Route::post('/smsCampaign/generateTemplateData', [
        'uses' => 'App\Http\Controllers\SmsCampaignController@generateTemplateData',
        'as' => 'smsCampaign.generateTemplateData'
    ]);

    Route::post('/emailCampaign/generateTemplateData', [
        'uses' => 'App\Http\Controllers\EmailCampaignController@generateTemplateData',
        'as' => 'emailCampaign.generateTemplateData'
    ]);

    Route::get('/c/c', [App\Http\Controllers\CurrencyController::class, 'code'])->name('currency.code');

    Route::get('/update', [
        'uses' => 'App\Http\Controllers\UpdateController@index',
        'as' => 'update.index'
    ]);

    Route::get('/profile/setting', [
        'uses' => 'App\Http\Controllers\ProfileController@setting',
        'as' => 'profile.setting'
    ]);

    Route::post('/profile/updateSetting', [
        'uses' => 'App\Http\Controllers\ProfileController@updateSetting',
        'as' => 'profile.updateSetting'
    ]);
    Route::get('/profile/password', [
        'uses' => 'App\Http\Controllers\ProfileController@password',
        'as' => 'profile.password'
    ]);

    Route::post('/profile/updatePassword', [
        'uses' => 'App\Http\Controllers\ProfileController@updatePassword',
        'as' => 'profile.updatePassword'
    ]);
    Route::get('/profile/view', [
        'uses' => 'App\Http\Controllers\ProfileController@view',
        'as' => 'profile.view'
    ]);
});

Route::group(['middleware' => ['auth']], function () {

    Route::get('/dashboard', [
        'uses' => 'App\Http\Controllers\DashboardController@index',
        'as' => 'dashboard'
    ]);

    Route::get('/dashboard/get-chart-data', [App\Http\Controllers\DashboardController::class, 'getChartData']);
});

Route::group(['middleware' => ['auth']], function () {

    Route::get('/apsetting', [
        'uses' => 'App\Http\Controllers\ApplicationSettingController@index',
        'as' => 'apsetting'
    ]);

    Route::post('/apsetting/update', [
        'uses' => 'App\Http\Controllers\ApplicationSettingController@update',
        'as' => 'apsetting.update'
    ]);
});

// general Setting
Route::group(['middleware' => ['auth']], function () {

    Route::get('/general', [
        'uses' => 'App\Http\Controllers\GeneralController@index',
        'as' => 'general'
    ]);

    Route::post('/general', [
        'uses' => 'App\Http\Controllers\GeneralController@edit',
        'as' => 'general'
    ]);

    Route::post('/general/localisation', [
        'uses' => 'App\Http\Controllers\GeneralController@localisation',
        'as' => 'general.localisation'
    ]);

    Route::post('/general/invoice', [
        'uses' => 'App\Http\Controllers\GeneralController@invoice',
        'as' => 'general.invoice'
    ]);

    Route::post('/general/defaults', [
        'uses' => 'App\Http\Controllers\GeneralController@defaults',
        'as' => 'general.defaults'
    ]);
});

Route::get('/home', function () {
    return redirect()->to('dashboard');
});

Route::get('/fetch-courses', [App\Http\Controllers\StudentController::class, 'fetchCourses'])->name('fetch-courses');

Route::delete('/doctor-schedules/{id}', 'DoctorScheduleController@destroy')->name('doctor-schedules.destroy');
Route::delete('/doctor-schedules/{doctorSchedule}', 'DoctorScheduleController@destroy')->name('doctor-schedules.destroy');

Route::post('events/store', [App\Http\Controllers\EventController::class, 'store'])->name('events.store');
Route::get('events/load', [App\Http\Controllers\EventController::class, 'loadEvents'])->name('events.load');
Route::put('events/{id}', [App\Http\Controllers\EventController::class, 'update'])->name('events.update');
Route::get('events/{id}', [App\Http\Controllers\EventController::class, 'show'])->name('events.show');
Route::delete('events/{id}', [App\Http\Controllers\EventController::class, 'destroy'])->name('events.destroy');

Route::get('loaddgdg', [App\Http\Controllers\PatientCaseStudyController::class, 'edit1'])->name('eddit');

Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index']);
    Route::post('/notifications/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/read-all', [App\Http\Controllers\NotificationController::class, 'readAll'])->name('notifications.readAll');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/tasknotifications', [App\Http\Controllers\TaskNotificationController::class, 'index']);
    Route::post('/tasknotifications/read', [App\Http\Controllers\TaskNotificationController::class, 'markAsRead'])->name('tasknotifications.markAsRead');
    Route::post('/tasknotifications/read-all', [App\Http\Controllers\TaskNotificationController::class, 'readAll'])->name('tasknotifications.readAll');
});

// Upload File in Exam Investigation

Route::post('/upload-file', [App\Http\Controllers\ExamInvestigationController::class, 'uploadFile'])->name('upload-file');
Route::get('/get-files/{id}', [App\Http\Controllers\ExamInvestigationController::class, 'getFiles'])->name('get-files');

// Upload File in Exam Investigation

Route::put('/items/{item}', [App\Http\Controllers\ItemController::class, 'update'])->name('items.update');

Route::post('/upload-file', [App\Http\Controllers\HomeController::class, 'uploadFile'])->name('upload-file');
Route::get('/get-files/{id}', [App\Http\Controllers\HomeController::class, 'getFiles'])->name('get-files');

Route::post('/delete-file', [App\Http\Controllers\HomeController::class, 'deleteFile'])->name('delete-file');
Route::get('/getsubcategories43', [App\Http\Controllers\ItemController1::class, 'getsubcategories1'])->name('getsubcategories');

Route::get('medical-history/{doctor_id}/{patient_id}', [App\Http\Controllers\PatientMedicalHistoryController::class, 'edit'])->name('medical-history');
Route::put('medical-history/{doctor_id}/{patient_id}', [App\Http\Controllers\PatientMedicalHistoryController::class, 'update'])
->name('medical-history.update'); // Use PUT method for update, and include parameters

Route::get('/patient-teeth-issues/{patientId}', [App\Http\Controllers\ExamInvestigationController::class, 'getTeethIssues'])->name('patient-teeth-issues');
Route::get('/patient-teeth-issues/{procedure_id}/{patientId}/{toothNumber}', [App\Http\Controllers\ExamInvestigationController::class, 'getToothIssues']);

Route::get('/get-teeth-files', [App\Http\Controllers\ExamInvestigationController::class, 'getTeethFiles'])->name('get-teeth-files');


use App\Http\Controllers\TestFileController;

Route::resource('test-files', TestFileController::class);

Route::get('/fetch-appointments', [App\Http\Controllers\ExamInvestigationController::class, 'fetchAppointments'])->name('fetch.appointments');
Route::get('/fetch-doctors', [App\Http\Controllers\ExamInvestigationController::class, 'fetchDoctors'])->name('fetch.doctors');
Route::get('/fetch-procedures', [App\Http\Controllers\PatientTreatmentPlanController::class, 'fetchProcedures'])->name('fetch.procedures');
Route::get('/fetchexamination', [App\Http\Controllers\PrescriptionController::class, 'fetchexamination'])->name('fetchexamination');
// Route::get('/fetchexamination', [App\Http\Controllers\PrescriptionController::class, 'fetchexamination'])->name('fetchexamination');

Route::get('/getmedicinestype/{medicineId}', [App\Http\Controllers\PrescriptionController::class, 'getmedicinestype'])->name('getmedicinestype');

Route::get('/fetch-teeth', [App\Http\Controllers\PatientTreatmentPlanController::class, 'fetchTeeth'])->name('fetch.teeth');
Route::get('/fetch-treatmentplan', [App\Http\Controllers\PatientTreatmentPlanController::class, 'fetchTreatmentplan'])->name('fetch.treatmentplan');

Route::get('/fetch-procedure', [App\Http\Controllers\PatientTreatmentPlanController::class, 'fetchProcedure'])->name('fetch.procedure');
Route::get('/fetch-treatment-details', [App\Http\Controllers\PatientTreatmentPlanController::class, 'fetchTreatmentDetails'])->name('fetch.treatmentDetails');

Route::get('/send-email', [App\Http\Controllers\EmailController::class, 'sendNotification']);

Route::post('/invoice_payments', [App\Http\Controllers\InvoicePaymentController::class, 'store'])->name('invoice_payments.store');
Route::get('invoices/{invoice}/remaining-balance', [App\Http\Controllers\InvoicePaymentController::class, 'remainingBalance'])->name('invoice.remainingBalance');
Route::get('invoices/{id}/fetch-paid-amount', [App\Http\Controllers\InvoicePaymentController::class, 'fetchPaidAmount'])->name('invoices.fetchPaidAmount');

Route::get('patient-details/{patientDetail}/history', [App\Http\Controllers\PatientDetailController::class, 'history'])->name('patient-details.history');
Route::get('patient-appointments/create/{userid}', [App\Http\Controllers\PatientAppointmentController::class, 'createFromPatientDetails'])
    ->name('patient-appointments.createFromPatientDetails');
Route::get('doctor-schedules/create/{userid}', [App\Http\Controllers\DoctorScheduleController::class, 'createFromDoctorDetails'])
    ->name('doctor-schedules.createFromDoctorDetails');
Route::post('/tasks/update-status', [App\Http\Controllers\TaskController::class, 'updateStatus'])->name('tasks.updateStatus');

Route::get('/task-notifications/fetch', [App\Http\Controllers\TaskController::class, 'fetchTaskNotifications'])->name('taskNotifications.fetch');
Route::post('/task-notifications/markAsRead', [App\Http\Controllers\TaskController::class, 'markTaskNotificationAsRead'])->name('taskNotifications.markAsRead');
Route::get('dynamic', [App\Http\Controllers\PatientDetailController::class, 'sendDynamicEmail']);

// In routes/web.php
// Routes/web.php
Route::get('/patient-medical-histories/create/from-patient/{userid}', [App\Http\Controllers\PatientMedicalHistoryController::class, 'createFromPatientDetails'])
    ->name('patient-medical-histories.create.from-patient');
Route::get('/patient-dental-histories/create/from-patient/{userid}', [App\Http\Controllers\PatientDentalHistoryController::class, 'createFromPatientDetails'])
    ->name('patient-dental-histories.create.from-patient');
Route::get('/patient-drug-histories/create/from-patient/{userid}', [App\Http\Controllers\PatientDrugHistoryController::class, 'createFromPatientDetails'])
    ->name('patient-drug-histories.create.from-patient');

Route::get('/patient-social-histories/create/from-patient/{userid}', [App\Http\Controllers\PatientSocialHistoryController::class, 'createFromPatientDetails'])
    ->name('patient-social-histories.create.from-patient');


Route::post('/delete-files', [App\Http\Controllers\ExamInvestigationController::class, 'deleteFiles'])->name('delete-files');
Route::get('/fetch-commission', [App\Http\Controllers\InvoiceController::class, 'fetchCommission'])->name('fetch.commission');
Route::post('/update-status', [App\Http\Controllers\PatientAppointmentController::class, 'changeStatus'])->name('change.status');
Route::post('/patientdetails/{id}/update-insurance-verified', [App\Http\Controllers\PatientDetailController::class, 'updateInsuranceVerified'])->name('updateInsuranceVerified');
Route::get('/unique-database-update-url', [App\Http\Controllers\DatabaseUpdateController::class, 'applyChanges'])->name('database.update');
Route::post('exam-investigations/updatejawtype', [App\Http\Controllers\ExamInvestigationController::class, 'updateJawType'])->name('exam-investigations.updatejawtype');
Route::get('/category/{category}/subcategories', [App\Http\Controllers\InventoryController::class, 'getSubCategories']);
Route::get('/category/{category}/items', [App\Http\Controllers\InventoryController::class, 'getItems']);
Route::get('/getmedicinedescription/{medicineId}', 'App\Http\Controllers\PrescriptionController@getMedicineDescription');
Route::post('/consumedQuantity',[App\Http\Controllers\InventoryController::class,'consumedQuantity']);
Route::post('/inventories/consume', [App\Http\Controllers\InventoryController::class, 'consume'])->name('inventories.consume');
Route::resource('dental_lab_orders', App\Http\Controllers\DentalLabOrderController::class);
Route::post('/send-reminder', [App\Http\Controllers\PatientAppointmentController::class, 'sendReminder'])->name('send.reminder');

