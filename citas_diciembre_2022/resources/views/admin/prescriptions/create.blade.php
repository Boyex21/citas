@extends('layouts.admin')

@section('title', 'Crear Prescripción')

@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="javascript:void(0);">Citas</a>
</li>
<li class="breadcrumb-item">
	<a href="javascript:void(0);">Prescripciones</a>
</li>
<li class="breadcrumb-item active" aria-current="page">
	<a href="javascript:void(0);">Registro</a>
</li>
@endsection

@section('links')
<link rel="stylesheet" href="{{ asset('/admins/css/elements/alert.css') }}">
<link href="{{ asset('/admins/vendor/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('/admins/vendor/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{ asset('/admins/vendor/touchspin/jquery.bootstrap-touchspin.min.css') }}">
<link rel="stylesheet" href="{{ asset('/admins/vendor/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('/admins/vendor/lobibox/Lobibox.min.css') }}">
@endsection

@section('content')

<div class="row layout-top-spacing">
	<div class="col-12 layout-spacing">
		<div class="statbox widget box box-shadow">
			<div class="widget-header">
				<div class="row">
					<div class="col-12">
						<h4>Crear Preescripción</h4>
					</div>
				</div>
			</div>
			<div class="widget-content widget-content-area shadow-none">
				<div class="row">
					<div class="col-12">

						@include('admin.partials.errors')

						<p>Campos obligatorios (<b class="text-danger">*</b>)</p>
						<form action="{{ route('prescriptions.store', ['appointment' => $appointment->id]) }}" method="POST" class="form" id="formPrescription">
							@csrf
							<div class="row">
								<div class="col-12">
									<h6 class="font-weight-bold">Detalles de la Cita</h6>
								</div>

								<div class="col-12 mb-3">
									<div class="card">
										<div class="card-body">
											<div class="row">
												<div class="col-lg-6 col-md-6 col-12">
													<div class="row">
														<div class="col-12">
															<h6 class="font-weight-bold">Información del Paciente</h6>
														</div>

														<div class="col-12">
															<p class="my-1"><b>Nombre:</b> @if(!is_null($appointment['user'])){{ $appointment['user']->name.' '.$appointment['user']->lastname }}@else{{ 'No Ingresado' }}@endif</p>
															<p class="my-1"><b>Email:</b> @if(!is_null($appointment['user'])){{ $appointment['user']->email }}@else{{ 'No Ingresado' }}@endif</p>
															<p class="my-1"><b>Teléfono:</b> @if(!is_null($appointment['user']) && !is_null($appointment['user']->phone)){{ $appointment['user']->phone }}@else{{ 'No Ingresado' }}@endif</p>
															<p class="my-1"><b>Edad:</b> @if(!is_null($appointment['user']) && !is_null($appointment['user']->birthday)){{ age($appointment['user']->birthday->format('Y-m-d')) }}@else{{ 'No Ingresado' }}@endif</p>
															<p class="my-1"><b>Peso:</b> @if(!is_null($appointment['user']) && !is_null($appointment['user']->weight)){{ number_format($appointment['user']->weight, 2, ',', '.').'Kg' }}@else{{ 'No Ingresado' }}@endif</p>
														</div>
													</div>
												</div>

												<div class="col-lg-6 col-md-6 col-12">
													<div class="row">
														<div class="col-12">
															<h6 class="font-weight-bold">Información de la Cita</h6>
														</div>

														<div class="col-12">
															<p class="my-1"><b>Doctor:</b> @if(!is_null($appointment['doctor'])){{ $appointment['doctor']->name.' '.$appointment['doctor']->lastname }}@else{{ 'No Ingresado' }}@endif</p>
															<p class="my-1"><b>Especialidad:</b> @if(!is_null($appointment['specialty'])){{ $appointment['specialty']->name }}@else{{ 'No Ingresado' }}@endif</p>
															<p class="my-1"><b>Fecha:</b> {{ $appointment->date->format('d-m-Y') }}</p>
															<p class="my-1"><b>Horario:</b> @if(!is_null($appointment['schedule'])){{ $appointment['schedule']->start->format('H:i A').' - '.$appointment['schedule']->end->format('H:i A') }}@else{{ 'No Ingresado' }}@endif</p>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="col-12">
									<h6 class="font-weight-bold">Información Física</h6>
								</div>

								<div class="form-group col-lg-4 col-md-4 col-12">
									<label class="col-form-label">Presión Sanguinea<b class="text-danger">*</b></label>
									<input class="form-control min-decimal @error('blood_pressure') is-invalid @enderror" type="text" name="blood_pressure" placeholder="Ingrese la presión sanguinea" value="@if(!is_null(old('blood_pressure'))){{ old('blood_pressure') }}@else{{ '0.00' }}@endif">
								</div>

								<div class="form-group col-lg-4 col-md-4 col-12">
									<label class="col-form-label">Frequencia de Pulso<b class="text-danger">*</b></label>
									<input class="form-control min-decimal @error('pulse_rate') is-invalid @enderror" type="text" name="pulse_rate" placeholder="Ingrese la frecuencia de pulso" value="@if(!is_null(old('pulse_rate'))){{ old('pulse_rate') }}@else{{ '0.00' }}@endif">
								</div>

								<div class="form-group col-lg-4 col-md-4 col-12">
									<label class="col-form-label">Temperatura<b class="text-danger">*</b></label>
									<input class="form-control min-decimal @error('temperature') is-invalid @enderror" type="text" name="temperature" placeholder="Ingrese la temperatura" value="@if(!is_null(old('temperature'))){{ old('temperature') }}@else{{ '0.00' }}@endif">
								</div>

								<div class="form-group col-12">
									<label class="col-form-label">Descripción del Problema<b class="text-danger">*</b></label>
									<textarea class="form-control @error('problem_description') is-invalid @enderror" name="problem_description" required placeholder="Introduzca una descripción" rows="5">{{ old('problem_description') }}</textarea>
								</div>

								<div class="col-12">
									<h6 class="font-weight-bold">Medicamentos Recetados</h6>
								</div>

								<div class="form-group col-lg-4 col-md-4 col-12">
									<label class="col-form-label">Medicina<b class="text-danger">*</b></label>
									<select class="form-control" id="prescriptionMedicine">
										<option value="">Seleccione</option>
										@foreach($medicines as $medicine)
										<option value="{{ $medicine->slug }}">{{ $medicine->name }}</option>
										@endforeach
									</select>
								</div>

								<div class="form-group col-lg-4 col-md-4 col-12">
									<label class="col-form-label">Dosis<b class="text-danger">*</b></label>
									<select class="form-control" id="prescriptionDosage">
										<option value="">Seleccione</option>
										<option value="1">0-0-0</option>
										<option value="2">0-0-1</option>
										<option value="3">0-1-0</option>
										<option value="4">0-1-1</option>
										<option value="5">1-0-0</option>
										<option value="6">1-0-1</option>
										<option value="7">1-1-0</option>
										<option value="8">1-1-1</option>
									</select>
								</div>

								<div class="form-group col-lg-4 col-md-4 col-12">
									<label class="col-form-label">Días<b class="text-danger">*</b></label>
									<input class="form-control int-positive" type="text" placeholder="Ingrese los días" value="1" id="prescriptionDays">
								</div>

								<div class="form-group col-lg-4 col-md-4 col-12">
									<label class="col-form-label">Hora<b class="text-danger">*</b></label>
									<select class="form-control" id="prescriptionTime">
										<option value="">Seleccione</option>
										<option value="1">Despues de Comer</option>
										<option value="2">Antes de Comer</option>
									</select>
								</div>

								<div class="form-group col-lg-8 col-md-8 col-12">
									<label class="col-form-label">Comentarios (Opcional)</label>
									<input class="form-control" type="text" placeholder="Ingrese los comentarios" id="prescriptionComments">
								</div>

								<div class="col-12">
									<p class="text-danger font-weight-bold mb-2 d-none" id="errorMedicinePrescription">Todos los campos son obligatorios</p>
								</div>

								<div class="form-group col-12">
									<button type="button" class="btn btn-primary" slug="{{ $appointment->id }}" id="addMedicinePrescription">Agregar</button>
								</div>

								<div class="col-12">
									<div class="table-responsive mb-4 mt-4">
										<table class="table table-hover">
											<thead>
												<tr>
													<th>#</th>
													<th>Medicina</th>
													<th>Dosis</th>
													<th>Días</th>
													<th>Hora</th>
													<th>Comentarios</th>
												</tr>
											</thead>
											<tbody class="prescription-items">
												@if(!session()->has('prescription') || (session()->has('prescription') && count(session('prescription'))==0))
												<tr class="text-center prescription-empty">
													<td colspan="6">No hay recetas agregadas a la prescripción</td>
												</tr>
												@else
												@foreach(session('prescription') as $item)
												<tr code="{{ $item['code'] }}">
													<td>
														<button type="button" class="btn btn-danger text-center delete-item" code="{{ $item['code'] }}">
															<i class="fa fa-times"></i>
														</button>
													</td>
													<td>{{ $item['medicine']->name }}</td>
													<td>{{ prescriptionDosage($item['dosage']) }}</td>
													<td>{{ $item['days'] }}</td>
													<td>{{ prescriptionTime($item['time']) }}</td>
													<td>{{ $item['comments'] }}</td>
												</tr>
												@endforeach
												@endif
											</tbody>
										</table>
									</div>
								</div>

								<div class="col-12">
									<h6 class="font-weight-bold">Información de Covid</h6>
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Covid<b class="text-danger">*</b></label>
									<select class="form-control @error('covid') is-invalid @enderror" name="covid" required>
										<option value="">Seleccione</option>
										<option value="0" @if(old('covid')=='0') selected @endif>No</option>
										<option value="1" @if(old('covid')=='1') selected @endif>Si</option>
									</select>
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Fecha de Contagio<b class="text-danger">*</b></label>
									<input class="form-control date @error('covid_date') is-invalid @enderror" type="text" name="covid_date" @if(is_null(old('covid')) || old('covid')!='1') disabled @else required @endif placeholder="Seleccione" value="{{ old('covid_date') }}" id="flatpickr">
								</div>

								<div class="form-group col-12">
									<label class="col-form-label">Sintomas<b class="text-danger">*</b></label>
									<select class="form-control selectpicker @error('symptoms') is-invalid @enderror" name="symptoms[]" @if(is_null(old('covid')) || old('covid')!='1') disabled @else required @endif title="Seleccione" data-size="10" multiple>
										@if(is_null(old('symptoms')))
										<option value="1">Fiebre</option>
										<option value="2">Tos</option>
										<option value="3">Cansancio</option>
										<option value="4">Pérdida del gusto</option>
										<option value="5">Pérdida del olfato</option>
										<option value="6">Dolor de garganta</option>
										<option value="7">Dolor de cabeza</option>
										<option value="8">Diarrea</option>
										<option value="9">Dolor en el pecho</option>
										<option value="10">Dificultad para respirar</option>
										@else
										{!! selectArraySymptoms([['id' => 1, 'name' => 'Fiebre'], ['id' => 2, 'name' => 'Tos'], ['id' => 3, 'name' => 'Cansancio'], ['id' => 4, 'name' => 'Pérdida del gusto'], ['id' => 5, 'name' => 'Pérdida del olfato'], ['id' => 6, 'name' => 'Dolor de garganta'], ['id' => 7, 'name' => 'Dolor de cabeza'], ['id' => 8, 'name' => 'Diarrea'], ['id' => 9, 'name' => 'Dolor en el pecho'], ['id' => 10, 'name' => 'Dificultad para respirar']], old('symptoms')) !!}
										@endif
									</select>
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Internado en UCI<b class="text-danger">*</b></label>
									<select class="form-control @error('uci') is-invalid @enderror" name="uci" @if(is_null(old('covid')) || old('covid')!='1') disabled @else required @endif>
										<option value="">Seleccione</option>
										<option value="0" @if(old('uci')=='0') selected @endif>No</option>
										<option value="1" @if(old('uci')=='1') selected @endif>Si</option>
									</select>
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Estado de Recuperación<b class="text-danger">*</b></label>
									<select class="form-control @error('covid_state') is-invalid @enderror" name="covid_state" @if(is_null(old('covid')) || old('covid')!='1') disabled @else required @endif>
										<option value="">Seleccione</option>
										<option value="1" @if(old('covid_state')=='1') selected @endif>Recuperado</option>
										<option value="2" @if(old('covid_state')=='2') selected @endif>No Recuperado</option>
									</select>
								</div>

								<div class="col-12">
									<h6 class="font-weight-bold">Consejos y Examenes</h6>
								</div>

								<div class="form-group col-12">
									<label class="col-form-label">Examenes<b class="text-danger">*</b></label>
									<textarea class="form-control @error('test') is-invalid @enderror" name="test" required placeholder="Introduzca los examenes" rows="5">{{ old('test') }}</textarea>
								</div>

								<div class="form-group col-12">
									<label class="col-form-label">Consejos<b class="text-danger">*</b></label>
									<textarea class="form-control @error('advice') is-invalid @enderror" name="advice" required placeholder="Introduzca los consejos" rows="5">{{ old('advice') }}</textarea>
								</div>

								<div class="col-12">
									<label class="col-form-label">Siguiente Visita<b class="text-danger">*</b></label>
									<div class="row">
										<div class="form-group col-lg-6 col-md-6 col-12">
											<input class="form-control int-positive @error('days') is-invalid @enderror" type="text" name="days" placeholder="Ingrese los días" value="@if(!is_null(old('days'))){{ old('days') }}@else{{ '1' }}@endif">
										</div>

										<div class="form-group col-lg-6 col-md-6 col-12">
											<select class="form-control @error('time') is-invalid @enderror" name="time" required>
												<option value="1" @if(old('time')=='1') selected @endif>Días</option>
												<option value="2" @if(old('time')=='2') selected @endif>Meses</option>
												<option value="2" @if(old('time')=='2') selected @endif>Años</option>
											</select>
										</div>
									</div>
								</div>

								<div class="form-group col-12">
									<div class="btn-group" role="group">
										<button type="submit" class="btn btn-primary" action="prescription">Guardar</button>
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
<script src="{{ asset('/admins/vendor/touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/jquery.validate.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/additional-methods.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/messages_es.js') }}"></script>
<script src="{{ asset('/admins/js/validate.js') }}"></script>
<script src="{{ asset('/admins/vendor/lobibox/Lobibox.js') }}"></script>
@endsection