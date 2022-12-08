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

/////////////////////////////////////////// AUTH //////////////////////////////////////////////
Auth::routes();
Route::get('/usuarios/email', 'AdminController@emailVerifyAdmin');

////////////////////////////////////////// WEB ////////////////////////////////////////////////
Route::get('/', function() {
	return redirect()->route('admin');
});

////////////////////////////////////////// ADMIN //////////////////////////////////////////////
Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin'], function () {
	// Home
	Route::get('/', 'AdminController@index')->name('admin');

	// Profile
	Route::prefix('perfil')->group(function () {
		Route::get('/', 'AdminController@profile')->name('profile');
		Route::get('/editar', 'AdminController@profileEdit')->name('profile.edit');
		Route::put('/', 'AdminController@profileUpdate')->name('profile.update');
	});

	// Users
	Route::prefix('usuarios')->group(function () {
		Route::get('/', 'UserController@index')->name('users.index')->middleware('permission:users.index');
		Route::get('/registrar', 'UserController@create')->name('users.create')->middleware('permission:users.create');
		Route::post('/', 'UserController@store')->name('users.store')->middleware('permission:users.create');
		Route::get('/{user:slug}', 'UserController@show')->name('users.show')->middleware('permission:users.show');
		Route::get('/{user:slug}/editar', 'UserController@edit')->name('users.edit')->middleware('permission:users.edit');
		Route::put('/{user:slug}', 'UserController@update')->name('users.update')->middleware('permission:users.edit');
		Route::delete('/{user:slug}', 'UserController@destroy')->name('users.delete')->middleware('permission:users.delete');
		Route::put('/{user:slug}/activar', 'UserController@activate')->name('users.activate')->middleware('permission:users.active');
		Route::put('/{user:slug}/desactivar', 'UserController@deactivate')->name('users.deactivate')->middleware('permission:users.deactive');
	});

	// Doctors
	Route::prefix('doctores')->group(function () {
		Route::get('/', 'DoctorController@index')->name('doctors.index')->middleware('permission:doctors.index');
		Route::get('/registrar', 'DoctorController@create')->name('doctors.create')->middleware('permission:doctors.create');
		Route::post('/', 'DoctorController@store')->name('doctors.store')->middleware('permission:doctors.create');
		Route::get('/{user:slug}', 'DoctorController@show')->name('doctors.show')->middleware('permission:doctors.show');
		Route::get('/{user:slug}/editar', 'DoctorController@edit')->name('doctors.edit')->middleware('permission:doctors.edit');
		Route::put('/{user:slug}', 'DoctorController@update')->name('doctors.update')->middleware('permission:doctors.edit');
		Route::delete('/{user:slug}', 'DoctorController@destroy')->name('doctors.delete')->middleware('permission:doctors.delete');
		Route::put('/{user:slug}/activar', 'DoctorController@activate')->name('doctors.activate')->middleware('permission:doctors.active');
		Route::put('/{user:slug}/desactivar', 'DoctorController@deactivate')->name('doctors.deactivate')->middleware('permission:doctors.deactive');
		Route::put('/{user:slug}/horarios', 'DoctorController@schedules')->name('doctors.schedules')->middleware('permission:doctors.schedules');
	});

	// Secretaries
	Route::prefix('secretarias')->group(function () {
		Route::get('/', 'SecretaryController@index')->name('secretaries.index')->middleware('permission:secretaries.index');
		Route::get('/registrar', 'SecretaryController@create')->name('secretaries.create')->middleware('permission:secretaries.create');
		Route::post('/', 'SecretaryController@store')->name('secretaries.store')->middleware('permission:secretaries.create');
		Route::get('/{user:slug}', 'SecretaryController@show')->name('secretaries.show')->middleware('permission:secretaries.show');
		Route::get('/{user:slug}/editar', 'SecretaryController@edit')->name('secretaries.edit')->middleware('permission:secretaries.edit');
		Route::put('/{user:slug}', 'SecretaryController@update')->name('secretaries.update')->middleware('permission:secretaries.edit');
		Route::delete('/{user:slug}', 'SecretaryController@destroy')->name('secretaries.delete')->middleware('permission:secretaries.delete');
		Route::put('/{user:slug}/activar', 'SecretaryController@activate')->name('secretaries.activate')->middleware('permission:secretaries.active');
		Route::put('/{user:slug}/desactivar', 'SecretaryController@deactivate')->name('secretaries.deactivate')->middleware('permission:secretaries.deactive');
	});

	// Patients
	Route::prefix('pacientes')->group(function () {
		Route::get('/', 'PatientController@index')->name('patients.index')->middleware('permission:patients.index');
		Route::get('/registrar', 'PatientController@create')->name('patients.create')->middleware('permission:patients.create');
		Route::post('/', 'PatientController@store')->name('patients.store')->middleware('permission:patients.create');
		Route::get('/{user:slug}', 'PatientController@show')->name('patients.show')->middleware('permission:patients.show');
		Route::get('/{user:slug}/editar', 'PatientController@edit')->name('patients.edit')->middleware('permission:patients.edit');
		Route::put('/{user:slug}', 'PatientController@update')->name('patients.update')->middleware('permission:patients.edit');
		Route::delete('/{user:slug}', 'PatientController@destroy')->name('patients.delete')->middleware('permission:patients.delete');
		Route::put('/{user:slug}/activar', 'PatientController@activate')->name('patients.activate')->middleware('permission:patients.active');
		Route::put('/{user:slug}/desactivar', 'PatientController@deactivate')->name('patients.deactivate')->middleware('permission:patients.deactive');
	});

	// Appointments
	Route::prefix('citas')->group(function () {
		Route::get('/', 'AppointmentController@index')->name('appointments.index')->middleware('permission:appointments.index');
		Route::get('/registrar', 'AppointmentController@create')->name('appointments.create')->middleware('permission:appointments.create');
		Route::post('/', 'AppointmentController@store')->name('appointments.store')->middleware('permission:appointments.create');
		Route::get('/{appointment:id}', 'AppointmentController@show')->name('appointments.show')->middleware('permission:appointments.show');
		Route::get('/{appointment:id}/editar', 'AppointmentController@edit')->name('appointments.edit')->middleware('permission:appointments.edit');
		Route::put('/{appointment:id}', 'AppointmentController@update')->name('appointments.update')->middleware('permission:appointments.edit');
		Route::delete('/{appointment:id}', 'AppointmentController@destroy')->name('appointments.delete')->middleware('permission:appointments.delete');
		Route::put('/{appointment:id}/cancelar', 'AppointmentController@cancel')->name('appointments.cancel')->middleware('permission:appointments.cancel');

		// Prescriptions
		Route::prefix('{appointment:id}/prescripciones')->group(function () {
			Route::get('/registrar', 'PrescriptionController@create')->name('prescriptions.create')->middleware('permission:appointments.attend');
			Route::post('/', 'PrescriptionController@store')->name('prescriptions.store')->middleware('permission:appointments.attend');
			Route::get('/editar', 'PrescriptionController@edit')->name('prescriptions.edit')->middleware('permission:appointments.edit');
			Route::put('/', 'PrescriptionController@update')->name('prescriptions.update')->middleware('permission:appointments.edit');
			Route::post('/agregar', 'PrescriptionController@prescriptionAdd')->middleware('permission:appointments.attend');
			Route::post('/quitar', 'PrescriptionController@prescriptionRemove')->middleware('permission:appointments.attend');
			Route::post('/editar', 'PrescriptionController@prescriptionUpdate')->middleware('permission:appointments.edit');
			Route::post('/eliminar', 'PrescriptionController@prescriptionDelete')->middleware('permission:appointments.edit');
		});
	});

	// Documents
	Route::prefix('documentos')->group(function () {
		Route::get('/', 'DocumentController@index')->name('documents.index')->middleware('permission:documents.index');
		Route::get('/registrar', 'DocumentController@create')->name('documents.create')->middleware('permission:documents.create');
		Route::post('/', 'DocumentController@store')->name('documents.store')->middleware('permission:documents.create');
		Route::post('/archivo', 'DocumentController@storeFile')->name('documents.files.store')->middleware('permission:documents.create');
		Route::get('/{document:id}', 'DocumentController@show')->name('documents.show')->middleware('permission:documents.show');
		Route::get('/{document:id}/editar', 'DocumentController@edit')->name('documents.edit')->middleware('permission:documents.edit');
		Route::put('/{document:id}', 'DocumentController@update')->name('documents.update')->middleware('permission:documents.edit');
		Route::post('/archivo/editar', 'DocumentController@updateFile')->name('documents.files.update')->middleware('permission:documents.edit');
		Route::post('/archivo/eliminar', 'DocumentController@destroyFile')->name('documents.files.delete')->middleware('permission:documents.edit');
		Route::delete('/{document:id}', 'DocumentController@destroy')->name('documents.delete')->middleware('permission:documents.delete');
	});

	// Specialties
	Route::prefix('especialidades')->group(function () {
		Route::get('/', 'SpecialtyController@index')->name('specialties.index')->middleware('permission:specialties.index');
		Route::get('/registrar', 'SpecialtyController@create')->name('specialties.create')->middleware('permission:specialties.create');
		Route::post('/', 'SpecialtyController@store')->name('specialties.store')->middleware('permission:specialties.create');
		Route::get('/{specialty:slug}/editar', 'SpecialtyController@edit')->name('specialties.edit')->middleware('permission:specialties.edit');
		Route::put('/{specialty:slug}', 'SpecialtyController@update')->name('specialties.update')->middleware('permission:specialties.edit');
		Route::delete('/{specialty:slug}', 'SpecialtyController@destroy')->name('specialties.delete')->middleware('permission:specialties.delete');
		Route::put('/{specialty:slug}/activar', 'SpecialtyController@activate')->name('specialties.activate')->middleware('permission:specialties.active');
		Route::put('/{specialty:slug}/desactivar', 'SpecialtyController@deactivate')->name('specialties.deactivate')->middleware('permission:specialties.deactive');
		Route::get('/doctor', 'SpecialtyController@getSpecialties')->name('specialties.get');
	});

	// Medicines
	Route::prefix('medicinas')->group(function () {
		Route::get('/', 'MedicineController@index')->name('medicines.index')->middleware('permission:medicines.index');
		Route::get('/registrar', 'MedicineController@create')->name('medicines.create')->middleware('permission:medicines.create');
		Route::post('/', 'MedicineController@store')->name('medicines.store')->middleware('permission:medicines.create');
		Route::get('/{medicine:slug}/editar', 'MedicineController@edit')->name('medicines.edit')->middleware('permission:medicines.edit');
		Route::put('/{medicine:slug}', 'MedicineController@update')->name('medicines.update')->middleware('permission:medicines.edit');
		Route::delete('/{medicine:slug}', 'MedicineController@destroy')->name('medicines.delete')->middleware('permission:medicines.delete');
		Route::put('/{medicine:slug}/activar', 'MedicineController@activate')->name('medicines.activate')->middleware('permission:medicines.active');
		Route::put('/{medicine:slug}/desactivar', 'MedicineController@deactivate')->name('medicines.deactivate')->middleware('permission:medicines.deactive');
	});

	// Schedules
	Route::prefix('horarios')->group(function () {
		Route::get('/', 'ScheduleController@index')->name('schedules.index')->middleware('permission:schedules.index');
		Route::get('/registrar', 'ScheduleController@create')->name('schedules.create')->middleware('permission:schedules.create');
		Route::post('/', 'ScheduleController@store')->name('schedules.store')->middleware('permission:schedules.create');
		Route::get('/{schedule:id}/editar', 'ScheduleController@edit')->name('schedules.edit')->middleware('permission:schedules.edit');
		Route::put('/{schedule:id}', 'ScheduleController@update')->name('schedules.update')->middleware('permission:schedules.edit');
		Route::delete('/{schedule:id}', 'ScheduleController@destroy')->name('schedules.delete')->middleware('permission:schedules.delete');
		Route::put('/{schedule:id}/activar', 'ScheduleController@activate')->name('schedules.activate')->middleware('permission:schedules.active');
		Route::put('/{schedule:id}/desactivar', 'ScheduleController@deactivate')->name('schedules.deactivate')->middleware('permission:schedules.deactive');
		Route::get('/disponible', 'ScheduleController@getSchedules')->name('schedules.get');
	});

	// Locations
	Route::prefix('locaciones')->group(function () {
		Route::get('/', 'LocationController@index')->name('locations.index')->middleware('permission:locations.index');
		Route::get('/registrar', 'LocationController@create')->name('locations.create')->middleware('permission:locations.create');
		Route::post('/', 'LocationController@store')->name('locations.store')->middleware('permission:locations.create');
		Route::get('/{location:slug}/editar', 'LocationController@edit')->name('locations.edit')->middleware('permission:locations.edit');
		Route::put('/{location:slug}', 'LocationController@update')->name('locations.update')->middleware('permission:locations.edit');
		Route::delete('/{location:slug}', 'LocationController@destroy')->name('locations.delete')->middleware('permission:locations.delete');
		Route::put('/{location:slug}/activar', 'LocationController@activate')->name('locations.activate')->middleware('permission:locations.active');
		Route::put('/{location:slug}/desactivar', 'LocationController@deactivate')->name('locations.deactivate')->middleware('permission:locations.deactive');
	});

	// Roles
	Route::prefix('roles')->group(function () {
		Route::get('/', 'RoleController@index')->name('roles.index')->middleware('permission:roles.index');
		Route::get('/registrar', 'RoleController@create')->name('roles.create')->middleware('permission:roles.create');
		Route::post('/', 'RoleController@store')->name('roles.store')->middleware('permission:roles.create');
		Route::get('/{role:id}/editar', 'RoleController@edit')->name('roles.edit')->middleware('permission:roles.edit');
		Route::put('/{role:id}', 'RoleController@update')->name('roles.update')->middleware('permission:roles.edit');
		Route::delete('/{role:id}', 'RoleController@destroy')->name('roles.delete')->middleware('permission:roles.delete');
		Route::put('/{role:id}/permisos', 'RoleController@permissions')->name('roles.permissions')->middleware('permission:roles.permissions');
	});

	// Statistics
	Route::prefix('estadisticas')->group(function () {
		Route::get('/', 'StatisticController@index')->name('statistics.index')->middleware('permission:statistics.index');
	});

	// Settings
	Route::prefix('ajustes')->group(function () {
		Route::get('/editar', 'SettingController@edit')->name('settings.edit')->middleware('permission:settings.edit');
		Route::put('/', 'SettingController@update')->name('settings.update')->middleware('permission:settings.edit');
	});
});