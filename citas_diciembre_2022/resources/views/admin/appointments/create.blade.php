@extends('layouts.admin')

@section('title', 'Crear Cita')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="javascript:void(0);">Citas</a>
</li>
<li class="breadcrumb-item active" aria-current="page">
    <a href="javascript:void(0);">Registro</a>
</li>
@endsection

@section('links')
<link rel="stylesheet" href="{{ asset('/admins/css/elements/alert.css') }}">
<link href="{{ asset('/admins/vendor/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('/admins/vendor/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{ asset('/admins/vendor/lobibox/Lobibox.min.css') }}">
@endsection

@section('content')

<div class="row layout-top-spacing">
	<div class="col-12 layout-spacing">
    	<div class="statbox widget box box-shadow">
	        <div class="widget-header">
	            <div class="row">
	                <div class="col-12">
	                    <h4>Crear Cita</h4>
	                </div>
	            </div>
	        </div>
	        <div class="widget-content widget-content-area shadow-none">
	        	<div class="row">
					<div class="col-12">

						@include('admin.partials.errors')

						<p>Campos obligatorios (<b class="text-danger">*</b>)</p>
						<form action="{{ route('appointments.store') }}" method="POST" class="form" id="formAppointment">
							@csrf
							<div class="row">
								@if(!Auth::user()->hasRole(['Paciente']))
								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Paciente<b class="text-danger">*</b></label>
									<select class="form-control @error('patient_id') is-invalid @enderror" name="patient_id" required>
										<option value="">Seleccione</option>
										@foreach($patients as $patient)
										<option value="{{ $patient->slug }}" @if(old('patient_id')==$patient->slug) selected @endif>{{ $patient->name.' '.$patient->lastname }}</option>
										@endforeach
									</select>
								</div>
								@else
								<input type="hidden" name="patient_id" value="{{ Auth::user()->slug }}">
								@endif

								@if(!Auth::user()->hasRole(['Doctor']))
								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Doctor<b class="text-danger">*</b></label>
									<select class="form-control scheduleDoctor @error('doctor_id') is-invalid @enderror" name="doctor_id" required>
										<option value="">Seleccione</option>
										@foreach($doctors as $doctor)
										<option value="{{ $doctor->slug }}" @if(old('doctor_id')==$doctor->slug) selected @endif>{{ $doctor->name.' '.$doctor->lastname }}</option>
										@endforeach
									</select>
								</div>
								@else
								<input class="scheduleDoctor" type="hidden" name="doctor_id" value="{{ Auth::user()->slug }}">
								@endif

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Especialidad<b class="text-danger">*</b></label>
									<select class="form-control @error('specialty_id') is-invalid @enderror" name="specialty_id" required id="selectSpecialties">
										<option value="">Seleccione</option>
										@if(is_null(old('doctor_id')) && is_null(old('specialty_id')))
										@foreach($specialties as $specialty)
										<option value="{{ $specialty->slug }}" @if(old('specialty_id')==$specialty->slug) selected @endif>{{ $specialty->name }}</option>
										@endforeach
										@else
										{!! selectArrayDoctorSpecialties(old('doctor_id'), [old('specialty_id')]) !!}
										@endif
									</select>
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Fecha<b class="text-danger">*</b></label>
									<input class="form-control date scheduleDate @error('date') is-invalid @enderror" type="text" required name="date" placeholder="Seleccione" value="{{ old('date') }}" id="flatpickrDateMin">
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Horario<b class="text-danger">*</b></label>
									<select class="form-control @error('schedule_id') is-invalid @enderror" name="schedule_id" required id="selectSchedules">
										<option value="">Seleccione</option>
										@if(!is_null(old('doctor_id')) && !is_null(old('schedule_id')) && !is_null(old('date')))
										{!! selectArrayDoctorSchedules(old('doctor_id'), [old('schedule_id')], old('date')) !!}
										@endif
									</select>
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Tipo de Consulta<b class="text-danger">*</b></label>
									<select class="form-control @error('type') is-invalid @enderror" name="type" required>
										<option value="">Seleccione</option>
										<option value="1" @if(old('type')=='1') selected @endif>Presencial</option>
										<option value="2" @if(old('type')=='2') selected @endif>Virtual</option>
									</select>
								</div>

								<div class="form-group col-12">
									<div class="btn-group" role="group">
										<button type="submit" class="btn btn-primary" action="appointment">Guardar</button>
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
<script src="{{ asset('/admins/vendor/lobibox/Lobibox.js') }}"></script>
@endsection