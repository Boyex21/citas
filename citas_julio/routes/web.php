<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\Auth\AdminForgotPasswordController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\DayController;
use App\Http\Controllers\Admin\MedicineController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DoctorController;


use App\Http\Controllers\Doctor\DoctorProfileController;
use App\Http\Controllers\Doctor\DoctorLoginController;
use App\Http\Controllers\Doctor\DoctorForgetPasswordController;
use App\Http\Controllers\Doctor\DoctorDepartmentController;
use App\Http\Controllers\Doctor\DoctorLocationController;
use App\Http\Controllers\Doctor\DoctorMedicineController;
use App\Http\Controllers\Doctor\ScheduleController;
use App\Http\Controllers\Doctor\ChamberController;
use App\Http\Controllers\Doctor\StaffController;
use App\Http\Controllers\Doctor\DoctorOrderController;
use App\Http\Controllers\Doctor\DoctorPaypalController;
use App\Http\Controllers\Doctor\AppointmentController;
use App\Http\Controllers\Doctor\DoctorPaymentMethodController;
use App\Http\Controllers\Doctor\GalleryController;
use App\Http\Controllers\Doctor\ZoomCredentialController;
use App\Http\Controllers\Doctor\MeetingController;
use App\Http\Controllers\Doctor\LeaveController;
use App\Http\Controllers\Doctor\MessageController;

use App\Http\Controllers\Staff\StaffLoginController;
use App\Http\Controllers\Staff\StaffForgetPasswordController;
use App\Http\Controllers\Staff\StaffProfileController;
use App\Http\Controllers\Staff\StaffDepartmentController;
use App\Http\Controllers\Staff\StaffLocationController;
use App\Http\Controllers\Staff\StaffMedicineController;
use App\Http\Controllers\Staff\StaffScheduleController;
use App\Http\Controllers\Staff\StaffAppointmentController;
use App\Http\Controllers\Staff\StaffGalleryController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\UserProfileController;


use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function() {
    return redirect()->route('login');
});

Route::group(['middleware' => ['HtmlSpecialchars']], function () {

    Route::group(['middleware' => ['XSS']], function () {

        Route::group(['middleware' => ['maintainance']], function () {
            Route::get('get-schedule', [HomeController::class, 'getSchedule'])->name('get-schedule');
            Route::get('schedule-avaibility', [HomeController::class, 'scheduleAvaibility'])->name('schedule-avaibility');
            Route::post('create-appointment', [HomeController::class, 'createAppointment'])->name('create-appointment');
            Route::get('remove-appointment/{id}', [HomeController::class, 'removeAppointment'])->name('remove-appointment');

            Route::post('store-review', [HomeController::class, 'storeReview'])->name('store-review');

            Route::get('/download-file/{file}', [HomeController::class, 'downloadListingFile'])->name('download-file');

            Route::get('/login', [LoginController::class, 'loginPage'])->name('login');
            Route::get('/register', [RegisterController::class, 'registerForm'])->name('register');
            Route::post('/store-login', [LoginController::class, 'storeLogin'])->name('store-login');
            Route::post('/store-register', [RegisterController::class, 'storeRegister'])->name('store-register');
            Route::get('/user-verification/{token}', [RegisterController::class, 'userVerification'])->name('user-verification');
            Route::post('/store-doctor-register', [RegisterController::class, 'storeDoctorRegister'])->name('store-doctor-register');
            Route::get('/doctor-verification/{token}', [RegisterController::class, 'doctorVerification'])->name('doctor-verification');

            Route::get('/forget-password', [LoginController::class, 'forgetPage'])->name('forget-password');
            Route::post('/send-forget-password', [LoginController::class, 'sendForgetPassword'])->name('send-forget-password');
            Route::get('/reset-password/{token}', [LoginController::class, 'resetPasswordPage'])->name('reset-password');
            Route::post('/store-reset-password/{token}', [LoginController::class, 'storeResetPasswordPage'])->name('store-reset-password');
            Route::get('/user/logout', [LoginController::class, 'userLogout'])->name('user.logout');

            Route::group(['as'=> 'user.', 'prefix' => 'user'],function (){

                Route::get('my-profile', [UserProfileController::class, 'myProfile'])->name('my-profile');
                Route::post('update-profile', [UserProfileController::class, 'updateProfile'])->name('update-profile');

                Route::group(['middleware' => ['checkuserprofile']], function () {
                    Route::get('dashboard', [UserProfileController::class, 'dashboard'])->name('dashboard');
                    Route::get('appointment', [UserProfileController::class, 'appointment'])->name('appointment');
                    Route::get('appointment/{id}', [UserProfileController::class, 'showAppointment'])->name('show-appointment');
                    Route::get('change-password', [UserProfileController::class, 'changePassword'])->name('change-password');
                    Route::post('update-password', [UserProfileController::class, 'updatePassword'])->name('update-password');
                });

            });


            Route::group(['as'=> 'doctor.', 'prefix' => 'doctor'],function (){
                Route::get('login', [DoctorLoginController::class,'doctorLoginPage'])->name('login');
                Route::post('login', [DoctorLoginController::class,'storeLogin'])->name('login');
                Route::get('logout', [DoctorLoginController::class,'doctorLogout'])->name('logout');
                Route::get('forget-password', [DoctorForgetPasswordController::class,'forgetPassword'])->name('forget-password');
                Route::post('send-forget-password', [DoctorForgetPasswordController::class,'sendForgetEmail'])->name('send.forget.password');
                Route::get('reset-password/{token}', [DoctorForgetPasswordController::class,'resetPassword'])->name('reset.password');
                Route::post('password-store/{token}', [DoctorForgetPasswordController::class,'storeResetData'])->name('store.reset.password');

                Route::get('profile', [DoctorProfileController::class,'myProfile'])->name('profile');
                Route::put('profile-update', [DoctorProfileController::class,'updateProfile'])->name('profile.update');
                Route::get('change-password', [DoctorProfileController::class,'changePassword'])->name('change-password');
                Route::put('update-password', [DoctorProfileController::class,'updatePassword'])->name('update-password');
                Route::get('social-link', [DoctorProfileController::class,'socailLink'])->name('social-link');
                Route::post('store-social-link', [DoctorProfileController::class,'storeSocialLink'])->name('store-social-link');
                Route::delete('delete-social-link/{id}', [DoctorProfileController::class,'deleteSocialLink'])->name('delete-social-link');


                Route::get('order', [DoctorOrderController::class, 'index'])->name('order');
                Route::get('order-show/{id}', [DoctorOrderController::class, 'show'])->name('order-show');
                Route::get('pricing-plan', [DoctorOrderController::class, 'pricingPlan'])->name('pricing-plan');
                Route::get('payment/{slug}', [DoctorOrderController::class, 'payment'])->name('payment');

                Route::post('pay-with-stripe', [DoctorOrderController::class, 'paywithStripe'])->name('pay-with-stripe');
                Route::get('/pay-with-paypal/{slug}', [DoctorPaypalController::class, 'payWithPaypal'])->name('pay-with-paypal');
                Route::get('/paypal-payment-success', [DoctorPaypalController::class, 'paypalPaymentSuccess'])->name('paypal-payment-success');
                Route::get('/paypal-payment-cancled', [DoctorPaypalController::class, 'paypalPaymentCancled'])->name('paypal-payment-cancled');
                Route::post('/pay-with-razorpay/{slug}', [DoctorOrderController::class, 'payWithRazorpay'])->name('pay-with-razorpay');
                Route::post('/pay-with-flutterwave', [DoctorOrderController::class, 'payWithFlutterwave'])->name('pay-with-flutterwave');
                Route::get('/pay-with-mollie/{slug}', [DoctorOrderController::class, 'payWithMollie'])->name('pay-with-mollie');
                Route::get('/mollie-payment-success', [DoctorOrderController::class, 'molliePaymentSuccess'])->name('mollie-payment-success');
                Route::post('/pay-with-paystack', [DoctorOrderController::class, 'payWithPayStack'])->name('pay-with-paystack');
                Route::get('/pay-with-instamojo/{slug}', [DoctorOrderController::class, 'payWithInstamojo'])->name('pay-with-instamojo');
                Route::get('/instamojo-response', [DoctorOrderController::class, 'instamojoResponse'])->name('instamojo-response');
                Route::post('/pay-with-bank/{slug}', [DoctorOrderController::class, 'payWithBank'])->name('pay-with-bank');
                Route::get('/free-trail/{slug}', [DoctorOrderController::class, 'freeTrail'])->name('free-trail');

                Route::group(['middleware' => ['doctorchecker','subscriptionchecker']], function () {
                    Route::get('/', [DoctorProfileController::class, 'dashboard'])->name('dashboard');
                    Route::get('dashboard', [DoctorProfileController::class, 'dashboard'])->name('dashboard');

                    Route::get('review', [DoctorProfileController::class, 'review'])->name('review');

                    Route::get('image-gallery', [GalleryController::class, 'imageGallery'])->name('image-gallery');
                    Route::post('store-image-gallery', [GalleryController::class, 'storeImageGallery'])->name('store-image-gallery');
                    Route::delete('delete-gallery-image/{id}', [GalleryController::class, 'deleteImageGallery'])->name('delete-gallery-image');
                    Route::get('video-gallery', [GalleryController::class, 'videoGallery'])->name('video-gallery');
                    Route::post('store-video-gallery', [GalleryController::class, 'storeVideoGallery'])->name('store-video-gallery');
                    Route::delete('delete-gallery-video/{id}', [GalleryController::class, 'deleteVideoGallery'])->name('delete-gallery-video');

                    Route::resource('department', DoctorDepartmentController::class);
                    Route::put('department-status/{id}', [DoctorDepartmentController::class,'changeStatus'])->name('department-status');

                    Route::resource('location', DoctorLocationController::class);
                    Route::put('location-status/{id}', [DoctorLocationController::class,'changeStatus'])->name('location-status');

                    Route::resource('medicine', DoctorMedicineController::class);
                    Route::post('medicne-store', [DoctorMedicineController::class,'storeUsingAjax'])->name('medicne-store');

                    Route::resource('schedule', ScheduleController::class);
                    Route::put('schedule-status/{id}', [ScheduleController::class,'changeStatus'])->name('schedule-status');

                    Route::resource('chamber', ChamberController::class);
                    Route::put('chamber-status/{id}', [ChamberController::class,'changeStatus'])->name('chamber-status');
                    Route::put('set-default/{id}', [ChamberController::class,'setDefault'])->name('set-default');

                    Route::resource('staff', StaffController::class);
                    Route::put('staff-status/{id}', [StaffController::class,'changeStatus'])->name('staff-status');

                    Route::get('appointment-payment', [AppointmentController::class, 'payment'])->name('appointment-payment');
                    Route::get('pending-payment', [AppointmentController::class, 'pendingPayment'])->name('pending-payment');
                    Route::get('show-payment/{invoice_id}', [AppointmentController::class, 'showPayment'])->name('show-payment');
                    Route::get('payment-approved/{id}', [AppointmentController::class, 'paymentApproved'])->name('payment-approved');
                    Route::delete('delete-payment/{id}', [AppointmentController::class, 'deletePayment'])->name('delete-payment');

                    Route::get('appointment', [AppointmentController::class, 'appointment'])->name('appointment');
                    Route::get('today-appointment', [AppointmentController::class, 'todayAppointment'])->name('today-appointment');
                    Route::get('show-appointment/{id}', [AppointmentController::class, 'showAppointment'])->name('show-appointment');
                    Route::get('prescription', [AppointmentController::class, 'prescription'])->name('prescription');
                    Route::get('edit-appointment/{id}', [AppointmentController::class, 'editAppointment'])->name('edit-appointment');
                    Route::post('store-prescription/{id}', [AppointmentController::class, 'storePrescription'])->name('store-prescription');
                    Route::get('show-prescription/{id}', [AppointmentController::class, 'showPrescription'])->name('show-prescription');
                    Route::get('delete-appointment-prescribe/{id}', [AppointmentController::class, 'deleteExistMedicine'])->name('delete-appointment-prescribe');
                    Route::put('update-prescription/{id}', [AppointmentController::class, 'updatePrescription'])->name('update-prescription');
                    Route::delete('delete-appointment/{id}', [AppointmentController::class, 'deleteAppointment'])->name('delete-appointment');


                    Route::get('create-appointment', [AppointmentController::class, 'createAppointment'])->name('create-appointment');
                    Route::post('store-appointment', [AppointmentController::class, 'storeAppointment'])->name('store-appointment');
                    Route::get('get-schedule', [AppointmentController::class, 'getSchedule'])->name('get-schedule');
                    Route::get('schedule-avaibility', [AppointmentController::class, 'scheduleAvaibility'])->name('schedule-avaibility');
                    Route::post('new-patient', [AppointmentController::class, 'createPatient'])->name('new-patient');


                    Route::get('payment-method',[DoctorPaymentMethodController::class,'index'])->name('payment-method');
                    Route::put('update-paypal',[DoctorPaymentMethodController::class,'updatePaypal'])->name('update-paypal');
                    Route::put('update-stripe',[DoctorPaymentMethodController::class,'updateStripe'])->name('update-stripe');
                    Route::put('update-razorpay',[DoctorPaymentMethodController::class,'updateRazorpay'])->name('update-razorpay');
                    Route::put('update-bank',[DoctorPaymentMethodController::class,'updateBank'])->name('update-bank');
                    Route::put('update-mollie',[DoctorPaymentMethodController::class,'updateMollie'])->name('update-mollie');
                    Route::put('update-paystack',[DoctorPaymentMethodController::class,'updatePayStack'])->name('update-paystack');
                    Route::put('update-flutterwave',[DoctorPaymentMethodController::class,'updateflutterwave'])->name('update-flutterwave');
                    Route::put('update-instamojo',[DoctorPaymentMethodController::class,'updateInstamojo'])->name('update-instamojo');
                    Route::put('update-cash-on-delivery',[DoctorPaymentMethodController::class,'updateCashOnDelivery'])->name('update-cash-on-delivery');

                    Route::group(['middleware' => ['onlineconsulting']], function () {
                        Route::get('zoom-credential', [ZoomCredentialController::class, 'index'])->name('zoom-credential');
                        Route::post('update-zoom-credential', [ZoomCredentialController::class, 'store'])->name('update-zoom-credential');

                        Route::get('zoom-meeting', [MeetingController::class, 'index'])->name('zoom-meeting');
                        Route::get('create-zoom-meeting', [MeetingController::class, 'createForm'])->name('create-zoom-meeting');
                        Route::post('store-zoom-meeting', [MeetingController::class, 'store'])->name('store-zoom-meeting');
                        Route::get('edit-zoom-meeting/{id}', [MeetingController::class, 'editForm'])->name('edit-zoom-meeting');
                        Route::put('update-zoom-meeting/{id}', [MeetingController::class, 'updateMeeting'])->name('update-zoom-meeting');
                        Route::delete('delete-zoom-meeting/{id}', [MeetingController::class, 'destroy'])->name('delete-zoom-meeting');

                        Route::get('meeting-history', [MeetingController::class, 'meetingHistory'])->name('meeting-history');
                        Route::get('upcomming-meeting', [MeetingController::class, 'upCommingMeeting'])->name('upcomming-meeting');
                    });

                    Route::get('message', [MessageController::class, 'index'])->name('message');
                    Route::get('load-chat-box/{id}', [MessageController::class, 'loadChatBox'])->name('load-chat-box');
                    Route::get('send-message', [MessageController::class, 'sendMessage'])->name('send-message');
                    Route::get('real-all-message', [MessageController::class, 'readAllMessage'])->name('real-all-message');
                    Route::get('load-new-message', [MessageController::class, 'loadNewMessage'])->name('load-new-message');


                    Route::resource('leave', LeaveController::class);
                });
});


Route::group(['as'=> 'staff.', 'prefix' => 'staff'],function (){
        // start auth route
    Route::get('login', [StaffLoginController::class,'staffLoginPage'])->name('login');
    Route::post('login', [StaffLoginController::class,'storeLogin'])->name('login');
    Route::get('logout', [StaffLoginController::class,'staffLogut'])->name('logout');
    Route::get('forget-password', [StaffForgetPasswordController::class,'forgetPassword'])->name('forget-password');
    Route::post('send-forget-password', [StaffForgetPasswordController::class,'sendForgetEmail'])->name('send.forget.password');
    Route::get('reset-password/{token}', [StaffForgetPasswordController::class,'resetPassword'])->name('reset.password');
    Route::post('password-store/{token}', [StaffForgetPasswordController::class,'storeResetData'])->name('store.reset.password');
        // end auth route

    Route::get('profile', [StaffProfileController::class,'myProfile'])->name('profile');
    Route::put('profile-update', [StaffProfileController::class,'updateProfile'])->name('profile.update');
    Route::get('change-password', [StaffProfileController::class,'changePassword'])->name('change-password');
    Route::put('update-password', [StaffProfileController::class,'updatePassword'])->name('update-password');

    Route::get('/', [StaffProfileController::class, 'dashboard'])->name('dashboard');
    Route::get('dashboard', [StaffProfileController::class, 'dashboard'])->name('dashboard');

    Route::get('image-gallery', [StaffGalleryController::class, 'imageGallery'])->name('image-gallery');
    Route::post('store-image-gallery', [StaffGalleryController::class, 'storeImageGallery'])->name('store-image-gallery');
    Route::delete('delete-gallery-image/{id}', [StaffGalleryController::class, 'deleteImageGallery'])->name('delete-gallery-image');
    Route::get('video-gallery', [StaffGalleryController::class, 'videoGallery'])->name('video-gallery');
    Route::post('store-video-gallery', [StaffGalleryController::class, 'storeVideoGallery'])->name('store-video-gallery');
    Route::delete('delete-gallery-video/{id}', [StaffGalleryController::class, 'deleteVideoGallery'])->name('delete-gallery-video');
    Route::get('social-link', [StaffGalleryController::class,'socailLink'])->name('social-link');
    Route::post('store-social-link', [StaffGalleryController::class,'storeSocialLink'])->name('store-social-link');
    Route::delete('delete-social-link/{id}', [StaffGalleryController::class,'deleteSocialLink'])->name('delete-social-link');

    Route::resource('department', StaffDepartmentController::class);
    Route::put('department-status/{id}', [StaffDepartmentController::class,'changeStatus'])->name('department-status');

    Route::resource('location', StaffLocationController::class);
    Route::put('location-status/{id}', [StaffLocationController::class,'changeStatus'])->name('location-status');

    Route::resource('medicine', StaffMedicineController::class);
    Route::post('medicne-store', [StaffMedicineController::class,'storeUsingAjax'])->name('medicne-store');

    Route::resource('schedule', StaffScheduleController::class);
    Route::put('schedule-status/{id}', [StaffScheduleController::class,'changeStatus'])->name('schedule-status');

    Route::get('appointment', [StaffAppointmentController::class, 'appointment'])->name('appointment');
    Route::get('today-appointment', [StaffAppointmentController::class, 'todayAppointment'])->name('today-appointment');
    Route::get('prescription', [StaffAppointmentController::class, 'prescription'])->name('prescription');
    Route::get('show-appointment/{id}', [StaffAppointmentController::class, 'showAppointment'])->name('show-appointment');
    Route::get('edit-appointment/{id}', [StaffAppointmentController::class, 'editAppointment'])->name('edit-appointment');
    Route::post('store-prescription/{id}', [StaffAppointmentController::class, 'storePrescription'])->name('store-prescription');
    Route::get('show-prescription/{id}', [StaffAppointmentController::class, 'showPrescription'])->name('show-prescription');
    Route::get('delete-appointment-prescribe/{id}', [StaffAppointmentController::class, 'deleteExistMedicine'])->name('delete-appointment-prescribe');
    Route::put('update-prescription/{id}', [StaffAppointmentController::class, 'updatePrescription'])->name('update-prescription');
    Route::delete('delete-appointment/{id}', [StaffAppointmentController::class, 'deleteAppointment'])->name('delete-appointment');
    Route::get('create-appointment', [StaffAppointmentController::class, 'createAppointment'])->name('create-appointment');
    Route::post('store-appointment', [StaffAppointmentController::class, 'storeAppointment'])->name('store-appointment');
    Route::get('get-schedule', [StaffAppointmentController::class, 'getSchedule'])->name('get-schedule');
    Route::get('schedule-avaibility', [StaffAppointmentController::class, 'scheduleAvaibility'])->name('schedule-avaibility');
    Route::post('new-patient', [StaffAppointmentController::class, 'createPatient'])->name('new-patient');

    Route::get('appointment-payment', [StaffAppointmentController::class, 'payment'])->name('appointment-payment');
    Route::get('pending-payment', [StaffAppointmentController::class, 'pendingPayment'])->name('pending-payment');
    Route::get('show-payment/{invoice_id}', [StaffAppointmentController::class, 'showPayment'])->name('show-payment');
    Route::get('payment-approved/{id}', [StaffAppointmentController::class, 'paymentApproved'])->name('payment-approved');
    Route::delete('delete-payment/{id}', [StaffAppointmentController::class, 'deletePayment'])->name('delete-payment');

});


});

// start admin routes
Route::group(['as'=> 'admin.', 'prefix' => 'admin'],function (){

    // start auth route
    Route::get('login', [AdminLoginController::class,'adminLoginPage'])->name('login');
    Route::post('login', [AdminLoginController::class,'storeLogin'])->name('login');
    Route::post('logout', [AdminLoginController::class,'adminLogout'])->name('logout');
    Route::get('forget-password', [AdminForgotPasswordController::class,'forgetPassword'])->name('forget-password');
    Route::post('send-forget-password', [AdminForgotPasswordController::class,'sendForgetEmail'])->name('send.forget.password');
    Route::get('reset-password/{token}', [AdminForgotPasswordController::class,'resetPassword'])->name('reset.password');
    Route::post('password-store/{token}', [AdminForgotPasswordController::class,'storeResetData'])->name('store.reset.password');
    // end auth route

    Route::get('/', [DashboardController::class,'dashobard'])->name('dashboard');
    Route::get('dashboard', [DashboardController::class,'dashobard'])->name('dashboard');
    Route::get('profile', [AdminProfileController::class,'index'])->name('profile');
    Route::put('profile-update', [AdminProfileController::class,'update'])->name('profile.update');

    Route::resource('department', DepartmentController::class);
    Route::put('department-status/{id}', [DepartmentController::class,'changeStatus'])->name('department-status');

    Route::resource('location', LocationController::class);
    Route::put('location-status/{id}', [LocationController::class,'changeStatus'])->name('location-status');

    Route::resource('medicine', MedicineController::class);
    Route::get('appointment', [MedicineController::class, 'appointments'])->name('appointment');

    Route::get('doctor', [DoctorController::class, 'doctors'])->name('doctor');
    Route::get('show-doctor/{id}', [DoctorController::class, 'showDoctor'])->name('show-doctor');
    Route::put('doctor-status/{id}', [DoctorController::class,'changeStatus'])->name('doctor-status');
    Route::delete('doctor-delete/{id}', [DoctorController::class,'destroy'])->name('doctor-delete');
    Route::get('staff', [DoctorController::class, 'staff'])->name('staff');
    Route::get('chamber', [DoctorController::class, 'chamber'])->name('chamber');

    Route::get('review', [DoctorController::class, 'review'])->name('review');
    Route::put('review-status/{id}', [DoctorController::class, 'changeReviewStatus'])->name('review-status');
    Route::delete('review-delete/{id}', [DoctorController::class, 'reviewDelete'])->name('review-delete');

    Route::resource('day', DayController::class);

    Route::get('general-setting',[SettingController::class,'index'])->name('general-setting');
    Route::put('update-general-setting',[SettingController::class,'updateGeneralSetting'])->name('update-general-setting');

    Route::put('update-theme-color',[SettingController::class,'updateThemeColor'])->name('update-theme-color');

    Route::put('update-logo-favicon',[SettingController::class,'updateLogoFavicon'])->name('update-logo-favicon');
    Route::put('update-cookie-consent',[SettingController::class,'updateCookieConset'])->name('update-cookie-consent');
    Route::put('update-google-recaptcha',[SettingController::class,'updateGoogleRecaptcha'])->name('update-google-recaptcha');
    Route::put('update-facebook-comment',[SettingController::class,'updateFacebookComment'])->name('update-facebook-comment');
    Route::put('update-tawk-chat',[SettingController::class,'updateTawkChat'])->name('update-tawk-chat');
    Route::put('update-google-analytic',[SettingController::class,'updateGoogleAnalytic'])->name('update-google-analytic');
    Route::put('update-custom-pagination',[SettingController::class,'updateCustomPagination'])->name('update-custom-pagination');
    Route::put('update-social-login',[SettingController::class,'updateSocialLogin'])->name('update-social-login');
    Route::put('update-facebook-pixel',[SettingController::class,'updateFacebookPixel'])->name('update-facebook-pixel');
    Route::put('update-pusher',[SettingController::class,'updatePusher'])->name('update-pusher');


    Route::resource('admin', AdminController::class);
    Route::put('admin-status/{id}', [AdminController::class,'changeStatus'])->name('admin-status');

    Route::get('customer-list',[CustomerController::class,'index'])->name('customer-list');
    Route::get('customer-show/{id}',[CustomerController::class,'show'])->name('customer-show');
    Route::put('customer-status/{id}',[CustomerController::class,'changeStatus'])->name('customer-status');
    Route::delete('customer-delete/{id}',[CustomerController::class,'destroy'])->name('customer-delete');
    Route::get('pending-customer-list',[CustomerController::class,'pendingCustomerList'])->name('pending-customer-list');
    Route::get('send-email-to-all-customer',[CustomerController::class,'sendEmailToAllUser'])->name('send-email-to-all-customer');
    Route::post('send-mail-to-all-user',[CustomerController::class,'sendMailToAllUser'])->name('send-mail-to-all-user');
    Route::post('send-mail-to-single-user/{id}',[CustomerController::class,'sendMailToSingleUser'])->name('send-mail-to-single-user');

});

});


});
// end admin routes