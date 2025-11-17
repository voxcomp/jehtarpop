<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DonationsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SupportController;
use Illuminate\Support\Facades\Route;

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
// authentication routes
Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('front');
Route::get('test/{path?}', [HomeController::class, 'test']);

Route::post('balance/payment', [PaymentController::class, 'freePayment'])->name('freePayment');
Route::post('balance/payment/complete', [PaymentController::class, 'freePaymentComplete'])->name('freePaymentComplete');
Route::get('balance/payment', [HomeController::class, 'freePayment'])->name('freePaymentForm');

Route::post('balance/payment/{student}', [PaymentController::class, 'balancePayment'])->name('balancePayment');
Route::post('balance/complete/{student}', [PaymentController::class, 'balanceComplete'])->name('balanceComplete');
Route::get('balance/{student}', [HomeController::class, 'balancePayment'])->name('balanceForm');
Route::get('payment/response', [PaymentController::class, 'paymentResponse'])->name('registration.payment.response');

// Support Ticket Routes
Route::prefix('support')->group(function () {
    Route::get('/', [SupportController::class, 'showPage'])->name('support.page');
    Route::get('/list', [SupportController::class, 'showList'])->name('support.list')->middleware('admin');
    Route::get('/detail/{ticket}', [SupportController::class, 'showDetail'])->name('support.detail')->middleware('admin');
    Route::get('/confirmation/{path}', [SupportController::class, 'showConfirmation'])->name('support.confirmation');
    Route::get('/confirmation/registration/{registration}', [SupportController::class, 'showConfirmationRegistration'])->name('support.confirmation.registration');
    Route::get('download/{file}', [SupportController::class, 'download'])->name('support.download')->middleware('admin');
    Route::post('upload/{ticket}', [SupportController::class, 'upload'])->name('support.upload')->middleware('admin');
    Route::get('/{path}', [SupportController::class, 'showPagePath'])->name('support.page.path');
    Route::get('/{path}/{registration}', [SupportController::class, 'showPageRegistration'])->name('support.page.registration');
    Route::post('/', [SupportController::class, 'createTicket'])->name('support.create');
    Route::post('/email/{ticket}', [SupportController::class, 'saveEmail'])->name('support.email.save')->middleware('admin');
    Route::post('/note/{ticket}', [SupportController::class, 'saveNote'])->name('support.note.save')->middleware('admin');
    Route::post('/note/delete/{note}', [SupportController::class, 'deleteNote'])->name('support.note.delete')->middleware('admin');
    Route::post('/status/{ticket}', [SupportController::class, 'saveStatus'])->name('support.status')->middleware('admin');
    Route::post('/delete/file/{file}', [SupportController::class, 'deleteFile'])->name('support.delete.file')->middleware('admin');
    Route::post('/delete/{ticket}', [SupportController::class, 'delete'])->name('support.delete')->middleware('admin');
});

// Donation Routes
Route::prefix('donation')->group(function () {
    Route::get('/', [DonationsController::class, 'showPage'])->name('donations.page');
    Route::post('/', [DonationsController::class, 'submitDonation'])->name('donations.submitDonation');
    Route::get('/payment/{donation}', [DonationsController::class, 'showPayment'])->name('donations.payment');
    Route::post('/payment/{donation}', [DonationsController::class, 'submitPayment'])->name('donations.submitPayment');
    Route::get('/confirmation/{donation}', [DonationsController::class, 'showConfirmation'])->name('donations.confirmation');
    Route::get('progress', [DonationsController::class, 'showProgress'])->middleware('cors');
});

// Sponsorship Routes
Route::prefix('sponsor')->group(function () {
    Route::get('/', [DonationsController::class, 'showSponsorPage'])->name('sponsor.page');
    Route::post('/', [DonationsController::class, 'submitSponsor'])->name('sponsor.submitDonation');
    Route::get('/payment/{donation}', [DonationsController::class, 'showSponsorPayment'])->name('sponsor.payment');
    Route::post('/payment/{donation}/alternate', [DonationsController::class, 'submitSponsorPaymentAlternate'])->name('sponsor.submitAltPayment');
    Route::post('/payment/{donation}', [DonationsController::class, 'submitSponsorPayment'])->name('sponsor.submitPayment');
    Route::get('/confirmation/{donation}', [DonationsController::class, 'showSponsorConfirmation'])->name('sponsor.confirmation');
});

// Registration Routes
Route::prefix('registration/{path}')->group(function () {
    Route::get('/', [RegistrationController::class, 'showCompany'])->name('registration.company.home');
    Route::get('company/{id?}', [RegistrationController::class, 'showCompany'])->name('registration.company');
    Route::post('company', [RegistrationController::class, 'saveCompany'])->name('registration.company.save');
    Route::patch('company', [RegistrationController::class, 'updateCompany'])->name('registration.company.update');

    Route::get('registrant', [RegistrationController::class, 'registrantShow'])->name('registration.registrant');
    Route::post('registrant', [RegistrationController::class, 'registrantSave'])->name('registration.registrant.save');
    Route::get('registrant/edit/{index}', [RegistrationController::class, 'registrantEdit'])->name('registration.registrant.edit');
    Route::patch('registrant/edit/{index}', [RegistrationController::class, 'registrantUpdate'])->name('registration.registrant.update');
    Route::get('registrant/remove/{index}', [RegistrationController::class, 'registrantRemove'])->name('registration.registrant.remove');

    Route::get('individual/{index?}', [RegistrationController::class, 'individualShow'])->name('registration.individual');
    Route::post('individual', [RegistrationController::class, 'individualSave'])->name('registration.individual.save');

    Route::get('billing/{registration}', [RegistrationController::class, 'billing'])->name('registration.billing');
    Route::post('billing/{registration}', [RegistrationController::class, 'saveBilling'])->name('registration.billing.save');

    Route::get('payment', [PaymentController::class, 'paymentPage'])->name('registration.payment');
    Route::post('payment/alt', [PaymentController::class, 'alternatePayment'])->name('registration.payment.alt');
    //	Route::post('payment', 'PaymentController@paymentSave')->name('registration.payment.save');
    Route::post('payment', [PaymentController::class, 'paymentToCC'])->name('registration.payment.toCC');
    Route::get('payment-post/{registration}', [PaymentController::class, 'paymentPost'])->name('registration.payment.post');
    Route::post('payment/complete/{registration}', [PaymentController::class, 'paymentComplete'])->name('registration.payment.complete');

    Route::get('confirmation/{registration}', [RegistrationController::class, 'confirmation'])->name('registration.confirmation');

    Route::get('cancel', [RegistrationController::class, 'cancelRegistration'])->name('registration.cancel');
    Route::get('cancel/{registration}', [RegistrationController::class, 'cancelRegistrationID'])->name('registration.cancel.id');
});

Route::redirect('/trade/company', '/registration/trade/company', 301);
Route::redirect('/trade/student', '/registration/trade/individual', 301);
Route::redirect('/trade/confirmation/{registration}', '/registration/trade/confirmation/{registration}', 301);

// Route::redirect('/event/company', '/registration/event/company', 301);
Route::redirect('/event/company/{eventid?}', '/registration/event/company/{eventid?}', 301);
Route::redirect('/event/individual', '/registration/event/individual', 301);
Route::redirect('/event/confirmation/{registration}', '/registration/event/confirmation/{registration}', 301);

// Admin routes
Route::get('home', [AdminController::class, 'index'])->name('home')->middleware('admin');
Route::get('admin/settings/general', [AdminController::class, 'settingsGeneral'])->name('settings.general')->middleware('admin');
Route::get('admin/settings/content', [AdminController::class, 'settingsContent'])->name('settings.content')->middleware('admin');
Route::get('admin/settings/registration', [AdminController::class, 'settingsRegistration'])->name('settings.registration')->middleware('admin');
Route::get('admin/settings/registration-content', [AdminController::class, 'settingsRegistrationContent'])->name('settings.registrationContent')->middleware('admin');
Route::get('admin/registration-mail/{start}', [AdminController::class, 'sendRegistrationMail'])->name('resend')->middleware('admin');
Route::get('admin/test', [AdminController::class, 'test']);
// --settings
Route::post('admin/helpdesk', [AdminController::class, 'saveHelpDesk'])->name('editHelpDesk')->middleware('admin');
Route::post('admin/content', [AdminController::class, 'saveContent'])->name('editContent')->middleware('admin');
Route::post('admin/registration-status', [AdminController::class, 'registrationStatus'])->name('registrationStatus')->middleware('admin');
Route::post('admin/confirmation-email', [AdminController::class, 'confirmationEmail'])->name('confirmationEmail')->middleware('admin');
Route::post('admin/payment-agree', [AdminController::class, 'paymentAgree'])->name('paymentAgree')->middleware('admin');
Route::post('admin/admin-api', [AdminController::class, 'adminAPI'])->name('adminAPI')->middleware('admin');
Route::post('admin/admin-email', [AdminController::class, 'adminEmail'])->name('adminEmail')->middleware('admin');
Route::post('admin/add-agreement', [AdminController::class, 'addAgreement'])->name('registrationTradeAgree')->middleware('admin');
Route::get('admin/remove-agreement/{id}', [AdminController::class, 'removeAgreement'])->name('registrationTradeAgreeRemove')->middleware('admin');
Route::post('admin/mark-events', [AdminController::class, 'eventsMark'])->name('eventsMark')->middleware('admin');
Route::post('admin/customers-remove', [AdminController::class, 'customerRemoveInHouse'])->name('customerRemoveInHouse')->middleware('admin');
Route::post('admin/customers-add', [AdminController::class, 'customerAddInHouse'])->name('customerAddInHouse')->middleware('admin');
Route::post('admin/fundraising', [AdminController::class, 'fundraising'])->name('fundraising')->middleware('admin');
Route::post('admin/class-description', [AdminController::class, 'classDescription'])->name('classDescription')->middleware('admin');
// --uploads
Route::get('admin/uploads', [AdminController::class, 'uploads'])->name('admin.uploads')->middleware('admin');
Route::post('admin/student-upload', [AdminController::class, 'studentUpload'])->name('studentUpload')->middleware('admin');
Route::post('admin/customer-upload', [AdminController::class, 'customerUpload'])->name('customerUpload')->middleware('admin');
Route::post('admin/course-upload', [AdminController::class, 'courseUpload'])->name('courseUpload')->middleware('admin');
Route::get('admin/course-upload', [AdminController::class, 'courseUpload'])->name('courseUpload')->middleware('admin');
Route::post('admin/online-course-upload', [AdminController::class, 'onlineClassUpload'])->name('onlineClassUpload')->middleware('admin');
Route::post('admin/correspondence-course-upload', [AdminController::class, 'correspondenceClassUpload'])->name('correspondenceClassUpload')->middleware('admin');
Route::post('admin/event-upload', [AdminController::class, 'eventUpload'])->name('eventUpload')->middleware('admin');
Route::post('admin/ticket-upload', [AdminController::class, 'ticketUpload'])->name('ticketUpload')->middleware('admin');
// --downloads
Route::get('admin/downloads', [AdminController::class, 'downloads'])->name('admin.downloads')->middleware('admin');
Route::post('admin/registrations', [AdminController::class, 'registrationDownload'])->name('registrations')->middleware('admin');
Route::post('admin/donations', [AdminController::class, 'donationsDownload'])->name('admin.donations')->middleware('admin');
// --view registrations
Route::get('admin/view/registrations', [AdminController::class, 'registrationViewPage'])->name('admin.viewRegistrations')->middleware('admin');
Route::post('admin/view/registrations', [AdminController::class, 'registrationView'])->name('viewRegistrations')->middleware('admin');
Route::get('admin/view/donations', [AdminController::class, 'donationsViewPage'])->name('admin.viewDonationsPage')->middleware('admin');
Route::post('admin/view/donations', [AdminController::class, 'donationsView'])->name('admin.viewDonations')->middleware('admin');
// --coupons
Route::get('admin/coupons', [AdminController::class, 'coupons'])->name('admin.coupons');
Route::get('admin/coupons/{coupon}', [AdminController::class, 'coupons'])->name('coupons.edit');
Route::patch('admin/coupons', [AdminController::class, 'couponSave'])->name('coupons.save');
Route::post('admin/coupons/{coupon}', [AdminController::class, 'couponDelete'])->name('coupons.delete');
Route::post('admin/coupons', [AdminController::class, 'couponCreate'])->name('coupons.create');

// Ajax Data
Route::post('ajax/company/compare/match', [HomeController::class, 'getCompanyMatch']);
Route::post('ajax/company/lookup/{partial}', [HomeController::class, 'getCompanyList']);
Route::post('ajax/company/{customer}', [HomeController::class, 'getCompanyInformation']);
Route::get('ajax/company/{customer}', [HomeController::class, 'getCompanyInformation']);
Route::post('ajax/student/lookup/{partial}/{first?}', [HomeController::class, 'getStudentList']);
Route::get('ajax/student/lookup/{partial}/{first?}', [HomeController::class, 'getStudentList']);
Route::post('ajax/student/{student}', [HomeController::class, 'getStudentInformation']);
Route::post('ajax/course/location/{trade}', [HomeController::class, 'getCourseLocations']);
Route::get('ajax/course/location/{trade}', [HomeController::class, 'getCourseLocations']);
Route::post('ajax/course/courses/{path}/{trade}/{location?}', [HomeController::class, 'getCourseIDs']);
Route::post('ajax/course/cost/{path}/{course}', [HomeController::class, 'getCourseCost']);
Route::post('ajax/course/student/cost/{course}/{customer?}', [HomeController::class, 'getStudentCourseCost']);
Route::post('ajax/event/tickets/{event}', [HomeController::class, 'getEventTickets']);
Route::post('ajax/event/cost/{ticket}/{customer?}', [HomeController::class, 'getEventCost']);
Route::post('ajax/coupon/{coupon}/{path}', [HomeController::class, 'coupon']);
Route::post('ajax/admin/response/{registration}', [HomeController::class, 'ajaxSendResponse']);
Route::post('ajax/admin/confirmation/{registration}', [HomeController::class, 'ajaxSendConfirmation']);
Route::post('ajax/class/description/{course}', [HomeController::class, 'getClassDescription']);
Route::get('ajax/class/description/{course}', [HomeController::class, 'getClassDescription']);

// Route::get('ajax/course/student/cost/{course}/{customer?}','HomeController@getStudentCourseCost');
