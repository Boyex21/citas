@extends('doctor.layout')

@section('title')
<title>Secretarias</title>
@endsection

@section('doctor-content')

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Secretarias</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('doctor.dashboard') }}">Panel Administrativo</a>
                </div>
                <div class="breadcrumb-item">Secretarias</div>
            </div>
        </div>

        <div class="section-body">
            <a href="javascript:;" data-toggle="modal" data-target="#createFaqCategory" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar Nueva</a>

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
                                            <th>Imagen</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($staffs as $staff)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $staff->name }}</td>
                                            <td>{{ $staff->email }}</td>
                                            <td>
                                                @if($staff->image)
                                                <img src="{{ asset($staff->image) }}" alt="" width="80px" class="rounded-circle">
                                                @endif
                                            </td>
                                            <td>
                                                @if($staff->status==1)
                                                <a href="javascript:;" onclick="changeStatus({{ $staff->id }})">
                                                    <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger">
                                                </a>
                                                @else
                                                <a href="javascript:;" onclick="changeStatus({{ $staff->id }})">
                                                    <input id="status_toggle" type="checkbox" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger">
                                                </a>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-sm" onclick="deleteData({{ $staff->id }})"><i class="fa fa-trash" aria-hidden="true"></i></a>

                                                <a href="javascript:;" data-toggle="modal" data-target="#editFaqCategory-{{ $staff->id }}" class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>
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
                <h5 class="modal-title">Crear Secretaria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form action="{{ route('doctor.staff.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="">Consultorio<span class="text-danger">*</span></label>
                                <select name="chamber" id="" class="form-control">
                                    <option value="">Todos</option>
                                    @foreach($chambers as $chamber)
                                    <option value="{{ $chamber->id }}">{{ $chamber->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-12">
                                <label>Nombre<span class="text-danger">*</span></label>
                                <input type="text" id="name" class="form-control"  name="name">
                            </div>

                            <div class="form-group col-12">
                                <label>Email<span class="text-danger">*</span></label>
                                <input type="email" id="slug" class="form-control"  name="email">
                            </div>

                            <div class="form-group col-12">
                                <label>Contraseña<span class="text-danger">*</span></label>
                                <input type="password" id="password" class="form-control"  name="password">
                            </div>

                            <div class="form-group col-12">
                                <label>Estado<span class="text-danger">*</span></label>
                                <select name="status" class="form-control">
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

@foreach($staffs as $staff)
<div class="modal fade" id="editFaqCategory-{{ $staff->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Secretaria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form action="{{ route('doctor.staff.update', $staff->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="">Consultorio<span class="text-danger">*</span></label>
                                <select name="chamber" id="" class="form-control">
                                    <option value="">Todos</option>
                                    @foreach($chambers as $chamber)
                                    <option {{ $chamber->id==$staff->chamber_id ? 'selected' : '' }} value="{{ $chamber->id }}">{{ $chamber->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-12">
                                <label>Nombre<span class="text-danger">*</span></label>
                                <input type="text" id="name" class="form-control"  name="name" value="{{ $staff->name }}">
                            </div>

                            <div class="form-group col-12">
                                <label>Email<span class="text-danger">*</span></label>
                                <input type="email" id="slug" class="form-control"  name="email" value="{{ $staff->email }}">
                            </div>

                            <div class="form-group col-12">
                                <label>Contraseña<span class="text-danger">*</span></label>
                                <input type="password" id="password" class="form-control"  name="password">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-primary">Actualizar</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
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
        $("#deleteForm").attr("action",'{{ url("doctor/staff/") }}'+"/"+id);
    }

    function changeStatus(id){
        $.ajax({
            type:"put",
            data: { _token : '{{ csrf_token() }}' },
            url:"{{url('/doctor/staff-status/')}}"+"/"+id,
            success:function(response){
                if(response.status==1){
                    toastr.success(response.message);
                }

                if(response.status==0){
                    toastr.error(response.message);
                }
            },
            error:function(err){
                console.log(err);
            }
        });
    }
</script>

@endsection