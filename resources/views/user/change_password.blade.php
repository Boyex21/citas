@extends('layout')

@section('title')
<title>Cambiar Contraseña</title>
@endsection

@section('meta')
<meta name="description" content="Cambiar Contraseña">
@endsection

@section('public-content')

<!--Banner Start-->
<div class="banner-area flex" style="background-image: url({{ asset('/uploads/website-images/banner-user.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>Cambiar Contraseña</h1>
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
                    <h2 class="d-headline">Cambiar Contraseña</h2>

                    <form action="{{ route('user.update-password') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-12">
                                <label>Contraseña Actual<span class="text-danger">*</span></label>
                                <input type="password" class="form-control" required name="current_password">
                            </div>

                            <div class="form-group col-12">
                                <label>Contraseña Nueva</label>
                                <input type="password" class="form-control" required name="password">
                            </div>

                            <div class="form-group col-12">
                                <label>Confirmar Contraseña<span class="text-danger">*</span></label>
                                <input type="password" class="form-control" required name="password_confirmation">
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-primary">Actualizar</button>
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

