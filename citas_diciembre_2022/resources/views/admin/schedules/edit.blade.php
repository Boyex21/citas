@extends('layouts.admin')

@section('title', 'Editar Horario')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="javascript:void(0);">Horarios</a>
</li>
<li class="breadcrumb-item active" aria-current="page">
    <a href="javascript:void(0);">Editar</a>
</li>
@endsection

@section('links')
<link rel="stylesheet" href="{{ asset('/admins/css/elements/alert.css') }}">
<link href="{{ asset('/admins/vendor/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('/admins/vendor/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{ asset('/admins/vendor/touchspin/jquery.bootstrap-touchspin.min.css') }}">
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
	                    <h4>Editar Horario</h4>
	                </div>
	            </div>
	        </div>
	        <div class="widget-content widget-content-area shadow-none">

				<div class="row">
					<div class="col-12">

						@include('admin.partials.errors')

						<p>Campos obligatorios (<b class="text-danger">*</b>)</p>
						<form action="{{ route('schedules.update', ['schedule' => $schedule->id]) }}" method="POST" class="form" id="formSchedule">
							@csrf
							@method('PUT')
							<div class="row">
								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Día<b class="text-danger">*</b></label>
									<select class="form-control @error('day') is-invalid @enderror" name="day" required>
										<option value="">Seleccione</option>
										<option value="1" @if($schedule->day=='Lunes') selected @endif>Lunes</option>
										<option value="2" @if($schedule->day=='Martes') selected @endif>Martes</option>
										<option value="3" @if($schedule->day=='Miércoles') selected @endif>Miércoles</option>
										<option value="4" @if($schedule->day=='Jueves') selected @endif>Jueves</option>
										<option value="5" @if($schedule->day=='Viernes') selected @endif>Viernes</option>
										<option value="6" @if($schedule->day=='Sábado') selected @endif>Sábado</option>
										<option value="7" @if($schedule->day=='Domingo') selected @endif>Domingo</option>
									</select>
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Hora de Inicio<b class="text-danger">*</b></label>
									<input class="form-control date @error('start') is-invalid @enderror" type="text" required name="start" placeholder="Seleccione" value="{{ $schedule->start->format('H:i') }}" id="flatpickrStartTime">
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Hora Final<b class="text-danger">*</b></label>
									<input class="form-control date @error('end') is-invalid @enderror" type="text" name="end" placeholder="Seleccione" value="{{ $schedule->end->format('H:i') }}" id="flatpickrEndTime">
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Límite de Citas<b class="text-danger">*</b></label>
									<input class="form-control int-positive @error('appointment_limit') is-invalid @enderror" type="text" name="appointment_limit" placeholder="Ingrese el límite de citas" value="{{ $schedule->appointment_limit }}">
								</div>

								<div class="form-group col-12">
									<div class="btn-group" role="group">
										<button type="submit" class="btn btn-primary mr-0" action="schedule">Actualizar</button>
										<a href="{{ route('schedules.index') }}" class="btn btn-secondary">Volver</a>
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
<script src="{{ asset('/admins/vendor/touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/jquery.validate.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/additional-methods.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/messages_es.js') }}"></script>
<script src="{{ asset('/admins/js/validate.js') }}"></script>
<script src="{{ asset('/admins/vendor/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/sweetalerts/custom-sweetalert.js') }}"></script>
<script src="{{ asset('/admins/vendor/lobibox/Lobibox.js') }}"></script>
@endsection