@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Service Video')}}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Service Video')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item active"><a href="{{ route('admin.service.index') }}">{{__('admin.Service')}}</a></div>
              <div class="breadcrumb-item">{{__('admin.Service Video')}}</div>
            </div>
          </div>

          <div class="section-body">
            <a href="{{ route('admin.service.index') }}" class="btn btn-primary"><i class="fas fa-list"></i> {{__('admin.Service')}}</a>
            <div class="row mt-4">
                <div class="col">
                  <div class="card">
                    <div class="card-header">
                        <h1>{{__('admin.Service')}} : {{ $service->name }}</h1>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.store-service-video') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="">{{__('admin.New Video Link')}}</label>
                                <input type="text" class="form-control" name="link" required>
                            </div>
                            <input type="hidden" name="service_id" required value="{{ $service->id }}">
                            <button type="submit" class="btn btn-primary">{{__('admin.Save')}}</button>
                        </form>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-body">
                      <div class="table-responsive table-invoice">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>{{__('admin.Video')}}</th>
                                    <th>{{__('admin.Action')}}</th>
                                  </tr>
                            </thead>
                            <tbody>
                                @foreach ($videos as $index => $video)
                                    <tr>
                                        @php
                                            $video_id=explode("=",$video->video_link);
                                        @endphp
                                        <td>
                                            <iframe width="320" height="215"
                                            src="https://www.youtube.com/embed/{{ $video_id[1] }}">
                                            </iframe>
                                        </td>
                                        <td>
                                        <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-sm" onclick="deleteData({{ $video->id }})"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
        $("#deleteForm").attr("action",'{{ url("admin/delete-service-video/") }}'+"/"+id)
    }
</script>
@endsection
