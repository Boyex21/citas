@extends('layouts.admin')

@section('title', 'Detalles de la Cita')

@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="javascript:void(0);">Citas</a>
</li>
<li class="breadcrumb-item active" aria-current="page">
	<a href="javascript:void(0);">Detalles</a>
</li>
@endsection

@section('links')
<link href="{{ asset('/admins/css/users/user-profile.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('/admins/vendor/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/admins/vendor/table/datatable/dt-global_style.css') }}">
@endsection

@section('content')

<div class="row layout-top-spacing">
	<div class="col-xl-6 col-lg-6 col-md-6 col-12 layout-spacing">
		<div class="user-profile">
			<div class="widget-content widget-content-area p-4">
				<div class="d-flex justify-content-between">
					<h3 class="">Datos del Paciente</h3>
					@can('patients.edit')
					<a href="{{ route('patients.edit', ['user' => $appointment['user']->slug]) }}" class="mt-2 edit-profile"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></a>
					@endcan
				</div>
				<div class="text-center user-info">
					<img src="{{ image_exist('/admins/img/users/', $appointment['user']->photo, true) }}" width="90" height="90" alt="Foto de perfil" title="{{ $appointment['user']->name." ".$appointment['user']->lastname }}">
					<p class="mb-0">{{ $appointment['user']->name." ".$appointment['user']->lastname }}</p>
				</div>
				<div class="user-info-list">

					<div class="">
						<ul class="contacts-block list-unstyled">
							<li class="contacts-block__item">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-coffee"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg>{!! roleUser($appointment['user']) !!}
							</li>
							<li class="contacts-block__item">
								<a href="mailto:{{ $appointment['user']->email }}" class="text-break"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>{{ $appointment['user']->email }}</a>
							</li>
							<li class="contacts-block__item">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>@if(!is_null($appointment['user']->phone)){{ $appointment['user']->phone }}@else{{ "No Ingresado" }}@endif
							</li>
							<li class="contacts-block__item">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>{!! state($appointment['user']->state) !!}
							</li>
						</ul>
					</div>                                    
				</div>
			</div>
		</div>
	</div>

	<div class="col-xl-6 col-lg-6 col-md-6 col-12 layout-spacing">
		<div class="user-profile">
			<div class="widget-content widget-content-area p-4">
				<div class="d-flex justify-content-between">
					<h3 class="">Datos del Doctor</h3>
					@can('doctors.edit')
					<a href="{{ route('doctors.edit', ['user' => $appointment['doctor']->slug]) }}" class="mt-2 edit-profile"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></a>
					@endcan
				</div>
				<div class="text-center user-info">
					<img src="{{ image_exist('/admins/img/users/', $appointment['doctor']->photo, true) }}" width="90" height="90" alt="Foto de perfil" title="{{ $appointment['doctor']->name." ".$appointment['doctor']->lastname }}">
					<p class="mb-0">{{ $appointment['doctor']->name." ".$appointment['doctor']->lastname }}</p>
				</div>
				<div class="user-info-list">

					<div class="">
						<ul class="contacts-block list-unstyled">
							<li class="contacts-block__item">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-coffee"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg>{!! roleUser($appointment['doctor']) !!}
							</li>
							<li class="contacts-block__item">
								<a href="mailto:{{ $appointment['doctor']->email }}" class="text-break"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>{{ $appointment['doctor']->email }}</a>
							</li>
							<li class="contacts-block__item">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>@if(!is_null($appointment['doctor']->phone)){{ $appointment['doctor']->phone }}@else{{ "No Ingresado" }}@endif
							</li>
							<li class="contacts-block__item">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>{!! state($appointment['doctor']->state) !!}
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-12 layout-spacing">
		<div class="user-profile layout-spacing">
			<div class="widget-content widget-content-area p-4">
				<div class="d-flex justify-content-between">
					<h3 class="pb-3">Detalles de la Consulta</h3>
				</div>
				<div class="user-info-list">

					<div class="">
						<ul class="contacts-block list-unstyled mw-100 mx-2 mb-0">
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Especialidad:</b> @if(!is_null($appointment['specialty'])){{ $appointment['specialty']->name }}@else{{ 'No Ingresado' }}@endif</span>
							</li>

							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Fecha de Cita:</b> {{ $appointment->date->format('d-m-Y') }}</span>
							</li>

							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Horario:</b> @if(!is_null($appointment['schedule'])){{ $appointment['schedule']->start->format('H:i A').' - '.$appointment['schedule']->end->format('H:i A') }}@else{{ 'No Ingresado' }}@endif</span>
							</li>

							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Tipo de Consulta:</b> {{ $appointment->type }}</span>
							</li>

							<li class="contacts-block__item">
								<a href="{{ route('appointments.index') }}" class="btn btn-secondary">Volver</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-12 layout-spacing">
		<div class="user-profile layout-spacing">
			<div class="widget-content widget-content-area p-4">
				<div class="d-flex justify-content-between">
					<h3 class="pb-3">Información Física</h3>
				</div>
				<div class="user-info-list">

					<div class="">
						<ul class="contacts-block list-unstyled mw-100 mx-2 mb-0">
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Presión Sanguinea:</b> {{ number_format($appointment->blood_pressure, 2, ',', '.') }}</span>
							</li>

							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Frequencia de Pulso:</b> {{ number_format($appointment->pulse_rate, 2, ',', '.') }}</span>
							</li>

							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Temperatura:</b> {{ number_format($appointment->temperature, 2, ',', '.') }}</span>
							</li>

							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Descripción del Problema:</b> {{ $appointment->problem_description }}</span>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	@if($appointment->covid=='Si')
	<div class="col-12 layout-spacing">
		<div class="user-profile layout-spacing">
			<div class="widget-content widget-content-area p-4">
				<div class="d-flex justify-content-between">
					<h3 class="pb-3">Información de Covid</h3>
				</div>
				<div class="user-info-list">

					<div class="">
						<ul class="contacts-block list-unstyled mw-100 mx-2 mb-0">
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Fecha de Contagio:</b> {{ $appointment->covid_date->format('d-m-Y') }}</span>
							</li>

							<li class="contacts-block__item">
								<span class="h6 text-black">
									<b>Sintomas:</b>
									@foreach($appointment['symptoms'] as $symptom)
									{{ $symptom->symptom }}@if(!$loop->last){{ ', ' }}@endif
									@endforeach
								</span>
							</li>

							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Internado en UCI:</b> {{ $appointment->uci }}</span>
							</li>

							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Estado de Recuperación:</b> {{ $appointment->covid_state }}</span>
							</li>

							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Tipo de Consulta:</b> {{ $appointment->type }}</span>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endif

	<div class="col-12 layout-spacing">
		<div class="statbox widget box box-shadow">
			<div class="widget-header">
				<div class="row">
					<div class="col-12">
						<h4>Medicamentos Recetados</h4>
					</div>
				</div>
			</div>
			<div class="widget-content widget-content-area shadow-none">

				<div class="row">
					<div class="col-12 mt-3">
						<table class="table table-hover table-normal">
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
							<tbody>
								@foreach($appointment['prescriptions'] as $prescription)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{ $prescription['medicine']->name }}</td>
									<td>{{ $prescription->dosage }}</td>
									<td>{{ $prescription->days }}</td>
									<td>{{ $prescription->time }}</td>
									<td>{{ $prescription->comments }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-12 layout-spacing">
		<div class="user-profile layout-spacing">
			<div class="widget-content widget-content-area p-4">
				<div class="d-flex justify-content-between">
					<h3 class="pb-3">Consejos y Examenes</h3>
				</div>
				<div class="user-info-list">

					<div class="">
						<ul class="contacts-block list-unstyled mw-100 mx-2 mb-0">
							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Examenes:</b> {{ $appointment->test }}</span>
							</li>

							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Consejos:</b> {{ $appointment->advice }}</span>
							</li>

							<li class="contacts-block__item">
								<span class="h6 text-black"><b>Siguiente Visita:</b> {{ $appointment->days.' '.$appointment->time }}</span>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('/admins/vendor/table/datatable/datatables.js') }}"></script>
@endsection