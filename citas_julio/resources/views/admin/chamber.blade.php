@extends('admin.master_layout')

@section('title')
<title>Consultorios</title>
@endsection

@section('admin-content')

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Consultorios</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
          <a href="{{ route('admin.dashboard') }}">Panel Administrativo</a>
        </div>
        <div class="breadcrumb-item">Consultorios</div>
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
                      <th>Nombre</th>
                      <th>Dirección</th>
                      <th>Autor</th>
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

@endsection