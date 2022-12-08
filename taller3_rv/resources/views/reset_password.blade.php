@extends('layout')
@section('title')
    <title>{{__('user.Reset Password')}}</title>
@endsection
@section('meta')
    <meta name="description" content="{{__('user.Reset Password')}}">
@endsection
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@section('public-content')


<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ asset($banner->image) }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{__('user.Reset Password')}}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><span>{{__('user.Reset Password')}}</span></li>
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
					<form action="{{ route('store-reset-password',$token) }}" method="POST">
                        @csrf
						<div class="form-row row">
							<div class="form-group col-12">
								<label for="">{{__('user.Email')}}</label>
								<input type="text" class="form-control" name="email" value="{{ $user->email }}" required>
							</div>
							<div class="form-group col-12">
								<label for="">{{__('user.Password')}}</label>
								<input type="password" class="form-control" name="password">
							</div>

                            <div class="form-group col-12">
								<label for="">{{__('user.Confirm Password')}}</label>
								<input id="password-confirm" type="password" class="form-control" name="password_confirmation" tabindex="2">
							</div>



                            @if($recaptchaSetting->status==1)
                                <div class="form-group col-12">
                                    <div class="g-recaptcha" data-sitekey="{{ $recaptchaSetting->site_key }}"></div>
                                </div>
                            @endif

							<button type="submit" class="btn btn-primary mb-2">{{__('user.Login')}}</button>
						</div>
					</form>

                    <a href="{{ route('login') }}" class="text-danger">{{__('user.Go to Login page')}}</a>



				</div>
			</div>
		</div>
	</div>
</div>
<!--Login End-->
@endsection
