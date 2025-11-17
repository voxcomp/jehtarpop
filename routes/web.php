<?php

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

Route::get('/', 'HomeController@index')->name('front');
Route::get('test/{path?}', 'HomeController@test');

Route::post('balance/payment', 'PaymentController@freePayment')->name('freePayment');
Route::post('balance/payment/complete', 'PaymentController@freePaymentComplete')->name('freePaymentComplete');
Route::get('balance/payment', 'HomeController@freePayment')->name('freePaymentForm');

Route::post('balance/payment/{student}', 'PaymentController@balancePayment')->name('balancePayment');
Route::post('balance/complete/{student}', 'PaymentController@balanceComplete')->name('balanceComplete');
Route::get('balance/{student}', 'HomeController@balancePayment')->name('balanceForm');
Route::get('payment/response', 'PaymentController@paymentResponse')->name('registration.payment.response');

// Support Ticket Routes
Route::prefix('support')->group(function () {
    Route::get('/', 'SupportController@showPage')->name('support.page');
    Route::get('/list', 'SupportController@showList')->name('support.list')->middleware('admin');
    Route::get('/detail/{ticket}', 'SupportController@showDetail')->name('support.detail')->middleware('admin');
    Route::get('/confirmation/{path}', 'SupportController@showConfirmation')->name('support.confirmation');
    Route::get('/confirmation/registration/{registration}', 'SupportController@showConfirmationRegistration')->name('support.confirmation.registration');
    Route::get('download/{file}', 'SupportController@download')->name('support.download')->middleware('admin');
    Route::post('upload/{ticket}', 'SupportController@upload')->name('support.upload')->middleware('admin');
    Route::get('/{path}', 'SupportController@showPagePath')->name('support.page.path');
    Route::get('/{path}/{registration}', 'SupportController@showPageRegistration')->name('support.page.registration');
    Route::post('/', 'SupportController@createTicket')->name('support.create');
    Route::post('/email/{ticket}', 'SupportController@saveEmail')->name('support.email.save')->middleware('admin');
    Route::post('/note/{ticket}', 'SupportController@saveNote')->name('support.note.save')->middleware('admin');
    Route::post('/note/delete/{note}', 'SupportController@deleteNote')->name('support.note.delete')->middleware('admin');
    Route::post('/status/{ticket}', 'SupportController@saveStatus')->name('support.status')->middleware('admin');
    Route::post('/delete/file/{file}', 'SupportController@deleteFile')->name('support.delete.file')->middleware('admin');
    Route::post('/delete/{ticket}', 'SupportController@delete')->name('support.delete')->middleware('admin');
});

// Donation Routes
Route::prefix('donation')->group(function () {
    Route::get('/', 'DonationsController@showPage')->name('donations.page');
    Route::post('/', 'DonationsController@submitDonation')->name('donations.submitDonation');
    Route::get('/payment/{donation}', 'DonationsController@showPayment')->name('donations.payment');
    Route::post('/payment/{donation}', 'DonationsController@submitPayment')->name('donations.submitPayment');
    Route::get('/confirmation/{donation}', 'DonationsController@showConfirmation')->name('donations.confirmation');
    Route::get('progress', 'DonationsController@showProgress')->middleware('cors');
});

// Sponsorship Routes
Route::prefix('sponsor')->group(function () {
    Route::get('/', 'DonationsController@showSponsorPage')->name('sponsor.page');
    Route::post('/', 'DonationsController@submitSponsor')->name('sponsor.submitDonation');
    Route::get('/payment/{donation}', 'DonationsController@showSponsorPayment')->name('sponsor.payment');
    Route::post('/payment/{donation}/alternate', 'DonationsController@submitSponsorPaymentAlternate')->name('sponsor.submitAltPayment');
    Route::post('/payment/{donation}', 'DonationsController@submitSponsorPayment')->name('sponsor.submitPayment');
    Route::get('/confirmation/{donation}', 'DonationsController@showSponsorConfirmation')->name('sponsor.confirmation');
});

// Registration Routes
Route::prefix('registration/{path}')->group(function () {
    Route::get('/', 'RegistrationController@showCompany')->name('registration.company.home');
    Route::get('company/{id?}', 'RegistrationController@showCompany')->name('registration.company');
    Route::post('company', 'RegistrationController@saveCompany')->name('registration.company.save');
    Route::patch('company', 'RegistrationController@updateCompany')->name('registration.company.update');

    Route::get('registrant', 'RegistrationController@registrantShow')->name('registration.registrant');
    Route::post('registrant', 'RegistrationController@registrantSave')->name('registration.registrant.save');
    Route::get('registrant/edit/{index}', 'RegistrationController@registrantEdit')->name('registration.registrant.edit');
    Route::patch('registrant/edit/{index}', 'RegistrationController@registrantUpdate')->name('registration.registrant.update');
    Route::get('registrant/remove/{index}', 'RegistrationController@registrantRemove')->name('registration.registrant.remove');

    Route::get('individual/{index?}', 'RegistrationController@individualShow')->name('registration.individual');
    Route::post('individual', 'RegistrationController@individualSave')->name('registration.individual.save');

    Route::get('billing/{registration}', 'RegistrationController@billing')->name('registration.billing');
    Route::post('billing/{registration}', 'RegistrationController@saveBilling')->name('registration.billing.save');

    Route::get('payment', 'PaymentController@paymentPage')->name('registration.payment');
    Route::post('payment/alt', 'PaymentController@alternatePayment')->name('registration.payment.alt');
    //	Route::post('payment', 'PaymentController@paymentSave')->name('registration.payment.save');
    Route::post('payment', 'PaymentController@paymentToCC')->name('registration.payment.toCC');
    Route::get('payment-post/{registration}', 'PaymentController@paymentPost')->name('registration.payment.post');
    Route::post('payment/complete/{registration}', 'PaymentController@paymentComplete')->name('registration.payment.complete');

    Route::get('confirmation/{registration}', 'RegistrationController@confirmation')->name('registration.confirmation');

    Route::get('cancel', 'RegistrationController@cancelRegistration')->name('registration.cancel');
    Route::get('cancel/{registration}', 'RegistrationController@cancelRegistrationID')->name('registration.cancel.id');
});

Route::redirect('/trade/company', '/registration/trade/company', 301);
Route::redirect('/trade/student', '/registration/trade/individual', 301);
Route::redirect('/trade/confirmation/{registration}', '/registration/trade/confirmation/{registration}', 301);

// Route::redirect('/event/company', '/registration/event/company', 301);
Route::redirect('/event/company/{eventid?}', '/registration/event/company/{eventid?}', 301);
Route::redirect('/event/individual', '/registration/event/individual', 301);
Route::redirect('/event/confirmation/{registration}', '/registration/event/confirmation/{registration}', 301);

// Admin routes
Route::get('home', 'AdminController@index')->name('home')->middleware('admin');
Route::get('admin/settings/general', 'AdminController@settingsGeneral')->name('settings.general')->middleware('admin');
Route::get('admin/settings/content', 'AdminController@settingsContent')->name('settings.content')->middleware('admin');
Route::get('admin/settings/registration', 'AdminController@settingsRegistration')->name('settings.registration')->middleware('admin');
Route::get('admin/settings/registration-content', 'AdminController@settingsRegistrationContent')->name('settings.registrationContent')->middleware('admin');
Route::get('admin/registration-mail/{start}', 'AdminController@sendRegistrationMail')->name('resend')->middleware('admin');
Route::get('admin/test', 'AdminController@test');
// --settings
Route::post('admin/helpdesk', 'AdminController@saveHelpDesk')->name('editHelpDesk')->middleware('admin');
Route::post('admin/content', 'AdminController@saveContent')->name('editContent')->middleware('admin');
Route::post('admin/registration-status', 'AdminController@registrationStatus')->name('registrationStatus')->middleware('admin');
Route::post('admin/confirmation-email', 'AdminController@confirmationEmail')->name('confirmationEmail')->middleware('admin');
Route::post('admin/payment-agree', 'AdminController@paymentAgree')->name('paymentAgree')->middleware('admin');
Route::post('admin/admin-api', 'AdminController@adminAPI')->name('adminAPI')->middleware('admin');
Route::post('admin/admin-email', 'AdminController@adminEmail')->name('adminEmail')->middleware('admin');
Route::post('admin/add-agreement', 'AdminController@addAgreement')->name('registrationTradeAgree')->middleware('admin');
Route::get('admin/remove-agreement/{id}', 'AdminController@removeAgreement')->name('registrationTradeAgreeRemove')->middleware('admin');
Route::post('admin/mark-events', 'AdminController@eventsMark')->name('eventsMark')->middleware('admin');
Route::post('admin/customers-remove', 'AdminController@customerRemoveInHouse')->name('customerRemoveInHouse')->middleware('admin');
Route::post('admin/customers-add', 'AdminController@customerAddInHouse')->name('customerAddInHouse')->middleware('admin');
Route::post('admin/fundraising', 'AdminController@fundraising')->name('fundraising')->middleware('admin');
Route::post('admin/class-description', 'AdminController@classDescription')->name('classDescription')->middleware('admin');
// --uploads
Route::get('admin/uploads', 'AdminController@uploads')->name('admin.uploads')->middleware('admin');
Route::post('admin/student-upload', 'AdminController@studentUpload')->name('studentUpload')->middleware('admin');
Route::post('admin/customer-upload', 'AdminController@customerUpload')->name('customerUpload')->middleware('admin');
Route::post('admin/course-upload', 'AdminController@courseUpload')->name('courseUpload')->middleware('admin');
Route::get('admin/course-upload', 'AdminController@courseUpload')->name('courseUpload')->middleware('admin');
Route::post('admin/online-course-upload', 'AdminController@onlineClassUpload')->name('onlineClassUpload')->middleware('admin');
Route::post('admin/correspondence-course-upload', 'AdminController@correspondenceClassUpload')->name('correspondenceClassUpload')->middleware('admin');
Route::post('admin/event-upload', 'AdminController@eventUpload')->name('eventUpload')->middleware('admin');
Route::post('admin/ticket-upload', 'AdminController@ticketUpload')->name('ticketUpload')->middleware('admin');
// --downloads
Route::get('admin/downloads', 'AdminController@downloads')->name('admin.downloads')->middleware('admin');
Route::post('admin/registrations', 'AdminController@registrationDownload')->name('registrations')->middleware('admin');
Route::post('admin/donations', 'AdminController@donationsDownload')->name('admin.donations')->middleware('admin');
// --view registrations
Route::get('admin/view/registrations', 'AdminController@registrationViewPage')->name('admin.viewRegistrations')->middleware('admin');
Route::post('admin/view/registrations', 'AdminController@registrationView')->name('viewRegistrations')->middleware('admin');
Route::get('admin/view/donations', 'AdminController@donationsViewPage')->name('admin.viewDonationsPage')->middleware('admin');
Route::post('admin/view/donations', 'AdminController@donationsView')->name('admin.viewDonations')->middleware('admin');
// --coupons
Route::get('admin/coupons', 'AdminController@coupons')->name('admin.coupons');
Route::get('admin/coupons/{coupon}', 'AdminController@coupons')->name('coupons.edit');
Route::patch('admin/coupons', 'AdminController@couponSave')->name('coupons.save');
Route::post('admin/coupons/{coupon}', 'AdminController@couponDelete')->name('coupons.delete');
Route::post('admin/coupons', 'AdminController@couponCreate')->name('coupons.create');

// Ajax Data
Route::post('ajax/company/compare/match', 'HomeController@getCompanyMatch');
Route::post('ajax/company/lookup/{partial}', 'HomeController@getCompanyList');
Route::post('ajax/company/{customer}', 'HomeController@getCompanyInformation');
Route::get('ajax/company/{customer}', 'HomeController@getCompanyInformation');
Route::post('ajax/student/lookup/{partial}/{first?}', 'HomeController@getStudentList');
Route::get('ajax/student/lookup/{partial}/{first?}', 'HomeController@getStudentList');
Route::post('ajax/student/{student}', 'HomeController@getStudentInformation');
Route::post('ajax/course/location/{trade}', 'HomeController@getCourseLocations');
Route::get('ajax/course/location/{trade}', 'HomeController@getCourseLocations');
Route::post('ajax/course/courses/{path}/{trade}/{location?}', 'HomeController@getCourseIDs');
Route::post('ajax/course/cost/{path}/{course}', 'HomeController@getCourseCost');
Route::post('ajax/course/student/cost/{course}/{customer?}', 'HomeController@getStudentCourseCost');
Route::post('ajax/event/tickets/{event}', 'HomeController@getEventTickets');
Route::post('ajax/event/cost/{ticket}/{customer?}', 'HomeController@getEventCost');
Route::post('ajax/coupon/{coupon}/{path}','HomeController@coupon');
Route::post('ajax/admin/response/{registration}', 'HomeController@ajaxSendResponse');
Route::post('ajax/admin/confirmation/{registration}', 'HomeController@ajaxSendConfirmation');
Route::post('ajax/class/description/{course}','HomeController@getClassDescription');
Route::get('ajax/class/description/{course}','HomeController@getClassDescription');

// Route::get('ajax/course/student/cost/{course}/{customer?}','HomeController@getStudentCourseCost');
