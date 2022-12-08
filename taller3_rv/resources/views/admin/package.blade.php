@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Pricing Plan')}}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Pricing Plan')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('admin.Pricing Plan')}}</div>
            </div>
          </div>

          <div class="section-body">
            <a href="{{ route('admin.pricing-plan.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{__('admin.Add New')}}</a>
            <div class="row mt-4">
                <div class="col">
                  <div class="card">
                    <div class="card-body">
                      <div class="table-responsive table-invoice">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th >{{__('admin.SN')}}</th>
                                    <th >{{__('admin.Name')}}</th>
                                    <th >{{__('admin.Price')}}</th>
                                    <th >{{__('admin.Expiration Day')}}</th>
                                    <th >{{__('admin.Status')}}</th>
                                    <th >{{__('admin.Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($packages as $index => $package)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $package->name }}</td>
                                        <td>{{ $setting->currency_icon }}{{ $package->price }}</td>
                                        <td>
                                            @if ($package->expiration_day == -1)
                                                {{__('admin.Unlimited')}}
                                            @else
                                            {{ $package->expiration_day }}
                                            @endif

                                        </td>
                                        <td>
                                            @if ($package->status==1)
                                                <a href="" onclick="blogStatus({{ $package->id }})"><input type="checkbox" checked data-toggle="toggle" data-on="{{__('admin.Enable')}}" data-off="{{__('admin.Disable')}}" data-onstyle="success" data-offstyle="danger"></a>
                                            @else
                                                <a href="" onclick="blogStatus({{ $package->id }})"><input type="checkbox" data-toggle="toggle" data-on="{{__('admin.Enable')}}" data-off="{{__('admin.Disable')}}" data-onstyle="success" data-offstyle="danger"></a>

                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.pricing-plan.edit',$package->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit    "></i></a>

                                            @if ($package->orders->count() == 0)
                                                <a data-toggle="modal" data-target="#deleteModal" href="javascript:;" onclick="deleteData({{ $package->id }})" class="btn btn-danger btn-sm"><i class="fas fa-trash    "></i></a>
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
                                  {{__('admin.You can not delete this Plan. Because there are one or more subsriptions has been created in this plan.')}}
                              </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('admin.Close')}}</button>
                        </div>
                    </div>
                </div>
            </div>

<script>
    function deleteData(id){
        $("#deleteForm").attr("action",'{{ url("admin/pricing-plan/") }}'+"/"+id)
    }
    function blogStatus(id){
        var isDemo = "{{ env('APP_VERSION') }}"
        if(isDemo == 0){
            toastr.error('This Is Demo Version. You Can Not Change Anything');
            return;
        }
        $.ajax({
            type:"put",
            data: { _token : '{{ csrf_token() }}' },
            url:"{{url('/admin/pricing-plan-status/')}}"+"/"+id,
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
