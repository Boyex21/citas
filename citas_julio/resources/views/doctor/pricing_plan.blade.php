@extends('doctor.layout')
@section('title')
<title>{{__('user.Pricing Plan')}}</title>
@endsection
@section('doctor-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('user.Pricing Plan')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('doctor.dashboard') }}">{{__('user.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('user.Pricing Plan')}}</div>
            </div>
          </div>
          <div class="section-body">
            <div class="row">
                @foreach ($packages as $index => $package)
                    @if ($currentOrder)
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="pricing {{ $currentOrder->package_id == $package->id ? 'pricing-highlight' : '' }}">
                            <div class="pricing-title">
                            {{ $package->name }}
                            </div>
                            <div class="pricing-padding">
                                <div class="pricing-price">
                                    <div>{{ $setting->currency_icon }}{{ $package->price }}</div>
                                    @if ($package->expiration_day == -1)
                                    <div>{{__('user.Unlimited')}} {{__('user.Days')}}</div>
                                    @else
                                    <div>{{ $package->expiration_day }} {{__('user.Days')}}</div>
                                    @endif

                                </div>
                                <div class="pricing-details">

                                    <div class="pricing-item">
                                        <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                        @if ($package->daily_appointment_qty == -1)
                                        <div class="pricing-item-label">{{__('user.Daily Appointment Limit')}} - {{__('user.Unlimited')}}</div>
                                        @else
                                        <div class="pricing-item-label">{{__('user.Daily Appointment Limit')}} - {{ $package->daily_appointment_qty }}</div>
                                        @endif

                                    </div>

                                    <div class="pricing-item">
                                        <div class="pricing-item-icon"><i class="fas fa-check"></i></div>

                                        @if ($package->maximum_chamber == -1)
                                        <div class="pricing-item-label">{{__('user.Chamber Limit')}} - {{__('user.Unlimited')}}</div>
                                        @else
                                        <div class="pricing-item-label">{{__('user.Chamber Limit')}} - {{ $package->maximum_chamber }}</div>
                                        @endif

                                    </div>

                                    <div class="pricing-item">
                                        <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                        @if ($package->maximum_staff == -1)
                                        <div class="pricing-item-label">{{__('user.Staff Limit')}} - {{__('user.Unlimited')}}</div>
                                        @else
                                        <div class="pricing-item-label">{{__('user.Staff Limit')}} - {{ $package->maximum_staff }}</div>
                                        @endif
                                    </div>

                                    <div class="pricing-item">
                                        <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                        @if ($package->maximum_image == -1)
                                        <div class="pricing-item-label">{{__('user.Gallery Image Limit')}} - {{__('user.Unlimited')}}</div>
                                        @else
                                        <div class="pricing-item-label">{{__('user.Gallery Image Limit')}} - {{ $package->maximum_image }}</div>
                                        @endif

                                    </div>

                                    <div class="pricing-item">
                                        <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                        @if ($package->maximum_video == -1)
                                        <div class="pricing-item-label">{{__('user.Gallery Video Limit')}} - {{__('user.Unlimited')}}</div>
                                        @else
                                        <div class="pricing-item-label">{{__('user.Gallery Video Limit')}} - {{ $package->maximum_video }}</div>
                                        @endif
                                    </div>

                                    @if ($package->online_consulting == 1)
                                        <div class="pricing-item">
                                            <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                            <div class="pricing-item-label">{{__('user.Online Consulting')}}</div>
                                        </div>
                                    @else
                                        <div class="pricing-item">
                                            <div class="pricing-item-icon bg-danger text-white"><i class="fas fa-times"></i></div>
                                            <div class="pricing-item-label">{{__('user.Online Consulting')}}</div>
                                        </div>
                                    @endif

                                    @if ($package->message_system == 1)
                                        <div class="pricing-item">
                                            <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                            <div class="pricing-item-label">{{__('user.Live Chat with Patient')}}</div>
                                        </div>
                                    @else
                                        <div class="pricing-item">
                                            <div class="pricing-item-icon bg-danger text-white"><i class="fas fa-times"></i></div>
                                            <div class="pricing-item-label">{{__('user.Live Chat with Patient')}}</div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                            <div class="pricing-cta">
                                @if ($package->price == 0)
                                    @if($package->id == $currentOrder->package_id)
                                        <a onclick="freeEnroll('{{ $package->slug }}')" href="javascript:;">{{__('user.Current Plan')}} <i class="fas fa-arrow-right"></i></a>
                                    @else
                                        <a onclick="freeEnroll('{{ $package->slug }}')" href="javascript:;">{{__('user.Select Plan')}} <i class="fas fa-arrow-right"></i></a>
                                    @endif

                                @else
                                    @if($package->id == $currentOrder->package_id)
                                        <a href="{{ route('doctor.payment', $package->slug) }}">{{__('user.Current Plan')}} <i class="fas fa-arrow-right"></i></a>
                                    @else
                                        <a href="{{ route('doctor.payment', $package->slug) }}">{{__('user.Select Plan')}} <i class="fas fa-arrow-right"></i></a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    @else
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="pricing ">
                                <div class="pricing-title">
                                {{ $package->name }}
                                </div>
                                <div class="pricing-padding">
                                    <div class="pricing-price">
                                        <div>{{ $setting->currency_icon }}{{ $package->price }}</div>
                                        @if ($package->expiration_day == -1)
                                        <div>{{__('user.Unlimited')}} {{__('user.Days')}}</div>
                                        @else
                                        <div>{{ $package->expiration_day }} {{__('user.Days')}}</div>
                                        @endif
                                    </div>
                                    <div class="pricing-details">

                                        <div class="pricing-item">
                                            <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                            @if ($package->daily_appointment_qty == -1)
                                            <div class="pricing-item-label">{{__('user.Daily Appointment Limit')}} - {{__('user.Unlimited')}}</div>
                                            @else
                                            <div class="pricing-item-label">{{__('user.Daily Appointment Limit')}} - {{ $package->daily_appointment_qty }}</div>
                                            @endif
                                        </div>

                                        <div class="pricing-item">
                                            <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                            @if ($package->maximum_chamber == -1)
                                            <div class="pricing-item-label">{{__('user.Chamber Limit')}} - {{__('user.Unlimited')}}</div>
                                            @else
                                            <div class="pricing-item-label">{{__('user.Chamber Limit')}} - {{ $package->maximum_chamber }}</div>
                                            @endif
                                        </div>

                                        <div class="pricing-item">
                                            <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                            @if ($package->maximum_staff == -1)
                                            <div class="pricing-item-label">{{__('user.Staff Limit')}} - {{__('user.Unlimited')}}</div>
                                            @else
                                            <div class="pricing-item-label">{{__('user.Staff Limit')}} - {{ $package->maximum_staff }}</div>
                                            @endif

                                        </div>

                                        <div class="pricing-item">
                                            <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                            @if ($package->maximum_image == -1)
                                            <div class="pricing-item-label">{{__('user.Gallery Image Limit')}} - {{__('user.Unlimited')}}</div>
                                            @else
                                            <div class="pricing-item-label">{{__('user.Gallery Image Limit')}} - {{ $package->maximum_image }}</div>
                                            @endif
                                        </div>

                                        <div class="pricing-item">
                                            <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                            @if ($package->maximum_video == -1)
                                            <div class="pricing-item-label">{{__('user.Gallery Video Limit')}} - {{__('user.Unlimited')}}</div>
                                            @else
                                            <div class="pricing-item-label">{{__('user.Gallery Video Limit')}} - {{ $package->maximum_video }}</div>
                                            @endif

                                        </div>

                                        @if ($package->online_consulting == 1)
                                            <div class="pricing-item">
                                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                                <div class="pricing-item-label">{{__('user.Online Consulting')}}</div>
                                            </div>
                                        @else
                                            <div class="pricing-item">
                                                <div class="pricing-item-icon bg-danger text-white"><i class="fas fa-times"></i></div>
                                                <div class="pricing-item-label">{{__('user.Online Consulting')}}</div>
                                            </div>
                                        @endif

                                        @if ($package->message_system == 1)
                                            <div class="pricing-item">
                                                <div class="pricing-item-icon"><i class="fas fa-check"></i></div>
                                                <div class="pricing-item-label">{{__('user.Live Chat with Patient')}}</div>
                                            </div>
                                        @else
                                            <div class="pricing-item">
                                                <div class="pricing-item-icon bg-danger text-white"><i class="fas fa-times"></i></div>
                                                <div class="pricing-item-label">{{__('user.Live Chat with Patient')}}</div>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                                <div class="pricing-cta">
                                    @if ($package->price == 0)
                                        @if ($currentOrder)
                                            <a onclick="freeEnroll('{{ $package->slug }}')" href="javascript:;">{{__('user.Select Plan')}} <i class="fas fa-arrow-right"></i></a>
                                        @else
                                            <a onclick="freeEnroll('{{ $package->slug }}')" href="javascript:;">{{__('user.Select Plan')}} <i class="fas fa-arrow-right"></i></a>
                                        @endif

                                    @else
                                        @if ($currentOrder)
                                            <a href="{{ route('doctor.payment', $package->slug) }}">{{__('user.Select Plan')}} <i class="fas fa-arrow-right"></i></a>
                                        @else
                                            <a href="{{ route('doctor.payment', $package->slug) }}">{{__('user.Select Plan')}} <i class="fas fa-arrow-right"></i></a>
                                        @endif

                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                @endforeach
              </div>
          </div>
        </section>
      </div>



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
