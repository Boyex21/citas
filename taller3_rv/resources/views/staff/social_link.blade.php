@extends('staff.layout')
@section('title')
<title>{{__('user.Social Link')}}</title>
@endsection
@section('staff-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('user.Social Link')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('staff.dashboard') }}">{{__('user.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('user.Social Link')}}</div>
            </div>
          </div>

          <div class="section-body">
            <div class="row mt-4">
                <div class="col">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('staff.store-social-link') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="">{{__('user.Icon')}} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control custom-icon-picker" name="icon"  required autocomplete="off">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">{{__('user.Link')}} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="link"  required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">{{__('user.Save')}}</button>
                        </form>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-body">
                      <div class="table-responsive table-invoice">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>{{__('user.Icon')}}</th>
                                    <th>{{__('user.Link')}}</th>
                                    <th>{{__('user.Action')}}</th>
                                  </tr>
                            </thead>
                            <tbody>
                                @foreach ($socialLinks as $index => $link)
                                    <tr>
                                        <td>
                                            <i class="{{ $link->icon }}"></i>
                                        </td>
                                         <td>
                                            <a href="{{ $link->link }}">{{ $link->link }}</a>
                                        </td>

                                        <td>
                                        <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-sm" onclick="deleteData({{ $link->id }})"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
            $("#deleteForm").attr("action",'{{ url("staff/delete-social-link/") }}'+"/"+id)
        }
    </script>
@endsection
