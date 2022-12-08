@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Pricing Plan')}}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Create Pricing Plan')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item active"><a href="{{ route('admin.pricing-plan.index') }}">{{__('admin.Pricing Plan')}}</a></div>
              <div class="breadcrumb-item">{{__('admin.Create Pricing Plan')}}</div>
            </div>
          </div>

          <div class="section-body">
            <a href="{{ route('admin.pricing-plan.index') }}" class="btn btn-primary"><i class="fas fa-list"></i> {{__('admin.Pricing Plan')}}</a>
            <div class="row mt-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">

                        <span class="d-block text-danger">* {{__('admin.Set 0 price for free package')}}</span>
                        <span class="d-block text-danger">* {{__('admin.Set -1 for unlimited Quantity')}}</span>
                        <span class="d-block text-danger">* {{__('admin.Set 0 staff for not available')}}</span>
                        <br>

                        <form action="{{ route('admin.pricing-plan.update', $package->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{__('admin.Name')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" id="name" value="{{ $package->name }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="price">{{__('admin.Price')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="price" class="form-control"  value="{{ $package->price }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="expiration_day">{{__('admin.Number of expiration day')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="expiration_day" class="form-control" value="{{ $package->expiration_day }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="daily_appointment_qty">{{__('admin.Daily maximum appointment')}} <span class="text-danger">*</span></label>
                                        <input type="number" name="daily_appointment_qty" class="form-control" value="{{ $package->daily_appointment_qty }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="maximum_chamber">{{__('admin.Number of Chamber')}} <span class="text-danger">*</span></label>
                                        <input type="number" name="maximum_chamber" class="form-control" value="{{ $package->maximum_chamber }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="maximum_staff">{{__('admin.Number of staff')}} <span class="text-danger">*</span></label>
                                        <input type="number" name="maximum_staff" class="form-control" value="{{ $package->maximum_staff }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="maximum_image">{{__('admin.Maximum Image')}} <span class="text-danger">*</span></label>
                                        <input type="number" name="maximum_image" class="form-control" value="{{ $package->maximum_image }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="maximum_video">{{__('admin.Maximum Video')}} <span class="text-danger">*</span></label>
                                        <input type="number" name="maximum_video" class="form-control" value="{{ $package->maximum_video }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="online_consulting">{{__('admin.Online Consulting')}} <span class="text-danger">*</span></label>
                                        <select name="online_consulting" id="online_consulting" class="form-control">
                                            <option {{ $package->online_consulting == 1 ? 'selected' : '' }}  value="1">{{__('admin.Enable')}}</option>
                                            <option {{ $package->online_consulting == 0 ? 'selected' : '' }} value="0">{{__('admin.Disable')}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="message_system">{{__('admin.Message System with patient')}} <span class="text-danger">*</span></label>
                                        <select name="message_system" id="message_system" class="form-control">
                                            <option {{ $package->message_system == 1 ? 'selected' : '' }}  value="1">{{__('admin.Enable')}}</option>
                                            <option {{ $package->message_system == 0 ? 'selected' : '' }} value="0">{{__('admin.Disable')}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="online_prescription">{{__('admin.Online Prescription')}} <span class="text-danger">*</span></label>
                                        <select name="online_prescription" id="online_prescription" class="form-control">
                                            <option {{ $package->online_prescription == 1 ? 'selected' : '' }} value="1">{{__('admin.Enable')}}</option>
                                            <option {{ $package->online_prescription == 0 ? 'selected' : '' }} value="0">{{__('admin.Disable')}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="review_system">{{__('admin.Review System')}} <span class="text-danger">*</span></label>
                                        <select name="review_system" id="review_system" class="form-control">
                                            <option {{ $package->review_system == 1 ? 'selected' : '' }} value="1">{{__('admin.Enable')}}</option>
                                            <option {{ $package->review_system == 0 ? 'selected' : '' }} value="0">{{__('admin.Disable')}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="status">{{__('admin.Status')}} <span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-control">
                                            <option {{ $package->status == 1 ? 'selected' : '' }} value="1">{{__('admin.Enable')}}</option>
                                            <option {{ $package->status == 0 ? 'selected' : '' }} value="0">{{__('admin.Disable')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success">{{__('admin.Save')}}</button>
                        </form>

                    </div>
                  </div>
                </div>
          </div>
        </section>
      </div>
@endsection
