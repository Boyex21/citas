@extends('admin.master_layout')

@section('title')
<title>Pacientes</title>
@endsection

@section('admin-content')

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Pacientes</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
          <a href="{{ route('admin.dashboard') }}">Panel Administrativo</a>
        </div>
        <div class="breadcrumb-item">Pacientes</div>
      </div>
    </div>

    <div class="section-body">
      <a href="javascript:;" data-toggle="modal" data-target="#createPatient" class="btn btn-primary"><i class="fas fa-plus"></i> Nuevo Paciente</a>

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
                      <th>Email</th>
                      <th>Imagen</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($customers as $customer)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $customer->name }}</td>
                      <td>{{ $customer->email }}</td>
                      <td>
                        @if($customer->image)
                        <img src="{{ asset($customer->image) }}" class="rounded-circle" alt="" width="80px">
                        @endif
                      </td>
                      <td>
                        @if($customer->status==1)
                        <a href="javascript:;" onclick="manageCustomerStatus({{ $customer->id }})">
                          <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger">
                        </a>
                        @else
                        <a href="javascript:;" onclick="manageCustomerStatus({{ $customer->id }})">
                          <input id="status_toggle" type="checkbox" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger">
                        </a>
                        @endif
                      </td>
                      <td>
                        <a href="{{ route('admin.customer-show', $customer->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>

                        <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-sm" onclick="deleteData({{ $customer->id }})"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
<div class="modal fade" id="createPatient" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Crear Paciente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <form action="{{ route('admin.customer-create') }}" id="newPatientForm" method="POST">
            @csrf
            <div class="row">
              <div class="form-group col-12">
                <label>Nombre<span class="text-danger">*</span></label>
                <input type="text" id="name" class="form-control"  name="name" value="{{ old('name') }}">
              </div>

              <div class="form-group col-12">
                <label>Email<span class="text-danger">*</span></label>
                <input type="email" id="email" class="form-control"  name="email" value="{{ old('email') }}">
              </div>

              <div class="form-group col-12">
                <label>Teléfono<span class="text-danger">*</span></label>
                <input type="text" id="phone" class="form-control"  name="phone" value="{{ old('phone') }}">
              </div>

              <div class="form-group col-12">
                <label>Edad<span class="text-danger">*</span></label>
                <input type="text" id="age" class="form-control"  name="age" value="{{ old('age') }}">
              </div>

              <div class="form-group col-12">
                <label>Peso<span class="text-danger">*</span></label>
                <input type="text" id="weight" class="form-control"  name="weight" value="{{ old('weight') }}">
              </div>

              <div class="form-group col-12">
                <label>Género<span class="text-danger">*</span></label>
                <select name="gender" id="gender" class="form-control">
                  <option value="">Seleccione</option>
                  <option value="Masculino">Masculino</option>
                  <option value="Femenino">Femenino</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="canNotDeleteModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">No puede eliminar este cliente. Porque hay uno o más pedidos y se ha creado una cuenta de tienda en este cliente.</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
  function deleteData(id){
    $("#deleteForm").attr("action",'{{ url("admin/customer-delete/") }}'+"/"+id)
  }
  function manageCustomerStatus(id){
    $.ajax({
      type:"put",
      data: { _token : '{{ csrf_token() }}' },
      url:"{{url('/admin/customer-status/')}}"+"/"+id,
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