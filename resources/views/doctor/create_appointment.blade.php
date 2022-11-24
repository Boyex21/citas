@extends('doctor.layout')

@section('title')
<title>Crear Cita</title>
@endsection

@section('doctor-content')

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Crear Cita</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
          <a href="{{ route('doctor.dashboard') }}">Panel Administrativo</a>
        </div>
        <div class="breadcrumb-item active">
          <a href="{{ route('doctor.appointment') }}">Citas</a>
        </div>
        <div class="breadcrumb-item">Crear Cita</div>
      </div>
    </div>

    <div class="section-body">
      <a href="javascript:;" data-toggle="modal" data-target="#createPatient" class="btn btn-primary"><i class="fas fa-plus"></i> Nuevo Paciente</a>
      
      <div class="row mt-4">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <form action="{{ route('doctor.store-appointment') }}" method="POST">
                @csrf
                <div class="form-group">
                  <label for="">Paciente</label>
                  <select name="patient" id="patient_id" class="form-control select2" required>
                    <option value="">Seleccione</option>
                    @foreach($patients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->name }} - {{ $patient->phone }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="form-group">
                  <label for="">Días</label>
                  <select name="day" id="day_id" class="form-control" required>
                    <option value="">Seleccione</option>
                    @foreach($days as $day)
                    <option value="{{ $day->id }}">{{ $day->custom_day }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="form-group">
                  <label for="">Consultorio</label>
                  <select disabled name="chamber" id="chamber_id" class="form-control" required>
                    <option value="">Seleccione</option>
                    @foreach($chambers as $chamber)
                    <option value="{{ $chamber->id }}">{{ $chamber->name }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="form-group">
                  <label for="">Fecha</label>
                  <input disabled type="text" name="date" id="date" class="form-control datepicker2" autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="">Horario</label>
                  <select disabled name="schedule" id="schedule" class="form-control">
                    <option value="">Seleccione</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="">Tipo de Consulta</label>
                  <div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input checked type="radio" id="customRadioInline1" name="consultation_type" class="custom-control-input" value="0">
                      <label class="custom-control-label" for="customRadioInline1">Presencial</label>
                    </div>

                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="customRadioInline2" name="consultation_type" class="custom-control-input" value="1">
                      <label class="custom-control-label" for="customRadioInline2">Virtual</label>
                    </div>
                  </div>
                </div>

                <button class="btn btn-primary" id="submitBtn" type="submit" disabled>Guardar</button>
              </form>
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
          <form id="newPatientForm" method="POST">
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

<script>
  (function($) {
    "use strict";
    $(document).ready(function () {

      $("#patient_id").on("change", function(){
        var patientId=$(this).val();
        if(!patientId){
          $("#chamber_id").val('');
          $("#chamber_id").prop('disabled', true);
          $("#date").val('');
          $("#date").prop('disabled', true);
          var scheduleHtml="<option>Seleccione</option>";
          $("#schedule").html(scheduleHtml);
          $("#schedule").prop("disabled", true);
        }else{
          $("#chamber_id").prop('disabled', false);
        }
      });

      $("#chamber_id").on("change", function(){
        var chamberId=$(this).val();
        if(!chamberId){
          $("#date").val('');
          $("#date").prop('disabled', true);
          var scheduleHtml="<option>Seleccione</option>";
          $("#schedule").html(scheduleHtml);
          $("#schedule").prop("disabled", true);
          $("#submitBtn").prop("disabled", true);
        }else{
          $("#date").prop('disabled', false);
          $("#date").val('');
          var scheduleHtml="<option>Seleccione</option>";
          $("#schedule").html(scheduleHtml);
          $("#schedule").prop("disabled", true);
          $("#submitBtn").prop("disabled", true);
        }
      });

      $("#date").on("change", function(){
        var appDate=$(this).val();
        var chamberId=$("#chamber_id").val();
        var dayId=$("#day_id").val();
        if(!appDate){
          $("#schedule").prop("disabled", true);
        }else{
          $("#schedule").prop("disabled", false);
        }
        $.ajax({
          type: 'GET',
          url: "{{ route('doctor.get-schedule') }}",
          data: {date: appDate, chamber: chamberId, day: dayId},
          success: function (response) {
            if(response.status==1){
              $("#schedule").html(response.schedules)
              $("#submitBtn").prop("disabled", true);
              $("#schedule").prop("disabled", false);

              if(response.scheduleQty==0){
                toastr.error("Horario No Encontrado");
              }
            }

            if(response.status == 0){
              toastr.error(response.message);
              $("#submitBtn").prop("disabled", true);
            }
          },
          error: function(err) {
            console.log(err);
            $("#submitBtn").prop("disabled", true);
          }
        });
      });

      $("#schedule").on("change", function(){
        var schedule=$(this).val();
        var appDate=$("#date").val();
        $.ajax({
          type: 'GET',
          url: "{{ route('doctor.schedule-avaibility') }}",
          data: {date : appDate, schedule: schedule},
          success: function (response) {
            if(response.status==1){
              $("#submitBtn").prop("disabled", false);
            }
            if(response.status==0){
              toastr.error(response.message);
              $("#submitBtn").prop("disabled", true);
            }
          },
          error: function(err) {
            console.log(err);
            $("#submitBtn").prop("disabled", true);
          }
        });
      });

      $("#newPatientForm").on("submit", function(e){
        e.preventDefault();

        $.ajax({
          url: "{{ route('doctor.new-patient') }}",
          type:"post",
          data:$('#newPatientForm').serialize(),
          success:function(response){
            if(response.status==1){
              $("#patient_id").html(response.patients)
              $("#newPatientForm").trigger("reset");
              toastr.success("Registro Exitoso");
              $("#createPatient").modal('hide');
            }
          },
          error:function(response){
            if(response.responseJSON.errors.name){
              toastr.error(response.responseJSON.errors.name[0]);
            }
            if(response.responseJSON.errors.email){
              toastr.error(response.responseJSON.errors.email[0]);
            }
            if(response.responseJSON.errors.phone){
              toastr.error(response.responseJSON.errors.phone[0]);
            }
            if(response.responseJSON.errors.age){
              toastr.error(response.responseJSON.errors.age[0]);
            }
            if(response.responseJSON.errors.weight){
              toastr.error(response.responseJSON.errors.weight[0]);
            }
            if(response.responseJSON.errors.gender){
              toastr.error(response.responseJSON.errors.gender[0]);
            }
          }
        });
      });
    });
  })(jQuery);
</script>

@endsection