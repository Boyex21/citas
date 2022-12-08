@extends('doctor.layout')
@section('title')
<title>{{__('user.Meeting History')}}</title>
@endsection
@section('doctor-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('user.Meeting History')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('doctor.dashboard') }}">{{__('user.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('user.Meeting History')}}</div>
            </div>
          </div>

          <div class="section-body">
            <a href="{{ route('doctor.create-zoom-meeting') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{__('user.Add New')}}</a>
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
                                    <th>{{__('user.Time')}}</th>
                                    <th>{{__('user.Duration')}}</th>
                                    <th>{{__('user.Meeting Id')}}</th>
                                  </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i=0;
                                @endphp
                                @foreach ($histories as $index => $meeting)
                                    @php
                                            $now=date('Y-m-d h:i:A');
                                    @endphp
                                    @if ($now > date('Y-m-d h:i:A',strtotime($meeting->meeting_time)))
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $meeting->user->name }}</td>
                                            <td>
                                                {{ date('Y-m-d h:i:A',strtotime($meeting->meeting_time)) }}
                                            </td>
                                            <td>{{ $meeting->duration }} {{__('user.Minutes')}}</td>
                                            <td>{{ $meeting->meeting_id }}</td>
                                            </td>
                                        </tr>
                                    @endif
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
