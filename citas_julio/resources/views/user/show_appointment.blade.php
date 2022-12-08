@extends('layout')

@section('title')
<title>Cita</title>
@endsection

@section('meta')
<meta name="description" content="Cita">
@endsection

@section('public-content')

<!--Banner Start-->
<div class="banner-area flex" style="background-image: url({{ asset('/uploads/website-images/banner-user.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>Cita</h1>
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
                    <div class="prescription">
                        <div class="top">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="logo"><img src="{{ url($setting->logo) }}" alt=""></div>
                                    <div class="address">
                                        {{ $appointment->chamber->name }}
                                        {!! clean(nl2br(e($appointment->chamber->address))) !!}
                                    </div>
                                    <div class="phone">
                                        {!! clean(nl2br(e($appointment->chamber->contact))) !!}
                                    </div>
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
                                @if ($appointment->problem_description || $appointment->test)
                                <div class="col-md-3">
                                    @if ($appointment->problem_description)
                                    <div class="problem">
                                        <h2>Problema</h2>
                                        <p>{!! clean(nl2br(e($appointment->problem_description))) !!}</p>
                                    </div>
                                    @endif

                                    @if ($appointment->test)
                                    <div class="test">
                                        <h2>Prueba</h2>
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
                                                @foreach ($appointment->prescribes as $prescribe)
                                                <li>
                                                    <div class="full">
                                                        <div class="l">
                                                            {{ $prescribe->medicine_name }} <br> {{ $prescribe->dosage }} ({{ $prescribe->time }})
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
                                        @if ($appointment->advice)
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

                        @if ($appointment->next_visit_qty && $appointment->next_visit_time)
                        <h6 class="text-center">Siguiente Visita: {{ $appointment->next_visit_qty }} {{ $appointment->next_visit_time }} Despues</h6>
                        @endif
                    </div>

                    <button class="btn btn-primary mt-3 print-btn" onclick="window.print()"><i class="fas fa-print" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Dashboard End-->

@endsection

