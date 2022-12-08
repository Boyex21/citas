@php
    $setting = App\Models\Setting::first();
    $customPages = App\Models\CustomPage::where('status',1)->get();
    $googleAnalytic = App\Models\GoogleAnalytic::first();
    $facebookPixel = App\Models\FacebookPixel::first();
    $socialLinks = App\Models\FooterSocialLink::get();
    $menus = App\Models\MenuVisibility::all();
@endphp


<!DOCTYPE html>
@if ($setting->text_direction == 'rtl')
<html class="no-js" lang="en" dir="rtl">
@else
<html class="no-js" lang="en">
@endif
<head>

<head>
    <!-- Meta Tags -->
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

    <!-- Title -->
    @yield('title')
    @yield('meta')

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset($setting->favicon) }}">

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

    @if ($setting->text_direction == 'rtl')
    <link rel="stylesheet" href="{{ asset('user/css/rtl.css') }}">
    @endif




    <script src="{{ asset('user/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('backend/js/sweetalert2@11.js') }}"></script>

    @if ($googleAnalytic->status == 1)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleAnalytic->analytic_id }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $googleAnalytic->analytic_id }}');
    </script>
    @endif

    @if ($facebookPixel->status == 1)
        <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{ $facebookPixel->app_id }}');
        fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" "display:none"
        src="https://www.facebook.com/tr?id={{ $facebookPixel->app_id }}&ev=PageView&noscript=1"
    /></noscript>
    @endif


    @include('theme_style')

</head>

<body>

    @php
        $menu = $menus->where('id', 29)->first();
    @endphp
    @if ($menu->status == 1)
    <!--Header-Area Start-->
    <div class="header-area" id="app">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-12">
                    <div class="header-social">
                        <ul>
                            <li>
                                <div class="social-bar">
                                    <ul>
                                        @foreach ($socialLinks as $socialLink)
                                        <li><a href="{{ $socialLink->link }}"><i class="{{ $socialLink->icon }}"></i></a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-9 col-12">
                    <div class="header-info">
                        <ul>
                            <li>
                                <i class="fa fa-envelope"></i>
                                <span>{{ $setting->topbar_email }}</span>
                            </li>
                            <li>
                                <i class="fa fa-phone"></i>
                                <span>{{ $setting->topbar_phone }}</span>
                            </li>

                            @php
                            $menu = $menus->where('id', 18)->first();
                            @endphp
                            @if ($menu->status == 1)
                                @auth
                                <li>
                                    <i class="fa fa-user"></i>
                                    <a href="{{ route('user.dashboard') }}">{{__('user.Dashboard')}}</a>
                                </li>
                                @else
                                <li>
                                    <i class="fa fa-lock"></i>
                                    <a href="{{ route('login') }}">{{__('user.Login')}}</a> / <a href="{{ route('register') }}">{{__('user.Register')}}</a>
                                </li>
                                @endauth
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Header-Area End-->
    @endif

    <!--Menu Start-->
    <div id="strickymenu" class="menu-area">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6">
                    <div class="logo flex">
                        <a href="{{ route('home') }}"><img src="{{ asset($setting->logo) }}" alt="Logo"></a>
                    </div>
                </div>
                <div class="col-md-9 col-6">
                    <div class="main-menu">
                        <ul class="nav-menu">
                            @php
                            $menu = $menus->where('id', 1)->first();
                            @endphp
                            @if ($menu->status == 1)
                            <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                            @endif

                            @php
                            $menu = $menus->where('id', 8)->first();
                            @endphp
                            @if ($menu->status == 1)
                            <li><a href="{{ route('about-us') }}">{{__('user.About Us')}}</a></li>
                            @endif

                            @php
                            $menu = $menus->where('id', 27)->first();
                            @endphp
                            @if ($menu->status == 1)
                            <li><a href="{{ route('pricing-plan') }}">{{__('user.Pricing Plan')}}</a></li>
                            @endif

                            @php
                            $menu = $menus->where('id', 28)->first();
                            @endphp
                            @if ($menu->status == 1)
                            <li><a href="{{ route('our-experts') }}">{{__('user.Our Experts')}}</a></li>
                            @endif

                            @php
                            $menu = $menus->where('id', 26)->first();
                            @endphp
                            @if ($menu->status == 1)
                            <li><a href="{{ route('service') }}">{{__('user.Service')}}</a></li>
                            @endif

                            @php
                            $menu = $menus->where('id', 5)->first();
                            @endphp
                            @if ($menu->status == 1)
                            <li><a href="{{ route('blog') }}">{{__('user.Blog')}}</a></li>
                            @endif

                            @php
                            $menu = $menus->where('id', 7)->first();
                            @endphp
                            @if ($menu->status == 1)

                            <li class="menu-item-has-children"><a href="javascript:;">{{__('user.Pages')}}</a>
                                <ul class="sub-menu">
                                    @php
                                    $menu = $menus->where('id', 12)->first();
                                    @endphp
                                    @if ($menu->status == 1)
                                    <li><a href="{{ route('faq') }}">{{__('user.FAQ')}}</a></li>
                                    @endif

                                    @php
                                    $menu = $menus->where('id', 17)->first();
                                    @endphp
                                    @if ($menu->status == 1)
                                    <li><a href="{{ route('testimonial') }}">{{__('user.Testimonial')}}</a></li>
                                    @endif

                                    @foreach ($customPages as $customPage)
                                    <li><a href="{{ route('page', $customPage->slug) }}">{{ $customPage->page_name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>

                            @endif

                            @php
                            $menu = $menus->where('id', 9)->first();
                            @endphp
                            @if ($menu->status == 1)
                            <li><a href="{{ route('contact-us') }}">{{__('user.Contact Us')}}</a></li>
                            @endif
                        </ul>
                    </div>

                    <!--Mobile Menu Icon Start-->
                    <div class="mobile-menuicon">
                        <span class="menu-bar" onclick="openNav()"><i class="fa fa-bars" aria-hidden="true"></i></span>
                    </div>
                    <!--Mobile Menu Icon End-->
                </div>
            </div>
        </div>
    </div>

    <!--Mobile Menu Start-->
    <div class="mobile-menu">
        <div id="mySidenav" class="sidenav">
            <a href="{{ route('home') }}"><img src="{{ asset($setting->logo) }}" alt=""></a>
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

            <ul>

                @php
                $menu = $menus->where('id', 1)->first();
                @endphp
                @if ($menu->status == 1)
                <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                @endif

                @php
                $menu = $menus->where('id', 8)->first();
                @endphp
                @if ($menu->status == 1)
                <li><a href="{{ route('about-us') }}">{{__('user.About Us')}}</a></li>
                @endif

                @php
                $menu = $menus->where('id', 27)->first();
                @endphp
                @if ($menu->status == 1)
                <li><a href="{{ route('pricing-plan') }}">{{__('user.Pricing Plan')}}</a></li>
                @endif

                @php
                $menu = $menus->where('id', 28)->first();
                @endphp
                @if ($menu->status == 1)
                <li><a href="{{ route('our-experts') }}">{{__('user.Our Experts')}}</a></li>
                @endif

                @php
                $menu = $menus->where('id', 26)->first();
                @endphp
                @if ($menu->status == 1)
                <li><a href="{{ route('service') }}">{{__('user.Service')}}</a></li>
                @endif

                @php
                $menu = $menus->where('id', 5)->first();
                @endphp
                @if ($menu->status == 1)
                <li><a href="{{ route('blog') }}">{{__('user.Blog')}}</a></li>
                @endif

                @php
                    $menu = $menus->where('id', 7)->first();
                    @endphp
                    @if ($menu->status == 1)

                    <li class="menu-child"><span>{{__('user.Pages')}}</span>
                        <ul>
                            @php
                            $menu = $menus->where('id', 12)->first();
                            @endphp
                            @if ($menu->status == 1)
                            <li><a href="{{ route('faq') }}">{{__('user.FAQ')}}</a></li>
                            @endif

                            @php
                            $menu = $menus->where('id', 17)->first();
                            @endphp
                            @if ($menu->status == 1)
                            <li><a href="{{ route('testimonial') }}">{{__('user.Testimonial')}}</a></li>
                            @endif

                            @foreach ($customPages as $customPage)
                            <li><a href="{{ route('page', $customPage->slug) }}">{{ $customPage->page_name }}</a></li>
                            @endforeach
                        </ul>
                    </li>

                @endif

                @php
                $menu = $menus->where('id', 9)->first();
                @endphp
                @if ($menu->status == 1)
                <li><a href="{{ route('contact-us') }}">{{__('user.Contact Us')}}</a></li>
                @endif
            </ul>

            <div class="footer-social pl_5">
                @foreach ($socialLinks as $socialLink)
                <a href="{{ $socialLink->link }}"><i class="{{ $socialLink->icon }}"></i></a>
                @endforeach
            </div>

        </div>
    </div>
    <!--Mobile Menu End-->

    <!--Menu End-->

    @yield('public-content')

@php
    $setting = App\Models\Setting::first();
    $socialLinks = App\Models\FooterSocialLink::get();
    $teams = App\Models\Team::where('status', 1)->get();
    $footer = App\Models\Footer::first();
    $tawk_setting = App\Models\TawkChat::first();
    $cookie_consent = App\Models\CookieConsent::first();
    $content = App\Models\HomepageContent::find(5);
    $menus = App\Models\MenuVisibility::all();
    $isRtl = false;
    if($setting->text_direction == 'rtl') $isRtl = true;
@endphp


@if ($cookie_consent->status == 1)
<script src="{{ asset('user/js/cookieconsent.min.js') }}"></script>
<script>
window.addEventListener("load",function(){window.wpcc.init({"border":"{{ $cookie_consent->border }}","corners":"{{ $cookie_consent->corners }}","colors":{"popup":{"background":"{{ $cookie_consent->background_color }}","text":"{{ $cookie_consent->text_color }} !important","border":"{{ $cookie_consent->border_color }}"},"button":{"background":"{{ $cookie_consent->btn_bg_color }}","text":"{{ $cookie_consent->btn_text_color }}"}},"content":{"href":"{{ route('privacy-policy') }}","message":"{{ $cookie_consent->message }}","link":"{{ $cookie_consent->link_text }}","button":"{{ $cookie_consent->btn_text }}"}})});
</script>
@endif

@if ($tawk_setting->status == 1)
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='{{ $tawk_setting->chat_link }}';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
</script>
@endif


<!--Subscribe Start-->
<div class="subscribe-area" style="background-image: url({{ $content->image ? asset($content->image) : '' }})">
    <div class="container">
        <div class="row ov_hd">
            <div class="col-md-12 wow fadeInDown" data-wow-delay="0.1s">
                <div class="main-headline white">
                    <h1>{{ $content->title }}</h1>
                    <p>{{ $content->description }}</p>
                </div>
            </div>
        </div>

        <div class="row ov_hd">
            <div class="col-md-12 wow fadeInUp" data-wow-delay="0.1s">
                <div class="subscribe-form">

                    <form id="subscriberForm">
                        @csrf
                        <input type="text" name="email" placeholder="{{__('user.Email')}}">
                        <button id="SubscribeBtn" type="submit" class="btn-sub"><i id="subscribe-spinner" class="loading-icon fa fa-spin fa-spinner mr-3 d-none"></i> {{__('user.Subscribe')}}</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<!--Subscribe Start-->

<!--Brand-Area Start-->
<div class="brand-area bg-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="brand-carousel owl-carousel">
                    @foreach ($teams as $team)
                    <a href="{{ $team->link }}">
                        <div class="brand-item">
                            <div class="brand-colume">
                                <div class="brand-bg"></div>
                                <img src="{{ asset($team->image) }}" alt="Brand">
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!--Brand-Area End-->

<!--Footer Start-->
<div class="main-footer">
    <div class="footer-area">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="footer-item">
                        <h3>{{__('user.About Us')}}</h3>
                        <div class="textwidget">
                            <p>{{ $footer->about_us }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="footer-item">
                        <h3>{{__('user.Quick Links')}}</h3>
                        <ul>
                            @php
                            $menu = $menus->where('id', 1)->first();
                            @endphp
                            @if ($menu->status == 1)
                            <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                            @endif

                            @php
                            $menu = $menus->where('id', 27)->first();
                            @endphp
                            @if ($menu->status == 1)
                            <li><a href="{{ route('pricing-plan') }}">{{__('user.Pricing Plan')}}</a></li>
                            @endif

                            @php
                            $menu = $menus->where('id', 28)->first();
                            @endphp
                            @if ($menu->status == 1)
                            <li><a href="{{ route('our-experts') }}">{{__('user.Our Experts')}}</a></li>
                            @endif

                            @php
                            $menu = $menus->where('id', 26)->first();
                            @endphp
                            @if ($menu->status == 1)
                            <li><a href="{{ route('service') }}">{{__('user.Service')}}</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="footer-item">
                        <h3>{{__('user.Important Links')}}</h3>
                        <ul>
                            @php
                            $menu = $menus->where('id', 8)->first();
                            @endphp
                            @if ($menu->status == 1)
                            <li><a href="{{ route('about-us') }}">{{__('user.About Us')}}</a></li>
                            @endif

                            @php
                            $menu = $menus->where('id', 14)->first();
                            @endphp
                            @if ($menu->status == 1)
                            <li><a href="{{ route('terms-and-conditions') }}">{{__('user.Terms and Conditions')}}</a></li>
                            @endif

                            @php
                            $menu = $menus->where('id', 13)->first();
                            @endphp
                            @if ($menu->status == 1)
                            <li><a href="{{ route('privacy-policy') }}">{{__('user.Privacy Policy')}}</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="footer-item">
                        <h3>{{__('user.Contact Us')}}</h3>
                        <div class="footer-recent-item">
                            <div class="footer-recent-text">
                                <a href="javascript:;">{{__('user.Address')}}:</a>
                                <div class="footer-post-date">{{ $footer->address }}</div>
                                <a href="javascript:;">{{__('user.Phone')}}:</a>
                                <div class="footer-post-date">{{ $footer->phone }}</div>
                                <a href="javascript:;">{{__('user.Email')}}:</a>
                                <div class="footer-post-date">{{ $footer->email }}</div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-copyrignt">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="copyright-text">
                        <p>{{ $footer->copyright }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="footer-social">
                        @foreach ($socialLinks as $socialLink)
                        <a href="{{ $socialLink->link }}"><i class="{{ $socialLink->icon }}"></i></a>
                        @endforeach
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
    let isRtl = '{{ $isRtl }}';
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
    let activeDoctorId = '';
    function loadChatBox(id){
        $(".seller").removeClass('active');
        $("#seller-list-"+id).addClass('active')
        $("#pending-"+ id).addClass('d-none')
        $("#pending-"+ id).html(0)
        activeDoctorId = id
        $.ajax({
            type:"get",
            url: "{{ url('user/load-chat-box/') }}" + "/" + id,
            success:function(response){
                $("#pills-home").html(response)
                scrollToBottomFunc()
            },
            error:function(err){
            }
        })
    }

    (function($) {
        "use strict";
        $(document).ready(function () {
            $('.datepicker2').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '-Infinity'
        });

            $("#subscriberForm").on('submit', function(e){
                e.preventDefault();
                var isDemo = "{{ env('APP_VERSION') }}"
                if(isDemo == 0){
                    toastr.error('This Is Demo Version. You Can Not Change Anything');
                    return;
                }

                $("#subscribe-spinner").removeClass('d-none')
                $("#SubscribeBtn").addClass('after_subscribe')
                $("#SubscribeBtn").attr('disabled',true);

                $.ajax({
                    type: 'POST',
                    data: $('#subscriberForm').serialize(),
                    url: "{{ route('subscribe-request') }}",
                    success: function (response) {
                        if(response.status == 1){
                            toastr.success(response.message);
                            $("#subscribe-spinner").addClass('d-none')
                            $("#SubscribeBtn").removeClass('after_subscribe')
                            $("#SubscribeBtn").attr('disabled',false);
                            $("#subscriberForm").trigger("reset");
                        }

                        if(response.status == 0){
                            toastr.error(response.message);
                            $("#subscribe-spinner").addClass('d-none')
                            $("#SubscribeBtn").removeClass('after_subscribe')
                            $("#SubscribeBtn").attr('disabled',false);
                        }
                    },
                    error: function(err) {
                        toastr.error('Something went wrong');
                        $("#subscribe-spinner").addClass('d-none')
                        $("#SubscribeBtn").removeClass('after_subscribe')
                        $("#SubscribeBtn").attr('disabled',false);
                    }
                });
            })

        });
    })(jQuery);

    function scrollToBottomFunc() {
        $('.wsus__chat_area_body').animate({
            scrollTop: $('.wsus__chat_area_body').get(0).scrollHeight
        }, 100);
    }
</script>

<?php $debugbar_enabled = config("debugbar.enabled") ?? true; ?>
@if(config("app.debug") == true && $debugbar_enabled)
	<?php
	    $renderer = \Debugbar::getJavascriptRenderer();
	?>
	{!! $renderer->renderHead() !!}
	{!! $renderer->render() !!}
@endif

</body>

</html>
