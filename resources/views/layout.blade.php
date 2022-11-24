<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <!-- Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    @yield('title')
    @yield('meta')

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset($setting->favicon) }}">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('user/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/swiper-bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/datatable.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/prescription.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/venobox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/spacing.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/bootstrap-datepicker.min.css') }}">

    <!--  FUNCION EXTRA PARA EL USUARIO -->
    <link rel="stylesheet" href="{{ asset('backend/uploader/jquery.dm-uploader.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/uploader/styles.css') }}">
    
    <script src="{{ asset('user/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('backend/js/sweetalert2@11.js') }}"></script>
</head>
<body>
    @yield('public-content')

    <!--Footer Start-->
    <div class="main-footer">
        <div class="footer-copyrignt">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="copyright-text">
                            <p class="text-center mb-0">Copyright {{ date('Y') }}. Todos los Derechos Reservados.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Footer End-->

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

    <!--Js-->
    <script src="{{ asset('user/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('user/js/popper.min.js') }}"></script>
    <script src="{{ asset('user/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('user/js/jquery.collapse.js') }}"></script>
    <script src="{{ asset('user/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('user/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('user/js/swiper-bundle.js') }}"></script>
    <script src="{{ asset('user/js/select2.min.js') }}"></script>
    <script src="{{ asset('user/js/wow.min.js') }}"></script>
    <script src="{{ asset('user/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('user/js/waypoints.min.js') }}"></script>
    <script src="{{ asset('user/js/venobox.min.js') }}"></script>
    <script src="{{ asset('user/js/slick.min.js') }}"></script>
    <script src="{{ asset('user/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('user/js/viewportchecker.js') }}"></script>
    <script src="{{ asset('user/js/custom.js') }}"></script>
    <script src="{{ asset('backend/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('backend/uploader/jquery.dm-uploader.min.js') }}"></script>
    <script src="{{ asset('toastr/toastr.min.js') }}"></script>

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

    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <script>
        toastr.error('{{ $error }}');
    </script>
    @endforeach
    @endif

    <script>
        //Search
        function openSearch() {
            document.getElementById("myOverlay").style.display = "block";
        }

        function closeSearch() {
            document.getElementById("myOverlay").style.display = "none";
        }

        //Mobile Menu
        function openNav() {
            document.getElementById("mySidenav").style.width = "100%";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }
    </script>

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

 // FUNCION EXTRA PARA EL USUARIO

                if ($('#documents-files').length) {
                    $('#documents-files').dmUploader({
                        url: '{{ route('user.documents.store.files') }}',
                        maxFileSize: 20000000,
                        allowedTypes: "*",
                        extFilter: ["jpg", "jpeg", "png", "webp", "pdf"],
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        onDragEnter: function(){
                            this.addClass('active');
                        },
                        onDragLeave: function(){
                            this.removeClass('active');
                        },
                        onBeforeUpload: function(){
                            $('button[type="submit"]').attr('disabled', true);
                            $("#response").text('Subiendo Archivo...');
                        },
                        onUploadSuccess: function(id, data){
                            var obj=data;

                            if (obj.status) {
                                $("#files").append($('<div>', {
                                    'class': 'form-group col-lg-3 col-md-3 col-sm-6 col-12',
                                    'element': id
                                }).append($('<div>', {
                                    'class': 'card'
                                }).append($('<div>', {
                                    'class': 'card-body p-2'
                                }).append($('<i>', {
                                    'class': 'fa fa-2x fa-file mb-2'
                                })).append($('<p>', {
                                    'text': obj.name,
                                    'class': 'text-truncate mb-0'
                                }))).append($('<input>', {
                                    'type': 'hidden',
                                    'name': 'files[]',
                                    'value': obj.name
                                })).append($('<button>', {
                                    'type': 'button',
                                    'class': 'btn btn-danger btn-absolute-right',
                                    'file': id,
                                    'urlFile': '/uploads/documents/'+obj.name,
                                    'onclick': 'deleteFileCreate("'+id+'");'
                                }).append('<i class="fa fa-trash">'))));

                                $('button[type="submit"]').attr('disabled', false);
                                $("#response").text('Correcto');
                            } else {
                                $('button[type="submit"]').attr('disabled', false);
                                $("#response").text('Error');
                            }
                        },
                        onUploadError: function(id, xhr, status, message){  
                            $('button[type="submit"]').attr('disabled', false);
                            $("#response").text('Error');
                        },
                        onFileSizeError: function(file){
                            $('button[type="submit"]').attr('disabled', false);
                            $("#response").text('El archivo \'' + file.name + '\' excede el tamaño máximo permitido.');
                        }
                    });
                }
                if ($('#document-files-edit').length) {
                    $('#document-files-edit').dmUploader({
                        url: '{{ route('user.documents.edit.files') }}',
                        maxFileSize: 20000000,
                        allowedTypes: "*",
                        extFilter: ["jpg", "jpeg", "png", "webp", "pdf"],
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        extraData: function() {
                            return {
                                "id": $('#id').val()
                            };
                        },
                        onDragEnter: function(){
                            this.addClass('active');
                        },
                        onDragLeave: function(){
                            this.removeClass('active');
                        },
                        onBeforeUpload: function(){
                            $('button[type="submit"]').attr('disabled', true);
                            $("#response").text('Subiendo Archivo...');
                        },
                        onUploadSuccess: function(id, data){
                            var obj=data;

                            if (obj.status) {
                                $("#files").append($('<div>', {
                                    'class': 'form-group col-lg-3 col-md-3 col-sm-6 col-12',
                                    'element': id
                                }).append($('<div>', {
                                    'class': 'card'
                                }).append($('<div>', {
                                    'class': 'card-body p-2'
                                }).append($('<i>', {
                                    'class': 'fa fa-2x fa-file mb-2'
                                })).append($('<p>', {
                                    'text': obj.name,
                                    'class': 'text-truncate mb-0'
                                }))).append($('<button>', {
                                    'type': 'button',
                                    'class': 'btn btn-danger btn-absolute-right removeFile',
                                    'file': id,
                                    'urlFile': obj.url
                                }).append('<i class="fa fa-trash">'))));
                                $('button[type="submit"]').attr('disabled', false);
                                $("#response").text('Correcto');
                                Lobibox.notify('success', {
                                    title: 'Registro exitoso',
                                    sound: true,
                                    msg: 'El archivo ha sido agregado exitosamente.'
                                });

                                // Function to delete files
                                $('.removeFile').on('click', function(event) {
                                    removeFile($(this), event);
                                });
                            } else {
                                $('button[type="submit"]').attr('disabled', false);
                                $("#response").text('Error');
                                Lobibox.notify('error', {
                                    title: 'Registro Fallido',
                                    sound: true,
                                    msg: 'Ha ocurrido un problema, intentelo nuevamente.'
                                });
                            }
                        },
                        onUploadError: function(id, xhr, status, message){  
                            $('button[type="submit"]').attr('disabled', false);
                            $("#response").text('Error');
                            Lobibox.notify('error', {
                                title: 'Registro Fallido',
                                sound: true,
                                msg: 'Ha ocurrido un problema, intentelo nuevamente.'
                            });
                        },
                        onFileSizeError: function(file){
                            $('button[type="submit"]').attr('disabled', false);
                            $("#response").text('El archivo \'' + file.name + '\' excede el tamaño máximo permitido.');
                        }
                    });
                }
            });
        })(jQuery);
    </script>
</body>
</html>