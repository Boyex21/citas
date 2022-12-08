@extends('doctor.layout')
@section('title')
<title>{{__('user.Chamber')}}</title>
@endsection
@section('doctor-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('user.Chamber')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('doctor.dashboard') }}">{{__('user.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('user.Chamber')}}</div>
            </div>
          </div>

          <div class="section-body">
            <a href="javascript:;" data-toggle="modal" data-target="#createFaqCategory" class="btn btn-primary"><i class="fas fa-plus"></i> {{__('user.Add New')}}</a>
            <div class="row mt-4">
                <div class="col">
                  <div class="card">
                    <div class="card-body">
                      <div class="table-responsive table-invoice">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th>{{__('user.SN')}}</th>
                                    <th>{{__('user.Name')}}</th>
                                    <th>{{__('user.Address')}}</th>
                                    <th>{{__('user.Status')}}</th>
                                    <th>{{__('user.Action')}}</th>
                                  </tr>
                            </thead>
                            <tbody>
                                @foreach ($chambers as $index => $chamber)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $chamber->name }}</td>
                                        <td>{{ $chamber->address }}</td>
                                        <td>
                                            @if($chamber->status == 1)
                                                <span class="badge badge-success">{{__('user.Active')}}</span>
                                            @else
                                                <span class="badge badge-danger">{{__('user.InActive')}}</span>
                                            @endif
                                        </td>
                                        <td>

                                        <a href="javascript:;" data-toggle="modal" data-target="#editFaqCategory-{{ $chamber->id }}" class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>

                                        @if ($chamber->staffs->count() == 0 && $chamber->appointments->count() == 0 && $chamber->schedules->count() == 0)
                                            <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-sm" onclick="deleteData({{ $chamber->id }})"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        @else
                                            <a href="javascript:;" data-toggle="modal" data-target="#canNotDeleteModal" class="btn btn-danger btn-sm" disabled><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        @endif
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

      <!-- Modal -->
      <div class="modal fade" id="canNotDeleteModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                      <div class="modal-body">
                          {{__('user.You can not delete this chamber. Because there are one or more staff, appointment has been created in this staff.')}}
                      </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('user.Close')}}</button>
                </div>
            </div>
        </div>
    </div>


      <!-- Modal -->
      <div class="modal fade" id="createFaqCategory" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                      <div class="modal-header">
                              <h5 class="modal-title">{{__('user.Create Chamber')}}</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                          </div>
                  <div class="modal-body">
                      <div class="container-fluid">
                        <form action="{{ route('doctor.chamber.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>{{__('user.Name')}} <span class="text-danger">*</span></label>
                                    <input type="text" id="name" class="form-control"  name="name" value="{{ old('name') }}">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('user.Address')}} <span class="text-danger">*</span></label>
                                    <textarea name="address" id="" class="form-control text-area-5" cols="30" rows="10"></textarea>
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('user.Contact')}} <span class="text-danger">*</span></label>
                                    <textarea name="contact" id="" class="form-control text-area-5" cols="30" rows="10"></textarea>
                                </div>



                                <div class="form-group col-12">
                                    <label>{{__('user.Status')}} <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        <option value="1">{{__('user.Active')}}</option>
                                        <option value="0">{{__('user.Inactive')}}</option>
                                    </select>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-primary">{{__('user.Save')}}</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('user.Close')}}</button>

                                </div>
                            </div>
                        </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      @foreach ($chambers as $index => $chamber)
        <div class="modal fade" id="editFaqCategory-{{ $chamber->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title">{{__('user.Edit Chamber')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                        <form action="{{ route('doctor.chamber.update', $chamber->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>{{__('user.Name')}} <span class="text-danger">*</span></label>
                                    <input type="text" id="name" class="form-control"  name="name" value="{{ $chamber->name }}">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('user.Address')}} <span class="text-danger">*</span></label>
                                    <textarea name="address" id="" class="form-control text-area-5" cols="30" rows="10">{{ $chamber->address }}</textarea>
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('user.Contact')}} <span class="text-danger">*</span></label>
                                    <textarea name="contact" id="" class="form-control text-area-5" cols="30" rows="10">{{ $chamber->contact }}</textarea>
                                </div>



                                <div class="form-group col-12">
                                    <label>{{__('user.Status')}} <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        <option {{ $chamber->status == 1 ? 'selected' : '' }} value="1">{{__('user.Active')}}</option>
                                        <option {{ $chamber->status == 0 ? 'selected' : '' }} value="0">{{__('user.Inactive')}}</option>
                                    </select>
                                </div>

                            </div>


                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-primary">{{__('user.Update')}}</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('user.Close')}}</button>

                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      @endforeach



<script>
    function deleteData(id){
        $("#deleteForm").attr("action",'{{ url("doctor/chamber/") }}'+"/"+id)
    }
    function setDefault(id){
        var isDemo = "{{ env('APP_VERSION') }}"
        if(isDemo == 0){
            toastr.error('This Is Demo Version. You Can Not Change Anything');
            return;
        }
        $.ajax({
            type:"put",
            data: { _token : '{{ csrf_token() }}' },
            url:"{{url('/doctor/set-default/')}}"+"/"+id,
            success:function(response){
                if(response.status == 1){
                    location.reload();
                }
            },
            error:function(err){
                console.log(err);
            }
        })
    }
</script>
@endsection
