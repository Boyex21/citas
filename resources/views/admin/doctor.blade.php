@extends('admin.master_layout')

@section('title')
<title>Doctores</title>
@endsection

@section('admin-content')

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Doctores</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">Panel Administrativo</a>
                </div>
                <div class="breadcrumb-item">Doctores</div>
            </div>
        </div>

        <div class="section-body">
            <a href="javascript:;" data-toggle="modal" data-target="#createFaqCategory" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar Nuevo</a>

            <div class="row mt-4">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive table-invoice">
                                <table class="table table-striped" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Total de Citas</th>
                                            <th>Total de Secretarias</th>
                                            <th>Total de Consultorios</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($doctors as $doctor)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $doctor->name }}</td>
                                            <td>{{ $doctor->email }}</td>
                                            <td>{{ $doctor->appointments->count() }}</td>
                                            <td>{{ $doctor->staffs->count() }}</td>
                                            <td>{{ $doctor->chambers->count() }}</td>
                                            <td>
                                                @if($doctor->status==1)
                                                <a href="javascript:;" onclick="manageCustomerStatus({{ $doctor->id }})">
                                                    <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger">
                                                </a>
                                                @else
                                                <a href="javascript:;" onclick="manageCustomerStatus({{ $doctor->id }})">
                                                    <input id="status_toggle" type="checkbox" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger">
                                                </a>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.show-doctor',$doctor->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                                <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-sm" onclick="deleteData({{ $doctor->id }})"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
        </div>
    </section>
</div>

<!-- Modal -->
<div class="modal fade" id="createFaqCategory" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crear Doctor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form action="{{ route('admin.doctor.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-12">
                                <label>Nombre<span class="text-danger">*</span></label>
                                <input type="text" id="name" class="form-control" required name="name">
                            </div>

                            <div class="form-group col-12">
                                <label>Email<span class="text-danger">*</span></label>
                                <input type="email" id="slug" class="form-control" required name="email">
                            </div>

                            <div class="form-group col-12">
                                <label>Contraseña<span class="text-danger">*</span></label>
                                <input type="password" id="password" class="form-control" required name="password">
                            </div>

                            <div class="form-group col-12">
                                <label>Estado<span class="text-danger">*</span></label>
                                <select name="status" class="form-control" required>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-primary">Guardar</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
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
        $("#deleteForm").attr("action",'{{ url("admin/doctor-delete/") }}'+"/"+id)
    }
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