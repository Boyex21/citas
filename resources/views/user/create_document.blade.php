@extends('layout')

@section('title')
<title>Agregar Documentos</title>
@endsection

@section('meta')
<meta name="description" content="Agregar Documentos">
@endsection

@section('public-content')

<!--Banner Start-->
<div class="banner-area flex" style="background-image: url({{ asset('/uploads/website-images/banner-user.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>Agregar Documentos</h1>
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
                    <h2 class="d-headline">Agregar Documentos</h2>

                    <form action="{{ route('user.documents.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-12">
                                <label for="">Doctor<span class="text-danger">*</span></label>
                                <select name="doctor" id="doctor_id" class="form-control" required>
                                    <option value="">Seleccione</option>
                                    @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->name }} - {{ $doctor->phone }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-12">
                                <label for="">Descripción de los Archivos<span class="text-danger">*</span></label>
                                <textarea name="description" class="form-control text-area-5" id="" cols="30" rows="10">{{ old('description') }}</textarea>
                            </div>

                            <div class="form-group col-12">
                                <label class="col-form-label">Documentos<span class="text-danger">*</span></label>
                                <div id="documents-files" class="dm-uploader text-center bg-white py-4 px-2">
                                    <h3 class="text-muted">Arrastra aquí tus archivos</h3>
                                    <div class="btn btn-primary btn-block">
                                        <span>Selecciona un archivo</span>
                                        <input type="file" title="Selecciona un archivo" multiple>
                                    </div>
                                </div>
                                <p id="response" class="text-left py-0"></p>
                            </div>

                            <div class="col-12">
                                <div class="row" id="files"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
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

<script type="text/javascript">
    function deleteFileCreate(file){
        $("div[element="+file+"]").remove();
    }
</script>

@endsection