@include('admin.header')
<div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
        <div class="col-md-4"></div>
          <div class="col-md-4">
            <div class="login-brand">
              <img src="{{ asset($setting->logo) }}" alt="logo" width="150" class="shadow-light">
            </div>

            <div class="card card-primary">
              <div class="card-header"><h4>{{__('user.Doctor Login')}}</h4></div>

              <div class="card-body">
                <form class="needs-validation" novalidate="" id="adminLoginForm">
                    @csrf

                  <div class="form-group">
                    <label for="email">{{__('user.Email')}}</label>
                    <input id="email exampleInputEmail" type="email" class="form-control" name="email" tabindex="1" autofocus value="{{ old('email') }}">
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                    	<label for="password" class="control-label">{{__('user.Password')}}</label>
                      <div class="float-right">
                        <a href="{{ route('doctor.forget-password') }}" class="text-small">
                          {{__('user.Forgot Password?')}}
                        </a>
                      </div>
                    </div>
                    <input id="password exampleInputPassword" type="password" class="form-control" name="password" tabindex="2">
                  </div>

                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember" {{ old('remember') ? 'checked' : '' }}>
                      <label class="custom-control-label" for="remember">{{__('user.Remember Me')}}</label>
                    </div>
                  </div>

                  <div class="form-group">
                    <button id="adminLoginBtn" type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      {{__('user.Login')}}
                    </button>
                  </div>
                </form>

              </div>
            </div>
            <div class="simple-footer">
              {{ $setting->copyright }}
            </div>
          </div>
        </div>


      </div>
    </section>
  </div>


<script>
    (function($) {
    "use strict";
    $(document).ready(function () {
        $("#adminLoginBtn").on('click',function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('doctor.login') }}",
                type:"post",
                data:$('#adminLoginForm').serialize(),
                success:function(response){
                    if(response.success){
                        window.location.href = "{{ route('doctor.dashboard')}}";
                        toastr.success(response.success)
                    }
                    if(response.error){
                        toastr.error(response.error)
                    }
                },
                error:function(response){
                    console.log(response);
                    if(response.responseJSON.errors.email)toastr.error(response.responseJSON.errors.email[0])
                    if(response.responseJSON.errors.password)toastr.error(response.responseJSON.errors.password[0])
                }
            });
        })
    });

    })(jQuery);
</script>

@include('admin.footer')


