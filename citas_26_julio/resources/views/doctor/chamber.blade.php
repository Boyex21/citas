@extends('doctor.layout')

@section('title')
<title>Consultorios</title>
@endsection

@section('doctor-content')

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Consultorios</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
          <a href="{{ route('doctor.dashboard') }}">Panel Administrativo</a>
        </div>
        <div class="breadcrumb-item">Consultorios</div>
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
                      <th>Dirección</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($chambers as $chamber)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $chamber->name }}</td>
                      <td>{{ $chamber->address }}</td>
                      <td>
                        @if($chamber->status==1)
                        <span class="badge badge-success">Activo</span>
                        @else
                        <span class="badge badge-danger">Inactivo</span>
                        @endif
                      </td>
                      <td>
                        <a href="javascript:;" data-toggle="modal" data-target="#editFaqCategory-{{ $chamber->id }}" class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>

                        @if($chamber->staffs->count()==0 && $chamber->appointments->count()==0 && $chamber->schedules->count()==0)
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
    </div>
  </section>
</div>

<!-- Modal -->
<div class="modal fade" id="canNotDeleteModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">No puede eliminar este consultorio. Debido a que hay uno o más secretarias, o se ha creado una cita en este consultorio.</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="createFaqCategory" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Crear Consultorio</h5>
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
                <label>Nombre<span class="text-danger">*</span></label>
                <input type="text" id="name" class="form-control"  name="name" value="{{ old('name') }}">
              </div>

              <div class="form-group col-12">
                <label>Dirección<span class="text-danger">*</span></label>
                <textarea name="address" id="" class="form-control text-area-5" cols="30" rows="10"></textarea>
              </div>

              <div class="form-group col-12">
                <label>Contacto<span class="text-danger">*</span></label>
                <textarea name="contact" id="" class="form-control text-area-5" cols="30" rows="10"></textarea>
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

@foreach ($chambers as $chamber)
<div class="modal fade" id="editFaqCategory-{{ $chamber->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar Consultorio</h5>
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
                <label>Nombre<span class="text-danger">*</span></label>
                <input type="text" id="name" class="form-control"  name="name" value="{{ $chamber->name }}">
              </div>

              <div class="form-group col-12">
                <label>Dirección<span class="text-danger">*</span></label>
                <textarea name="address" id="" class="form-control text-area-5" cols="30" rows="10">{{ $chamber->address }}</textarea>
              </div>

              <div class="form-group col-12">
                <label>Contacto<span class="text-danger">*</span></label>
                <textarea name="contact" id="" class="form-control text-area-5" cols="30" rows="10">{{ $chamber->contact }}</textarea>
              </div>

              <div class="form-group col-12">
                <label>Estado<span class="text-danger">*</span></label>
                <select name="status" class="form-control">
                  <option {{ $chamber->status == 1 ? 'selected' : '' }} value="1">Activo</option>
                  <option {{ $chamber->status == 0 ? 'selected' : '' }} value="0">Inactivo</option>
                </select>
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
    $("#deleteForm").attr("action",'{{ url("doctor/chamber/") }}'+"/"+id)
  }
  function setDefault(id){
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
    });
  }
</script>

@endsection