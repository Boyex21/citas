@extends('doctor.layout')

@section('title')
<title>Cambiar Contraseña</title>
@endsection

@section('doctor-content')

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Cambiar Contraseña</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
          <a href="{{ route('doctor.dashboard') }}">Panel Administrativo</a>
        </div>
        <div class="breadcrumb-item">Cambiar Contraseña</div>
      </div>
    </div>
    <div class="section-body">
      <div class="row mt-sm-4">
        <div class="col-md-12">
          <div class="card profile-widget">
            <div class="profile-widget-description">
              <form action="{{ route('doctor.update-password') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                  <div class="form-group col-md-12">
                    <label>Contraseña<span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="password">
                  </div>

                  <div class="form-group col-md-12">
                    <label>Confirmar Contraseña<span class="text-danger">*</span></label>
                    <input type="password" class="form-control"  name="password_confirmation">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <button class="btn btn-primary">Actualizar</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

@endsection