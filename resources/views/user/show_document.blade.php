@extends('layout')

@section('title')
<title>Documento</title>
@endsection

@section('meta')
<meta name="description" content="Documento">
@endsection

@section('public-content')

<!--Banner Start-->
<div class="banner-area flex" style="background-image: url({{ asset('/uploads/website-images/banner-user.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>Documento</h1>
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
                    <div class="row">
                        <div class="col-12">
                            <div>Doctor: {{ $document->doctor->name }}</div>
                        </div>

                        <div class="col-12">
                            <div>Descripión de los Archivos: {{ $document->description }}</div>
                        </div>

                        <div class="col-12">
                            <h4>Documentos</h4>
                            <ol class="ml-3">
                                @foreach($document['files'] as $file)
                                <li>
                                    <a href="{{ asset('uploads/documents/'.$file->file) }}" download>{{ $file->file }}</a>
                                    <a href="{{ asset('uploads/documents/'.$file->file) }}" download class="btn btn-sm btn-primary ml-2">Descargar</a>
                                </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Dashboard End-->

@endsection