@extends('doctor.layout')

@section('title')
<title>Descanso</title>
@endsection

@section('doctor-content')

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Descanso</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
          <a href="{{ route('doctor.dashboard') }}">Panel Administrativo</a>
        </div>
        <div class="breadcrumb-item">Descanso</div>
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
                      <th>Fecha</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($leaves as $leave)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $leave->date }}</td>
                      <td>
                        <a href="javascript:;" data-toggle="modal" data-target="#editFaqCategory-{{ $leave->id }}" class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>

                        <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-sm" onclick="deleteData({{ $leave->id }})"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
        <h5 class="modal-title">Crear Licencia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <form action="{{ route('doctor.leave.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="form-group col-12">
                <label>Fecha<span class="text-danger">*</span></label>
                <input type="text" id="date" class="form-control datepicker2" autocomplete="off"  name="date" value="{{ old('name') }}">
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

@foreach ($leaves as $leave)
<div class="modal fade" id="editFaqCategory-{{ $leave->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar Licencia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <form action="{{ route('doctor.leave.update', $leave->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
              <div class="form-group col-12">
                <label>Fecha<span class="text-danger">*</span></label>
                <input type="text" id="date" class="form-control datepicker2" autocomplete="off"  name="date" value="{{ $leave->date }}">
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
    $("#deleteForm").attr("action",'{{ url("doctor/leave/") }}'+"/"+id)
  }
</script>

@endsection