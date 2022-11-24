@extends('layout')

@section('title')
<title>Documentos</title>
@endsection

@section('meta')
<meta name="description" content="Citas">
@endsection

@section('public-content')

<!--Banner Start-->
<div class="banner-area flex" style="background-image: url({{ asset('/uploads/website-images/banner-user.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>Documentos</h1>
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
                    <h2 class="d-headline">Documentos</h2>

                    <a href="{{ route('user.documents.create') }}" class="btn btn-primary mb-3">Agregar Documentos</a>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Doctor</th>
                                    <th>Cant. de Documentos</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documents as $document)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $document['doctor']->name }}</td>
                                    <td>{{ $document['files']->count() }}</td>
                                    <td>{{ $document->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <a href="{{ route('user.documents.show', $document->id) }}" class="btn btn-success btn-sm"> <i class="fa fa-eye" aria-hidden="true"></i></a>

                                        <a href="{{ route('user.documents.edit', $document->id) }}" class="btn btn-success btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>

                                        <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-sm" onclick="deleteData({{ $document->id }})"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $documents->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<!--Dashboard End-->

<script type="text/javascript">
    function deleteData(id){
        $("#deleteForm").attr("action",'{{ url("user/documents/") }}'+"/"+id)
    }
</script>

@endsection