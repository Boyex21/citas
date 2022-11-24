@extends('doctor.layout')

@section('title')
<title>Prescripción</title>
@endsection

@section('doctor-content')

<style>
    @media print {
        .section-header,
        .order-status,
        #sidebar-wrapper,
        .print-area,
        .main-footer,
        .additional_info,
        .print_btn,
        .edit_btn {
            display:none!important;
        }
    }
</style>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Prescripción</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('doctor.dashboard') }}">Panel Administrativo</a>
                </div>
                <div class="breadcrumb-item">Prescripción</div>
            </div>
        </div>
        <div class="section-body">
            <button class="btn btn-primary print_btn"> <i class="fa fa-print" aria-hidden="true"></i> Imprimir</button>

            <a href="{{ route('doctor.edit-appointment', $appointment->id) }}" class="btn btn-success edit_btn"><i class="fas fa-edit"></i> Editar</a>

            <div class="row mt-4">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="prescription">
                                <div class="top">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="logo"><img src="{{ url($setting->logo) }}" alt=""></div>
                                            <div class="address">
                                                {{ $appointment->chamber->name }}
                                                {!! clean(nl2br(e($appointment->chamber->address))) !!}
                                            </div>
                                            <div class="phone">{!! clean(nl2br(e($appointment->chamber->contact))) !!}</div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="right">
                                                <h2>{{ $doctor->name }}</h2>
                                                <p>{{ $doctor->designation }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="patient-info">
                                    <div class="row">
                                        <div class="col-md-6">Nombre del Paciente: {{ $appointment->user->name }}</div>
                                        <div class="col-md-3">Edad: {{ $appointment->user->age }} Años</div>
                                        <div class="col-md-3 text-right">Fecha: {{ date('m-d-Y',strtotime($appointment->date)) }}</div>
                                    </div>
                                </div>

                                <div class="main-section">
                                    <div class="row">
                                        @if($appointment->problem_description || $appointment->test)
                                        <div class="col-md-3">
                                            @if($appointment->problem_description)
                                            <div class="problem">
                                                <h2>Problema</h2>
                                                <p>{!! clean(nl2br(e($appointment->problem_description))) !!}</p>
                                            </div>
                                            @endif

                                            @if ($appointment->test)
                                            <div class="test">
                                                <h2>Examenes</h2>
                                                <p>{!! clean(nl2br(e($appointment->test))) !!}</p>
                                            </div>
                                            @endif
                                        </div>
                                        @endif
                                        <div class="col-md-9">
                                            <div class="medicine">
                                                <div class="rx">R<span>x</span></div>
                                                <div class="list">
                                                    <ol>
                                                        @foreach($appointment->prescribes as $prescribe)
                                                        <li>
                                                            <div class="full">
                                                                <div class="l">
                                                                    {{ $prescribe->medicine_name }}<br>{{ $prescribe->dosage }} ({{ $prescribe->time }})
                                                                    @if ($prescribe->comment)
                                                                    <br>{{ $prescribe->comment }}
                                                                    @endif
                                                                </div>
                                                                <div class="r">{{ $prescribe->number_of_day }} Días</div>
                                                            </div>
                                                        </li>
                                                        @endforeach
                                                    </ol>
                                                </div>
                                                @if($appointment->advice)
                                                <div class="advice">
                                                    <h2>Consejo</h2>
                                                    <p>{!! clean(nl2br(e($appointment->advice))) !!}</p>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="footer">
                                    <h2>Firma</h2>
                                    <p>{{ $doctor->name }}<br>{{ $doctor->designation }}</p>
                                </div>

                                @if($appointment->next_visit_qty && $appointment->next_visit_time)
                                <h6 class="text-center">Siguiente Visita: {{ $appointment->next_visit_qty }} {{ $appointment->next_visit_time }} Despues</h6>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    (function($) {
        "use strict";
        $(document).ready(function() {
            $(".print_btn").on("click", function(){
                $(".custom_click").click();
                window.print();
            });
        });
    })(jQuery);
</script>

@endsection