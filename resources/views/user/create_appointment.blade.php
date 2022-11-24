@extends('layout')

@section('title')
<title>Crear Cita</title>
@endsection

@section('meta')
<meta name="description" content="Crear Cita">
@endsection

@section('public-content')

<!--Banner Start-->
<div class="banner-area flex" style="background-image: url({{ asset('/uploads/website-images/banner-user.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>Crear Cita</h1>
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
                    <h2 class="d-headline">Crear Cita</h2>

                    <form action="{{ route('user.appointment.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-12">
                                <label for="">Doctor</label>
                                <select name="doctor" id="doctor_id" class="form-control" required>
                                    <option value="">Seleccione</option>
                                    @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->name }} - {{ $doctor->phone }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-12">
                                <label for="">Días</label>
                                <select name="day" id="day_id" class="form-control" required>
                                    <option value="">Seleccione</option>
                                    @foreach($days as $day)
                                    <option value="{{ $day->id }}">{{ $day->custom_day }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-12">
                                <label for="">Especialidad</label>
                                <select disabled name="chamber" id="chamber_id" class="form-control" required>
                                    <option value="">Seleccione</option>
                                </select>
                            </div>

                            <div class="form-group col-12">
                                <label for="">Fecha</label>
                                <input disabled type="text" name="date" id="date" class="form-control datepicker2" autocomplete="off">
                            </div>

                            <div class="form-group col-12">
                                <label for="">Horario</label>
                                <select disabled name="schedule" id="schedule" class="form-control">
                                    <option value="">Seleccione</option>
                                </select>
                            </div>

                            <div class="form-group col-12">
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
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary" id="submitBtn">Guardar</button>
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
                        url: "{{ route('user.get-chambers') }}",
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
                    url: "{{ route('user.get-schedule') }}",
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
                    url: "{{ route('user.schedule-avaibility') }}",
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