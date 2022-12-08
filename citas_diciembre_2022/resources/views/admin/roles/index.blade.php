@extends('layouts.admin')

@section('title', 'Lista de Roles')

@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="javascript:void(0);">Roles</a>
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
						<h4>Lista de Roles</h4>
					</div>
				</div>
			</div>
			<div class="widget-content widget-content-area shadow-none">

				<div class="row">
					<div class="col-12 mt-3">
						@can('roles.create')
						<div class="text-right mr-3">
							<a href="{{ route('roles.create') }}" class="btn btn-primary mb-2">Agregar</a>
						</div>
						@endcan

						<table class="table table-normal table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>Nombre</th>
									@if(auth()->user()->can('roles.edit') || auth()->user()->can('roles.delete'))
									<th class="no-content">Acciones</th>
									@endif
								</tr>
							</thead>
							<tbody>
								@foreach($roles as $role)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{ $role->name }}</td>
									@if(auth()->user()->can('roles.edit') || auth()->user()->can('roles.delete'))
									<td>
										<div class="btn-group btn-svg-sm" role="group">
											@can('roles.edit')
											@if($role->name!='Super Admin' && $role->name!='Administrador' && $role->name!='Doctor' && $role->name!='Secretaria' && $role->name!='Paciente')
											<a href="{{ route('roles.edit', ['role' => $role->id]) }}" class="btn btn-info btn-sm bs-tooltip mr-0" title="Editar">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
											</a>
											@endif
											@can('roles.permissions')
											<button type="button" class="btn btn-secondary btn-sm bs-tooltip mr-0" title="Permisos" onclick="permissionRole('{{ $role->id }}', {{ $role->permissions->pluck('name') }})">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-unlock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 9.9-1"></path></svg>
											</button>
											@endcan
											@endcan
											@can('roles.delete')
											@if($role->name!='Super Admin' && $role->name!='Administrador' && $role->name!='Doctor' && $role->name!='Secretaria' && $role->name!='Paciente')
											<button type="button" class="btn btn-danger btn-sm bs-tooltip mr-0" title="Eliminar" onclick="deleteRole('{{ $role->id }}')">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
											</button>
											@endif
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

@can('roles.permissions')
<div class="modal fade" id="permissionRole" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form action="#" method="POST" id="formPermissionRole">
			@csrf
			@method('PUT')
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Selecciona los permisos que quieres asignar al rol</h5>
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
							<label class="col-form-label">Permisos<b class="text-danger">*</b></label>
							<select class="form-control selectpicker @error('permission_id') is-invalid @enderror" name="permission_id[]" required title="Seleccione" data-size="10" data-selected-text-format="count > 5" data-count-selected-text="{0} Permisos Seleccionados" multiple>
								@foreach($permissions as $permission)
								<option value="{{ $permission->name }}">@lang('permissions.'.$permission->name)</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary" action="role">Actualizar</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endcan

@can('roles.delete')
<div class="modal fade" id="deleteRole" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">¿Estás seguro de que quieres eliminar este rol?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn" data-dismiss="modal">Cancelar</button>
				<form action="#" method="POST" id="formDeleteRole">
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