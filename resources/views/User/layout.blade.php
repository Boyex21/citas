<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <!-- Meta Tags -->
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

    <!-- Title -->
    <title>Citas Médicas</title>
    @yield('meta')

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <!--Header-Area Start-->
    <div class="header-area" id="app">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-12">
                </div>
                <div class="col-xl-9 col-lg-9 col-12">
                    <div class="header-info">
                        <ul>
                            <li>
                                <i class="fa fa-envelope"></i>
                                <span>bayoalfre@gmail.com</span>
                            </li>
                            <li>
                                <i class="fa fa-phone"></i>
                                <span>099 686 3725</span>
                            </li>
                                <li>
                                    <i class="fa fa-user"></i>
                                    <a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Header-Area End-->

    <!--Header-Area Start-->
    <div class="header-area" id="app">
        <div class="container-fluit">
            <div class="row d-flex justify-content-center">
                <div class="col-xl-12 col-lg-12 col-12 text-center">
                    <h4 class="text-white">SISTEMA DE AUTOMATIZACIÓN Y MEJORA DE LOS PROCESOS EN EL HOSPITAL BÁSICO DE LA ZONA EL ORO</h4>
                </div>
            </div>
        </div>
    </div>
    <!--Header-Area End-->

    @yield('public-content')

<!--Footer Start-->
<div class="main-footer">
    <div class="footer-copyrignt">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="copyright-text text-center">
                        <p>Copyright 2022, Bryan Palacios. Todos los derechos reservados.</p>
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
<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
