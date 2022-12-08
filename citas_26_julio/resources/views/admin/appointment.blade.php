@extends('admin.master_layout')

@section('title')
<title>Historial de Citas</title>
@endsection

@section('admin-content')

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Historial de Citas</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
          <a href="{{ route('admin.dashboard') }}">Panel Administrativo</a>
        </div>
        <div class="breadcrumb-item">Historial de Citas</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row mt-4">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive table-invoice">
                <table class="table table-striped" id="dataTable">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Doctor</th>
                      <th>Paciente</th>
                      <th>Fecha</th>
                      <th>Horario</th>
                      <th>Consultorio</th>
                      <th>Tipo de Consulta</th>
                      <th>Estado</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($appointments as $appointment)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>@if(!is_null($appointment->doctor)){{ $appointment->doctor->name }}@endif</td>
                      <td>@if(!is_null($appointment->user)){{ $appointment->user->name }}@endif</td>
                      <td>{{ date('d F, Y', strtotime($appointment->date)) }}</td>
                      <td>{{ date('h:i A', strtotime($appointment->schedule->start_time)).' - '.date('h:i A', strtotime($appointment->schedule->end_time)) }}</td>
                      <td>@if(!is_null($appointment->chamber)){{ $appointment->chamber->name }}@endif</td>
                      <td>
                        @if($appointment->consultation_type==1)
                        <span class="badge badge-warning">Virtual</span>
                        @else
                        <span class="badge badge-success">Presencial</span>
                        @endif
                      </td>
                      <td>
                        @if($appointment->already_treated==1)
                        <span class="badge badge-success">Tratado</span>
                        @else
                        <span class="badge badge-danger">Pendiente</span>
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

@endsection