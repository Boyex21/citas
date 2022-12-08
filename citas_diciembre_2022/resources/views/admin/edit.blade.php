@extends('layouts.admin')

@section('title', 'Editar Perfil')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="javascript:void(0);">Perfil</a>
</li>
<li class="breadcrumb-item active" aria-current="page">
    <a href="javascript:void(0);">Editar</a>
</li>
@endsection

@section('links')
<link rel="stylesheet" href="{{ asset('/admins/css/elements/alert.css') }}">
<link rel="stylesheet" href="{{ asset('/admins/vendor/dropify/dropify.min.css') }}">
<link href="{{ asset('/admins/vendor/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('/admins/vendor/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{ asset('/admins/vendor/touchspin/jquery.bootstrap-touchspin.min.css') }}">
<link rel="stylesheet" href="{{ asset('/admins/vendor/bootstrap-select/bootstrap-select.min.css') }}">
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
	                    <h4>Editar Perfil</h4>
	                </div>
	            </div>
	        </div>
	        <div class="widget-content widget-content-area shadow-none">

				<div class="row">
					<div class="col-12">

						@include('admin.partials.errors')

						<p>Campos obligatorios (<b class="text-danger">*</b>)</p>
						<form action="{{ route('profile.update', ['slug' => Auth::user()->slug]) }}" method="POST" class="form" id="formProfile" enctype="multipart/form-data">
							@csrf
							@method('PUT')
							<div class="row">
								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Foto (Opcional)</label>
									<input type="file" name="photo" accept="image/*" class="dropify" data-height="125" data-max-file-size="20M" data-allowed-file-extensions="jpg png jpeg web3" data-default-file="{{ image_exist('/admins/img/users/', Auth::user()->photo, true) }}" />
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<div class="row">
										<div class="form-group col-lg-12 col-md-12 col-12">
											<label class="col-form-label">Nombre<b class="text-danger">*</b></label>
											<input class="form-control @error('name') is-invalid @enderror" type="text" name="name" required placeholder="Introduzca un nombre" value="{{ Auth::user()->name }}">
										</div>

										<div class="form-group col-lg-12 col-md-12 col-12">
											<label class="col-form-label">Apellido<b class="text-danger">*</b></label>
											<input class="form-control @error('lastname') is-invalid @enderror" type="text" name="lastname" required placeholder="Introduzca un apellido" value="{{ Auth::user()->lastname }}">
										</div>
									</div> 
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Correo Electrónico</label>
									<input class="form-control" type="text" disabled value="{{ Auth::user()->email }}">
								</div>

								@if(Auth::user()->hasRole(['Paciente']))
								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Cédula<b class="text-danger">*</b></label>
									<input class="form-control @error('dni') is-invalid @enderror" type="text" name="dni" required placeholder="Introduzca una cédula" value="{{ Auth::user()->dni }}">
								</div>
								@endif

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Teléfono<b class="text-danger">*</b></label>
									<input class="form-control @error('phone') is-invalid @enderror" type="text" name="phone" required placeholder="Introduzca un teléfono" value="{{ Auth::user()->phone }}" id="phone">
								</div>

								<div class="form-group @if(Auth::user()->hasRole(['Paciente'])) col-lg-6 col-md-6 @endif col-12">
									<label class="col-form-label">Dirección<b class="text-danger">*</b></label>
									<input class="form-control @error('address') is-invalid @enderror" type="text" name="address" required placeholder="Introduzca una dirección" value="{{ Auth::user()->address }}">
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Locación<b class="text-danger">*</b></label>
									<select class="form-control @error('location_id') is-invalid @enderror" name="location_id" required>
										<option value="">Seleccione</option>
										@foreach($locations as $location)
										<option value="{{ $location->slug }}" @if(Auth::user()->location_id==$location->id) selected @endif>{{ $location->name }}</option>
										@endforeach
									</select>
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Género<b class="text-danger">*</b></label>
									<select class="form-control @error('gender') is-invalid @enderror" name="gender" required>
										<option value="">Seleccione</option>
										<option value="1" @if(Auth::user()->gender=='Masculino') selected @endif>Masculino</option>
										<option value="2" @if(Auth::user()->gender=='Femenino') selected @endif>Femenino</option>
										<option value="3" @if(Auth::user()->gender=='Otro') selected @endif>Otro</option>
									</select>
								</div>

								@if(Auth::user()->hasRole(['Paciente']))
								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Fecha de Nacimiento<b class="text-danger">*</b></label>
									<input class="form-control date @error('birthday') is-invalid @enderror" type="text" name="birthday" placeholder="Seleccione" value="@if(!is_null(Auth::user()->birthday)){{ Auth::user()->birthday->format('d-m-Y') }}@endif" id="flatpickr">
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Peso (Kg)<b class="text-danger">*</b></label>
									<input class="form-control min-decimal @error('weight') is-invalid @enderror" type="text" name="weight" placeholder="Ingrese un peso" value="{{ Auth::user()->weight }}">
								</div>
								@endif

								@if(Auth::user()->hasRole(['Doctor']))
								<div class="form-group col-12">
									<label class="col-form-label">Designación<b class="text-danger">*</b></label>
									<input class="form-control @error('designation') is-invalid @enderror" type="text" name="designation" required placeholder="Introduzca una designación" value="{{ Auth::user()->designation }}">
								</div>

								<div class="form-group col-12">
									<label class="col-form-label">Especialidades<b class="text-danger">*</b></label>
									<select class="form-control selectpicker @error('specialty_id') is-invalid @enderror" name="specialty_id[]" required title="Seleccione" data-size="10" multiple>
										{!! selectArray($specialties, Auth::user()['specialties']) !!}
									</select>
								</div>

								<div class="form-group col-12">
									<label class="col-form-label">Sobre Mi<b class="text-danger">*</b></label>
									<textarea class="form-control @error('about') is-invalid @enderror" name="about" required placeholder="Introduzca una descripción" rows="6">{{ Auth::user()->about }}</textarea>
								</div>

								<div class="form-group col-12">
									<label class="col-form-label">Educación<b class="text-danger">*</b></label>
									<textarea class="form-control @error('education') is-invalid @enderror" name="education" required placeholder="Introduzca la educación" rows="6">{{ Auth::user()->education }}</textarea>
								</div>
								@endif

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Contraseña (Opcional)</label>
									<input class="form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="********" id="password">
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Confirmar Contraseña (Opcional)</label>
									<input class="form-control" type="password" name="password_confirmation" placeholder="********">
								</div>

								<div class="form-group col-12">
									<div class="btn-group" role="group">
										<button type="submit" class="btn btn-primary mr-0" action="profile">Actualizar</button>
										<a href="{{ route('profile') }}" class="btn btn-secondary">Volver</a>
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
<script src="{{ asset('/admins/vendor/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/jquery.validate.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/additional-methods.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/messages_es.js') }}"></script>
<script src="{{ asset('/admins/js/validate.js') }}"></script>
<script src="{{ asset('/admins/vendor/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/sweetalerts/custom-sweetalert.js') }}"></script>
<script src="{{ asset('/admins/vendor/lobibox/Lobibox.js') }}"></script>
@endsection