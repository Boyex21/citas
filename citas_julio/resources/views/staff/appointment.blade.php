@extends('staff.layout')
@section('title')
<title>{{ $title }}</title>
@endsection
@section('staff-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{ $title }}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('staff.dashboard') }}">{{__('user.Dashboard')}}</a></div>
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
                                    <th>{{__('user.Date')}}</th>
                                    <th>{{__('user.Schedule')}}</th>
                                    <th>{{__('user.Chamber')}}</th>
                                    <th>{{__('user.Consultation Type')}}</th>
                                    <th>{{__('user.Status')}}</th>
                                    <th>{{__('user.Action')}}</th>
                                  </tr>
                            </thead>
                            <tbody>
                                @foreach ($appointments as $index => $appointment)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $appointment->user->name }}</td>
                                        <td>{{ date('d F, Y', strtotime($appointment->date)) }}</td>
                                        <td>
                                            {{ date('h:i A', strtotime($appointment->schedule->start_time)) }} - {{ date('h:i A', strtotime($appointment->schedule->end_time)) }}
                                        </td>
                                        <td>{{ $appointment->chamber->name }}</td>

                                        <td>
                                            @if ($appointment->consultation_type == 1)
                                                <span class="badge badge-warning">{{__('user.Online')}}</span>
                                            @else
                                            <span class="badge badge-success">{{__('user.Offline')}}</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if ($appointment->already_treated == 1)
                                                <span class="badge badge-success">{{__('user.Treated')}}</span>
                                            @else
                                            <span class="badge badge-danger">{{__('user.Pending')}}</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if ($appointment->already_treated == 1)
                                                <a href="{{ route('staff.show-appointment', $appointment->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            @else
                                                <a href="javascript:;" class="btn btn-primary btn-sm disabled"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            @endif

                                            <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-sm" onclick="deleteData({{ $appointment->id }})"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
            $("#deleteForm").attr("action",'{{ url("staff/delete-appointment/") }}'+"/"+id)
        }
    </script>
@endsection
