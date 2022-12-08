@extends('doctor.layout')
@section('title')
<title>{{__('user.Invoice')}}</title>
@endsection
<style>
    @media print {
        .section-header,
        .order-status,
        #sidebar-wrapper,
        .print-area,
        .main-footer,
        .additional_info {
            display:none!important;
        }

    }
</style>
@section('doctor-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('user.Invoice')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('doctor.dashboard') }}">{{__('user.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('user.Invoice')}}</div>
            </div>
          </div>
          <div class="section-body">
            <div class="invoice">
              <div class="invoice-print">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="invoice-title">
                      <h2><img src="{{ asset($setting->logo) }}" alt="" width="120px"></h2>
                      <div class="invoice-number">{{__('user.Order Id')}} #{{ $order->order_id }}</div>
                    </div>
                    <hr>

                    <div class="row">
                      <div class="col-md-6">
                        <address>
                          <strong>{{__('user.Billing Information')}}:</strong><br>
                            {{ $user->name }}<br>
                            @if ($user->email)
                            {{ $user->email }}<br>
                            @endif
                            @if ($user->phone)
                            {{ $user->phone }}<br>
                            @endif
                            {{ $user->address }}<br>
                        </address>
                      </div>

                      <div class="col-md-6 text-md-right">
                        <address>
                          <strong>{{__('user.Payment Information')}}:</strong><br>
                          {{__('user.Method')}}: {{ $order->payment_method }}<br>
                          {{__('user.Status')}} : @if ($order->payment_status == 1)
                              <span class="badge badge-success">{{__('user.Success')}}</span>
                              @else
                              <span class="badge badge-danger">{{__('user.Pending')}}</span>
                          @endif <br>
                          {{__('user.Transaction')}}: {!! clean(nl2br($order->transaction_id)) !!}
                        </address>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row mt-4">
                  <div class="col-md-12">
                    <div class="section-title">{{__('user.Order Summary')}}</div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-md table-bordered">
                                    <tr>
                                        <td>{{__('user.Package Name')}}</td>
                                        <td>{{ $order->package_name }}</td>
                                    </tr>

                                    <tr>
                                        <td>{{__('user.Purchase Date')}}</td>
                                        <td>{{ date('d F, Y', strtotime($order->purchase_date)) }}</td>
                                    </tr>

                                    <tr>
                                        <td>{{__('user.Expired Date')}}</td>
                                        @if ($order->expired_date)
                                        <td>{{ date('d F, Y', strtotime($order->expired_date)) }}</td>
                                        @else
                                        <td>{{__('user.Lifetime')}}</td>
                                        @endif
                                    </tr>

                                    <tr>
                                        <td>{{__('user.Amount')}}</td>
                                        <td>{{ $setting->currency_icon }}{{ $order->amount }}</td>
                                    </tr>

                                    <tr>
                                        <td>{{__('user.Online Consulting')}}</td>
                                        <td>
                                            @if ($order->online_consulting == 1)
                                            {{__('user.Available')}}
                                            @else
                                            {{__('user.Not Available')}}
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>{{__('user.Message System')}}</td>
                                        <td>
                                            @if ($order->message_system == 1)
                                            {{__('user.Available')}}
                                            @else
                                            {{__('user.Not Available')}}
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>{{__('user.Daily maximum appointment')}}</td>
                                        @if ($order->daily_appointment_qty == -1)
                                            <td>
                                                {{__('user.Unlimited')}}
                                            </td>
                                        @else
                                            <td>
                                                {{ $order->daily_appointment_qty }}
                                            </td>
                                        @endif

                                    </tr>

                                    <tr>
                                        <td>{{__('user.Maximum Staff')}}</td>
                                        @if ($order->maximum_staff == -1)
                                            <td>
                                                {{__('user.Unlimited')}}
                                            </td>
                                        @else
                                            <td>
                                                {{ $order->maximum_staff }}
                                            </td>
                                        @endif

                                    </tr>

                                    <tr>
                                        <td>{{__('user.Maximum Gallery Image')}}</td>
                                        @if ($order->maximum_image == -1)
                                        <td>
                                            {{__('user.Unlimited')}}
                                        </td>
                                        @else
                                        <td>
                                            {{ $order->maximum_image }}
                                        </td>
                                        @endif

                                    </tr>

                                    <tr>
                                        <td>{{__('user.Maximum Video Gallery')}}</td>
                                        @if ($order->maximum_video == -1)
                                        <td>
                                            {{__('user.Unlimited')}}
                                        </td>
                                        @else
                                        <td>
                                            {{ $order->maximum_video }}
                                        </td>
                                        @endif

                                    </tr>

                                    <tr>
                                        <td>{{__('user.Maximum Chamber')}}</td>

                                        @if ($order->maximum_chamber == -1)
                                        <td>
                                            {{__('user.Unlimited')}}
                                        </td>
                                        @else
                                        <td>
                                            {{ $order->maximum_chamber }}
                                        </td>
                                        @endif

                                    </tr>
                            </table>
                        </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </section>
      </div>
@endsection
