@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Service')}}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Service')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('admin.Service')}}</div>
            </div>
          </div>

          <div class="section-body">
            <a href="{{ route('admin.service.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{__('admin.Add New')}}</a>
            <div class="row mt-4">
                <div class="col">
                  <div class="card">
                    <div class="card-body">
                      <div class="table-responsive table-invoice">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th>{{__('admin.SN')}}</th>
                                    <th width="20%">{{__('admin.Name')}}</th>
                                    <th width="10%">{{__('admin.Icon')}}</th>
                                    <th width="15%">{{__('admin.Show Homepage')}}</th>
                                    <th>{{__('admin.Status')}}</th>
                                    <th>{{__('admin.Action')}}</th>
                                  </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $index => $service)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $service->name }}</td>
                                        <td><i class="{{ $service->icon }}"></i></td>
                                        <td>
                                            @if($service->show_homepage == 1)
                                                <span class="badge badge-success">{{__('admin.Enable')}}</span>
                                            @else
                                            <span class="badge badge-danger">{{__('admin.Disable')}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($service->status == 1)
                                            <a href="javascript:;" onclick="changeServiceStatus({{ $service->id }})">
                                                <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="{{__('admin.Active')}}" data-off="{{__('admin.InActive')}}" data-onstyle="success" data-offstyle="danger">
                                            </a>
                                            @else
                                            <a href="javascript:;" onclick="changeServiceStatus({{ $service->id }})">
                                                <input id="status_toggle" type="checkbox" data-toggle="toggle" data-on="{{__('admin.Active')}}" data-off="{{__('admin.InActive')}}" data-onstyle="success" data-offstyle="danger">
                                            </a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.service.edit',$service->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                            <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-sm" onclick="deleteData({{ $service->id }})"><i class="fa fa-trash" aria-hidden="true"></i></a>

                                            <div class="dropdown d-inline">
                                                <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  <i class="fas fa-list"></i>
                                                </button>

                                                <div class="dropdown-menu" x-placement="top-start" >
                                                  <a class="dropdown-item has-icon" href="{{ route('admin.service.gallery', $service->id) }}"><i class="far fa-image"></i> {{__('admin.Image Gallery')}}</a>

                                                  <a class="dropdown-item has-icon" href="{{ route('admin.service.video', $service->id) }}"><i class="fas fa-solid fa-video"></i> {{__('admin.Video')}}</a>

                                                  <a class="dropdown-item has-icon" href="{{ route('admin.service.faq', $service->id) }}"><i class="fas fa-question"></i>{{__('admin.FAQ')}}</a>

                                                </div>
                                              </div>

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
        $("#deleteForm").attr("action",'{{ url("admin/service/") }}'+"/"+id)
    }
    function changeServiceStatus(id){
        var isDemo = "{{ env('APP_VERSION') }}"
        if(isDemo == 0){
            toastr.error('This Is Demo Version. You Can Not Change Anything');
            return;
        }
        $.ajax({
            type:"put",
            data: { _token : '{{ csrf_token() }}' },
            url:"{{url('/admin/service-status/')}}"+"/"+id,
            success:function(response){
                toastr.success(response)
            },
            error:function(err){
                console.log(err);

            }
        })
    }
</script>
@endsection
