@extends('layout')
@section('title')
    <title>{{__('dashboard')}}</title>
@endsection
@section('meta')
    <meta name="description" content="{{__('dashboard')}}">
@endsection

@section('public-content')

<!--Dashboard Start-->
<div class="dashboard-area pt_70 pb_70">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                @include('sidebar')
            </div>
            <div class="col-lg-9">
                <div class="detail-dashboard add-form">
                    <h2 class="d-headline">Cambiar Contraseña</h2>

                    <form action="{{ route('update-contrasena') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-12">
                                <label>Contraseña Actual <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="current_password">
                            </div>
                            <div class="form-group col-12">
                                <label>Nueva Contraseña</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <div class="form-group col-12">
                                <label>Confirmar Nueva Contraseña <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-primary">Guardar</button>
                            </div>
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

