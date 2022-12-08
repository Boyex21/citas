@extends('staff.layout')
@section('title')
<title>{{__('user.My Profile')}}</title>
@endsection
@section('staff-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('user.My Profile')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('staff.dashboard') }}">{{__('user.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('user.My Profile')}}</div>
            </div>
          </div>
          <div class="section-body">
            <div class="row mt-sm-4">
              <div class="col-md-12">
                <div class="card profile-widget">
                  <div class="profile-widget-header">
                      @if ($staff->image)
                      <img alt="image" src="{{ asset($staff->image) }}" class="rounded-circle profile-widget-picture">
                      @else
                      <img alt="image" src="{{ asset($defaultProfile->image) }}" class="rounded-circle profile-widget-picture">
                      @endif
                  </div>
                  <div class="profile-widget-description">
                    <form action="{{ route('staff.profile.update') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('PUT')
                        <div class="row">
                            <div class="form-group col-md-12">
                            <label>{{__('user.New Image')}}</label>
                            <input type="file" class="form-control-file" name="image">
                            </div>
                            <div class="form-group col-md-12">
                                <label>{{__('user.Name')}} <span class="text-danger">*</span></label>
                                <input type="text" id="name" class="form-control" value="{{ $staff->name }}" name="name">
                            </div>

                            <div class="form-group col-md-12">
                                <label>{{__('user.Email')}} <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" value="{{ $staff->email }}" name="email" readonly>
                            </div>

                            <div class="form-group col-md-12">
                                <label>{{__('user.Password')}} </label>
                                <input type="password" class="form-control"  name="password">
                            </div>

                            <div class="form-group col-md-12">
                                <label>{{__('user.Confirm Password')}} </label>
                                <input type="password" class="form-control"  name="password_confirmation">
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-primary">{{__('user.Update')}}</button>
                            </div>
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
