@extends('layout')
@section('title')
<title>Recuperar Contraseña</title>
@endsection
@section('meta')
<meta name="description" content="Recuperar Contraseña">
@endsection
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@section('public-content')


<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ asset('/uploads/website-images/banner-user.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>Recuperar Contraseña</h1>
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
					<form action="{{ route('send-forget-password') }}" method="POST">
                        @csrf
                        <div class="form-row row">
                            <div class="form-group col-12">
                                <label for="">Email</label>
                                <input type="text" class="form-control" required name="email">
                            </div>

                            <button type="submit" class="btn btn-primary mb-2">Enviar</button>
                        </div>
                    </form>

                    <p>Ya tienes una cuenta? <a href="{{ route('login') }}" class="text-danger">Ingresa</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Login End-->

@endsection
