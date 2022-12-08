@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Appointment History')}}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Appointment History')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('admin.Appointment History')}}</div>
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
                                    <th>{{__('admin.SN')}}</th>
                                    <th>{{__('admin.Doctor')}}</th>
                                    <th>{{__('admin.Patient')}}</th>
                                    <th>{{__('admin.Date')}}</th>
                                    <th>{{__('admin.Schedule')}}</th>
                                    <th>{{__('admin.Chamber')}}</th>
                                    <th>{{__('admin.Consultation Type')}}</th>
                                    <th>{{__('admin.Status')}}</th>
                                    <th>{{__('admin.Fee')}}</th>
                                  </tr>
                            </thead>
                            <tbody>
                                @foreach ($appointments as $index => $appointment)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $appointment->doctor->name }}</td>
                                        <td>{{ $appointment->user->name }}</td>
                                        <td>{{ date('d F, Y', strtotime($appointment->date)) }}</td>
                                        <td>
                                            {{ date('h:i A', strtotime($appointment->schedule->start_time)) }} - {{ date('h:i A', strtotime($appointment->schedule->end_time)) }}
                                        </td>
                                        <td>{{ $appointment->chamber->name }}</td>

                                        <td>
                                            @if ($appointment->consultation_type == 1)
                                                <span class="badge badge-warning">{{__('admin.Online')}}</span>
                                            @else
                                            <span class="badge badge-success">{{__('admin.Offline')}}</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if ($appointment->already_treated == 1)
                                                <span class="badge badge-success">{{__('admin.Treated')}}</span>
                                            @else
                                            <span class="badge badge-danger">{{__('admin.Pending')}}</span>
                                            @endif
                                        </td>
                                        <td>{{ $setting->currency_icon }}{{ $appointment->fee }}</td>
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
