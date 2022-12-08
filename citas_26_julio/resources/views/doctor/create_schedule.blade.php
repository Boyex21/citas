@extends('doctor.layout')

@section('title')
<title>Crear Horario</title>
@endsection

@section('doctor-content')

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Crear Horario</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('doctor.dashboard') }}">Panel Administrativo</a>
                </div>
                <div class="breadcrumb-item active">
                    <a href="{{ route('doctor.schedule.index') }}">Horarios</a>
                </div>
                <div class="breadcrumb-item">Crear Horario</div>
            </div>
        </div>

        <div class="section-body">
            <a href="{{ route('doctor.schedule.index') }}" class="btn btn-primary"><i class="fas fa-list"></i> Lista de Horarios</a>

            <div class="row mt-4">
                <div class="col">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('doctor.schedule.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="">Día<span class="text-danger">*</span></label>
                                    <select name="day" id="" class="form-control">
                                        <option value="">Seleccione</option>
                                        @foreach ($days as $day)
                                        <option value="{{ $day->id }}">{{ $day->custom_day }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="">Consultorios<span class="text-danger">*</span></label>
                                    <select name="chamber" id="" class="form-control">
                                        <option value="">Seleccione</option>
                                        @foreach ($chambers as $chamber)
                                        <option value="{{ $chamber->id }}">{{ $chamber->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-12">
                                    <label for="start_time">Hora de Inicio<span class="text-danger">*</span></label>
                                    <input type="text" name="start_time" class="form-control clockpicker" data-align="top" data-autoclose="true" autocomplete="off">
                                </div>

                                <div class="form-group col-12">
                                    <label for="end_time">Hora Final<span class="text-danger">*</span></label>
                                    <input type="text" name="end_time" class="form-control clockpicker" data-align="top" data-autoclose="true" autocomplete="off">
                                </div>

                                <div class="form-group col-12">
                                    <label>Limite de Citas<span class="text-danger">*</span></label>
                                    <input type="number" id="appointment_limit" class="form-control"  name="appointment_limit" value="{{ old('appointment_limit') }}">
                                </div>

                                <div class="form-group col-12">
                                    <label>Estado<span class="text-danger">*</span></label>
                                    <select name="status" id="" class="form-control">
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-primary">Guardar</button>
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