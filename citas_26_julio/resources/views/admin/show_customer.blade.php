@extends('admin.master_layout')

@section('title')
<title>Perfil del Paciente</title>
@endsection

@section('admin-content')

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Perfil del Paciente</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">Panel Administrativo</a>
                </div>
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.customer-list') }}">Pacientes</a>
                </div>
                <div class="breadcrumb-item">Perfil del Paciente</div>
            </div>
        </div>

        <div class="section-body">
            <a href="{{ route('admin.customer-list') }}" class="btn btn-primary"><i class="fas fa-list"></i> Lista de Pacientes</a>

            <div class="row mt-4">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive table-invoice">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td>Imagen</td>
                                        <td>
                                            @if($customer->image)
                                            <img src="{{ asset($customer->image) }}" class="rounded-circle" alt="" width="80px">
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nombre</td>
                                        <td>{{ $customer->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>{{ $customer->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>Teléfono</td>
                                        <td>{{ $customer->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td>Dirección</td>
                                        <td>{{ $customer->address }}</td>
                                    </tr>
                                    <tr>
                                        <td>Estado</td>
                                        <td>
                                            @if($customer->status==1)
                                            <a href="javascript:;" onclick="manageCustomerStatus({{ $customer->id }})">
                                                <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger">
                                            </a>
                                            @else
                                            <a href="javascript:;" onclick="manageCustomerStatus({{ $customer->id }})">
                                                <input id="status_toggle" type="checkbox" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger">
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
        </div>
    </section>
</div>

<script>
    function manageCustomerStatus(id){
        $.ajax({
            type:"put",
            data: { _token : '{{ csrf_token() }}' },
            url:"{{url('/admin/customer-status/')}}"+"/"+id,
            success:function(response){
                toastr.success(response)
            },
            error:function(err){
                console.log(err);
            }
        });
    }
</script>

@endsection