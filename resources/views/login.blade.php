@extends('layout')
@section('title')
    <title>{{__('user.Login')}}</title>
@endsection
@section('meta')
    <meta name="description" content="{{__('user.Login')}}">
@endsection
@section('public-content')

<!--Banner Start-->
<div class="banner-area flex" style="background-image:url('uploads/website-images/login-page-banner.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <div class="col-2"><h1>Login</h1></div>
                    <!-- <div class="col-2"><ul><li><a href="{{ route('login') }}">Login</a></li></ul></div> -->
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->

<!--Login Start-->
<div class="login-area pt_70 pb_70">
	<div class="container">
		<div class="row">
			<div class="col-xl-5 m-auto">
				<div class="login-form">
					<form id="loginForm">
                        @csrf
						<div class="form-row row">
							<div class="form-group col-12">
								<label for="">Usuario o Correo</label>
								<input type="text" class="form-control" name="email">
							</div>
							<div class="form-group col-12">
								<label for="">Contraseña</label>
								<input type="password" class="form-control" name="password">
							</div>
							<button type="submit" class="btn btn-primary mb-2">Entrar</button>
						</div>
					</form>
                    <a href="" class="mt-2 text-primary">Recuperar contraseña</a>
                    <p>No tiene usuario? <a href="" class="text-primary">Registrese</a></p>
				</div>
			</div>
		</div>
	</div>
</div>
<!--Login End-->

<script>
(function($) {
        "use strict";
        $(document).ready(function () {
            $("#loginForm").on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    data: $('#loginForm').serialize(),
                    url: "{{ route('store-login') }}",
                    success: function (response) {
                        if(response.status == 1){
                            toastr.success(response.message)
                            $("#loginForm").trigger("reset");
                            window.location.href = "{{ route('dashboard')}}";
                        }

                        if(response.status == 0){
                            toastr.error(response.message)
                        }
                    },
                    error: function(response) {
                        if(response.responseJSON.errors.email)toastr.error(response.responseJSON.errors.email[0])
                        if(response.responseJSON.errors.password)toastr.error(response.responseJSON.errors.password[0])

                        if(!response.responseJSON.errors.email || !response.responseJSON.errors.password){
                            toastr.error("{{__('user.Please complete the recaptcha to submit the form')}}")
                        }
                    }
                });

            })
        });
    })(jQuery);
</script>

@endsection
