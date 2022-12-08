@extends('layouts.admin')

@section('title', 'Crear Paciente')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="javascript:void(0);">Pacientes</a>
</li>
<li class="breadcrumb-item active" aria-current="page">
    <a href="javascript:void(0);">Registro</a>
</li>
@endsection

@section('links')
<link rel="stylesheet" href="{{ asset('/admins/css/elements/alert.css') }}">
<link rel="stylesheet" href="{{ asset('/admins/vendor/dropify/dropify.min.css') }}">
<link href="{{ asset('/admins/vendor/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('/admins/vendor/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{ asset('/admins/vendor/touchspin/jquery.bootstrap-touchspin.min.css') }}">
<link rel="stylesheet" href="{{ asset('/admins/vendor/lobibox/Lobibox.min.css') }}">
@endsection

@section('content')

<div class="row layout-top-spacing">
	<div class="col-12 layout-spacing">
    	<div class="statbox widget box box-shadow">
	        <div class="widget-header">
	            <div class="row">
	                <div class="col-12">
	                    <h4>Crear Paciente</h4>
	                </div>
	            </div>
	        </div>
	        <div class="widget-content widget-content-area shadow-none">
	        	<div class="row">
					<div class="col-12">

						@include('admin.partials.errors')

						<p>Campos obligatorios (<b class="text-danger">*</b>)</p>
						<form action="{{ route('patients.store') }}" method="POST" class="form" id="formPatient" enctype="multipart/form-data">
							@csrf
							<div class="row">
								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Foto (Opcional)</label>
									<input type="file" name="photo" accept="image/*" class="dropify" data-height="125" data-max-file-size="20M" data-allowed-file-extensions="jpg png jpeg web3" />
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<div class="row">
										<div class="form-group col-12">
											<label class="col-form-label">Nombre<b class="text-danger">*</b></label>
											<input class="form-control @error('name') is-invalid @enderror" type="text" name="name" required placeholder="Introduzca un nombre" value="{{ old('name') }}">
										</div>

										<div class="form-group col-12">
											<label class="col-form-label">Apellido<b class="text-danger">*</b></label>
											<input class="form-control @error('lastname') is-invalid @enderror" type="text" name="lastname" required placeholder="Introduzca un apellido" value="{{ old('lastname') }}">
										</div>
									</div> 
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Correo Electrónico<b class="text-danger">*</b></label>
									<input class="form-control @error('email') is-invalid @enderror" type="email" name="email" required placeholder="Introduzca un correo electrónico" value="{{ old('email') }}">
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Cédula<b class="text-danger">*</b></label>
									<input class="form-control @error('dni') is-invalid @enderror" type="text" name="dni" required placeholder="Introduzca una cédula" value="{{ old('dni') }}">
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Teléfono<b class="text-danger">*</b></label>
									<input class="form-control @error('phone') is-invalid @enderror" type="text" name="phone" required placeholder="Introduzca un teléfono" value="{{ old('phone') }}" id="phone">
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Dirección<b class="text-danger">*</b></label>
									<input class="form-control @error('address') is-invalid @enderror" type="text" name="address" required placeholder="Introduzca una dirección" value="{{ old('address') }}">
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Locación<b class="text-danger">*</b></label>
									<select class="form-control @error('location_id') is-invalid @enderror" name="location_id" required>
										<option value="">Seleccione</option>
										@foreach($locations as $location)
										<option value="{{ $location->slug }}" @if(old('location_id')==$location->slug) selected @endif>{{ $location->name }}</option>
										@endforeach
									</select>
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Género<b class="text-danger">*</b></label>
									<select class="form-control @error('gender') is-invalid @enderror" name="gender" required>
										<option value="">Seleccione</option>
										<option value="1" @if(old('gender')=='1') selected @endif>Masculino</option>
										<option value="2" @if(old('gender')=='2') selected @endif>Femenino</option>
										<option value="3" @if(old('gender')=='3') selected @endif>Otro</option>
									</select>
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Fecha de Nacimiento<b class="text-danger">*</b></label>
									<input class="form-control date @error('birthday') is-invalid @enderror" type="text" name="birthday" placeholder="Seleccione" value="{{ old('birthday') }}" id="flatpickr">
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Peso (Kg)<b class="text-danger">*</b></label>
									<input class="form-control min-decimal @error('weight') is-invalid @enderror" type="text" name="weight" placeholder="Ingrese un peso" value="@if(!is_null(old('weight'))){{ old('weight') }}@else{{ '0.00' }}@endif">
								</div>
								
								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Contraseña<b class="text-danger">*</b></label>
									<input class="form-control @error('password') is-invalid @enderror" type="password" name="password" required placeholder="********" id="password">
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Confirmar Contraseña<b class="text-danger">*</b></label>
									<input class="form-control" type="password" name="password_confirmation" required placeholder="********">
								</div>
								<div class="form-group col-12">
									<div class="btn-group" role="group">
										<button type="submit" class="btn btn-primary" action="patient">Guardar</button>
										<a href="{{ route('patients.index') }}" class="btn btn-secondary">Volver</a>
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
<script src="{{ asset('/admins/vendor/dropify/dropify.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('/admins/vendor/flatpickr/es.js') }}"></script>
<script src="{{ asset('/admins/vendor/touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/jquery.validate.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/additional-methods.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/messages_es.js') }}"></script>
<script src="{{ asset('/admins/js/validate.js') }}"></script>
<script src="{{ asset('/admins/vendor/lobibox/Lobibox.js') }}"></script>
@endsection