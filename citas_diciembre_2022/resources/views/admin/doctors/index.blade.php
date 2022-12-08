@extends('layouts.admin')

@section('title', 'Lista de Doctores')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="javascript:void(0);">Doctores</a>
</li>
<li class="breadcrumb-item active" aria-current="page">
    <a href="javascript:void(0);">Lista</a>
</li>
@endsection

@section('links')
<link rel="stylesheet" href="{{ asset('/admins/vendor/bootstrap-select/bootstrap-select.min.css') }}">
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
	                    <h4>Lista de Doctores</h4>
	                </div>
	            </div>
	        </div>
	        <div class="widget-content widget-content-area shadow-none">

	        	<div class="row">
					<div class="col-12 mt-3">
						@can('doctors.create')
						<div class="text-right mr-3">
							<a href="{{ route('doctors.create') }}" class="btn btn-primary">Agregar</a>
						</div>
						@endcan

                        <table class="table table-normal table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
									<th>Nombre Completo</th>
									<th>Correo</th>
									<th>Teléfono</th>
									<th>Estado</th>
                                    @if(auth()->user()->can('doctors.show') || auth()->user()->can('doctors.edit') || auth()->user()->can('doctors.active') || auth()->user()->can('doctors.deactive') || auth()->user()->can('doctors.delete'))
									<th class="no-content">Acciones</th>
									@endif
                                </tr>
                            </thead>
                            <tbody>
								@foreach($users as $user)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td class="d-flex align-items-center">
										<img src="{{ image_exist('/admins/img/users/', $user->photo, true) }}" class="rounded-circle mr-2" width="45" height="45" alt="{{ $user->name." ".$user->lastname }}" title="{{ $user->name." ".$user->lastname }}"> {{ $user->name." ".$user->lastname }}
									</td>
									<td>{{ $user->email }}</td>
									<td>{{ $user->phone }}</td>
									<td>{!! state($user->state) !!}</td>
									@if(auth()->user()->can('doctors.show') || auth()->user()->can('doctors.edit') || auth()->user()->can('doctors.active') || auth()->user()->can('doctors.deactive') || auth()->user()->can('doctors.delete'))
									<td>
										<div class="btn-group btn-svg-sm" role="group">
											@can('doctors.show')
											<a href="{{ route('doctors.show', ['user' => $user->slug]) }}" class="btn btn-primary btn-sm bs-tooltip mr-0" title="Perfil">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
											</a>
											@endcan
											@can('doctors.edit')
											<a href="{{ route('doctors.edit', ['user' => $user->slug]) }}" class="btn btn-info btn-sm bs-tooltip mr-0" title="Editar">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
											</a>
											@endcan
											@can('doctors.schedules')
											<button type="button" class="btn btn-secondary btn-sm bs-tooltip mr-0" title="Agregar Horarios" onclick="scheduleDoctor('{{ $user->slug }}', {{ $user->schedules->pluck('id') }})">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
											</button>
											@endcan
											@if($user->state=='Activo')
											@can('doctors.deactive')
											<button type="button" class="btn btn-warning btn-sm bs-tooltip mr-0" title="Desactivar" onclick="deactiveDoctor('{{ $user->slug }}')">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-power"><path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path><line x1="12" y1="2" x2="12" y2="12"></line></svg>
											</button>
											@endcan
											@else
											@can('doctors.active')
											<button type="button" class="btn btn-success btn-sm bs-tooltip mr-0" title="Activar" onclick="activeDoctor('{{ $user->slug }}')">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
											</button>
											@endcan
											@endif
											@can('doctors.delete')
											<button type="button" class="btn btn-danger btn-sm bs-tooltip mr-0" title="Eliminar" onclick="deleteDoctor('{{ $user->slug }}')">
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

@can('doctors.schedules')
<div class="modal fade" id="scheduleDoctor" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form action="#" method="POST" id="formScheduleDoctor">
			@csrf
			@method('PUT')
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Selecciona los horarios que quieres asignar al doctor</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-12">
							@include('admin.partials.errors')
							<p>Campos obligatorios (<b class="text-danger">*</b>)</p>
						</div>

						<div class="form-group col-12">
							<label class="col-form-label">Horarios<b class="text-danger">*</b></label>
							<select class="form-control selectpicker @error('schedule_id') is-invalid @enderror" name="schedule_id[]" required title="Seleccione" data-size="10" data-selected-text-format="count > 5" data-count-selected-text="{0} Horarios Seleccionados" multiple>
								@foreach($schedules as $schedule)
								<option value="{{ $schedule->id }}">{{ $schedule->day.': '.$schedule->start->format('H:i A').' - '.$schedule->end->format('H:i A') }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary" action="doctor">Actualizar</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endcan

@can('doctors.deactive')
<div class="modal fade" id="deactiveDoctor" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">¿Estás seguro de que quieres desactivar este doctor?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn" data-dismiss="modal">Cancelar</button>
				<form action="#" method="POST" id="formDeactiveDoctor">
					@csrf
					@method('PUT')
					<button type="submit" class="btn btn-primary">Desactivar</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endcan

@can('doctors.active')
<div class="modal fade" id="activeDoctor" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">¿Estás seguro de que quieres activar este doctor?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn" data-dismiss="modal">Cancelar</button>
				<form action="#" method="POST" id="formActiveDoctor">
					@csrf
					@method('PUT')
					<button type="submit" class="btn btn-primary">Activar</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endcan

@can('doctors.delete')
<div class="modal fade" id="deleteDoctor" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">¿Estás seguro de que quieres eliminar este doctor?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn" data-dismiss="modal">Cancelar</button>
				<form action="#" method="POST" id="formDeleteDoctor">
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
<script src="{{ asset('/admins/vendor/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/table/datatable/datatables.js') }}"></script>
<script src="{{ asset('/admins/vendor/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/sweetalerts/custom-sweetalert.js') }}"></script>
<script src="{{ asset('/admins/vendor/lobibox/Lobibox.js') }}"></script>
@endsection