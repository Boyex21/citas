@extends('doctor.layout')
@section('title')
<title>{{__('user.Zoom Meeting')}}</title>
@endsection
@section('doctor-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('user.Zoom Meeting')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('doctor.dashboard') }}">{{__('user.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('user.Zoom Meeting')}}</div>
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
                                    <th>{{__('user.Start time')}}</th>
                                    <th>{{__('user.Duration')}}</th>
                                    <th>{{__('user.Meeting Id')}}</th>
                                    <th>{{__('user.Password')}}</th>
                                    <th>{{__('user.Action')}}</th>

                                  </tr>
                            </thead>
                            <tbody>
                                @foreach ($meetings as $index => $meeting)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ date('Y-m-d h:i:A',strtotime($meeting->start_time)) }}</td>
                                        <td>{{ $meeting->duration }} {{__('user.Minutes')}}</td>
                                        <td>{{ $meeting->meeting_id }}</td>
                                        <td>{{ $meeting->password }}</td>

                                        <td>

                                            @if (env('APP_VERSION') == 0)
                                                <a id="zoom_demo_mode" href="javascript:;"  class="btn btn-success btn-sm"><i class="fas fa-video"></i></a>
                                            @else
                                                <a target="_blank" href="{{ $meeting->join_url }}" class="btn btn-success btn-sm"><i class="fas fa-video"></i></a>
                                            @endif

                                            <a href="{{ route('doctor.edit-zoom-meeting', $meeting->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>

                                            <a onclick="deleteData({{ $meeting->id }})" href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
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
                $("#deleteForm").attr("action",'{{ url("doctor/delete-zoom-meeting/") }}'+"/"+id)
            }
      </script>
@endsection
