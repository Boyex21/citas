@extends('doctor.layout')
@section('title')
<title>{{__('user.Order')}}</title>
@endsection
@section('doctor-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('user.Order')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('doctor.dashboard') }}">{{__('user.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('user.Order')}}</div>
            </div>
          </div>

          <div class="section-body">
            <div class="row mt-4">
                <div class="col">
                  <div class="card">
                    <div class="card-body">
                      <div class="table-responsive table-invoice">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th>{{__('user.SN')}}</th>
                                    <th>{{__('user.Order Id')}}</th>
                                    <th>{{__('user.Amount')}}</th>
                                    <th>{{__('user.Purchase Date')}}</th>
                                    <th>{{__('user.Order Status')}}</th>
                                    <th>{{__('user.Action')}}</th>

                                  </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $index => $order)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $order->order_id }}</td>
                                        <td>{{ $setting->currency_icon }}{{ $order->amount }}</td>
                                        <td>{{ date('d F, Y', strtotime($order->purchase_date)) }}</td>
                                        <td>
                                            @if ($order->status == 1)
                                                <span class="badge badge-success">{{__('user.Success')}}</span>
                                            @elseif ($order->status == 2)
                                                <span class="badge badge-danger">{{__('user.Expired')}}</span>
                                            @else
                                            <span class="badge badge-danger">{{__('user.Pending')}}</span>
                                            @endif
                                        </td>

                                        <td>
                                        <a href="{{ route('doctor.order-show',$order->order_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>
                                  @endforeach
                            </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
          </div>
        </section>
      </div>
@endsection
