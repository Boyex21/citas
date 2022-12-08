@extends('admin.master_layout')

@section('title')
<title>Panel Administrativo</title>
@endsection

@section('admin-content')

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Panel Administrativo</h1>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="fas fa-user"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total de Doctores</h4>
              </div>
              <div class="card-body">
                {{ $doctors->count() }}
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
              <i class="far fa-user"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total de Pacientes</h4>
              </div>
              <div class="card-body">
                {{ $users->count() }}
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="fas fa-stethoscope"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Citas de Hoy</h4>
              </div>
              <div class="card-body">
                {{ $todayAppointments->count() }}
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-success">
              <i class="fas fa-stethoscope"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Citas del Mes</h4>
              </div>
              <div class="card-body">
                {{ $monthlyAppointments->count() }}
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="fas fa-stethoscope"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Citas del Año</h4>
              </div>
              <div class="card-body">
                {{ $yearlyAppointments->count() }}
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
              <i class="fas fa-stethoscope"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total de Citas</h4>
              </div>
              <div class="card-body">
                {{ $appointments->count() }}
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
              <i class="fas fa-users"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total de Secretarias</h4>
              </div>
              <div class="card-body">
                {{ $staffs->count() }}
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="fas fa-hospital"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total de Consultorios</h4>
              </div>
              <div class="card-body">
                {{ $chambers->count() }}
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-success">
              <i class="fas fa-medkit"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total de Medicinas</h4>
              </div>
              <div class="card-body">
                {{ $medicines->count() }}
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="fas fa-circle"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total de Departamentos</h4>
              </div>
              <div class="card-body">
                {{ $departments->count() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

@endsection