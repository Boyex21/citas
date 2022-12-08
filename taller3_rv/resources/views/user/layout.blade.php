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
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none d-none"><i class="fas fa-search"></i></a></li>
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown dropdown-list-toggle"><a href="{{ route('home') }}" class="nav-link nav-link-lg"><i class="fas fa-home"></i> {{__('user.Visit Website')}}</i></a>

          </li>

          @php
              $header_user = Auth::guard('web')->user();
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

              <a href="{{ route('user.my-profile') }}" class="dropdown-item has-icon">
                <i class="far fa-user"></i> {{__('user.My Profile')}}
              </a>
              <div class="dropdown-divider"></div>
              <a href="{{ route('user.change-password') }}" class="dropdown-item has-icon">
                <i class="fas fa-lock"></i> {{__('user.Change Password')}}
              </a>
              <div class="dropdown-divider"></div>

              <a href="{{ route('user.logout') }}" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> {{__('user.Logout')}}
              </a>



            </div>
          </li>
        </ul>
      </nav>


      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="{{ route('user.dashboard') }}">{{ $setting->sidebar_lg_header }}</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('user.dashboard') }}">{{ $setting->sidebar_sm_header }}</a>
          </div>
          <ul class="sidebar-menu">
              <li class="{{ Route::is('user.dashboard') ? 'active' : '' }}"><a class="nav-link" href="{{ route('user.dashboard') }}"><i class="fas fa-home"></i> <span>{{__('user.Dashboard')}}</span></a></li>

              <li class="{{ Route::is('user.order') ? 'active' : '' }}"><a class="nav-link" href="{{ route('user.order') }}"><i class="fas fa-th-large"></i> <span>{{__('user.Order List')}}</span></a></li>

              <li class="{{ Route::is('user.my-profile') ? 'active' : '' }}"><a class="nav-link" href="{{ route('user.my-profile') }}"><i class="far fa-user"></i> <span>{{__('user.My Profile')}}</span></a></li>

              <li class="{{ Route::is('user.support-ticket') ? 'active' : '' }}"><a class="nav-link" href="{{ route('user.support-ticket') }}"><i class="fas fa-fa fa-envelope"></i> <span>{{__('user.Support Ticket')}}</span></a></li>

              <li class="{{ Route::is('user.purchased-product') ? 'active' : '' }}"><a class="nav-link" href="{{ route('user.purchased-product') }}"><i class="fas fa-fa fa-download"></i> <span>{{__('user.Purchased Product')}}</span></a></li>





              <li class="{{ Route::is('user.change-password') ? 'active' : '' }}"><a class="nav-link" href="{{ route('user.change-password') }}"><i class="fas fa-lock"></i> <span>{{__('user.Change Password')}}</span></a></li>

              <li class="{{ Route::is('user.logout') ? 'active' : '' }}"><a class="nav-link" href="{{ route('user.logout') }}"><i class="fas fa-sign-out-alt"></i> <span>{{__('user.Logout')}}</span></a></li>

            </ul>

        </aside>
      </div>

      @yield('user-content')

    </div>
  </div>

  @include('admin.footer')
