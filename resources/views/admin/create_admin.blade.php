@extends('admin.master_layout')

@section('title')
<title>Crear Administrador</title>
@endsection

@section('admin-content')

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Crear Administrador</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
          <a href="{{ route('admin.dashboard') }}">Panel Administrativo</a>
        </div>
        <div class="breadcrumb-item active">
          <a href="{{ route('admin.admin.index') }}">Administradores</a>
        </div>
        <div class="breadcrumb-item">Crear Administrador</div>
      </div>
    </div>

    <div class="section-body">
      <a href="{{ route('admin.admin.index') }}" class="btn btn-primary"><i class="fas fa-list"></i> Lista de Administradores</a>
      <div class="row mt-4">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <form action="{{ route('admin.admin.store') }}" method="POST">
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

                  <div class="col-12">
                    <button class="btn btn-primary">Guardar</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

@endsection