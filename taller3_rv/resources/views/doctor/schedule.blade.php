@extends('doctor.layout')
@section('title')
<title>{{__('user.Schedule')}}</title>
@endsection
@section('doctor-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('user.Schedule')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('doctor.dashboard') }}">{{__('user.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('user.Schedule')}}</div>
            </div>
          </div>

          <div class="section-body">
            <a href="{{ route('doctor.schedule.create') }}"  class="btn btn-primary"><i class="fas fa-plus"></i> {{__('user.Add New')}}</a>
            <div class="row mt-4">
                <div class="col">
                  <div class="card">
                    <div class="card-body">
                      <div class="table-responsive table-invoice">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th>{{__('user.SN')}}</th>
                                    <th>{{__('user.Day')}}</th>
                                    <th>{{__('user.Chamber')}}</th>
                                    <th>{{__('user.Start time')}}</th>
                                    <th>{{__('user.End time')}}</th>
                                    <th>{{__('user.Limit')}}</th>
                                    <th>{{__('user.Status')}}</th>
                                    <th>{{__('user.Action')}}</th>
                                  </tr>
                            </thead>
                            <tbody>
                                @foreach ($schedules as $index => $schedule)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $schedule->day->custom_day }}</td>
                                        <td>{{ $schedule->chamber->name }}</td>
                                        <td>{{ date('h:i A', strtotime($schedule->start_time)) }}</td>
                                        <td>{{ date('h:i A', strtotime($schedule->end_time)) }}</td>
                                        <td>{{ $schedule->appointment_limit }}</td>
                                        <td>
                                            @if($schedule->status == 1)
                                                <a href="javascript:;" onclick="changeFeatureStatus({{ $schedule->id }})">
                                                    <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="{{__('user.Active')}}" data-off="{{__('user.InActive')}}" data-onstyle="success" data-offstyle="danger">
                                                </a>
                                            @else
                                                <a href="javascript:;" onclick="changeFeatureStatus({{ $schedule->id }})">
                                                    <input id="status_toggle" type="checkbox" data-toggle="toggle" data-on="{{__('user.Active')}}" data-off="{{__('user.InActive')}}" data-onstyle="success" data-offstyle="danger">
                                                </a>
                                            @endif
                                        </td>
                                        <td>

                                        <a href="{{ route('doctor.schedule.edit', $schedule->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>

                                        @if ($schedule->appointments->count() == 0)
                                            <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-sm" onclick="deleteData({{ $schedule->id }})"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        @else
                                            <a href="javascript:;" data-toggle="modal" data-target="#canNotDeleteModal" class="btn btn-danger btn-sm" disabled><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        @endif

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


       <!-- Modal -->
       <div class="modal fade" id="canNotDeleteModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                      <div class="modal-body">
                          {{__('user.You can not delete this schedule. Because there are one or more appointments has been created in this schedule.')}}
                      </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('user.Close')}}</button>
                </div>
            </div>
        </div>
    </div>



<script>
    function deleteData(id){
        $("#deleteForm").attr("action",'{{ url("doctor/schedule/") }}'+"/"+id)
    }
    function changeFeatureStatus(id){
        var isDemo = "{{ env('APP_VERSION') }}"
        if(isDemo == 0){
            toastr.error('This Is Demo Version. You Can Not Change Anything');
            return;
        }
        $.ajax({
            type:"put",
            data: { _token : '{{ csrf_token() }}' },
            url:"{{url('/doctor/schedule-status/')}}"+"/"+id,
            success:function(response){
                toastr.success(response)
            },
            error:function(err){
                console.log(err);

            }
        })
    }
</script>

@endsection
