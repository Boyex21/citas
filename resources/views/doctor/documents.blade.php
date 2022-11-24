@extends('doctor.layout')

@section('title')
<title>Documentos</title>
@endsection

@section('doctor-content')

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Documentos</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('doctor.dashboard') }}">Panel Administrativo</a>
                </div>
                <div class="breadcrumb-item">Documentos</div>
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
                                            <th>Cant. de Documentos</th>
                                            <th>Fecha</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($documents as $document)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $document->user->name }}</td>
                                            <td>{{ $document['files']->count() }}</td>
                                            <td>{{ $document->created_at->format('d-m-Y') }}</td>
                                            <td>
                                                <a href="{{ route('doctor.documents.show', $document->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
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