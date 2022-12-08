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
            <a href="{{ route('doctor.zoom-meeting') }}" class="btn btn-primary"><i class="fas fa-list"></i> {{__('user.Zoom Meeting')}}</a>
            <div class="row mt-4">
                <div class="col">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('doctor.update-zoom-meeting', $meeting->meeting_id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="">{{__('user.Patient')}} <span class="text-danger">*</span></label>
                                <select name="patient" id="" class="form-control select2">
                                    <option value="">{{__('user.Select Patient')}}</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->phone }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">{{__('user.Topic')}} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="topic" autocomplete="off" value="{{ $meeting->topic }}">
                            </div>

                            <div class="form-group">
                                <label for="">{{__('user.Start Time')}} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control datetimepicker_mask" name="start_time" autocomplete="off" value="{{ $meeting->start_time }}">
                            </div>

                            <div class="form-group">
                                <label for="">{{__('user.Duration')}} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="duration" autocomplete="off" value="{{ $meeting->duration }}">
                            </div>

                            <button type="submit" class="btn btn-primary">{{__('user.Save')}}</button>
                        </form>
                    </div>
                  </div>
                </div>
          </div>
        </section>
      </div>

@endsection
