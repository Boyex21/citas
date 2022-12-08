
@extends('admin.master_layout')
@section('title')
<title>{{ $doctor->name }}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{ $doctor->name }}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{ $doctor->name }}</div>
            </div>
          </div>

          <div class="section-body">
            <a href="{{ route('admin.doctor') }}" class="btn btn-primary"><i class="fas fa-list"></i> {{__('admin.Doctor List')}}</a>
            <div class="row mt-4">
                <div class="col">
                  <div class="card">
                    <div class="card-body">
                      <div class="table-responsive table-invoice">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <td>{{__('admin.Image')}}</td>
                                <td>
                                    @if ($doctor->image)
                                    <img src="{{ asset($doctor->image) }}" class="rounded-circle" alt="" width="80px">
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>{{__('admin.Name')}}</td>
                                <td>{{ $doctor->name }}</td>
                            </tr>
                            <tr>
                                <td>{{__('admin.Email')}}</td>
                                <td>{{ $doctor->email }}</td>
                            </tr>
                            <tr>
                                <td>{{__('admin.Phone')}}</td>
                                <td>{{ $doctor->phone }}</td>
                            </tr>
                            <tr>
                                <td>{{__('admin.Total Appointment')}}</td>
                                <td>{{ $doctor->appointments->count() }}</td>
                            </tr>
                            <tr>
                                <td>{{__('admin.Total Staff')}}</td>
                                <td>{{ $doctor->staffs->count() }}</td>
                            </tr>
                            <tr>
                                <td>{{__('admin.Total Chamber')}}</td>
                                <td>{{ $doctor->chambers->count() }}</td>
                            </tr>

                            <tr>
                                <td>{{__('admin.Address')}}</td>
                                <td>{{ $doctor->address }}</td>
                            </tr>
                            <tr>
                                <td>{{__('admin.Status')}}</td>
                                <td>
                                    @if($doctor->status == 1)
                                        <a href="javascript:;" onclick="manageCustomerStatus({{ $doctor->id }})">
                                            <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="{{__('admin.Active')}}" data-off="{{__('admin.InActive')}}" data-onstyle="success" data-offstyle="danger">
                                        </a>
                                        @else
                                        <a href="javascript:;" onclick="manageCustomerStatus({{ $doctor->id }})">
                                            <input id="status_toggle" type="checkbox" data-toggle="toggle" data-on="{{__('admin.Active')}}" data-off="{{__('admin.InActive')}}" data-onstyle="success" data-offstyle="danger">
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
          </div>
        </section>
      </div>

<script>
    function manageCustomerStatus(id){
        var isDemo = "{{ env('APP_VERSION') }}"
        if(isDemo == 0){
            toastr.error('This Is Demo Version. You Can Not Change Anything');
            return;
        }
        $.ajax({
            type:"put",
            data: { _token : '{{ csrf_token() }}' },
            url:"{{url('/admin/doctor-status/')}}"+"/"+id,
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
