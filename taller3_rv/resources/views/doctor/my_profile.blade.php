@extends('doctor.layout')
@section('title')
<title>{{__('user.My Profile')}}</title>
@endsection
@section('doctor-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('user.My Profile')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('doctor.dashboard') }}">{{__('user.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('user.My Profile')}}</div>
            </div>
          </div>
          <div class="section-body">
            <div class="row mt-sm-4">
              <div class="col-md-12">
                <div class="card profile-widget">
                  <div class="profile-widget-header">
                      @if ($doctor->image)
                      <img alt="image" src="{{ asset($doctor->image) }}" class="rounded-circle profile-widget-picture">
                      @else
                      <img alt="image" src="{{ asset($defaultProfile->image) }}" class="rounded-circle profile-widget-picture">
                      @endif
                  </div>
                  <div class="profile-widget-description">
                    <form action="{{ route('doctor.profile.update') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('PUT')
                        <div class="row">
                            <div class="form-group col-md-12">
                            <label>{{__('user.New Image')}}</label>
                            <input type="file" class="form-control-file" name="image">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{__('user.Name')}} <span class="text-danger">*</span></label>
                                <input type="text" id="name" class="form-control" value="{{ $doctor->name }}" name="name">
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{__('user.Slug')}} <span class="text-danger">*</span></label>
                                <input type="text" id="slug" class="form-control" value="{{ $doctor->slug }}" name="slug">
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{__('user.Email')}} <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" value="{{ $doctor->email }}" name="email" readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{__('user.Designation')}} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="{{ $doctor->designation }}" name="designation">
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{__('user.Phone')}} </label>
                                <input type="text" class="form-control" value="{{ $doctor->phone }}" name="phone">
                            </div>



                            <div class="form-group col-md-6">
                                <label>{{__('user.Fee')}} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="{{ $doctor->fee }}" name="fee">
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{__('user.Location')}} <span class="text-danger">*</span></label>
                                <select name="location_id" id="" class="form-control select2">
                                    <option value="">{{__('user.Select Location')}}</option>
                                    @foreach ($locations as $location)
                                        <option {{ $location->id == $doctor->location_id ? 'selected' : '' }} value="{{ $location->id }}">{{ $location->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group col-md-6">
                                <label>{{__('user.Department')}} <span class="text-danger">*</span></label>
                                <select name="department_id" id="" class="form-control select2">
                                    <option value="">{{__('user.Select Department')}}</option>
                                    @foreach ($departments as $department)
                                    <option {{ $department->id == $doctor->department_id ? 'selected' : '' }} value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-12">
                                <label>{{__('user.Address')}} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="{{ $doctor->address }}" name="address">
                            </div>

                            <div class="form-group col-md-12">
                                <label>{{__('user.About')}} <span class="text-danger">*</span></label>
                                <textarea name="about" id="summernote" cols="30" rows="10">{{ $doctor->about }}</textarea>
                            </div>

                            <div class="form-group col-md-12">
                                <label>{{__('user.Qualification')}} <span class="text-danger">*</span></label>
                                <textarea name="qualification" id="summernote2" cols="30" rows="10">{{ $doctor->qualifications }}</textarea>
                            </div>

                            <div class="form-group col-md-12">
                                <label>{{__('user.Seo Title')}}</label>
                                <input type="text" class="form-control" name="seo_title" value="{{ $doctor->seo_title }}">
                            </div>

                            <div class="form-group col-md-12">
                                <label>{{__('user.Seo Description')}}</label>
                                <input type="text" class="form-control" name="seo_description" value="{{ $doctor->seo_description }}">
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


<script>
    (function($) {
        "use strict";
        $(document).ready(function () {
            $("#name").on("focusout",function(e){
                $("#slug").val(convertToSlug($(this).val()));
            })
        });
    })(jQuery);

    function convertToSlug(Text)
    {
        return Text
            .toLowerCase()
            .replace(/[^\w ]+/g,'')
            .replace(/ +/g,'-');
    }
</script>
@endsection
