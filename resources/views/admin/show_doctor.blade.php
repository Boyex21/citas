@extends('admin.master_layout')

@section('title')
<title>Perfil de Doctor</title>
@endsection

@section('admin-content')

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Perfil de Doctor</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">Panel Administrativo</a>
                </div>
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.doctor') }}">Doctores</a>
                </div>
                <div class="breadcrumb-item">Perfil de Doctor</div>
            </div>
        </div>

        <div class="section-body">
            <a href="{{ route('admin.doctor') }}" class="btn btn-primary"><i class="fas fa-list"></i> Lista de Doctores</a>
            
            <div class="row mt-4">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive table-invoice">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td>Imagen</td>
                                        <td>
                                            @if($doctor->image)
                                            <img src="{{ asset($doctor->image) }}" class="rounded-circle" alt="" width="80px">
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nombre</td>
                                        <td>{{ $doctor->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>{{ $doctor->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>Teléfono</td>
                                        <td>{{ $doctor->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total de Citas</td>
                                        <td>{{ $doctor->appointments->count() }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total de Secretarias</td>
                                        <td>{{ $doctor->staffs->count() }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total de Consultorios</td>
                                        <td>{{ $doctor->chambers->count() }}</td>
                                    </tr>
                                    <tr>
                                        <td>Dirección</td>
                                        <td>{{ $doctor->address }}</td>
                                    </tr>
                                    <tr>
                                        <td>Estado</td>
                                        <td>
                                            @if($doctor->status == 1)
                                            <a href="javascript:;" onclick="manageCustomerStatus({{ $doctor->id }})">
                                                <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger">
                                            </a>
                                            @else
                                            <a href="javascript:;" onclick="manageCustomerStatus({{ $doctor->id }})">
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
            url:"{{url('/admin/doctor-status/')}}"+"/"+id,
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