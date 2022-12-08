@extends('layouts.admin')

@section('title', 'Lista de Documentos')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="javascript:void(0);">Documentos</a>
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
	                    <h4>Lista de Documentos</h4>
	                </div>
	            </div>
	        </div>
	        <div class="widget-content widget-content-area shadow-none">

	        	<div class="row">
					<div class="col-12 mt-3">
						@can('documents.create')
						<div class="text-right mr-3">
							<a href="{{ route('documents.create') }}" class="btn btn-primary mb-2">Agregar</a>
						</div>
						@endcan

                        <table class="table table-normal table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Paciente</th>
									<th>Doctor</th>
									<th>Cant. de Documentos</th>
									<th>Fecha</th>
                                    @if(auth()->user()->can('documents.show') || auth()->user()->can('documents.edit') || auth()->user()->can('documents.delete'))
									<th class="no-content">Acciones</th>
									@endif
                                </tr>
                            </thead>
                            <tbody>
								@foreach($documents as $document)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{ $document['user']->name.' '.$document['user']->lastname }}</td>
									<td>{{ $document['doctor']->name.' '.$document['doctor']->lastname }}</td>
                                    <td>{{ $document['files']->count() }}</td>
                                    <td>{{ $document->created_at->format('d-m-Y') }}</td>
									@if(auth()->user()->can('documents.show') || auth()->user()->can('documents.edit') || auth()->user()->can('documents.delete'))
									<td>
										<div class="btn-group btn-svg-sm" role="group">
											@can('documents.show')
											<a href="{{ route('documents.show', ['document' => $document->id]) }}" class="btn btn-primary btn-sm bs-tooltip mr-0" title="Ver Detalles">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
											</a>
											@endcan
											@can('documents.edit')
											<a href="{{ route('documents.edit', ['document' => $document->id]) }}" class="btn btn-info btn-sm bs-tooltip mr-0" title="Editar">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
											</a>
											@endcan
											@can('documents.delete')
											<button type="button" class="btn btn-danger btn-sm bs-tooltip mr-0" title="Eliminar" onclick="deleteDocument('{{ $document->id }}')">
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

@can('documents.delete')
<div class="modal fade" id="deleteDocument" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">¿Estás seguro de que quieres eliminar este documento?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn" data-dismiss="modal">Cancelar</button>
				<form action="#" method="POST" id="formDeleteDocument">
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
<script src="{{ asset('/admins/vendor/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/sweetalerts/custom-sweetalert.js') }}"></script>
<script src="{{ asset('/admins/vendor/lobibox/Lobibox.js') }}"></script>
@endsection