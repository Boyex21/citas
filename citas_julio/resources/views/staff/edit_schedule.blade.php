@extends('staff.layout')
@section('title')
<title>{{__('user.Update Schedule')}}</title>
@endsection
@section('staff-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('user.Update Schedule')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('staff.dashboard') }}">{{__('user.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('user.Update Schedule')}}</div>
            </div>
          </div>

          <div class="section-body">
            <a href="{{ route('staff.schedule.index') }}" class="btn btn-primary"><i class="fas fa-list"></i> {{__('user.Schedules')}}</a>
            <div class="row mt-4">
                <div class="col">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('staff.schedule.update', $schedule->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="">{{__('user.Day')}}</label>
                                    <select name="day" id="" class="form-control">
                                        <option value="">{{__('user.Select Day')}}</option>
                                        @foreach ($days as $day)
                                        <option {{ $day->id == $schedule->day_id ? 'selected' : '' }} value="{{ $day->id }}">{{ $day->custom_day }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="">{{__('user.Chamber')}} <span class="text-danger">*</span></label>
                                    <select name="chamber" id="" class="form-control">
                                        <option value="">{{__('user.Select Chamber')}}</option>
                                        @foreach ($chambers as $chamber)
                                        <option {{ $chamber->id == $schedule->chamber_id ? 'selected' : '' }} value="{{ $chamber->id }}">{{ $chamber->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-12">
                                    <label for="start_time">{{__('user.Start Time')}}</label>
                                    <input type="text" name="start_time" class="form-control clockpicker" data-align="top" data-autoclose="true" autocomplete="off" value="{{ $schedule->start_time }}">
                                </div>

                                <div class="form-group col-12">
                                    <label for="end_time">{{__('user.End Time')}}</label>
                                    <input type="text" name="end_time" class="form-control clockpicker" data-align="top" data-autoclose="true" autocomplete="off" value="{{ $schedule->end_time }}">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('user.Appointment Limit')}} <span class="text-danger">*</span></label>
                                    <input type="number" id="appointment_limit" class="form-control"  name="appointment_limit" value="{{ $schedule->appointment_limit }}">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('user.Status')}} <span class="text-danger">*</span></label>
                                    <select name="status" id="" class="form-control">
                                        <option {{ $schedule->status == 1 ? 'selected' : '' }} value="1">{{__('user.Active')}}</option>
                                        <option {{ $schedule->status == 0 ? 'selected' : '' }} value="0">{{__('user.Inactive')}}</option>
                                    </select>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-primary">{{__('user.Update')}}</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('user.Close')}}</button>

                                </div>
                            </div>
                        </form>
                    </div>
                  </div>
                </div>
          </div>
        </section>
      </div>

@endsection
