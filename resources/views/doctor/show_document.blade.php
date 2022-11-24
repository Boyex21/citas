@extends('doctor.layout')

@section('title')
<title>Documento</title>
@endsection

@section('doctor-content')

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Documento</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('doctor.dashboard') }}">Panel Administrativo</a>
                </div>
                <div class="breadcrumb-item active">
                    <a href="{{ route('doctor.documents.index') }}">Documentos</a>
                </div>
                <div class="breadcrumb-item">Documento</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row mt-4">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div>Paciente: {{ $document->user->name }}</div>
                                    <div>Descripción de los Documentos: {{ $document->description }}</div>
                                </div>

                                <div class="col-12">
                                    <h4 class="mt-3">Documentos</h4>
                                    <ol>
                                        @foreach($document['files'] as $file)
                                        <li>
                                            <a href="{{ asset('uploads/documents/'.$file->file) }}" download>{{ $file->file }}</a>
                                            <a href="{{ asset('uploads/documents/'.$file->file) }}" download class="btn btn-sm btn-primary ml-2">Descargar</a>
                                        </li>
                                        @endforeach
                                    </ol>
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