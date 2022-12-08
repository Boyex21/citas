@extends('layout')

@section('title')
<title>Ingresar</title>
@endsection

@section('meta')
<meta name="description" content="Ingresar">
@endsection

@section('public-content')

<!--Banner Start-->
<div class="banner-area flex" style="background-image: url({{ asset('/uploads/website-images/banner-user.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>Ingresar | Hospital Básico de la zona el Oro</h1>
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
                                <label for="">Email</label>
                                <input type="text" class="form-control" required name="email">
                            </div>

                            <div class="form-group col-12">
                                <label for="">Contraseña</label>
                                <input type="password" class="form-control" required name="password">
                            </div>

                            <button type="submit" class="btn btn-primary mb-2">Ingresar</button>
                        </div>
                    </form>

                    <a href="{{ route('forget-password') }}" class="mt-2 text-danger">Olvidaste tu contraseña?</a>

                    <p>¿Aún no tienes una cuenta? <a href="{{ route('register') }}" class="text-danger">Registrarse aquí</a></p>
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
                        if(response.status==1){
                            toastr.success(response.message);
                            $("#loginForm").trigger("reset");
                            window.location.href="{{ route('user.dashboard') }}";
                        }

                        if(response.status==0){
                            toastr.error(response.message);
                        }
                    },
                    error: function(response) {
                        if(response.responseJSON.errors.email) {
                            toastr.error(response.responseJSON.errors.email[0]);
                        }
                        if(response.responseJSON.errors.password) {
                            toastr.error(response.responseJSON.errors.password[0]);  
                        }
                    }
                });
            });
        });
    })(jQuery);
</script>

@endsection
