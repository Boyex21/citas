@extends('staff.layout')
@section('title')
<title>{{__('user.Dashboard')}}</title>
@endsection
@section('staff-content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
          <h1>{{__('user.Dashbaord')}}</h1>
        </div>

        <div class="section-body">
          <div class="row">
              <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-primary">
                    <i class="fas fa-shopping-cart"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>{{__('user.Today Appointment')}}</h4>
                    </div>
                    <div class="card-body">
                      {{ $todayAppointments->count() }}
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                  <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <div class="card-wrap">
                      <div class="card-header">
                        <h4>{{__('user.Monthly Appointment')}}</h4>
                      </div>
                      <div class="card-body">
                        {{ $monthlyAppointments->count() }}
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                  <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <div class="card-wrap">
                      <div class="card-header">
                        <h4>{{__('user.Yearly Appointment')}}</h4>
                      </div>
                      <div class="card-body">
                        {{ $yearlyAppointments->count() }}
                      </div>
                    </div>
                  </div>
                </div>

              <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-danger">
                    <i class="fas fa-shopping-cart"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>{{__('user.Total Appointment')}}</h4>
                    </div>
                    <div class="card-body">
                      {{ $appointments->count() }}
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-warning">
                      <i class="far fa-newspaper"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>{{__('user.Pending Payment')}}</h4>
                    </div>
                    <div class="card-body">
                      {{ $setting->currency_icon }}{{ $orders->where('payment_status', 0)->sum('amount') }}
                    </div>
                  </div>
                </div>
              </div>


              <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                  <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-circle"></i>
                    </div>
                    <div class="card-wrap">
                      <div class="card-header">
                        <h4>{{__('user.Total Payment')}}</h4>
                      </div>
                      <div class="card-body">
                        {{ $setting->currency_icon }}{{ $orders->sum('total_fee') }}
                      </div>
                    </div>
                  </div>
                </div>


                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                  <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-wrap">
                      <div class="card-header">
                        <h4>{{__('user.Total Staff')}}</h4>
                      </div>
                      <div class="card-body">
                        {{ $staffs->count() }}
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                  <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-hospital"></i>
                    </div>
                    <div class="card-wrap">
                      <div class="card-header">
                        <h4>{{__('user.Total Chamber')}}</h4>
                      </div>
                      <div class="card-body">
                        {{ $chambers->count() }}
                      </div>
                    </div>
                  </div>
                </div>

            </div>
        </div>

      </section>
  </div>
@endsection
