@extends('staff.layout')
@section('title')
<title>{{__('user.Invoice')}}</title>
@endsection

@section('staff-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('user.Invoice')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('staff.dashboard') }}">{{__('user.Dashboard')}}</a></div>
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
                      <div class="invoice-number">{{__('user.Order Id')}} #{{ $payment->invoice_id }}</div>
                    </div>
                    <hr>

                    @php
                        $user = $payment->user;
                    @endphp
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
                          {{__('user.Method')}}: {{ $payment->payment_method }}<br>
                          {{__('user.Status')}} : @if ($payment->payment_status == 1)
                              <span class="badge badge-success">{{__('user.Success')}}</span>
                              @else
                              <span class="badge badge-danger">{{__('user.Pending')}}</span>
                          @endif <br>
                          {{__('user.Transaction')}}: {!! clean(nl2br($payment->transaction_id)) !!}
                        </address>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row mt-4">
                  <div class="col-md-12">
                    <div class="section-title">{{__('user.Order Summary')}}</div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{__('user.Date')}}</th>
                                        <th>{{__('user.Chamber')}}</th>
                                        <th>{{__('user.Schedule')}}</th>
                                        <th>{{__('user.Fee')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payment->appointments as $index => $item)
                                        <tr>
                                            <td>{{ date('d F, Y',strtotime($item->date)) }}</td>
                                            <td>{{ $item->chamber->name }}</td>
                                            <td>
                                                {{ date('h:i A', strtotime($item->schedule->start_time)) }} - {{ date('h:i A', strtotime($item->schedule->end_time)) }}
                                            <td>
                                                {{ $setting->currency_icon }}{{ $item->fee }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="text-md-right print-area">
                            <hr>
                            @if ($payment->payment_status == 0)
                            <a href="{{ route('staff.payment-approved', $payment->id) }}" class="btn btn-success btn-icon icon-left">{{__('user.Approve Payment')}}</a>
                            @endif
                            <button class="btn btn-danger btn-icon icon-left" data-toggle="modal" data-target="#deleteModal" onclick="deleteData({{ $payment->id }})"><i class="fas fa-times"></i> {{__('user.Delete')}}</button>
                          </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </section>
      </div>
      <script>
        function deleteData(id){
            $("#deleteForm").attr("action",'{{ url("staff/delete-payment/") }}'+"/"+id)
        }
    </script>

@endsection
