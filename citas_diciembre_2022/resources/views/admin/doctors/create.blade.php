@extends('layouts.admin')

@section('title', 'Crear Doctor')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="javascript:void(0);">Doctores</a>
</li>
<li class="breadcrumb-item active" aria-current="page">
    <a href="javascript:void(0);">Registro</a>
</li>
@endsection

@section('links')
<link rel="stylesheet" href="{{ asset('/admins/css/elements/alert.css') }}">
<link rel="stylesheet" href="{{ asset('/admins/vendor/dropify/dropify.min.css') }}">
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
	                    <h4>Crear Doctor</h4>
	                </div>
	            </div>
	        </div>
	        <div class="widget-content widget-content-area shadow-none">
	        	<div class="row">
					<div class="col-12">

						@include('admin.partials.errors')

						<p>Campos obligatorios (<b class="text-danger">*</b>)</p>
						<form action="{{ route('doctors.store') }}" method="POST" class="form" id="formDoctor" enctype="multipart/form-data">
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
									<label class="col-form-label">Designación<b class="text-danger">*</b></label>
									<input class="form-control @error('designation') is-invalid @enderror" type="text" name="designation" required placeholder="Introduzca una designación" value="{{ old('designation') }}">
								</div>

								<div class="form-group col-12">
									<label class="col-form-label">Especialidades<b class="text-danger">*</b></label>
									<select class="form-control selectpicker @error('specialty_id') is-invalid @enderror" name="specialty_id[]" required title="Seleccione" data-size="10" multiple>
										@if(is_null(old('specialty_id')))
										@foreach($specialties as $specialty)
										<option value="{{ $specialty->slug }}">{{ $specialty->name }}</option>
										@endforeach
										@else
										{!! selectArray($specialties, old('specialty_id')) !!}
										@endif
									</select>
								</div>

								<div class="form-group col-12">
									<label class="col-form-label">Sobre Mi<b class="text-danger">*</b></label>
									<textarea class="form-control @error('about') is-invalid @enderror" name="about" required placeholder="Introduzca una descripción" rows="6">{{ old('about') }}</textarea>
								</div>

								<div class="form-group col-12">
									<label class="col-form-label">Educación<b class="text-danger">*</b></label>
									<textarea class="form-control @error('education') is-invalid @enderror" name="education" required placeholder="Introduzca la educación" rows="6">{{ old('education') }}</textarea>
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
										<button type="submit" class="btn btn-primary" action="doctor">Guardar</button>
										<a href="{{ route('doctors.index') }}" class="btn btn-secondary">Volver</a>
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
<script src="{{ asset('/admins/vendor/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/jquery.validate.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/additional-methods.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/messages_es.js') }}"></script>
<script src="{{ asset('/admins/js/validate.js') }}"></script>
<script src="{{ asset('/admins/vendor/lobibox/Lobibox.js') }}"></script>
@endsection