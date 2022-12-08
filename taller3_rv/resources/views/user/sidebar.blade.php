@php
    $defaultProfile = App\Models\BannerImage::whereId('15')->first();
    $user = Auth::guard('web')->user();
@endphp

<div class="dashboard-widget">
    <div class="dashboard-account-info">
        <img src="{{ $user->image ? asset($user->image) : asset($defaultProfile->image) }}" alt="">
        <h3>{{ $user->name }}</h3>
        <p>{{__('user.Patient Id')}} : {{ $user->patient_id }}</p>
    </div>
     <ul>
         <li class="{{ Route::is('user.dashboard') ? 'active' : '' }}"><a href="{{ route('user.dashboard') }}"><i class="fa fa-chevron-right"></i> {{__('user.Dashboard')}}</a></li>

         <li class="{{ Route::is('user.appointment') || Route::is('user.show-appointment') ? 'active' : '' }}"><a href="{{ route('user.appointment') }}"><i class="fa fa-chevron-right"></i> {{__('user.Appointment')}}</a></li>

         <li class="{{ Route::is('user.transaction') ? 'active' : '' }}"><a href="{{ route('user.transaction') }}"><i class="fa fa-chevron-right"></i> {{__('user.Transaction History')}}</a></li>

         <li class="{{ Route::is('user.my-profile') ? 'active' : '' }}"><a href="{{ route('user.my-profile') }}"><i class="fa fa-chevron-right"></i> {{__('user.My Profile')}}</a></li>

         <li class="{{ Route::is('user.change-password') ? 'active' : '' }}"><a href="{{ route('user.change-password') }}"><i class="fa fa-chevron-right"></i> {{__('user.Change Password')}}</a></li>

         <li class="{{ Route::is('user.review') ? 'active' : '' }}"><a href="{{ route('user.review') }}"><i class="fa fa-chevron-right"></i> {{__('user.Reviews')}}</a></li>

         <li class="{{ Route::is('user.meeting-history') ? 'active' : '' }}"><a href="{{ route('user.meeting-history') }}"><i class="fa fa-chevron-right"></i> {{__('user.Meeting History')}}</a></li>

         <li class="{{ Route::is('user.upcoming-meeting') ? 'active' : '' }}"><a href="{{ route('user.upcoming-meeting') }}"><i class="fa fa-chevron-right"></i> {{__('user.Upcomming Meeting')}}</a></li>

         <li class="{{ Route::is('user.message') ? 'active' : '' }}"><a href="{{ route('user.message') }}"><i class="fa fa-chevron-right"></i> {{__('user.Messages')}}</a></li>

         <li><a href="{{ route('user.logout') }}"><i class="fa fa-chevron-right"></i> {{__('user.Logout')}}</a></li>
     </ul>
 </div>
