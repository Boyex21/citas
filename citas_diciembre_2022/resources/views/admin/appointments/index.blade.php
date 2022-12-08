@extends('layouts.admin')

@section('title', 'Lista de Citas')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="javascript:void(0);">Citas</a>
</li>
<li class="breadcrumb-item active" aria-current="page">
    <a href="javascript:void(0);">Lista</a>
</li>
@endsection

@section('links')
<link rel="stylesheet" type="text/css" href="{{ asset('/admins/vendor/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/admins/vendor/table/datatable/dt-global_style.css') }}">
<link href="{{ asset('/admins/css/components/custom-modal.css') }}" rel="stylesheet" type="text/css" />
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
	                    <h4>Lista de Citas</h4>
	                </div>
	            </div>
	        </div>
	        <div class="widget-content widget-content-area shadow-none">

	        	<div class="row">
					<div class="col-12 mt-3">
						@can('appointments.create')
						<div class="text-right mr-3">
							<a href="{{ route('appointments.create') }}" class="btn btn-primary mb-2">Agregar</a>
						</div>
						@endcan

                        <table class="table table-normal table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
									<th>Doctor</th>
									<th>Paciente</th>
									<th>Fecha</th>
									<th>Horario</th>
									<th>Tipo de Consulta</th>
									<th>Estado</th>
                                    @if(auth()->user()->can('appointments.edit') || auth()->user()->can('appointments.active') || auth()->user()->can('appointments.deactive') || auth()->user()->can('appointments.delete'))
									<th class="no-content">Acciones</th>
									@endif
                                </tr>
                            </thead>
                            <tbody>
								@foreach($appointments as $appointment)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{ $appointment['doctor']->name." ".$appointment['doctor']->lastname }}</td>
									<td>{{ $appointment['user']->name." ".$appointment['user']->lastname }}</td>
									<td>{{ $appointment->date->format('d-m-Y') }}</td>
									<td>{{ $appointment['schedule']->start->format('H:i A').' - '.$appointment['schedule']->end->format('H:i A') }}</td>
									<td>{!! typeAppointment($appointment->type) !!}</td>
									<td>{!! stateAppointment($appointment->state) !!}</td>
									@if(auth()->user()->can('appointments.edit') || auth()->user()->can('appointments.active') || auth()->user()->can('appointments.deactive') || auth()->user()->can('appointments.delete'))
									<td>
										<div class="btn-group btn-svg-sm" role="group">
											@can('appointments.edit')
											<a href="{{ route('appointments.edit', ['appointment' => $appointment->id]) }}" class="btn btn-info btn-sm bs-tooltip mr-0" title="Editar">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
											</a>
											@endcan
											@if($appointment->state=='Pendiente' || $appointment->state=='Cancelada')
											@can('appointments.attend')
											<button type="button" class="btn btn-success btn-sm bs-tooltip mr-0" title="Atender" onclick="attendAppointment('{{ $appointment->id }}')">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
											</button>
											@endcan
											@endif
											@if($appointment->state=='Pendiente' || $appointment->state=='Tratado')
											@can('appointments.cancel')
											<button type="button" class="btn btn-warning btn-sm bs-tooltip mr-0" title="Cancelar" onclick="cancelAppointment('{{ $appointment->id }}')">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-power"><path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path><line x1="12" y1="2" x2="12" y2="12"></line></svg>
											</button>
											@endcan
											@endif
											@can('appointments.delete')
											<button type="button" class="btn btn-danger btn-sm bs-tooltip mr-0" title="Eliminar" onclick="deleteAppointment('{{ $appointment->id }}')">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
											</button>
											@endcan
										</div>
									</td>
									@endif
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

@can('appointments.cancel')
<div class="modal fade" id="cancelAppointment" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">¿Estás seguro de que quieres cancelar esta cita?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn" data-dismiss="modal">Cancelar</button>
				<form action="#" method="POST" id="formCancelAppointment">
					@csrf
					@method('PUT')
					<button type="submit" class="btn btn-primary">Cancelar</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endcan

@can('appointments.attend')
<div class="modal fade" id="attendAppointment" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">¿Estás seguro de que quieres atender esta cita?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn" data-dismiss="modal">Cancelar</button>
				<form action="#" method="POST" id="formAttendAppointment">
					@csrf
					@method('PUT')
					<button type="submit" class="btn btn-primary">Atender</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endcan

@can('appointments.delete')
<div class="modal fade" id="deleteAppointment" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">¿Estás seguro de que quieres eliminar esta cita?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn" data-dismiss="modal">Cancelar</button>
				<form action="#" method="POST" id="formDeleteAppointment">
					@csrf
					@method('DELETE')
					<button type="submit" class="btn btn-primary">Eliminar</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endcan

@endsection

@section('scripts')
<script src="{{ asset('/admins/vendor/table/datatable/datatables.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/jquery.validate.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/additional-methods.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/messages_es.js') }}"></script>
<script src="{{ asset('/admins/js/validate.js') }}"></script>
<script src="{{ asset('/admins/vendor/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/sweetalerts/custom-sweetalert.js') }}"></script>
<script src="{{ asset('/admins/vendor/lobibox/Lobibox.js') }}"></script>
@endsection