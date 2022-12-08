@extends('doctor.layout')
@section('title')
<title>{{__('user.Prescription')}}</title>
@endsection
@section('doctor-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('user.Prescription')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('doctor.dashboard') }}">{{__('user.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('user.Prescription')}}</div>
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
                                    <th>{{__('user.Status')}}</th>
                                    <th>{{__('user.Action')}}</th>
                                  </tr>
                            </thead>
                            <tbody>
                                @foreach ($prescriptions as $index => $prescription)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $prescription->user->name }}</td>
                                        <td>{{ date('d F, Y', strtotime($prescription->date)) }}</td>
                                        <td>
                                            {{ date('h:i A', strtotime($prescription->schedule->start_time)) }} - {{ date('h:i A', strtotime($prescription->schedule->end_time)) }}
                                        </td>
                                        <td>{{ $prescription->chamber->name }}</td>
                                        <td>
                                            @if ($prescription->already_treated == 1)
                                                <span class="badge badge-success">{{__('user.Treated')}}</span>
                                            @else
                                            <span class="badge badge-danger">{{__('user.Pending')}}</span>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('doctor.show-prescription', $prescription->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
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
