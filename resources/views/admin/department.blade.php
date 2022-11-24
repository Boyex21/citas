@extends('admin.master_layout')

@section('title')
<title>Departamentos</title>
@endsection

@section('admin-content')

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Departamentos</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
          <a href="{{ route('admin.dashboard') }}">Panel Administrativo</a>
        </div>
        <div class="breadcrumb-item">Departamentos</div>
      </div>
    </div>

    <div class="section-body">
      <a href="javascript:;" data-toggle="modal" data-target="#createFaqCategory" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar Nueva</a>

      <div class="row mt-4">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive table-invoice">
                <table class="table table-striped" id="dataTable">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nombre</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($departments as $department)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $department->name }}</td>
                      <td>
                        @if($department->status==1)
                        <a href="javascript:;" onclick="changeBlogCategoryStatus({{ $department->id }})">
                          <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger">
                        </a>
                        @else
                        <a href="javascript:;" onclick="changeBlogCategoryStatus({{ $department->id }})">
                          <input id="status_toggle" type="checkbox" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger">
                        </a>
                        @endif
                      </td>
                      <td>
                        <a href="javascript:;" data-toggle="modal" data-target="#editFaqCategory-{{ $department->id }}" class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>

                        @if($department->doctors->count()==0)
                        <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-sm" onclick="deleteData({{ $department->id }})"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        @else
                        <a href="javascript:;" data-toggle="modal" data-target="#canNotDeleteModal" class="btn btn-danger btn-sm" disabled><i class="fa fa-trash" aria-hidden="true"></i></a>
                        @endif
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Modal -->
<div class="modal fade" id="canNotDeleteModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">No puede eliminar este Departamento. Debido a que hay uno o más expertos se ha creado en este Departamento.</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="createFaqCategory" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Crear Departamento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <form action="{{ route('admin.department.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="form-group col-12">
                <label>Nombre<span class="text-danger">*</span></label>
                <input type="text" id="name" class="form-control"  name="name" value="{{ old('name') }}">
              </div>

              <div class="form-group col-12">
                <label>Estado<span class="text-danger">*</span></label>
                <select name="status" class="form-control">
                  <option value="1">Activo</option>
                  <option value="0">Inactivo</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <button class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@foreach($departments as $department)
<div class="modal fade" id="editFaqCategory-{{ $department->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar Departamento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <form action="{{ route('admin.department.update', $department->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
              <div class="form-group col-12">
                <label>Nombre<span class="text-danger">*</span></label>
                <input type="text" id="name" class="form-control"  name="name" value="{{ $department->name }}">
              </div>

              <div class="form-group col-12">
                <label>Estado<span class="text-danger">*</span></label>
                <select name="status" class="form-control">
                  <option {{ $department->status == 1 ? 'selected' : '' }} value="1">Activo</option>
                  <option {{ $department->status == 0 ? 'selected' : '' }} value="0">Inactivo</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <button class="btn btn-primary">Actualizar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endforeach

<script>
  function deleteData(id){
    $("#deleteForm").attr("action",'{{ url("admin/department/") }}'+"/"+id)
  }
  function changeBlogCategoryStatus(id){
    $.ajax({
      type:"put",
      data: { _token : '{{ csrf_token() }}' },
      url:"{{url('/admin/department-status/')}}"+"/"+id,
      success:function(response){
        toastr.success(response)
      },
      error:function(err){
        console.log(err);
      }
    });
  }
</script>

@endsection