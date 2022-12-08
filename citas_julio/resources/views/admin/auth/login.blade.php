<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <title>Ingresar</title>

  <link rel="shortcut icon"  href="{{ asset('/uploads/website-images/docpoint-favicon.png') }}"  type="image/x-icon">

  <link rel="stylesheet" href="{{ asset('backend/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/datatables/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/fontawesome/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/css/bootstrap-social.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/css/components.css') }}">
  <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/css/bootstrap4-toggle.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/css/dev.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/css/prescription.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/css/tagify.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/css/bootstrap-tagsinput.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/css/fontawesome-iconpicker.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/css/bootstrap-datepicker.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/clockpicker/dist/bootstrap-clockpicker.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/datetimepicker/jquery.datetimepicker.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/css/iziToast.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/timepicker/jquery.datetimepicker.min.css') }}">
  <style>
    .fade.in {
      opacity: 1 !important;
    }
  </style>

  <script src="{{ asset('backend/js/jquery-3.6.0.min.js') }}"></script>
  <script src="{{ asset('backend/timepicker/jquery.timepicker.min.js') }}"></script>
  <script src="{{ asset('backend/js/sweetalert2@11.js') }}"></script>
</head>
<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-md-4"></div>
          <div class="col-md-4">
            <div class="login-brand">
              <!-- <img src="{{ asset('/uploads/website-images/docpoint-logo.png') }}" alt="logo" width="150" class="shadow-light"> -->
            </div>

            <div class="card card-primary">
              <div class="card-header">
                <h4>Ingresar</h4>
              </div>

              <div class="card-body">
                <form class="needs-validation" novalidate="" id="adminLoginForm">
                  @csrf

                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email exampleInputEmail" type="email" class="form-control" required name="email" tabindex="1" autofocus value="{{ old('email') }}">
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                    	<label for="password" class="control-label">Contraseña</label>
                      <div class="float-right">
                        <a href="{{ route('admin.forget-password') }}" class="text-small">¿Has olvidado tu contraseña?</a>
                      </div>
                    </div>
                    <input id="password exampleInputPassword" type="password" class="form-control" required name="password" tabindex="2">
                  </div>

                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember" {{ old('remember') ? 'checked' : '' }}>
                      <label class="custom-control-label" for="remember">Recuérdame</label>
                    </div>
                  </div>

                  <div class="form-group">
                    <button id="adminLoginBtn" type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">Ingresar</button>
                  </div>
                </form>

              </div>
            </div>
            <div class="simple-footer">Copyright {{ date('Y') }}. Todos los derechos reservados.</div>
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
            url: "{{ route('admin.login') }}",
            type:"post",
            data:$('#adminLoginForm').serialize(),
            success:function(response){
              if(response.success){
                window.location.href = "{{ route('admin.dashboard')}}";
                toastr.success(response.success)
              }
              if(response.error){
                toastr.error(response.error)
              }
            },
            error:function(response){
              console.log(response);
              if(response.responseJSON.errors.email){
                toastr.error(response.responseJSON.errors.email[0]);
              }
              if(response.responseJSON.errors.password){
                toastr.error(response.responseJSON.errors.password[0]);
              }
            }
          });
        });

        $(document).on('keyup', '#exampleInputEmail, #exampleInputPassword', function (e) {
          if(e.keyCode == 13){
            e.preventDefault();

            $.ajax({
              url: "{{ route('admin.login') }}",
              type:"post",
              data:$('#adminLoginForm').serialize(),
              success:function(response){
                if(response.success){
                  window.location.href = "{{ route('admin.dashboard')}}";
                  toastr.success(response.success)
                }
                if(response.error){
                  toastr.error(response.error)

                }
              },
              error:function(response){
                if(response.responseJSON.errors.email){
                  toastr.error(response.responseJSON.errors.email[0]);
                }
                if(response.responseJSON.errors.password){
                  toastr.error(response.responseJSON.errors.password[0]);
                }
              }
            });
          }
        });
      });

    })(jQuery);
  </script>

  <script src="{{ asset('backend/js/popper.min.js') }}"></script>
  <script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('backend/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('backend/datatables/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('backend/js/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('backend/js/moment.min.js') }}"></script>
  <script src="{{ asset('backend/js/stisla.js') }}"></script>
  <script src="{{ asset('backend/js/scripts.js') }}"></script>
  <script src="{{ asset('backend/js/select2.min.js') }}"></script>
  <script src="{{ asset('backend/js/tagify.js') }}"></script>
  <script src="{{ asset('toastr/toastr.min.js') }}"></script>
  <script src="{{ asset('backend/js/bootstrap4-toggle.min.js') }}"></script>
  <script src="{{ asset('backend/js/fontawesome-iconpicker.min.js') }}"></script>
  <script src="{{ asset('backend/js/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('backend/clockpicker/dist/bootstrap-clockpicker.js') }}"></script>
  <script src="{{ asset('backend/datetimepicker/jquery.datetimepicker.js') }}"></script>
  <script src="{{ asset('backend/js/iziToast.min.js') }}"></script>
  <script src="{{ asset('backend/js/modules-toastr.js') }}"></script>
  <script src="{{ asset('backend/ckeditor4/ckeditor.js') }}"></script>

  <script>
    @if(Session::has('messege'))
    var type="{{Session::get('alert-type','info')}}"
    switch(type){
      case 'info':
      toastr.info("{{ Session::get('messege') }}");
      break;
      case 'success':
      toastr.success("{{ Session::get('messege') }}");
      break;
      case 'warning':
      toastr.warning("{{ Session::get('messege') }}");
      break;
      case 'error':
      toastr.error("{{ Session::get('messege') }}");
      break;
    }
    @endif
  </script>

  @if($errors->any())
  @foreach($errors->all() as $error)
  <script>
    toastr.error('{{ $error }}');
  </script>
  @endforeach
  @endif

  <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>