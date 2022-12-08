@extends('doctor.layout')
@section('title')
<title>{{ $title }}</title>
@endsection
@section('doctor-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{ $title }}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('doctor.dashboard') }}">{{__('user.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{ $title }}</div>
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
                                    <th>{{__('user.Patient')}}</th>
                                    <th>{{__('user.Order Id')}}</th>
                                    <th>{{__('user.Amount')}}</th>
                                    <th>{{__('user.Date')}}</th>
                                    <th>{{__('user.Status')}}</th>
                                    <th>{{__('user.Action')}}</th>

                                  </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $index => $payment)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $payment->user->name }}</td>
                                        <td>{{ $payment->invoice_id }}</td>
                                        <td>{{ $setting->currency_icon }}{{ $payment->total_fee }}</td>
                                        <td>{{ date('d F, Y', strtotime($payment->created_at)) }}</td>
                                        <td>
                                            @if ($payment->status == 1)
                                                <span class="badge badge-success">{{__('user.Success')}}</span>
                                            @else
                                            <span class="badge badge-danger">{{__('user.Pending')}}</span>
                                            @endif
                                        </td>

                                        <td>
                                        <a href="{{ route('doctor.show-payment',$payment->invoice_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                        <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-sm" onclick="deleteData({{ $payment->id }})"><i class="fa fa-trash" aria-hidden="true"></i></a>

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

      <script>
        function deleteData(id){
            $("#deleteForm").attr("action",'{{ url("doctor/delete-payment/") }}'+"/"+id)
        }
    </script>

@endsection
