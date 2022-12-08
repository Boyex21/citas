@extends('layout')
@section('title')
    <title>{{__('user.Login')}}</title>
@endsection
@section('meta')
    <meta name="description" content="{{__('user.Login')}}">
@endsection
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@section('public-content')


<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ asset($banner->image) }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{__('user.Login')}}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><span>{{__('user.Login')}}</span></li>
                    </ul>
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
								<label for="">{{__('user.Email')}}</label>
								<input type="text" class="form-control" name="email">
							</div>
							<div class="form-group col-12">
								<label for="">{{__('user.Password')}}</label>
								<input type="password" class="form-control" name="password">
							</div>

                            @if($recaptchaSetting->status==1)
                                <div class="form-group col-12">
                                    <div class="g-recaptcha" data-sitekey="{{ $recaptchaSetting->site_key }}"></div>
                                </div>
                            @endif

							<button type="submit" class="btn btn-primary mb-2">{{__('user.Login')}}</button>
						</div>
					</form>

                    <a href="{{ route('forget-password') }}" class="mt-2 text-danger">{{__('user.Forget your password ?')}}</a>

                    <p>{{__('user.Don\'t have an account yet?')}} <a href="{{ route('register') }}" class="text-danger">{{__('user.Register here')}}</a></p>



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
                            window.location.href = "{{ route('user.dashboard')}}";
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
