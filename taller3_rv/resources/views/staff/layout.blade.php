@php
    $setting = App\Models\Setting::first();
@endphp

@include('admin.header')
<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg custom_click"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none d-none"><i class="fas fa-search"></i></a></li>
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown dropdown-list-toggle"><a target="_blank" href="{{ route('home') }}" class="nav-link nav-link-lg"><i class="fas fa-home"></i> {{__('user.Visit Website')}}</i></a>

          </li>

          @php
              $header_user = Auth::guard('staff')->user();
              $defaultProfile = App\Models\BannerImage::whereId('15')->first();
          @endphp
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
              @if ($header_user ->image)
              <img alt="image" src="{{ asset($header_user ->image) }}" class="rounded-circle mr-1">
              @else
              <img alt="image" src="{{ asset($defaultProfile->image) }}" class="rounded-circle mr-1">
              @endif
            <div class="d-sm-none d-lg-inline-block">{{ $header_user ->name }}</div></a>
            <div class="dropdown-menu dropdown-menu-right">

              <a href="{{ route('staff.profile') }}" class="dropdown-item has-icon">
                <i class="far fa-user"></i> {{__('user.My Profile')}}
              </a>
              <div class="dropdown-divider"></div>

              <a href="{{ route('staff.logout') }}" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> {{__('user.Logout')}}
              </a>



            </div>
          </li>
        </ul>
      </nav>


      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="{{ route('staff.dashboard') }}">{{ $setting->sidebar_lg_header }}</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('staff.dashboard') }}">{{ $setting->sidebar_sm_header }}</a>
          </div>
          <ul class="sidebar-menu">
              <li class="{{ Route::is('staff.dashboard') ? 'active' : '' }}"><a class="nav-link" href="{{ route('staff.dashboard') }}"><i class="fas fa-home"></i> <span>{{__('user.Dashboard')}}</span></a></li>


              <li class="nav-item dropdown {{ Route::is('staff.appointment') || Route::is('staff.show-appointment') || Route::is('staff.show-prescription') || Route::is('staff.create-appointment') || Route::is('staff.today-appointment') || Route::is('staff.prescription')  ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fa fa-stethoscope"></i><span>{{__('user.Appointments')}}</span></a>
                <ul class="dropdown-menu">

                    <li class="{{ Route::is('staff.create-appointment') ? 'active' : '' }}"><a class="nav-link" href="{{ route('staff.create-appointment') }}">{{__('user.Create Appointment')}}</a></li>

                    <li class="{{ Route::is('staff.today-appointment') ? 'active' : '' }}"><a class="nav-link" href="{{ route('staff.today-appointment') }}">{{__('user.Today Appointment')}}</a></li>

                    <li class="{{ Route::is('staff.appointment') || Route::is('staff.show-appointment') ? 'active' : '' }}"><a class="nav-link" href="{{ route('staff.appointment') }}">{{__('user.Appointment History')}}</a></li>



                    <li class="{{ Route::is('staff.prescription') || Route::is('staff.show-prescription') ? 'active' : '' }}"><a class="nav-link" href="{{ route('staff.prescription') }}">{{__('user.Prescription')}}</a></li>

                </ul>
              </li>

              <li class="nav-item dropdown {{ Route::is('staff.appointment-payment') || Route::is('staff.pending-payment') || Route::is('staff.show-payment') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fa fa-credit-card"></i><span>{{__('user.Payment')}}</span></a>

                <ul class="dropdown-menu">
                    <li class="{{ Route::is('staff.pending-payment') ? 'active' : '' }}"><a class="nav-link" href="{{ route('staff.pending-payment') }}">{{__('user.Pending Payment')}}</a></li>

                    <li class="{{ Route::is('staff.appointment-payment') || Route::is('staff.show-payment') ? 'active' : '' }}"><a class="nav-link" href="{{ route('staff.appointment-payment') }}">{{__('user.Payment History')}}</a></li>

                </ul>
              </li>


              <li class="{{ Route::is('staff.medicine.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('staff.medicine.index') }}"><i class="fas fa-medkit"></i> <span>{{__('user.Medicine')}}</span></a></li>

              <li class="{{ Route::is('staff.location.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('staff.location.index') }}"><i class="fas fa-map-marker"></i> <span>{{__('user.Location')}}</span></a></li>

              <li class="{{ Route::is('staff.department.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('staff.department.index') }}"><i class="fas fa-id-card"></i> <span>{{__('user.Department')}}</span></a></li>

              <li class="{{ Route::is('staff.schedule.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('staff.schedule.index') }}"><i class="fas fa-calendar"></i> <span>{{__('user.Schedule')}}</span></a></li>

              <li class="nav-item dropdown {{ Route::is('staff.video-gallery') || Route::is('staff.image-gallery') || Route::is('staff.change-password') || Route::is('staff.social-link') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-user"></i><span>{{__('user.Doctor Profile')}}</span></a>

                <ul class="dropdown-menu">
                    <li class="{{ Route::is('staff.social-link') ? 'active' : '' }}"><a class="nav-link" href="{{ route('staff.social-link') }}">{{__('user.Social Link')}}</a></li>

                    <li class="{{ Route::is('staff.image-gallery') ? 'active' : '' }}"><a class="nav-link" href="{{ route('staff.image-gallery') }}">{{__('user.Image Gallery')}}</a></li>

                    <li class="{{ Route::is('staff.video-gallery') ? 'active' : '' }}"><a class="nav-link" href="{{ route('staff.video-gallery') }}">{{__('user.Video Gallery')}}</a></li>

                </ul>
              </li>


              <li class="{{ Route::is('staff.logout') ? 'active' : '' }}"><a class="nav-link" href="{{ route('staff.logout') }}"><i class="fas fa-sign-out-alt"></i> <span>{{__('user.Logout')}}</span></a></li>

            </ul>

        </aside>
      </div>

      @yield('staff-content')

    </div>
  </div>

  @include('admin.footer')
