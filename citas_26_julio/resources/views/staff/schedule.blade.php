@extends('staff.layout')

@section('title')
<title>Horarios</title>
@endsection

@section('staff-content')

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Horarios</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('staff.dashboard') }}">Panel Administrativo</a>
                </div>
                <div class="breadcrumb-item">Horarios</div>
            </div>
        </div>

        <div class="section-body">
            <a href="{{ route('staff.schedule.create') }}"  class="btn btn-primary"><i class="fas fa-plus"></i> Agregar Nuevo</a>

            <div class="row mt-4">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive table-invoice">
                                <table class="table table-striped" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Día</th>
                                            <th>Consultorio</th>
                                            <th>Hora de Inicio</th>
                                            <th>Hora Final</th>
                                            <th>Limite</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($schedules as $schedule)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $schedule->day->custom_day }}</td>
                                            <td>{{ $schedule->chamber->name }}</td>
                                            <td>{{ date('h:i A', strtotime($schedule->start_time)) }}</td>
                                            <td>{{ date('h:i A', strtotime($schedule->end_time)) }}</td>
                                            <td>{{ $schedule->appointment_limit }}</td>
                                            <td>
                                                @if($schedule->status==1)
                                                <a href="javascript:;" onclick="changeFeatureStatus({{ $schedule->id }})">
                                                    <input id="status_toggle" type="checkbox" checked data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger">
                                                </a>
                                                @else
                                                <a href="javascript:;" onclick="changeFeatureStatus({{ $schedule->id }})">
                                                    <input id="status_toggle" type="checkbox" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger">
                                                </a>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('staff.schedule.edit', $schedule->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>

                                                @if ($schedule->appointments->count()==0)
                                                <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-sm" onclick="deleteData({{ $schedule->id }})"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
            <div class="modal-body">No puede eliminar este horario. Porque se han creado una o más citas en este horario.</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteData(id){
        $("#deleteForm").attr("action",'{{ url("staff/schedule/") }}'+"/"+id)
    }
    function changeFeatureStatus(id){
        $.ajax({
            type:"put",
            data: { _token : '{{ csrf_token() }}' },
            url:"{{url('/staff/schedule-status/')}}"+"/"+id,
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