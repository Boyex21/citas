@extends('layout')

@section('title')
<title>Editar Perfil</title>
@endsection

@section('meta')
<meta name="description" content="Editar Perfil">
@endsection

@section('public-content')

<!--Banner Start-->
<div class="banner-area flex" style="background-image: url({{ asset('/uploads/website-images/banner-user.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>Editar Perfil</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->

<!--Dashboard Start-->
<div class="dashboard-area pt_70 pb_70">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                @include('user.sidebar')
            </div>
            <div class="col-lg-9">
                <div class="detail-dashboard add-form">
                    <h2 class="d-headline">Editar Perfil</h2>
                    <form action="{{ route('user.update-profile') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row row">
                            <div class="form-group col-12">
                                <label>Imagen</label>
                                <input type="file" class="form-control"  name="image">
                            </div>

                            <div class="form-group col-12">
                                <label>Nombre<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" required value="{{ $user->name }}" name="name">
                            </div>

                            <div class="form-group col-12">
                                <label>Cédula<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" required value="{{ $user->patient_id }}" name="cedula">
                            </div>

                            <div class="form-group col-12">
                                <label>Email<span class="text-danger">*</span></label>
                                <input type="email" readonly class="form-control" value="{{ $user->email }}" name="email">
                            </div>

                            <div class="form-group col-12">
                                <label>Teléfono<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" required value="{{ $user->phone }}" name="phone">
                            </div>

                            <div class="form-group col-12">
                                <label>Dirección<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" required value="{{ $user->address }}" name="address">
                            </div>

                            <div class="form-group col-12">
                                <label>Edad<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" required value="{{ $user->age }}" name="age">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Peso<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" required value="{{ $user->weight }}" name="weight">
                            </div>

                            <div class="form-group col-md-6 option-item">
                                <label for="">Género<span>*</span></label>
                                <select class="form-control" name="gender" required>
                                    <option value="">Seleccione</option>
                                    <option {{ 'Masculino'==$user->gender ? 'selected' : '' }} value="Masculino">Masculino</option>
                                    <option {{ 'Femenino'==$user->gender ? 'selected' : '' }} value="Femenino">Femenino</option>
                                    <option {{ 'Otro'==$user->gender ? 'selected' : '' }} value="Otro">Otro</option>
                                </select>
                            </div>

                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Dashboard End-->

@endsection

