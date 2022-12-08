@extends('admin.master_layout')

@section('title')
<title>Ajustes</title>
@endsection

@section('admin-content')

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Ajustes</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
          <a href="{{ route('admin.dashboard') }}">Panel Administrativo</a>
        </div>
        <div class="breadcrumb-item">Ajustes</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row mt-4">
        <div class="col">
          <div class="card">
            <div class="card-header">
              <div class="card-body">
                <div class="row">
                  <div class="col-12 col-sm-12 col-md-3">
                    <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                      <li class="nav-item border rounded mb-1">
                        <a class="nav-link active" id="general-setting-tab" data-toggle="tab" href="#generalSettingTab" role="tab" aria-controls="generalSettingTab" aria-selected="true">Ajustes Generales</a>
                      </li>

                      <li class="nav-item border rounded mb-1">
                        <a class="nav-link" id="logo-tab" data-toggle="tab" href="#logoTab" role="tab" aria-controls="logoTab" aria-selected="true">Logo y Favicon</a>
                      </li>
                    </ul>
                  </div>
                  <div class="col-12 col-sm-12 col-md-9">
                    <div class="border rounded">
                      <div class="tab-content no-padding" id="settingsContent">

                        <div class="tab-pane fade show active" id="generalSettingTab" role="tabpanel" aria-labelledby="general-setting-tab">
                          <div class="card m-0">
                            <div class="card-body">
                              <form action="{{ route('admin.update-general-setting') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                  <label for="">Registro/Ingreso de Usuarios</label>
                                  <select name="user_register" id="" class="form-control">
                                    <option {{ $setting->enable_user_register==1 ? 'selected' : '' }} value="1">Habilitado</option>
                                    <option {{ $setting->enable_user_register==0 ? 'selected' : '' }} value="0">Deshabilitado</option>
                                  </select>
                                </div>

                                <div class="form-group">
                                  <label for="">Nombre Largo del Sistema (Menu)</label>
                                  <input type="text" name="lg_header" class="form-control" value="{{ $setting->sidebar_lg_header }}">
                                </div>

                                <div class="form-group">
                                  <label for="">Nombre Corto del Sistema (Menu)</label>
                                  <input type="text" name="sm_header" class="form-control" value="{{ $setting->sidebar_sm_header }}">
                                </div>

                                <div class="form-group">
                                  <label for="">Email de Contacto</label>
                                  <input type="email" name="contact_email" class="form-control" value="{{ $setting->contact_email }}">
                                </div>

                                <button class="btn btn-primary" type="submit">Actualizar</button>
                              </form>
                            </div>
                          </div>
                        </div>

                        <div class="tab-pane fade" id="logoTab" role="tabpanel" aria-labelledby="logo-tab">
                          <div class="card m-0">
                            <div class="card-body">
                              <form action="{{ route('admin.update-logo-favicon') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                  <label for="">Logo Actual</label>
                                  <div>
                                    <img src="{{ asset($setting->logo) }}" alt="" width="200px">
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label for="">Logo Nuevo</label>
                                  <input type="file" name="logo" class="form-control-file">
                                </div>

                                <div class="form-group">
                                  <label for="">Nombre del Logo</label>
                                  <input required type="text" name="logo_name" class="form-control" value="{{ $setting->logo_alt }}">
                                </div>

                                <div class="form-group">
                                  <label for="">Favicon Actual</label>
                                  <div>
                                    <img src="{{ asset($setting->favicon) }}" alt="" width="50px">
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label for="">Nuevo Favicon</label>
                                  <input type="file" name="favicon" class="form-control-file">
                                </div>

                                <div class="form-group">
                                  <label for="">Nombre del Favicon</label>
                                  <input required type="text" name="favicon_name" class="form-control" value="{{ $setting->favicon_alt }}">
                                </div>

                                <button class="btn btn-primary">Actualizar</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

@endsection