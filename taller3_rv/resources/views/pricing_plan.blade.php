@extends('layout')
@section('title')
    <title>{{ $seo->seo_title }}</title>
@endsection
@section('meta')
    <meta name="description" content="{{ $seo->seo_description }}">
@endsection

@section('public-content')

<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ asset($banner->image) }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{__('user.Pricing Plan')}}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><span>{{__('user.Pricing Plan')}}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->

<!--Price Table Start-->
<div class="price-table-area pt_40 pb_70">
    <div class="container">
        <div class="row">

            @foreach ($packages as $index => $package)
            <div class="price-table col-lg-4 col-md-6">
                <div class="price-item mt_30">
                    <div class="price-header">
                        <h3>{{ $package->name }}</h3>
                        <h2>{{ $setting->currency_icon }}{{ $package->price }}</h2>
                        @if ($package->expiration_day == -1)
                        <p>{{__('user.Unlimited')}} {{__('user.Days')}}</p>
                        @else
                        <p>{{ $package->expiration_day }} {{__('user.Days')}}</p>
                        @endif

                    </div>
                    <div class="price-body">
                        <ul>
                            @if ($package->daily_appointment_qty == -1)
                            <li><i class="fas fa-check"></i> {{__('user.Daily Appointment Limit')}} - {{__('user.Unlimited')}}</li>
                            @else
                            <li><i class="fas fa-check"></i> {{__('user.Daily Appointment Limit')}} - {{ $package->daily_appointment_qty }}</li>
                            @endif

                            @if ($package->maximum_chamber == -1)
                            <li><i class="fas fa-check"></i> {{__('user.Chamber Limit')}} - {{__('user.Unlimited')}}</li>
                            @else
                            <li><i class="fas fa-check"></i> {{__('user.Chamber Limit')}} - {{ $package->maximum_chamber }}</li>
                            @endif

                            @if ($package->maximum_staff == -1)
                            <li><i class="fas fa-check"></i> {{__('user.Staff Limit')}} - {{__('user.Unlimited')}}</li>
                            @else
                            <li><i class="fas fa-check"></i> {{__('user.Staff Limit')}} - {{ $package->maximum_staff }}</li>
                            @endif


                            @if ($package->maximum_image == -1)
                            <li><i class="fas fa-check"></i> {{__('user.Gallery Image Limit')}} - {{__('user.Unlimited')}}</li>
                            @else
                            <li><i class="fas fa-check"></i> {{__('user.Gallery Image Limit')}} - {{ $package->maximum_image }}</li>
                            @endif


                            @if ($package->maximum_video == -1)
                            <li><i class="fas fa-check"></i> {{__('user.Gallery Video Limit')}} - {{__('user.Unlimited')}}</li>
                            @else
                            <li><i class="fas fa-check"></i> {{__('user.Gallery Video Limit')}} - {{ $package->maximum_video }}</li>
                            @endif


                            @if ($package->online_consulting == 1)
                                <li><i class="fas fa-check"></i> {{__('user.Online Consulting')}}</li>
                            @else
                                <li><i class="fas fa-times"></i> {{__('user.Online Consulting')}}</li>
                            @endif

                            @if ($package->message_system == 1)
                                <li><i class="fas fa-check"></i> {{__('user.Live Chat with Patient')}}</li>
                            @else
                                <li><i class="fas fa-check"></i> {{__('user.Live Chat with Patient')}}</li>
                            @endif
                        </ul>
                    </div>
                    <div class="price-footer">
                        <div class="button">
                            @if ($package->price == 0)
                            <a onclick="freeEnroll('{{ $package->slug }}')" href="javascript:;">{{__('user.Select Plan')}} <i class="fa fa-chevron-circle-right"></i></a>
                            @else
                            <a href="{{ route('doctor.payment', $package->slug) }}">{{__('user.Select Plan')}} <i class="fa fa-chevron-circle-right"></i></a>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!--Price Table End-->


<script>
    function freeEnroll(slug){
        Swal.fire({
            title: "{{__('user.Are you sure ?')}}",
            text: "{{__('user.You will also upgrade your plan!')}}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{{__('user.Yes, Enroll It')}}",
            cancelButtonText: "{{__('user.Cancel')}}",
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    "{{__('user.Enrolled')}}",
                    "{{__('user.Congrats to Enroll our Free Plan')}}",
                    'success'
                )
                location.href = "{{ url('doctor/free-trail/') }}" + "/" + slug;
            }
        })
    }
</script>
@endsection
