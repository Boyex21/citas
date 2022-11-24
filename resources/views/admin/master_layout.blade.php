<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  @yield('title')

  <link rel="shortcut icon"  href="{{ asset($setting->favicon) }}" type="image/x-icon">

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
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none d-none"><i class="fas fa-search"></i></a></li>
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            @if(Auth::guard('admin')->user()->image)
            <img alt="image" src="{{ asset(Auth::guard('admin')->user()->image) }}" class="rounded-circle mr-1">
            @else
            <img alt="image" src="{{ asset('/uploads/website-images/default-avatar.jpg') }}" class="rounded-circle mr-1">
            @endif
            <div class="d-sm-none d-lg-inline-block">{{ Auth::guard('admin')->user()->name }}</div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="{{ route('admin.profile') }}" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Perfil
              </a>

              <div class="dropdown-divider"></div>
              
              <a href="{{ route('admin.logout') }}" class="dropdown-item has-icon text-danger" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
              </a>
              <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </div>
          </li>
        </ul>
      </nav>

      @include('admin.sidebar')

      @yield('admin-content')

      <footer class="main-footer">
        <div class="footer-left">Copyright {{ date('Y') }}. Todos los derechos reservados.</div>
      </footer>
    </div>
  </div>

  <div class="modal fade" tabindex="-1" role="dialog" id="deleteModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmación de Eliminación</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>¿Estás seguro de eliminar este elemento?</p>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <form id="deleteForm" action="" method="POST">
            @csrf
            @method("DELETE")
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Eliminar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

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
  @foreach ($errors->all() as $error)
  <script>
    toastr.error('{{ $error }}');
  </script>
  @endforeach
  @endif
  
  <script>
    (function($) {
      "use strict";
      $(document).ready(function () {
        if ($('#summernote').length) {
          CKEDITOR.replace('summernote');
        }
        if ($('#summernote2').length) {
          CKEDITOR.replace('summernote2');
        }
        if ($('#summernote3').length) {
          CKEDITOR.replace('summernote3');
        }
        if ($('#summernote4').length) {
          CKEDITOR.replace('summernote4');
        }
        if ($('#summernote5').length) {
          CKEDITOR.replace('summernote5');
        }
        if ($('#dataTable').length) {
          $('#dataTable').DataTable({
            "oLanguage": {
              "oPaginate": {
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
              },
              "sInfo": "Resultados del _START_ al _END_ de un total de _TOTAL_ registros",
              "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
              "sSearchPlaceholder": "Buscar...",
              "sLengthMenu": "Mostrar _MENU_ registros",
              "sProcessing":     "Procesando...",
              "sZeroRecords":    "No se encontraron resultados",
              "sEmptyTable":     "Ningún resultado disponible en esta tabla",
              "sInfoEmpty":      "No hay resultados",
              "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
              "sInfoPostFix":    "",
              "sUrl":            "",
              "sInfoThousands":  ",",
              "sLoadingRecords": "Cargando...",
              "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
              }
            }
          });
        }
        if ($('.select2').length) {
          $('.select2').select2();
        }
        if ($('.sub_cat_one').length) {
          $('.sub_cat_one').select2();
        }
        if ($('.tags').length) {
          $('.tags').tagify();
        }
        if ($('.datetimepicker_mask').length) {
          $('.datetimepicker_mask').datetimepicker({
            format: 'Y-m-d H:i:s',
            formatTime: 'H:i:s',
            formatDate: 'Y-m-d',
            step: 5,
          });
        }
        if ($('.custom-icon-picker').length) {
          $('.custom-icon-picker').iconpicker({
            templates: {
              popover: '<div class="iconpicker-popover popover"><div class="arrow"></div>' +
              '<div class="popover-title"></div><div class="popover-content"></div></div>',
              footer: '<div class="popover-footer"></div>',
              buttons: '<button class="iconpicker-btn iconpicker-btn-cancel btn btn-default btn-sm">Cancel</button>' +
              ' <button class="iconpicker-btn iconpicker-btn-accept btn btn-primary btn-sm">Accept</button>',
              search: '<input type="search" class="form-control iconpicker-search" placeholder="Type to filter" />',
              iconpicker: '<div class="iconpicker"><div class="iconpicker-items"></div></div>',
              iconpickerItem: '<a role="button" href="javascript:;" class="iconpicker-item"><i></i></a>'
            }
          });
        }
        if ($('.datepicker').length) {
          $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
          });
        }
        if ($('.datepicker2').length) {
          $('.datepicker2').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '-Infinity'
          });
        }
        if ($('.clockpicker').length) {
          $('.clockpicker').clockpicker();
        }
      });
    })(jQuery);
  </script>
</body>
</html>