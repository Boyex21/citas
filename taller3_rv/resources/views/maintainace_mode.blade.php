@php
    $setting = App\Models\Setting::first();
    $maintainance = App\Models\MaintainanceText::first();
@endphp

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi" />
          @yield('title')
          @yield('meta')
          <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
          <link rel="icon" type="image/png" href="{{ asset($setting->favicon) }}">
          <link rel="stylesheet" href="{{ asset('user/css/all.min.css') }}">
          <link rel="stylesheet" href="{{ asset('user/css/bootstrap.min.css') }}">
          <link rel="stylesheet" href="{{ asset('user/css/spacing.css') }}">
          <link rel="stylesheet" href="{{ asset('user/css/slick.css') }}">
          <link rel="stylesheet" href="{{ asset('user/css/select2.min.css') }}">
          <link rel="stylesheet" href="{{ asset('user/css/venobox.min.css') }}">
          <link rel="stylesheet" href="{{ asset('user/css/style.css') }}">
          <link rel="stylesheet" href="{{ asset('user/css/responsive.css') }}">

          <!--jquery library js-->
          <script src="{{ asset('user/js/jquery-3.6.0.min.js') }}"></script>
      </head>


<body>


    <section class="wsus__404">
        <div class="container">
          <div class="row">
            <div class="col-xl-8 m-auto">
              <div class="wsus__404_text">
                <img width="200px" src="{{ asset($maintainance->image) }}" alt="">
                <p>{!! clean(nl2br($maintainance->description)) !!}</p>

              </div>
            </div>
          </div>
        </div>
      </section>

    <!--bootstrap js-->
    <script src="{{ asset('user/js/bootstrap.bundle.min.js') }}"></script>
    <!--font-awesome js-->
    <script src="{{ asset('user/js/Font-Awesome.js') }}"></script>
    <!--slick slider js-->
    <script src="{{ asset('user/js/slick.min.js') }}"></script>
    <!--counter js-->
    <script src="{{ asset('user/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('user/js/jquery.countup.min.js') }}"></script>
    <!--isotop js-->
    <script src="{{ asset('user/js/isotope.pkgd.min.js') }}"></script>
    <!--sticky sidebar js-->
    <script src="{{ asset('user/js/sticky_sidebar.js') }}"></script>
    <!--select2 js-->
    <script src="{{ asset('user/js/select2.min.js') }}"></script>
    <!--simply Countdown js-->
    <script src="{{ asset('user/js/simplyCountdown.js') }}"></script>
    <!--venobox js-->
    <script src="{{ asset('user/js/venobox.min.js') }}"></script>

    <!--main/custom js-->
    <script src="{{ asset('user/js/main.js') }}"></script>
</body>

</html>
