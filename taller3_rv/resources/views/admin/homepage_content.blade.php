@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Homepage Content')}}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Homepage Content')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('admin.Homepage Content')}}</div>
            </div>
          </div>

          <div class="section-body">
                <div class="col">
                  <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-3">
                                <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                                    @foreach ($contents as $index => $content)
                                        <li class="nav-item border rounded mb-1">
                                            <a class="nav-link {{ $index == 0  ? 'active' : '' }}" id="error-tab-{{ $content->id }}" data-toggle="tab" href="#errorTab-{{ $content->id }}" role="tab" aria-controls="errorTab-{{ $content->id }}" aria-selected="true">{{ $content->section_name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-12 col-sm-12 col-md-9">
                                <div class="border rounded">
                                    <div class="tab-content no-padding" id="settingsContent">
                                        @foreach ($contents as $index => $content)
                                            <div class="tab-pane fade {{ $index == 0  ? 'show active' : '' }}" id="errorTab-{{ $content->id }}" role="tabpanel" aria-labelledby="error-tab-{{ $content->id }}">
                                                <div class="card m-0">
                                                    <div class="card-body">
                                                        <form action="{{ route('admin.update-homepage-content',$content->id) }}" method="POST" enctype="multipart/form-data">
                                                            @method('PUT')
                                                            @csrf
                                                            <div class="row">

                                                                @if ($content->id == 5)
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label for="">{{__('admin.Existing Background')}}</label>
                                                                            <div>
                                                                                <img width="200px" src="{{ asset($content->image) }}" alt="">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label for="">{{__('admin.New Background')}}</label>
                                                                            <input type="file" name="image" class="form-control-file">
                                                                        </div>
                                                                    </div>
                                                                @endif


                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label for="">{{__('admin.Title')}}</label>
                                                                        <input type="text" name="title" class="form-control" value="{{ $content->title }}">
                                                                    </div>
                                                                </div>


                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label for="">{{__('admin.Description')}}</label>
                                                                        <textarea name="description" id="" cols="30" rows="5" class="form-control text-area-5">{{ filterTag(clean($content->description)) }}</textarea>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">{{__('admin.Update')}}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
          </div>
        </section>
      </div>
@endsection
