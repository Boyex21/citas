@extends('layout')

@section('title')
<title>Editar Documentos</title>
@endsection

@section('meta')
<meta name="description" content="Editar Documentos">
@endsection

@section('public-content')

<!--Banner Start-->
<div class="banner-area flex" style="background-image: url({{ asset('/uploads/website-images/banner-user.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>Editar Documentos</h1>
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
                    <h2 class="d-headline">Editar Documentos</h2>

                    <form action="{{ route('user.documents.update', $document->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="form-group col-12">
                                <label for="">Doctor<span class="text-danger">*</span></label>
                                <select name="doctor" id="doctor_id" class="form-control" required>
                                    <option value="">Seleccione</option>
                                    @foreach($doctors as $doctor)
                                    <option {{ $document->doctor_id==$doctor->id ? 'selected' : '' }} value="{{ $doctor->id }}">{{ $doctor->name }} - {{ $doctor->phone }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-12">
                                <label for="">Descripción de los Archivos<span class="text-danger">*</span></label>
                                <textarea name="description" class="form-control text-area-5" id="" cols="30" rows="10">{{ $document->description }}</textarea>
                            </div>

                            <div class="form-group col-12">
                                <label class="col-form-label">Documentos<span class="text-danger">*</span></label>
                                <div id="document-files-edit" class="dm-uploader text-center bg-white py-4 px-2">
                                    <h3 class="text-muted">Arrastra aquí tus archivos</h3>
                                    <div class="btn btn-primary btn-block">
                                        <span>Selecciona un archivo</span>
                                        <input type="file" title="Selecciona un archivo" multiple>
                                    </div>
                                </div>
                                <p id="response" class="text-left py-0"></p>
                            </div>

                            <div class="col-12">
                                <div class="row" id="files">
                                    @foreach($document['files'] as $file)
                                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-12" element="{{ $loop->iteration }}">
                                        <div class="card">
                                            <div class="card-body p-2">
                                                <i class="fa fa-2x fa-file mb-2"></i>
                                                <p class="text-truncate mb-0">{{ $file->file }}</p>
                                            </div>

                                            <button type="button" class="btn btn-danger btn-absolute-right removeFile" file="{{ $loop->iteration }}" urlFile="{{ asset('/uploads/documents/'.$file->file) }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <input type="hidden" id="id" value="{{ $document->id }}">
                        </div>
                        <div class="row">
                            <div class="col-12">
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

<script type="text/javascript">
    // Function to delete files
    $('.removeFile').click(function(event) {
        removeFile($(this), event);
    });

    function removeFile(element, event) {
        var file=element.attr('file'), id=$('#id').val(), urlFile=event.currentTarget.attributes[3].value;
        urlFile=urlFile.split('/');
        if (id!="") {
            $.ajax({
                url: '/user/documents/files/destroy',
                type: 'POST',
                dataType: 'json',
                data: {id: id, url: urlFile[5]},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .done(function(obj) {
                if (obj.status) {
                    $("div[element='"+file+"']").remove();
                    Lobibox.notify('success', {
                        title: 'Eliminación Exitosa',
                        sound: true,
                        msg: 'El archivo ha sido eliminado exitosamente.'
                    });
                } else {
                    Lobibox.notify('error', {
                        title: 'Eliminación Fallida',
                        sound: true,
                        msg: 'Ha ocurrido un problema, intentelo nuevamente.'
                    });
                }
            })
            .fail(function() {
                errorNotification();
            });
        }
    }
</script>

@endsection