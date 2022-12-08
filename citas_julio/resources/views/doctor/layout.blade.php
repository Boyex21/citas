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

        @php
            $doctor = Auth::guard('doctor')->user();
            $existOrder = App\Models\Order::orderBy('id','desc')->where('doctor_id', $doctor->id)->where('payment_status', 1)->first();
        @endphp


        @php
            $header_user = Auth::guard('doctor')->user();
            $defaultProfile = App\Models\BannerImage::whereId('15')->first();

            $newMessages = App\Models\Message::orderBy('id','desc')->where(['doctor_id' => $header_user->id, 'doctor_view' => 0])->groupBy('user_id')->select('user_id','id','message','created_at')->get()->take(5);
        @endphp

        <ul class="navbar-nav navbar-right">

          <li class="dropdown dropdown-list-toggle"><a target="_blank" href="{{ route('home') }}" class="nav-link nav-link-lg"><i class="fas fa-home"></i> {{__('user.Visit Website')}}</i></a>
          </li>

        @if ($existOrder)
            @php
                $isMessageSystem = false;
                if ($existOrder->message_system == 1) {
                    $isMessageSystem = true;
                }
            @endphp
        @if ($isMessageSystem)

          <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle beep"><i class="far fa-envelope"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">

                @if ($newMessages->count() > 0)
                    <div class="dropdown-header">{{__('user.Messages')}}
                        <div class="float-right">
                        <a href="{{ route('doctor.real-all-message') }}">{{__('user.Mark All As Read')}}</a>
                        </div>
                    </div>
                    <div class="dropdown-list-content dropdown-list-message">
                        @foreach ($newMessages as $newMessage)
                            <a href="javascript:;" class="dropdown-item dropdown-item-unread">
                            <div class="dropdown-item-avatar">
                                <img alt="image" src="{{ $newMessage->user->image ? asset($newMessage->user->image) : asset($defaultProfile->image) }}" class="rounded-circle">
                                <div class="is-online"></div>
                            </div>
                            <div class="dropdown-item-desc">
                                <b>{{ $newMessage->user->name }}</b>
                                <p> {!! clean(nl2br($newMessage->message)) !!}</p>
                                <div class="time">{{ $newMessage->created_at->diffForHumans() }}</div>
                            </div>
                            </a>
                        @endforeach
                </div>
                <div class="dropdown-footer text-center">
                    <a href="{{ route('doctor.message') }}">{{__('user.View All')}} <i class="fas fa-chevron-right"></i></a>
                </div>
              @else
                <p class="text-danger text-center mt-2 py-4">{{__('user.Message Not Found')}}</p>
              @endif
            </div>
          </li>
          @endif
        @endif

          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
              @if ($header_user ->image)
              <img alt="image" src="{{ asset($header_user ->image) }}" class="rounded-circle mr-1">
              @else
              <img alt="image" src="{{ asset($defaultProfile->image) }}" class="rounded-circle mr-1">
              @endif
            <div class="d-sm-none d-lg-inline-block">{{ $header_user ->name }}</div></a>
            <div class="dropdown-menu dropdown-menu-right">

              <a href="{{ route('doctor.profile') }}" class="dropdown-item has-icon">
                <i class="far fa-user"></i> {{__('user.My Profile')}}
              </a>
              <div class="dropdown-divider"></div>

              <a href="{{ route('doctor.logout') }}" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> {{__('user.Logout')}}
              </a>



            </div>
          </li>
        </ul>
      </nav>


      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="{{ route('doctor.dashboard') }}">{{ $setting->sidebar_lg_header }}</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('doctor.dashboard') }}">{{ $setting->sidebar_sm_header }}</a>
          </div>
          <ul class="sidebar-menu">
              <li class="{{ Route::is('doctor.dashboard') ? 'active' : '' }}"><a class="nav-link" href="{{ route('doctor.dashboard') }}"><i class="fas fa-home"></i> <span>{{__('user.Dashboard')}}</span></a></li>

            @if ($existOrder)
              <li class="nav-item dropdown {{ Route::is('doctor.appointment') || Route::is('doctor.show-appointment') || Route::is('doctor.edit-appointment') || Route::is('doctor.show-prescription') || Route::is('doctor.create-appointment') || Route::is('doctor.today-appointment') || Route::is('doctor.prescription')  ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fa fa-stethoscope"></i><span>{{__('user.Appointments')}}</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Route::is('doctor.create-appointment') ? 'active' : '' }}"><a class="nav-link" href="{{ route('doctor.create-appointment') }}">{{__('user.Create Appointment')}}</a></li>

                    <li class="{{ Route::is('doctor.today-appointment')  ? 'active' : '' }}"><a class="nav-link" href="{{ route('doctor.today-appointment') }}">{{__('user.Today Appointment')}}</a></li>

                    <li class="{{ Route::is('doctor.appointment') || Route::is('doctor.show-appointment') || Route::is('doctor.edit-appointment')  ? 'active' : '' }}"><a class="nav-link" href="{{ route('doctor.appointment') }}">{{__('user.Appointment History')}}</a></li>

                    <li class="{{ Route::is('doctor.prescription') || Route::is('doctor.show-prescription') ? 'active' : '' }}"><a class="nav-link" href="{{ route('doctor.prescription') }}">{{__('user.Prescription')}}</a></li>

                </ul>
              </li>


              @if ($existOrder)
                    @php
                        $isOnlineConsulting = false;
                        if ($existOrder->online_consulting == 1) {
                            $isOnlineConsulting = true;
                        }
                    @endphp
                @if ($isOnlineConsulting)
                    <li class="nav-item dropdown {{ Route::is('doctor.zoom-credential') || Route::is('doctor.zoom-meeting') || Route::is('doctor.create-zoom-meeting') || Route::is('doctor.edit-zoom-meeting') || Route::is('doctor.meeting-history') || Route::is('doctor.upcomming-meeting') ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown"><i class="fa fa-video"></i><span>{{__('user.Live Consultation')}}</span></a>

                        <ul class="dropdown-menu">
                            <li class="{{ Route::is('doctor.zoom-meeting') || Route::is('doctor.create-zoom-meeting') || Route::is('doctor.edit-zoom-meeting') ? 'active' : '' }}"><a class="nav-link" href="{{ route('doctor.zoom-meeting') }}">{{__('user.Meeting')}}</a></li>

                            <li class="{{ Route::is('doctor.meeting-history') ? 'active' : '' }}"><a class="nav-link" href="{{ route('doctor.meeting-history') }}">{{__('user.Meeting History')}}</a></li>

                            <li class="{{ Route::is('doctor.upcomming-meeting') ? 'active' : '' }}"><a class="nav-link" href="{{ route('doctor.upcomming-meeting') }}">{{__('user.Upcoming Meeting')}}</a></li>

                            <li class="{{ Route::is('doctor.zoom-credential') ? 'active' : '' }}"><a class="nav-link" href="{{ route('doctor.zoom-credential') }}">{{__('user.Setting')}}</a></li>
                        </ul>
                    </li>
                @endif
              @endif


              @if ($existOrder)
                    @php
                        $isMessageSystem = false;
                        if ($existOrder->message_system == 1) {
                            $isMessageSystem = true;
                        }
                    @endphp
                @if ($isMessageSystem)

                <li class="{{ Route::is('doctor.message') ? 'active' : '' }}"><a class="nav-link" href="{{ route('doctor.message') }}"><i class="fas fa-fa fa-envelope""></i> <span>{{__('user.Messages')}}</span></a></li>
                @endif
              @endif

              <li class="nav-item dropdown {{ Route::is('doctor.appointment-payment') || Route::is('doctor.pending-payment') || Route::is('doctor.show-payment') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fa fa-credit-card"></i><span>{{__('user.Payment')}}</span></a>

                <ul class="dropdown-menu">
                    <li class="{{ Route::is('doctor.pending-payment') ? 'active' : '' }}"><a class="nav-link" href="{{ route('doctor.pending-payment') }}">{{__('user.Pending Payment')}}</a></li>

                    <li class="{{ Route::is('doctor.appointment-payment') || Route::is('doctor.show-payment') ? 'active' : '' }}"><a class="nav-link" href="{{ route('doctor.appointment-payment') }}">{{__('user.Payment History')}}</a></li>

                </ul>
              </li>


              <li class="{{ Route::is('doctor.payment-method') ? 'active' : '' }}"><a class="nav-link" href="{{ route('doctor.payment-method') }}"><i class="fa fa-ad"></i> <span>{{__('user.Payment Method')}}</span></a></li>

              @endif


              <li class="nav-item dropdown {{ Route::is('doctor.pricing-plan') || Route::is('doctor.payment') || Route::is('doctor.order') || Route::is('doctor.order-show') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fa fa-rocket"></i><span>{{__('user.Pricing Plan')}}</span></a>

                <ul class="dropdown-menu">

                    <li class="{{ Route::is('doctor.pricing-plan') || Route::is('doctor.payment') ? 'active' : '' }}"><a class="nav-link" href="{{ route('doctor.pricing-plan') }}">{{__('user.Pricing Plan')}}</a></li>

                    <li class="{{ Route::is('doctor.order') || Route::is('doctor.order-show') ? 'active' : '' }}"><a class="nav-link" href="{{ route('doctor.order') }}">{{__('user.Orders')}}</a></li>
                </ul>
              </li>



              @if ($existOrder)

              <li class="{{ Route::is('doctor.leave.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('doctor.leave.index') }}"><i class="fas fa-calendar"></i> <span>{{__('user.Manage Leave')}}</span></a></li>

              <li class="{{ Route::is('doctor.medicine.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('doctor.medicine.index') }}"><i class="fas fa-medkit"></i> <span>{{__('user.Medicine')}}</span></a></li>



              <li class="{{ Route::is('doctor.location.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('doctor.location.index') }}"><i class="fas fa-map-marker"></i> <span>{{__('user.Location')}}</span></a></li>

              <li class="{{ Route::is('doctor.department.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('doctor.department.index') }}"><i class="fas fa-id-card"></i> <span>{{__('user.Department')}}</span></a></li>

              <li class="{{ Route::is('doctor.schedule.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('doctor.schedule.index') }}"><i class="fas fa-calendar"></i> <span>{{__('user.Schedule')}}</span></a></li>

              <li class="{{ Route::is('doctor.chamber.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('doctor.chamber.index') }}"><i class="fas fa-hospital"></i> <span>{{__('user.Chamber')}}</span></a></li>

              <li class="{{ Route::is('doctor.staff.*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('doctor.staff.index') }}"><i class="fas fa-users"></i> <span>{{__('user.Staff')}}</span></a></li>

              @endif



              <li class="nav-item dropdown {{ Route::is('doctor.profile') || Route::is('doctor.video-gallery') || Route::is('doctor.image-gallery') || Route::is('doctor.change-password') || Route::is('doctor.social-link') || Route::is('doctor.review') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-user"></i><span>{{__('user.My Profile')}}</span></a>

                <ul class="dropdown-menu">

                    <li class="{{ Route::is('doctor.profile') ? 'active' : '' }}"><a class="nav-link" href="{{ route('doctor.profile') }}">{{__('user.My Profile')}}</a></li>

                    <li class="{{ Route::is('doctor.change-password') ? 'active' : '' }}"><a class="nav-link" href="{{ route('doctor.change-password') }}">{{__('user.Change Password')}}</a></li>

                    <li class="{{ Route::is('doctor.social-link') ? 'active' : '' }}"><a class="nav-link" href="{{ route('doctor.social-link') }}">{{__('user.Social Link')}}</a></li>

                    @if ($existOrder)
                    <li class="{{ Route::is('doctor.review') ? 'active' : '' }}"><a class="nav-link" href="{{ route('doctor.review') }}">{{__('user.Reviews')}}</a></li>

                    <li class="{{ Route::is('doctor.image-gallery') ? 'active' : '' }}"><a class="nav-link" href="{{ route('doctor.image-gallery') }}">{{__('user.Image Gallery')}}</a></li>

                    <li class="{{ Route::is('doctor.video-gallery') ? 'active' : '' }}"><a class="nav-link" href="{{ route('doctor.video-gallery') }}">{{__('user.Video Gallery')}}</a></li>

                    @endif

                </ul>
              </li>


              <li class="{{ Route::is('doctor.logout') ? 'active' : '' }}"><a class="nav-link" href="{{ route('doctor.logout') }}"><i class="fas fa-sign-out-alt"></i> <span>{{__('user.Logout')}}</span></a></li>

            </ul>

        </aside>
      </div>

      @yield('doctor-content')

    </div>
  </div>

  @include('admin.footer')
