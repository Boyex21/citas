@extends('admin.master_layout')

@section('title')
<title>Consultorios</title>
@endsection

@section('admin-content')

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Especialidades</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
          <a href="{{ route('admin.dashboard') }}">Panel Administrativo</a>
        </div>
        <div class="breadcrumb-item">Especialidades</div>
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
                      <th>Dirección</th>
                      <th>Doctor</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($chambers as $chamber)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $chamber->name }}</td>
                      <td>{{ $chamber->address }}</td>
                      <td>{{ $chamber->doctor->name }}</td>
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
        <h5 class="modal-title">Crear Especialidad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <form action="{{ route('admin.chamber.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="form-group col-12">
                <label for="">Doctor<span class="text-danger">*</span></label>
                <select name="doctor" class="form-control select2" required>
                  <option value="">Seleccione</option>
                  @foreach($doctors as $doctor)
                  <option value="{{ $doctor->id }}">{{ $doctor->name }} - {{ $doctor->phone }}</option>
                  @endforeach
                </select>
              </div>

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

@endsection