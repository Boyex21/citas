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
                    <h2 class="d-headline">Actualizar Perfil</h2>
                    <form action="{{ route('update-perfil') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row row">
                            <div class="form-group col-12">
                                <label>Foto </label>
                                <input type="file" class="form-control"  name="image">
                            </div>

                           <div class="form-group col-12">
                                <label>Cédula <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="{{ $user->cedula }}" name="cedula">
                           </div>

                            <div class="form-group col-12">
                                <label>Nombre <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="{{ $user->name }}" name="name">
                                </div>

                                <div class="form-group col-12">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="email" readonly class="form-control" value="{{ $user->email }}" name="email">
                                </div>

                                <div class="form-group col-6">
                                    <label>Teléfono <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="{{ $user->phone }}" name="phone">
                                </div>
                                <div class="form-group col-6">
                                    <label>Ciudad <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="{{ $user->city }}" name="city">
                                </div>

                                <div class="form-group col-12">
                                    <label>Dirección <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="{{ $user->address }}" name="address">
                                </div>
                                <div class="form-group col-6">
                                    <label>Nacimiento <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="{{ $user->born }}" name="born">
                                </div>
                                <div class="form-group col-6 option-item">
                                    <label for="">Género <span>*</span></label>
                                    <select class="form-control" name="gender">
                                        <option value="">Seleccione género</option>
                                        <option {{ trans('Masculino') == $user->gender ? 'selected' : '' }} value="Masculino">Masculino</option>
                                        <option {{ trans('Femenino') == $user->gender ? 'selected' : '' }} value="Femenino">Femenino</option>
                                        <option {{ trans('Otros') == $user->gender ? 'selected' : '' }} value="Otros">Otros</option>
                                    </select>
                                </div>
                           
                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
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

