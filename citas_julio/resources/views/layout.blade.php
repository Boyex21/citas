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
    <link rel="icon" type="image/png" href="{{ asset('/uploads/website-images/docpoint-favicon.png') }}">

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

    <script src="{{ asset('js/app.js') }}"></script>

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
                $('.datepicker2').datepicker({
                    format: 'yyyy-mm-dd',
                    startDate: '-Infinity'
                });
            });
        })(jQuery);
    </script>
</body>
</html>