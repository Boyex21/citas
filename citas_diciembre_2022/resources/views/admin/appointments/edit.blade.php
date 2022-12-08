@extends('layouts.admin')

@section('title', 'Editar Cita')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="javascript:void(0);">Citas</a>
</li>
<li class="breadcrumb-item active" aria-current="page">
    <a href="javascript:void(0);">Editar</a>
</li>
@endsection

@section('links')
<link rel="stylesheet" href="{{ asset('/admins/css/elements/alert.css') }}">
<link href="{{ asset('/admins/vendor/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('/admins/vendor/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('/admins/vendor/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/admins/vendor/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/admins/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('/admins/vendor/lobibox/Lobibox.min.css') }}">
@endsection

@section('content')

<div class="row layout-top-spacing">
	<div class="col-12 layout-spacing">
    	<div class="statbox widget box box-shadow">
	        <div class="widget-header">
	            <div class="row">
	                <div class="col-12">
	                    <h4>Editar Cita</h4>
	                </div>
	            </div>
	        </div>
	        <div class="widget-content widget-content-area shadow-none">

				<div class="row">
					<div class="col-12">

						@include('admin.partials.errors')

						<p>Campos obligatorios (<b class="text-danger">*</b>)</p>
						<form action="{{ route('appointments.update', ['appointment' => $appointment->id]) }}" method="POST" class="form" id="formAppointment">
							@csrf
							@method('PUT')
							<div class="row">
								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Doctor</label>
									<input class="form-control text-dark" type="text" disabled placeholder="Doctor" value="{{ $appointment['doctor']->name.' '.$appointment['doctor']->lastname }}">
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Paciente</label>
									<input class="form-control text-dark" type="text" disabled placeholder="Paciente" value="{{ $appointment['user']->name.' '.$appointment['user']->lastname }}">
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Día<b class="text-danger">*</b></label>
									<select class="form-control @error('day') is-invalid @enderror" name="day" required>
										<option value="">Seleccione</option>
										<option value="1" @if($appointment->day=='Lunes') selected @endif>Lunes</option>
										<option value="2" @if($appointment->day=='Martes') selected @endif>Martes</option>
										<option value="3" @if($appointment->day=='Miércoles') selected @endif>Miércoles</option>
										<option value="4" @if($appointment->day=='Jueves') selected @endif>Jueves</option>
										<option value="5" @if($appointment->day=='Viernes') selected @endif>Viernes</option>
										<option value="6" @if($appointment->day=='Sábado') selected @endif>Sábado</option>
										<option value="7" @if($appointment->day=='Domingo') selected @endif>Domingo</option>
									</select>
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Fecha<b class="text-danger">*</b></label>
									<input class="form-control date @error('date') is-invalid @enderror" type="text" required name="date" placeholder="Seleccione" value="{{ $appointment->date->format('d-m-Y') }}" id="flatpickrDateMin">
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Horario<b class="text-danger">*</b></label>
									<select class="form-control @error('schedule_id') is-invalid @enderror" name="schedule_id" required>
										<option value="">Seleccione</option>
										@foreach($schedules as $schedule)
										<option value="{{ $schedule->id }}" @if($appointment->schedule_id==$schedule->id) selected @endif>{{ $schedule->start->format('H:i A').' - '.$schedule->end->format('H:i A') }}</option>
										@endforeach
									</select>
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Tipo de Consulta<b class="text-danger">*</b></label>
									<select class="form-control @error('type') is-invalid @enderror" name="type" required>
										<option value="">Seleccione</option>
										<option value="1" @if($appointment->type=='Presencial') selected @endif>Presencial</option>
										<option value="2" @if($appointment->type=='Virtual') selected @endif>Virtual</option>
									</select>
								</div>

								<div class="form-group col-12">
									<div class="btn-group" role="group">
										<button type="submit" class="btn btn-primary mr-0" action="appointment">Actualizar</button>
										<a href="{{ route('appointments.index') }}" class="btn btn-secondary">Volver</a>
									</div>
								</div> 
							</div>
						</form>
					</div>                                        
				</div>

			</div>
		</div>
	</div>

</div>

@endsection

@section('scripts')
<script src="{{ asset('/admins/vendor/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('/admins/vendor/flatpickr/es.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/jquery.validate.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/additional-methods.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/messages_es.js') }}"></script>
<script src="{{ asset('/admins/js/validate.js') }}"></script>
<script src="{{ asset('/admins/vendor/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/sweetalerts/custom-sweetalert.js') }}"></script>
<script src="{{ asset('/admins/vendor/lobibox/Lobibox.js') }}"></script>
@endsection