@extends('staff.layout')

@section('title')
<title>Prescripciones</title>
@endsection

@section('staff-content')

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Prescripciones</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
          <a href="{{ route('staff.dashboard') }}">Panel Administrativo</a>
        </div>
        <div class="breadcrumb-item">Prescripciones</div>
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
                      <th>Paciente</th>
                      <th>Fecha</th>
                      <th>Horario</th>
                      <th>Consultorio</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($prescriptions as $prescription)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $prescription->user->name }}</td>
                      <td>{{ date('d F, Y', strtotime($prescription->date)) }}</td>
                      <td>{{ date('h:i A', strtotime($prescription->schedule->start_time)) }} - {{ date('h:i A', strtotime($prescription->schedule->end_time)) }}</td>
                      <td>{{ $prescription->chamber->name }}</td>
                      <td>
                        @if($prescription->already_treated==1)
                        <span class="badge badge-success">Tratado</span>
                        @else
                        <span class="badge badge-danger">Pendiente</span>
                        @endif
                      </td>
                      <td>
                        <a href="{{ route('staff.show-prescription', $prescription->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
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