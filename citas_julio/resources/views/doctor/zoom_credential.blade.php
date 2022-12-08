@extends('doctor.layout')
@section('title')
<title>{{__('user.Zoom Setting')}}</title>
@endsection
@section('doctor-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('user.Zoom Setting')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('doctor.dashboard') }}">{{__('user.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('user.Zoom Setting')}}</div>
            </div>
          </div>

          <div class="section-body">
            <div class="row mt-4">
                <div class="col">
                  <div class="card">
                    <div class="card-body">
                        @if ($credential)
                            <form action="{{ route('doctor.update-zoom-credential') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="">{{__('user.Zoom Api Key')}}</label>
                                    <input type="text" class="form-control" name="api_key" value="{{ $credential->zoom_api_key }}">
                                </div>

                                <div class="form-group">
                                    <label for="">{{__('user.Zoom API Secret')}}</label>
                                    <input type="text" class="form-control" name="api_secret" value="{{ $credential->zoom_api_secret }}">
                                </div>

                                <div class="form-group">
                                    <label for="">{{__('user.Live Consultation Status')}}</label>
                                    <div>
                                        @if ($credential->status == 1)
                                            <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="{{__('user.Enable')}}" data-off="{{__('user.Disable')}}" data-onstyle="success" data-offstyle="danger" name="status">
                                            @else
                                            <input id="status_toggle" type="checkbox" data-toggle="toggle" data-on="{{__('user.Enable')}}" data-off="{{__('user.Disable')}}" data-onstyle="success" data-offstyle="danger" name="status">
                                        @endif
                                    </div>
                                </div>


                                <button type="submit" class="btn btn-primary">{{__('user.Save')}}</button>
                            </form>
                        @else
                            <form action="{{ route('doctor.update-zoom-credential') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="">{{__('user.Zoom Api Key')}}</label>
                                    <input type="text" class="form-control" name="api_key" >
                                </div>

                                <div class="form-group">
                                    <label for="">{{__('user.Zoom API Secret')}}</label>
                                    <input type="text" class="form-control" name="api_secret" >
                                </div>

                                <div class="form-group">
                                    <label for="">{{__('user.Live Consultation Status')}}</label>
                                    <div>
                                        <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="{{__('user.Enable')}}" data-off="{{__('user.Disable')}}" data-onstyle="success" data-offstyle="danger" name="status">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">{{__('user.Save')}}</button>
                            </form>
                        @endif
                    </div>
                  </div>
                </div>
          </div>
        </section>
      </div>

@endsection
