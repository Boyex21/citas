@extends('doctor.layout')

@section('title')
<title>Citas de Hoy</title>
@endsection

@section('doctor-content')

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Citas de Hoy</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('doctor.dashboard') }}">Panel Administrativo</a>
                </div>
                <div class="breadcrumb-item active">
                    <a href="{{ route('doctor.appointment') }}">Citas</a>
                </div>
                <div class="breadcrumb-item">Citas de Hoy</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row mt-4">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <form action="">
                                <div class="form-group">
                                    <label for="">Consultorios</label>
                                    <select name="chamber" id="chamber" class="form-control">
                                        @if(Session::get('chamber_id'))
                                        <option {{ Session::get('chamber_id')=='' ? 'selected' : '' }} value="">Todos</option>
                                        @foreach ($chambers as $chamber)
                                        <option {{ Session::get('chamber_id')==$chamber->id ? 'selected' : '' }} value="{{ $chamber->id }}">{{ $chamber->name }}</option>
                                        @endforeach
                                        @else
                                        <option value="">Todos</option>
                                        @foreach($chambers as $chamber)
                                        <option value="{{ $chamber->id }}">{{ $chamber->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Buscar</button>
                            </form>
                        </div>
                    </div>
                </div>
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
                                            <th>Tipo de Consulta</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($appointments as $appointment)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $appointment->user->name }}</td>
                                            <td>{{ date('d F, Y', strtotime($appointment->date)) }}</td>
                                            <td>{{ date('h:i A', strtotime($appointment->schedule->start_time)) }} - {{ date('h:i A', strtotime($appointment->schedule->end_time)) }}</td>
                                            <td>{{ $appointment->chamber->name }}</td>
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
                                            <td>
                                                <a href="{{ route('doctor.show-appointment', $appointment->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                                @if($appointment->already_treated==1)
                                                <a href="{{ route('doctor.edit-appointment', $appointment->id) }}" class="btn btn-success btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                                @endif

                                                <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-sm" onclick="deleteData({{ $appointment->id }})"><i class="fa fa-trash" aria-hidden="true"></i></a>
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

<script>
    function deleteData(id){
        $("#deleteForm").attr("action",'{{ url("doctor/delete-appointment/") }}'+"/"+id)
    }
</script>

@endsection