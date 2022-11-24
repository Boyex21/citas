@extends('admin.master_layout')

@section('title')
<title>Crear Cita</title>
@endsection

@section('admin-content')

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Crear Cita</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">
          <a href="{{ route('admin.dashboard') }}">Panel Administrativo</a>
        </div>
        <div class="breadcrumb-item active">
          <a href="{{ route('admin.appointment') }}">Citas</a>
        </div>
        <div class="breadcrumb-item">Crear Cita</div>
      </div>
    </div>

    <div class="section-body">
      <div class="row mt-4">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <form action="{{ route('admin.store-appointment') }}" method="POST">
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
                  <label for="">Doctor</label>
                  <select name="doctor" id="doctor_id" class="form-control select2" required>
                    <option value="">Seleccione</option>
                    @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}">{{ $doctor->name }} - {{ $doctor->phone }}</option>
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

<script>
  (function($) {
    "use strict";
    $(document).ready(function () {
      $("#doctor_id").on("change", function(){
        var doctorId=$(this).val();
        if(!doctorId){
          $("#chamber_id").val('');
          $("#chamber_id").prop('disabled', true);
          $("#date").val('');
          $("#date").prop('disabled', true);
          var scheduleHtml="<option>Seleccione</option>";
          $("#schedule").html(scheduleHtml);
          $("#schedule").prop("disabled", true);
        }else{
          $.ajax({
            type: 'GET',
            url: "{{ route('admin.get-chambers') }}",
            data: {doctor: doctorId},
            success: function (response) {
              if(response.status==1){
                $("#chamber_id").html(response.chambers);
                $("#submitBtn").prop("disabled", true);
                $("#chamber_id").prop('disabled', false);
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
        var doctorId=$("#doctor_id").val();
        if(!appDate){
          $("#schedule").prop("disabled", true);
        }else{
          $("#schedule").prop("disabled", false);
        }
        $.ajax({
          type: 'GET',
          url: "{{ route('admin.get-schedule') }}",
          data: {date: appDate, chamber: chamberId, day: dayId, doctor: doctorId},
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
        var doctorId=$("#doctor_id").val();
        $.ajax({
          type: 'GET',
          url: "{{ route('admin.schedule-avaibility') }}",
          data: {date : appDate, schedule: schedule, doctor: doctorId},
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
    });
  })(jQuery);
</script>

@endsection