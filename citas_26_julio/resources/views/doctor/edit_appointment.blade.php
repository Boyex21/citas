@extends('doctor.layout')

@section('title')
<title>Editar Cita</title>
@endsection

@section('doctor-content')

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Editar Cita</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('doctor.dashboard') }}">Panel Administrativo</a>
                </div>
                <div class="breadcrumb-item">Editar Cita</div>
            </div>
        </div>

        <div class="section-body">
            <div class="invoice">
                <div class="invoice-print">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                @php
                                $user=$appointment->user;
                                @endphp
                                <div class="col-md-6">
                                    <address>
                                        <strong>Información del Paciente:</strong><br>
                                        {{ $user->name }}<br>
                                        @if ($user->email)
                                        {{ $user->email }}<br>
                                        @endif
                                        @if ($user->phone)
                                        {{ $user->phone }}<br>
                                        @endif
                                        Edad: {{ $user->age }}<br>
                                        Peso: {{ $user->weight }}<br>
                                    </address>
                                </div>

                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>Información de la Cita:</strong><br>
                                        Consultorio: {{ $appointment->chamber->name }}<br>
                                        Fecha: {{ date('d F, Y', strtotime($appointment->date)) }}<br>
                                        Horario: {{ date('h:i A', strtotime($appointment->schedule->start_time)) }} - {{ date('h:i A', strtotime($appointment->schedule->end_time)) }} <br>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="hiddenPrescribeRow" class="vh d-none">
            <div id="delete-prescribe-row">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Medicina</label>
                            <select name="medicines[]" id="medicine_hidden_id" class="form-control">
                                <option value="">Seleccione</option>
                                @foreach ($medicines as $medicine)
                                <option value="{{ $medicine->name }}">{{ $medicine->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Dosis</label>
                            <select name="dosages[]" id="" class="form-control">
                                <option value="0-0-0">0-0-0</option>
                                <option value="0-0-1">0-0-1</option>
                                <option value="0-1-0">0-1-0</option>
                                <option value="0-1-1">0-1-1</option>
                                <option value="1-0-0">1-0-0</option>
                                <option value="1-0-1">1-0-1</option>
                                <option value="1-1-0">1-1-0</option>
                                <option value="1-1-1">1-1-1</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Día</label>
                            <select name="days[]" id="" class="form-control">
                                @for($i=1;$i<=90;$i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2" >
                        <div class="form-group">
                            <label for="">Hora</label>
                            <select name="times[]" id="" class="form-control">
                                <option value="Despues de Comer">Despues de Comer</option>
                                <option value="Antes de Comer">Antes de Comer</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3" >
                        <div class="form-group">
                            <label for="">Comentario</label>
                            <input type="text" name="comments[]" class="form-control" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-1 add_btn" >
                        <button type="button" id="removePrescribeRow" class="btn btn-danger"><i class="fas fa-trash" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('doctor.update-prescription', $appointment->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="section-body">
                <div class="row mt-4">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <h4>Información Física</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Presión Sanguinea</label>
                                            <input type="text" class="form-control" name="blood_pressure" value="{{ $appointment->blood_pressure }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Frequencia de Pulso</label>
                                            <input type="text" class="form-control" name="pulse_rate" value="{{ $appointment->pulse_rate }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Temperatura</label>
                                            <input type="text" class="form-control" name="temperature" value="{{ $appointment->temperature }}">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Descripción del Problema</label>
                                            <textarea name="problem_description" class="form-control text-area-3" id="" cols="30" rows="10">{{ $appointment->problem_description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-body">
                <div class="row mt-4">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <button type="button" data-toggle="modal" data-target="#createMedicine" class="btn btn-primary float-end"><i class="fa fa-plus" aria-hidden="true"></i> Nueva Medicina</button>
                            </div>

                            <div class="card-body" id="medicineRow">
                                @foreach ($appointment->prescribes as $prescribe)
                                <div class="row old-prescribe-{{ $prescribe->id }}">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Medicina</label>
                                            <select name="medicines[]" id="medicine_id" class="form-control">
                                                <option value="">Seleccione</option>
                                                @foreach($medicines as $medicine)
                                                <option {{ $medicine->name == $prescribe->medicine_name ? 'selected' : '' }} value="{{ $medicine->name }}">{{ $medicine->name }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Dosis</label>
                                            <select name="dosages[]" id="" class="form-control">
                                                <option {{ $prescribe->dosage=='0-0-0' ? 'selected':'' }} value="0-0-0">0-0-0</option>
                                                <option {{ $prescribe->dosage=='0-0-1' ? 'selected':'' }} value="0-0-1">0-0-1</option>
                                                <option {{ $prescribe->dosage=='0-1-0' ? 'selected':'' }} value="0-1-0">0-1-0</option>
                                                <option {{ $prescribe->dosage=='0-1-1' ? 'selected':'' }} value="0-1-1">0-1-1</option>
                                                <option {{ $prescribe->dosage=='1-0-0' ? 'selected':'' }} value="1-0-0">1-0-0</option>
                                                <option {{ $prescribe->dosage=='1-0-1' ? 'selected':'' }} value="1-0-1">1-0-1</option>
                                                <option {{ $prescribe->dosage=='1-1-0' ? 'selected':'' }} value="1-1-0">1-1-0</option>
                                                <option {{ $prescribe->dosage=='1-1-1' ? 'selected':'' }} value="1-1-1">1-1-1</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Día</label>
                                            <select name="days[]" id="" class="form-control">
                                                @for($i=1;$i<=90;$i++)
                                                <option {{ $prescribe->number_of_day==$i ? 'selected' :'' }} value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2" >
                                        <div class="form-group">
                                            <label for="">Hora</label>
                                            <select name="times[]" id="" class="form-control">
                                                <option {{ $prescribe->time=='Despues de Comer' ? "selected" : "" }} value="Despues de Comer">Despues de Comer</option>
                                                <option {{ $prescribe->time=='Antes de Comer' ? "selected" : "" }} value="Antes de Comer">Antes de Comer</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3" >
                                        <div class="form-group">
                                            <label for="">Comentarios</label>
                                            <input value="{{ $prescribe->comment }}" type="text" name="comments[]" class="form-control" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-1 add_btn" >
                                        <button onclick="oldPrescribeDelete({{ $prescribe->id }})" type="button" class="btn btn-danger"><i class="fas fa-trash" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                                @endforeach

                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Medicina</label>
                                            <select name="medicines[]" id="medicine_id" class="form-control">
                                                <option value="">Seleccione</option>
                                                @foreach ($medicines as $medicine)
                                                <option value="{{ $medicine->name }}">{{ $medicine->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Dosis</label>
                                            <select name="dosages[]" id="" class="form-control">
                                                <option value="0-0-0">0-0-0</option>
                                                <option value="0-0-1">0-0-1</option>
                                                <option value="0-1-0">0-1-0</option>
                                                <option value="0-1-1">0-1-1</option>
                                                <option value="1-0-0">1-0-0</option>
                                                <option value="1-0-1">1-0-1</option>
                                                <option value="1-1-0">1-1-0</option>
                                                <option value="1-1-1">1-1-1</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Día</label>
                                            <select name="days[]" id="" class="form-control">
                                                @for($i=1;$i<=90;$i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2" >
                                        <div class="form-group">
                                            <label for="">Hora</label>
                                            <select name="times[]" id="" class="form-control">
                                                <option value="Despues de Comer">Despues de Comer</option>
                                                <option value="Antes de Comer">Antes de Comer</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3" >
                                        <div class="form-group">
                                            <label for="">Comentarios</label>
                                            <input type="text" name="comments[]" class="form-control" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-1 add_btn" >
                                        <button id="addMedicineRow" type="button" class="btn btn-primary"><i class="fas fa-plus" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-body">
                <div class="row mt-4">
                    <div class="col">
                        <div class="card">
                            <div class="card-body" id="medicineRow">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="">Examenes</label>
                                            <textarea name="test" class="form-control text-area-5" id="" cols="30" rows="10">{{ $appointment->test }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="">Consejos</label>
                                            <textarea name="advice" class="form-control text-area-5" id="" cols="30" rows="10">{{ $appointment->advice }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="">Siguiente Visita</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <select class="custom-select" id="inputGroupSelect01" name="next_visit_qty">
                                                        <option value="">Seleccione</option>
                                                        @for($i=1; $i<=31 ;$i++)
                                                        <option {{ $appointment->next_visit_qty==$i ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>

                                                <select class="custom-select" id="inputGroupSelect01" name="next_visit_time">
                                                    <option value="">Seleccione</option>
                                                    <option {{ $appointment->next_visit_time=='Días' ? 'selected' : '' }} value="Días">Días</option>
                                                    <option {{ $appointment->next_visit_time=='Meses' ? 'selected' : '' }} value="Meses">Meses</option>
                                                    <option {{ $appointment->next_visit_time=='Años' ? 'selected' : '' }} value="Años">Años</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Actualizar</button>
                                        <a href="{{ route('doctor.show-prescription', $appointment->id) }}" type="button" class="btn btn-success"><i class="fa fa-eye" aria-hidden="true"></i> Ver</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>

<!-- Modal -->
<div class="modal fade" id="createMedicine" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva Medicina</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form id="modalMedicineFrom">
                        @csrf
                        <div class="form-group col-12">
                            <label>Nombre<span class="text-danger">*</span></label>
                            <input type="text" id="name" class="form-control"  name="name" value="{{ old('name') }}">
                        </div>
                        <button class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    (function($) {
        "use strict";
        $(document).ready(function() {
            // add new prescribe medicine input field
            $("#addMedicineRow").on('click',function () {
                var html=$("#hiddenPrescribeRow").html();
                $("#medicineRow").append(html)
                // $('.select2').select2();
            });

            // remove prescribe medicine input field row
            $(document).on('click', '#removePrescribeRow', function () {
                $(this).closest('#delete-prescribe-row').remove();
            });

            $("#modalMedicineFrom").on('submit', function(e){
                e.preventDefault();

                $.ajax({
                    url: "{{ route('doctor.medicne-store') }}",
                    type:"post",
                    data:$('#modalMedicineFrom').serialize(),
                    success:function(response){
                        if(response.status==1){
                            $("#medicine_id").html(response.medicines);
                            $("#medicine_hidden_id").html(response.medicines);
                            $("#modalMedicineFrom").trigger("reset");
                            toastr.success("Registro Exitoso");
                            $("#createMedicine").modal('hide');
                        }
                    },
                    error:function(response){
                        if(response.responseJSON.errors.name){
                            toastr.error(response.responseJSON.errors.name[0]);
                        }
                    }
                });
            });
        });
    })(jQuery);

    function oldPrescribeDelete(id){
        $.ajax({
            type: 'GET',
            url: "{{ url('doctor/delete-appointment-prescribe/') }}"+"/"+ id,
            success: function (response) {
                var old_prescirbe_row="old-prescribe-"+id;
                $("."+old_prescirbe_row).remove();
                toastr.success(response.success);
            },
            error: function(err) {
                console.log(err);
            }
        });
    }
</script>

@endsection