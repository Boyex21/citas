@extends('admin.master_layout')
@section('title')
<title>{{__('admin.About Us')}}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.About Us')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('admin.About Us')}}</div>
            </div>
          </div>

            <div class="section-body">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                  <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{__('admin.About Us')}}</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                  <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">{{__('admin.Mission')}}</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                  <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">{{__('admin.Vision')}}</a>
                                </li>
                              </ul>
                              <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active mt-5" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    <form action="{{ route('admin.about-us.update', $about->id) }}" enctype="multipart/form-data" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">{{__('admin.Existing Image')}}</label>
                                                    <div><img width="200px" src="{{ $about->about_image ? url($about->about_image) : '' }}" alt="About Image"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">{{__('admin.New Image')}}</label>
                                                    <input type="file" class="form-control-file" name="image">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">{{__('admin.Existing Background Image')}}</label>
                                                    <div><img width="200px" src="{{ $about->background_image ? url($about->background_image) : '' }}" alt="About Background Image"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">{{__('admin.New Image')}}</label>
                                                    <input type="file" class="form-control-file" name="background_image">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="sep"></div>

                                        <div class="form-group">
                                            <label for="about_description">{{__('admin.Description')}}</label>
                                            <textarea name="about_description" id="summernote">{!! clean($about->about_description) !!}</textarea>
                                        </div>

                                        <button class="btn btn-success" type="submit">{{__('admin.Update')}}</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade mt-5" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <form action="{{ route('admin.update-mission', $about->id) }}" enctype="multipart/form-data" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="">{{__('admin.Existing Image')}}</label>
                                            <div><img width="200px" src="{{ $about->mission_image ? url($about->mission_image) : '' }}" alt="Mission Image"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="">{{__('admin.New Image')}}</label>
                                            <input type="file" class="form-control-file" name="image">
                                        </div>

                                        <div class="form-group">
                                            <label for="mission_description">{{__('admin.Description')}}</label>
                                            <textarea name="mission_description" id="summernote2">{!! clean($about->mission_description) !!}</textarea>
                                        </div>


                                        <button class="btn btn-success" type="submit">{{__('admin.Update')}}</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade mt-5" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                    <form action="{{ route('admin.update-vision', $about->id) }}" enctype="multipart/form-data" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="">{{__('admin.Existing Image')}}</label>
                                            <div><img width="200px" src="{{ $about->vision_image ? url($about->vision_image) : '' }}" alt="Vision Image"></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="">{{__('admin.New Image')}}</label>
                                            <input type="file" name="image" class="form-control-file">
                                        </div>

                                        <div class="form-group">
                                            <label for="">{{__('admin.Description')}}</label>
                                            <textarea name="vision_description" id="summernote3">{!! clean($about->vision_description) !!}</textarea>
                                        </div>

                                        <button class="btn btn-success" type="submit">{{__('admin.Update')}}</button>
                                    </form>
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
      </div>
@endsection
