$(document).ready(function(){
	// Login
	$("button[action='login']").on("click",function(){
		$("#formLogin").validate({
			rules:
			{
				email: {
					required: true,
					email: true,
					minlength: 5,
					maxlength: 191
				},

				password: {
					required: true,
					minlength: 8,
					maxlength: 40
				}
			},
			submitHandler: function(form) {
				$("button[action='login']").attr('disabled', true);
				form.submit();
			}
		});
	});

	// Register
	$("button[action='register']").on("click",function(){
		$("#formRegister").validate({
			rules:
			{
				name: {
					required: true,
					minlength: 2,
					maxlength: 191
				},

				lastname: {
					required: true,
					minlength: 2,
					maxlength: 191
				},

				email: {
					required: true,
					email: true,
					minlength: 5,
					maxlength: 191,
					remote: {
						url: "/usuarios/email",
						type: "get"
					}
				},

				password: {
					required: true,
					minlength: 8,
					maxlength: 40
				},

				terms: {
					required: true
				}
			},
			messages:
			{
				email: {
					remote: "Este correo ya esta en uso."
				}
			},
			submitHandler: function(form) {
				$("button[action='register']").attr('disabled', true);
				form.submit();
			}
		});
	});

	// Recovery Password
	$("button[action='recovery']").on("click",function(){
		$("#formRecovery").validate({
			rules:
			{
				email: {
					required: true,
					email: true,
					minlength: 5,
					maxlength: 191
				}
			},
			submitHandler: function(form) {
				$("button[action='recovery']").attr('disabled', true);
				form.submit();
			}
		});
	});

	// Reset Password
	$("button[action='reset']").on("click",function(){
		$("#formReset").validate({
			rules:
			{
				email: {
					required: true,
					email: true,
					minlength: 5,
					maxlength: 191
				},

				password: {
					required: true,
					minlength: 8,
					maxlength: 40
				},

				password_confirmation: { 
					equalTo: "#password",
					minlength: 8,
					maxlength: 40
				}
			},
			submitHandler: function(form) {
				$("button[action='reset']").attr('disabled', true);
				form.submit();
			}
		});
	});

	// Profile
	$("button[action='profile']").on("click",function(){
		$("#formProfile").validate({
			rules:
			{
				name: {
					required: true,
					minlength: 2,
					maxlength: 191
				},

				lastname: {
					required: true,
					minlength: 2,
					maxlength: 191
				},

				phone: {
					required: true,
					minlength: 5,
					maxlength: 15
				},

				password: {
					required: false,
					minlength: 8,
					maxlength: 40
				},

				password_confirmation: { 
					equalTo: "#password",
					minlength: 8,
					maxlength: 40
				}
			},
			submitHandler: function(form) {
				$("button[action='profile']").attr('disabled', true);
				form.submit();
			}
		});
	});

	// Administrators
	$("button[action='user']").on("click",function(){
		$("#formUser").validate({
			rules:
			{
				name: {
					required: true,
					minlength: 2,
					maxlength: 191
				},

				lastname: {
					required: true,
					minlength: 2,
					maxlength: 191
				},

				email: {
					required: true,
					email: true,
					minlength: 5,
					maxlength: 191,
					remote: {
						url: "/usuarios/email",
						type: "get"
					}
				},

				phone: {
					required: true,
					minlength: 5,
					maxlength: 15
				},

				type: {
					required: true
				},

				state: {
					required: true
				},

				password: {
					required: true,
					minlength: 8,
					maxlength: 40
				},

				password_confirmation: { 
					equalTo: "#password",
					minlength: 8,
					maxlength: 40
				}
			},
			messages:
			{
				email: {
					remote: "Este correo ya esta en uso."
				},

				type: {
					required: 'Seleccione una opción.'
				},

				state: {
					required: 'Seleccione una opción.'
				}
			},
			submitHandler: function(form) {
				$("button[action='user']").attr('disabled', true);
				form.submit();
			}
		});
	});

	// Doctors
	$("button[action='doctor']").on("click",function(){
		$("#formDoctor").validate({
			rules:
			{
				name: {
					required: true,
					minlength: 2,
					maxlength: 191
				},

				lastname: {
					required: true,
					minlength: 2,
					maxlength: 191
				},

				email: {
					required: true,
					email: true,
					minlength: 5,
					maxlength: 191,
					remote: {
						url: "/usuarios/email",
						type: "get"
					}
				},

				phone: {
					required: true,
					minlength: 5,
					maxlength: 15
				},

				address: {
					required: true,
					minlength: 2,
					maxlength: 191
				},

				location_id: {
					required: true
				},

				'specialty_id[]': {
					required: true
				},

				state: {
					required: true
				},

				password: {
					required: true,
					minlength: 8,
					maxlength: 40
				},

				password_confirmation: { 
					equalTo: "#password",
					minlength: 8,
					maxlength: 40
				}
			},
			messages:
			{
				email: {
					remote: "Este correo ya esta en uso."
				},

				location_id: {
					required: 'Seleccione una opción.'
				},

				'specialty_id[]': {
					required: 'Seleccione una opción.'
				},

				state: {
					required: 'Seleccione una opción.'
				}
			},
			submitHandler: function(form) {
				$("button[action='doctor']").attr('disabled', true);
				form.submit();
			}
		});
	});

	// Secretaries
	$("button[action='secretary']").on("click",function(){
		$("#formSecretary").validate({
			rules:
			{
				name: {
					required: true,
					minlength: 2,
					maxlength: 191
				},

				lastname: {
					required: true,
					minlength: 2,
					maxlength: 191
				},

				email: {
					required: true,
					email: true,
					minlength: 5,
					maxlength: 191,
					remote: {
						url: "/usuarios/email",
						type: "get"
					}
				},

				phone: {
					required: true,
					minlength: 5,
					maxlength: 15
				},

				address: {
					required: true,
					minlength: 2,
					maxlength: 191
				},

				location_id: {
					required: true
				},

				state: {
					required: true
				},

				password: {
					required: true,
					minlength: 8,
					maxlength: 40
				},

				password_confirmation: { 
					equalTo: "#password",
					minlength: 8,
					maxlength: 40
				}
			},
			messages:
			{
				email: {
					remote: "Este correo ya esta en uso."
				},

				location_id: {
					required: 'Seleccione una opción.'
				},

				state: {
					required: 'Seleccione una opción.'
				}
			},
			submitHandler: function(form) {
				$("button[action='secretary']").attr('disabled', true);
				form.submit();
			}
		});
	});

	// Patients
	$("button[action='patient']").on("click",function(){
		$("#formPatient").validate({
			rules:
			{
				name: {
					required: true,
					minlength: 2,
					maxlength: 191
				},

				lastname: {
					required: true,
					minlength: 2,
					maxlength: 191
				},

				email: {
					required: true,
					email: true,
					minlength: 5,
					maxlength: 191,
					remote: {
						url: "/usuarios/email",
						type: "get"
					}
				},

				phone: {
					required: true,
					minlength: 5,
					maxlength: 15
				},

				address: {
					required: true,
					minlength: 2,
					maxlength: 191
				},

				location_id: {
					required: true
				},

				state: {
					required: true
				},

				password: {
					required: true,
					minlength: 8,
					maxlength: 40
				},

				password_confirmation: { 
					equalTo: "#password",
					minlength: 8,
					maxlength: 40
				}
			},
			messages:
			{
				email: {
					remote: "Este correo ya esta en uso."
				},

				location_id: {
					required: 'Seleccione una opción.'
				},

				state: {
					required: 'Seleccione una opción.'
				}
			},
			submitHandler: function(form) {
				$("button[action='patient']").attr('disabled', true);
				form.submit();
			}
		});
	});

	// Appointments
	$("button[action='appointment']").on("click",function(){
		$("#formAppointment").validate({
			rules:
			{
				doctor_id: {
					required: true
				},

				patient_id: {
					required: true
				},

				day: {
					required: true
				},

				date: {
					required: true,
					date: false,
					time: false
				},

				schedule_id: {
					required: true
				},

				type: {
					required: true
				}
			},
			messages:
			{
				doctor_id: {
					required: 'Seleccione una opción.'
				},

				patient_id: {
					required: 'Seleccione una opción.'
				},

				day: {
					required: 'Seleccione una opción.'
				},

				date: {
					required: 'Seleccione una fecha.'
				},

				schedule_id: {
					required: 'Seleccione una opción.'
				},

				type: {
					required: 'Seleccione una opción.'
				}
			},
			submitHandler: function(form) {
				$("button[action='appointment']").attr('disabled', true);
				form.submit();
			}
		});
	});

	// Documents
	$("button[action='document']").on("click",function(){
		$("#formDocument").validate({
			rules:
			{
				doctor_id: {
					required: true
				},

				description: {
					required: true,
					minlength: 2,
					maxlength: 1000
				},

				'files[]': {
					required: true
				}
			},
			messages:
			{
				doctor_id: {
					required: 'Seleccione una opción.'
				},

				'files[]': {
					required: 'Seleccione un archivo.'
				}
			},
			submitHandler: function(form) {
				$("button[action='document']").attr('disabled', true);
				form.submit();
			}
		});
	});

	// Specialties
	$("button[action='specialty']").on("click",function(){
		$("#formSpecialty").validate({
			rules:
			{
				name: {
					required: true,
					minlength: 2,
					maxlength: 191
				}
			},
			submitHandler: function(form) {
				$("button[action='specialty']").attr('disabled', true);
				form.submit();
			}
		});
	});

	// Departments
	$("button[action='department']").on("click",function(){
		$("#formDepartment").validate({
			rules:
			{
				name: {
					required: true,
					minlength: 2,
					maxlength: 191
				}
			},
			submitHandler: function(form) {
				$("button[action='department']").attr('disabled', true);
				form.submit();
			}
		});
	});

	// Medicines
	$("button[action='medicine']").on("click",function(){
		$("#formMedicine").validate({
			rules:
			{
				name: {
					required: true,
					minlength: 2,
					maxlength: 191
				}
			},
			submitHandler: function(form) {
				$("button[action='medicine']").attr('disabled', true);
				form.submit();
			}
		});
	});

	// Schedules
	$("button[action='schedule']").on("click",function(){
		$("#formSchedule").validate({
			rules:
			{
				day: {
					required: true
				},

				start: {
					required: true,
					date: false,
					time: false
				},

				end: {
					required: true,
					date: false,
					time: false
				},

				appointment_limit: {
					required: true,
					min: 1,
					max: 100
				}
			},
			messages:
			{
				day: {
					required: 'Seleccione una opción.'
				},

				start: {
					required: 'Seleccione una hora.'
				},

				end: {
					required: 'Seleccione una hora.'
				}
			},
			submitHandler: function(form) {
				$("button[action='schedule']").attr('disabled', true);
				form.submit();
			}
		});
	});

	// Locations
	$("button[action='location']").on("click",function(){
		$("#formLocation").validate({
			rules:
			{
				name: {
					required: true,
					minlength: 2,
					maxlength: 191
				}
			},
			submitHandler: function(form) {
				$("button[action='location']").attr('disabled', true);
				form.submit();
			}
		});
	});

	// Roles
	$("button[action='role']").on("click",function(){
		$("#formRole, #formPermissionRole").validate({
			rules:
			{
				name: {
					required: true,
					minlength: 2,
					maxlength: 191
				},

				'permission_id[]': {
					required: true
				}
			},
			messages:
			{
				'permission_id[]': {
					required: 'Seleccione una opción.'
				}
			},
			submitHandler: function(form) {
				$("button[action='role']").attr('disabled', true);
				form.submit();
			}
		});
	});

	// Settings
	$("button[action='setting']").on("click",function(){
		$("#formSetting").validate({
			rules:
			{
				name: {
					required: true,
					minlength: 2,
					maxlength: 191
				},

				logo: {
					required: false
				},

				favicon: {
					required: false
				},

				enable_register: {
					required: true
				}
			},
			messages:
			{
				logo: {
					required: 'Seleccione una imagen.'
				},

				favicon: {
					required: 'Seleccione una imagen.'
				},

				enable_register: {
					required: 'Seleccione una opción.'
				}
			},
			submitHandler: function(form) {
				$("button[action='setting']").attr('disabled', true);
				form.submit();
			}
		});
	});
});