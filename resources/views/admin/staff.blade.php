@extends('admin.master_layout')

@section('title')
<title>Secretarias</title>
@endsection

@section('admin-content')

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Secretarias</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
          <a href="{{ route('admin.dashboard') }}">Panel Administrativo</a>
        </div>
        <div class="breadcrumb-item">Secretarias</div>
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
                      <th>Email</th>
                      <th>Doctor</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($staffs as $staff)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $staff->name }}</td>
                      <td>{{ $staff->email }}</td>
                      <td>{{ $staff->doctor->name }}</td>
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
  </section>
</div>

@endsection