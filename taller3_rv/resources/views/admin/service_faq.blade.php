@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Service FAQ')}}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Service FAQ')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('admin.Service FAQ')}}</div>
            </div>
          </div>

          <div class="section-body">
            <a href="{{ route('admin.service.index') }}" class="btn btn-primary"><i class="fas fa-list"></i> {{__('admin.Service')}}</a>
            <a href="javascript:;" data-toggle="modal" data-target="#createServiceFaq" class="btn btn-success"><i class="fas fa-plus"></i> {{__('admin.Add New')}}</a>

            <div class="row mt-4">
                <div class="col">
                  <div class="card">
                    <div class="card-header">
                        <h1>{{__('admin.Service')}} : {{ $service->name }}</h1>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive table-invoice">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th width="5%">{{__('admin.SN')}}</th>
                                    <th width="35%">{{__('admin.Question')}}</th>
                                    <th width="50%">{{__('admin.Answer')}}</th>
                                    <th width="10%">{{__('admin.Action')}}</th>
                                  </tr>
                            </thead>
                            <tbody>
                                @foreach ($faqs as $index => $faq)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $faq->question }}</td>
                                        <td>{{ $faq->answer }}</td>
                                        <td>
                                        <a href="javascript:;" data-toggle="modal" data-target="#editServiceFaq-{{ $faq->id }}" class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>

                                        <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-sm" onclick="deleteData({{ $faq->id }})"><i class="fa fa-trash" aria-hidden="true"></i></a>
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



      @foreach ($faqs as $faq)
        <div class="modal fade" id="editServiceFaq-{{ $faq->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                                <h5 class="modal-title">{{__('admin.Edit FAQ')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form action="{{ route('admin.update-service-faq', $faq->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label>{{__('admin.Question')}} <span class="text-danger">*</span></label>
                                        <input required type="text" id="question" class="form-control"  name="question" value="{{ $faq->question }}">
                                        <input type="hidden" value="{{ $service->id }}" name="service_id">
                                    </div>
                                    <div class="form-group col-12">
                                        <label>{{__('admin.Answer')}} <span class="text-danger">*</span></label>
                                        <textarea required name="answer" id="" cols="30" rows="10" class="form-control text-area-5">{{ filterTag(clean($faq->answer)) }}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button class="btn btn-primary">{{__('admin.Update')}}</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('admin.Close')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
      @endforeach

      <div class="modal fade" id="createServiceFaq" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                      <div class="modal-header">
                              <h5 class="modal-title">{{__('admin.Create FAQ')}}</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                          </div>
                  <div class="modal-body">
                      <div class="container-fluid">
                        <form action="{{ route('admin.store-service-faq') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>{{__('admin.Question')}} <span class="text-danger">*</span></label>
                                    <input required type="text" id="question" class="form-control"  name="question" value="{{ old('question') }}">
                                    <input type="hidden" value="{{ $service->id }}" name="service_id">
                                </div>
                                <div class="form-group col-12">
                                    <label>{{__('admin.Answer')}} <span class="text-danger">*</span></label>
                                    <textarea required name="answer" id="" cols="30" rows="10" class="form-control text-area-5">{{ old('answer') }}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-primary">{{__('admin.Save')}}</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('admin.Close')}}</button>
                                </div>
                            </div>
                        </form>
                      </div>
                  </div>

              </div>
          </div>
      </div>



<script>
    function deleteData(id){
        $("#deleteForm").attr("action",'{{ url("admin/delete-service-faq/") }}'+"/"+id)
    }
    function changeBlogCategoryStatus(id){
        var isDemo = "{{ env('APP_VERSION') }}"
        if(isDemo == 0){
            toastr.error('This Is Demo Version. You Can Not Change Anything');
            return;
        }
        $.ajax({
            type:"put",
            data: { _token : '{{ csrf_token() }}' },
            url:"{{url('/admin/faq-status/')}}"+"/"+id,
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
