<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\Auth\AdminForgotPasswordController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminAppointmentController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\DayController;
use App\Http\Controllers\Admin\MedicineController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\AdminChamberController;
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
use App\Http\Controllers\Doctor\AppointmentController;
use App\Http\Controllers\Doctor\LeaveController;

use App\Http\Controllers\Staff\StaffLoginController;
use App\Http\Controllers\Staff\StaffForgetPasswordController;
use App\Http\Controllers\Staff\StaffProfileController;
use App\Http\Controllers\Staff\StaffDepartmentController;
use App\Http\Controllers\Staff\StaffLocationController;
use App\Http\Controllers\Staff\StaffMedicineController;
use App\Http\Controllers\Staff\StaffScheduleController;
use App\Http\Controllers\Staff\StaffAppointmentController;

use App\Http\Controllers\User\UserProfileController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function() {
    return redirect()->route('login');
});

Route::group(['middleware' => ['HtmlSpecialchars']], function () {

    Route::group(['middleware' => ['XSS']], function () {
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

        Route::group(['as' => 'doctor.', 'prefix' => 'doctor'], function () {
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

            Route::group(['middleware' => ['doctorchecker']], function () {
                Route::get('/', [DoctorProfileController::class, 'dashboard'])->name('dashboard');
                Route::get('dashboard', [DoctorProfileController::class, 'dashboard'])->name('dashboard');

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

                Route::resource('leave', LeaveController::class);
            });
        });

        Route::group(['as'=> 'staff.', 'prefix' => 'staff'], function (){
            Route::get('login', [StaffLoginController::class,'staffLoginPage'])->name('login');
            Route::post('login', [StaffLoginController::class,'storeLogin'])->name('login');
            Route::get('logout', [StaffLoginController::class,'staffLogut'])->name('logout');
            Route::get('forget-password', [StaffForgetPasswordController::class,'forgetPassword'])->name('forget-password');
            Route::post('send-forget-password', [StaffForgetPasswordController::class,'sendForgetEmail'])->name('send.forget.password');
            Route::get('reset-password/{token}', [StaffForgetPasswordController::class,'resetPassword'])->name('reset.password');
            Route::post('password-store/{token}', [StaffForgetPasswordController::class,'storeResetData'])->name('store.reset.password');

            Route::get('profile', [StaffProfileController::class,'myProfile'])->name('profile');
            Route::put('profile-update', [StaffProfileController::class,'updateProfile'])->name('profile.update');
            Route::get('change-password', [StaffProfileController::class,'changePassword'])->name('change-password');
            Route::put('update-password', [StaffProfileController::class,'updatePassword'])->name('update-password');

            Route::get('/', [StaffProfileController::class, 'dashboard'])->name('dashboard');
            Route::get('dashboard', [StaffProfileController::class, 'dashboard'])->name('dashboard');

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
        });

        Route::group(['as'=> 'admin.', 'prefix' => 'admin'],function (){
            Route::get('login', [AdminLoginController::class,'adminLoginPage'])->name('login');
            Route::post('login', [AdminLoginController::class,'storeLogin'])->name('login');
            Route::post('logout', [AdminLoginController::class,'adminLogout'])->name('logout');
            Route::get('forget-password', [AdminForgotPasswordController::class,'forgetPassword'])->name('forget-password');
            Route::post('send-forget-password', [AdminForgotPasswordController::class,'sendForgetEmail'])->name('send.forget.password');
            Route::get('reset-password/{token}', [AdminForgotPasswordController::class,'resetPassword'])->name('reset.password');
            Route::post('password-store/{token}', [AdminForgotPasswordController::class,'storeResetData'])->name('store.reset.password');

            Route::get('/', [DashboardController::class,'dashobard'])->name('dashboard');
            Route::get('dashboard', [DashboardController::class,'dashobard'])->name('dashboard');
            Route::get('profile', [AdminProfileController::class,'index'])->name('profile');
            Route::put('profile-update', [AdminProfileController::class,'update'])->name('profile.update');

            Route::resource('department', DepartmentController::class);
            Route::put('department-status/{id}', [DepartmentController::class,'changeStatus'])->name('department-status');

            Route::resource('location', LocationController::class);
            Route::put('location-status/{id}', [LocationController::class,'changeStatus'])->name('location-status');

            Route::resource('medicine', MedicineController::class);

            Route::get('appointment', [AdminAppointmentController::class, 'index'])->name('appointment');
            Route::get('create-appointment', [AdminAppointmentController::class, 'createAppointment'])->name('create-appointment');
            Route::post('store-appointment', [AdminAppointmentController::class, 'storeAppointment'])->name('store-appointment');
            Route::get('get-chambers', [AdminAppointmentController::class, 'getChamber'])->name('get-chambers');
            Route::get('get-schedule', [AdminAppointmentController::class, 'getSchedule'])->name('get-schedule');
            Route::get('schedule-avaibility', [AdminAppointmentController::class, 'scheduleAvaibility'])->name('schedule-avaibility');

            Route::get('doctor', [DoctorController::class, 'doctors'])->name('doctor');
            Route::post('doctor', [DoctorController::class, 'doctorStore'])->name('doctor.store');
            Route::get('show-doctor/{id}', [DoctorController::class, 'showDoctor'])->name('show-doctor');
            Route::put('doctor-status/{id}', [DoctorController::class,'changeStatus'])->name('doctor-status');
            Route::delete('doctor-delete/{id}', [DoctorController::class,'destroy'])->name('doctor-delete');
            Route::get('staff', [DoctorController::class, 'staff'])->name('staff');

            Route::get('chamber', [AdminChamberController::class, 'index'])->name('chamber');
            Route::post('chamber', [AdminChamberController::class, 'store'])->name('chamber.store');

            Route::get('general-setting',[SettingController::class,'index'])->name('general-setting');
            Route::put('update-general-setting',[SettingController::class,'updateGeneralSetting'])->name('update-general-setting');
            Route::put('update-logo-favicon',[SettingController::class,'updateLogoFavicon'])->name('update-logo-favicon');

            Route::resource('admin', AdminController::class);
            Route::put('admin-status/{id}', [AdminController::class,'changeStatus'])->name('admin-status');

            Route::get('customer-list',[CustomerController::class,'index'])->name('customer-list');
            Route::post('customer-create',[CustomerController::class,'store'])->name('customer-create');
            Route::get('customer-show/{id}',[CustomerController::class,'show'])->name('customer-show');
            Route::put('customer-status/{id}',[CustomerController::class,'changeStatus'])->name('customer-status');
            Route::delete('customer-delete/{id}',[CustomerController::class,'destroy'])->name('customer-delete');
            Route::get('pending-customer-list',[CustomerController::class,'pendingCustomerList'])->name('pending-customer-list');
        });
    });
});