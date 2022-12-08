@extends('layout')
@section('title')
    <title>{{__('user.Register')}}</title>
@endsection
@section('meta')
    <meta name="description" content="{{__('user.Register')}}">
@endsection
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@section('public-content')


<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ asset($banner->image) }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{__('user.Register')}}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><span>{{__('user.Register')}}</span></li>
                    </ul>
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
						<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">{{__('user.Patient')}}</a>
					</li>
					<li class="nav-item" role="presentation">
						<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">{{__('user.Doctor')}} </a>
					</li>
				</ul>
				<div class="tab-content" id="pills-tabContent">
					<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
						<div class="regiser-form login-form">
							<form id="regForm">
                                @csrf
								<div class="form-row row">
									<div class="form-group col-12">
										<label for="">{{__('user.Name')}}</label>
										<input type="text" class="form-control" name="name">
									</div>

									<div class="form-group col-12">
										<label for="">{{__('user.Email')}}</label>
										<input type="email" class="form-control" name="email">
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

									<div class="form-group col-12">
                                        <button type="submit" id="regBtn" class="btn btn-primary"><i id="reg-spinner" class="reg-icon fa fa-spin fa-spinner mr-51 d-none"></i> {{__('user.Register')}}</button>

									</div>
								</div>
							</form>

                            <p>{{__('user.Already have an account?')}} <a href="{{ route('login') }}" class="text-danger">{{__('user.Login here')}}</a></p>
						</div>
					</div>
					<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
						<div class="regiser-form login-form">
							<form id="doctorRegForm">
                                @csrf
								<div class="form-row row">
									<div class="form-group col-12">
										<label for="">{{__('user.Name')}}</label>
										<input type="text" class="form-control" name="name">
									</div>

									<div class="form-group col-12">
										<label for="">{{__('user.Email')}}</label>
										<input type="email" class="form-control" name="email">
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

									<div class="form-group col-12">
                                        <button type="submit" id="docRegBtn" class="btn btn-primary"><i id="doc-reg-spinner" class="reg-icon fa fa-spin fa-spinner mr-51 d-none"></i> {{__('user.Register')}}</button>

									</div>
								</div>
							</form>

                            <p>{{__('user.Already have an account?')}} <a href="{{ route('doctor.login') }}" class="text-danger">{{__('user.Login here')}}</a></p>
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
                var isDemo = "{{ env('APP_VERSION') }}"
                if(isDemo == 0){
                    toastr.error('This Is Demo Version. You Can Not Change Anything');
                    return;
                }

                $("#reg-spinner").removeClass('d-none')
                $("#regBtn").attr('disabled',true);

                $.ajax({
                    type: 'POST',
                    data: $('#regForm').serialize(),
                    url: "{{ route('store-register') }}",
                    success: function (response) {
                        if(response.status == 1){
                            toastr.success(response.message)
                            $("#regForm").trigger("reset");
                            $("#reg-spinner").addClass('d-none')
                            $("#regBtn").attr('disabled',false);
                        }

                        if(response.status == 0){
                            toastr.error(response.message)
                            $("#reg-spinner").addClass('d-none')
                            $("#regBtn").attr('disabled',false);
                        }
                    },
                    error: function(response) {
                        $("#reg-spinner").addClass('d-none')
                        $("#regBtn").attr('disabled',false);

                        if(response.responseJSON.errors.name)toastr.error(response.responseJSON.errors.name[0])
                        if(response.responseJSON.errors.email)toastr.error(response.responseJSON.errors.email[0])
                        if(response.responseJSON.errors.password)toastr.error(response.responseJSON.errors.password[0])

                        if(!response.responseJSON.errors.name || !response.responseJSON.errors.email || !response.responseJSON.errors.password){
                            toastr.error("{{__('user.Please complete the recaptcha to submit the form')}}")
                        }
                    }
                });
            })

            $("#doctorRegForm").on('submit', function(e){
                e.preventDefault();
                var isDemo = "{{ env('APP_VERSION') }}"
                if(isDemo == 0){
                    toastr.error('This Is Demo Version. You Can Not Change Anything');
                    return;
                }

                $("#doc-reg-spinner").removeClass('d-none')
                $("#docRegBtn").attr('disabled',true);

                $.ajax({
                    type: 'POST',
                    data: $('#doctorRegForm').serialize(),
                    url: "{{ route('store-doctor-register') }}",
                    success: function (response) {
                        if(response.status == 1){
                            toastr.success(response.message)
                            $("#doctorRegForm").trigger("reset");
                            $("#doc-reg-spinner").addClass('d-none')
                            $("#docRegBtn").attr('disabled',false);
                        }

                        if(response.status == 0){
                            toastr.error(response.message)
                            $("#doc-reg-spinner").addClass('d-none')
                            $("#docRegBtn").attr('disabled',false);
                        }
                    },
                    error: function(response) {
                        $("#doc-reg-spinner").addClass('d-none')
                        $("#docRegBtn").attr('disabled',false);

                        if(response.responseJSON.errors.name)toastr.error(response.responseJSON.errors.name[0])
                        if(response.responseJSON.errors.email)toastr.error(response.responseJSON.errors.email[0])
                        if(response.responseJSON.errors.password)toastr.error(response.responseJSON.errors.password[0])

                        if(!response.responseJSON.errors.name || !response.responseJSON.errors.email || !response.responseJSON.errors.password){
                            toastr.error("{{__('user.Please complete the recaptcha to submit the form')}}")
                        }
                    }
                });
            })




        });
    })(jQuery);

</script>
@endsection
