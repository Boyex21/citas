@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Invoice')}}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Invoice')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('admin.Invoice')}}</div>
            </div>
          </div>
          <div class="section-body">
            <div class="invoice">
              <div class="invoice-print">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="invoice-title">
                      <h2><img src="{{ asset($setting->logo) }}" alt="" width="120px"></h2>
                      <div class="invoice-number">{{__('admin.Order Id')}} #{{ $order->order_id }}</div>
                    </div>
                    <hr>

                    <div class="row">
                      <div class="col-md-6">
                        <address>
                          <strong>{{__('admin.Billing Information')}}:</strong><br>
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
                          <strong>{{__('admin.Payment Information')}}:</strong><br>
                          {{__('admin.Method')}}: {{ $order->payment_method }}<br>
                          {{__('admin.Status')}} : @if ($order->payment_status == 1)
                              <span class="badge badge-success">{{__('admin.Success')}}</span>
                              @else
                              <span class="badge badge-danger">{{__('admin.Pending')}}</span>
                          @endif <br>
                          {{__('admin.Transaction')}}: {!! clean(nl2br($order->transaction_id)) !!}
                        </address>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row mt-4">
                  <div class="col-md-12">
                    <div class="section-title">{{__('admin.Order Summary')}}</div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-md table-bordered">
                                    <tr>
                                        <td>{{__('admin.Package Name')}}</td>
                                        <td>{{ $order->package_name }}</td>
                                    </tr>

                                    <tr>
                                        <td>{{__('admin.Purchase Date')}}</td>
                                        <td>{{ date('d F, Y', strtotime($order->purchase_date)) }}</td>
                                    </tr>

                                    <tr>
                                        <td>{{__('admin.Expired Date')}}</td>
                                        @if ($order->expired_date)
                                        <td>{{ date('d F, Y', strtotime($order->expired_date)) }}</td>
                                        @else
                                        <td>{{__('admin.Lifetime')}}</td>
                                        @endif
                                    </tr>

                                    <tr>
                                        <td>{{__('admin.Amount')}}</td>
                                        <td>{{ $setting->currency_icon }}{{ $order->amount }}</td>
                                    </tr>

                                    <tr>
                                        <td>{{__('admin.Online Consulting')}}</td>
                                        <td>
                                            @if ($order->online_consulting == 1)
                                            {{__('admin.Available')}}
                                            @else
                                            {{__('admin.Not Available')}}
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>{{__('admin.Message System')}}</td>
                                        <td>
                                            @if ($order->message_system == 1)
                                            {{__('admin.Available')}}
                                            @else
                                            {{__('admin.Not Available')}}
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>{{__('admin.Daily maximum appointment')}}</td>
                                        @if ($order->daily_appointment_qty == -1)
                                            <td>
                                                {{__('admin.Unlimited')}}
                                            </td>
                                        @else
                                            <td>
                                                {{ $order->daily_appointment_qty }}
                                            </td>
                                        @endif

                                    </tr>

                                    <tr>
                                        <td>{{__('admin.Maximum Staff')}}</td>
                                        @if ($order->maximum_staff == -1)
                                            <td>
                                                {{__('admin.Unlimited')}}
                                            </td>
                                        @else
                                            <td>
                                                {{ $order->maximum_staff }}
                                            </td>
                                        @endif

                                    </tr>

                                    <tr>
                                        <td>{{__('admin.Maximum Gallery Image')}}</td>
                                        @if ($order->maximum_image == -1)
                                        <td>
                                            {{__('admin.Unlimited')}}
                                        </td>
                                        @else
                                        <td>
                                            {{ $order->maximum_image }}
                                        </td>
                                        @endif

                                    </tr>

                                    <tr>
                                        <td>{{__('admin.Maximum Video Gallery')}}</td>
                                        @if ($order->maximum_video == -1)
                                        <td>
                                            {{__('admin.Unlimited')}}
                                        </td>
                                        @else
                                        <td>
                                            {{ $order->maximum_video }}
                                        </td>
                                        @endif

                                    </tr>

                                    <tr>
                                        <td>{{__('admin.Maximum Chamber')}}</td>

                                        @if ($order->maximum_chamber == -1)
                                        <td>
                                            {{__('admin.Unlimited')}}
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

              <div class="text-md-right print-area">
                <hr>
                @if ($order->payment_status == 0)
                <a href="{{ route('admin.payment-approved', $order->id) }}" class="btn btn-success btn-icon icon-left">{{__('admin.Approve Payment')}}</a>
                @endif
                <button class="btn btn-danger btn-icon icon-left" data-toggle="modal" data-target="#deleteModal" onclick="deleteData({{ $order->id }})"><i class="fas fa-times"></i> {{__('admin.Delete')}}</button>
              </div>
            </div>
          </div>
        </section>
      </div>
      <script>
        function deleteData(id){
            $("#deleteForm").attr("action",'{{ url("admin/delete-order/") }}'+"/"+id)
        }
    </script>
@endsection
