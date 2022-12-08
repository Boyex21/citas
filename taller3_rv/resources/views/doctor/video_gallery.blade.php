@extends('doctor.layout')
@section('title')
<title>{{__('user.Video Gallery')}}</title>
@endsection
@section('doctor-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('user.Video Gallery')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('doctor.dashboard') }}">{{__('user.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('user.Video Gallery')}}</div>
            </div>
          </div>

          <div class="section-body">
            <div class="row mt-4">
                <div class="col">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('doctor.store-video-gallery') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="">{{__('user.New Video')}}</label>
                                <input type="text" class="form-control" name="link"  required>
                            </div>

                            <button type="submit" class="btn btn-primary">{{__('user.Upload')}}</button>
                        </form>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-body">
                      <div class="table-responsive table-invoice">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>{{__('user.Video')}}</th>
                                    <th>{{__('user.Action')}}</th>
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
            $("#deleteForm").attr("action",'{{ url("doctor/delete-gallery-video/") }}'+"/"+id)
        }
    </script>
@endsection
