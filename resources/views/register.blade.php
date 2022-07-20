@extends('layout')
@section('title')
    <title>Registro</title>
@endsection
@section('meta')
    <meta name="description" content="Registro">
@endsection
@section('public-content')

<!--Banner Start-->
<div class="banner-area flex" style="background-image:url('uploads/website-images/login-page-banner.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>Registro</h1>
                    <!-- <ul>
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><span>Registro</span></li>
                    </ul> -->
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->

<!--Register Start-->
<div class="register-area pt_70 pb_70">
	<div class="container wow fadeIn">
		<div class="row">
			<div class="offset-lg-3 col-lg-6 offset-lg-3 m-auto">
				<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
					<li class="nav-item" role="presentation">
						<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Usuario</a>
					</li>
				</ul>
				<div class="tab-content" id="pills-tabContent">
					<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
						<div class="regiser-form login-form">
							<form id="regForm">
                                @csrf
								<div class="form-row row">
									<div class="form-group col-12">
										<label for="">Cédula</label>
										<input type="text" class="form-control" name="cedula">
									</div>
									<div class="form-group col-12">
										<label for="">Nombre</label>
										<input type="text" class="form-control" name="name">
									</div>

									<div class="form-group col-12">
										<label for="">Correo</label>
										<input type="email" class="form-control" name="email">
									</div>

									<div class="form-group col-12">
										<label for="">Contraseña</label>
										<input type="password" class="form-control" name="password">
									</div>

									<div class="form-group col-12">
                                        <button type="submit" id="regBtn" class="btn btn-primary"><i id="reg-spinner" class="reg-icon fa fa-spin fa-spinner mr-51 d-none"></i> Registro</button>

									</div>
								</div>
							</form>

                            <p>Si tiene una cuenta <a href="{{ route('login') }}" class="text-danger">Login</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--Register End-->

<script>
    (function($) {
        "use strict";
        $(document).ready(function () {
            $("#regForm").on('submit', function(e){
                e.preventDefault();
					debugger;
                $("#reg-spinner").removeClass('d-none')
                $("#regBtn").attr('disabled',true);

                $.ajax({
                    type: 'POST',
                    data: $('#regForm').serialize(),
                    url: "{{ route('store-register') }}",
                    success: function (response) {
							debugger;
                        if(response.status == 1){
                            toastr.success(response.message)
                            $("#regForm").trigger("reset");
                            $("#reg-spinner").addClass('d-none')
                            $("#regBtn").attr('disabled',false);
                            window.location.href = "{{ route('login')}}";
                        }

                        if(response.status == 0){
                            toastr.error(response.message)
                            $("#reg-spinner").addClass('d-none')
                            $("#regBtn").attr('disabled',false);
                        }
                    },
                    error: function(response) {
							debugger;
                        $("#reg-spinner").addClass('d-none')
                        $("#regBtn").attr('disabled',false);

                        if(response.responseJSON.errors.name)toastr.error(response.responseJSON.errors.name[0])
                        if(response.responseJSON.errors.email)toastr.error(response.responseJSON.errors.email[0])
                        if(response.responseJSON.errors.password)toastr.error(response.responseJSON.errors.password[0])
                    }
                });
            })
        });
    })(jQuery);

</script>
@endsection
