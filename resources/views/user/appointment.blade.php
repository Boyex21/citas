@extends('layout')

@section('title')
<title>Historial de Citas</title>
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
                    <h1>Historial de Citas</h1>
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
                    <h2 class="d-headline">Historial de Citas</h2>

                    <a href="{{ route('user.appointment.create') }}" class="btn btn-primary mb-3">Crear Cita</a>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Doctor</th>
                                    <th>Consultorio</th>
                                    <th>Fecha</th>
                                    <th>Horario</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($appointments as $appointment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $appointment->doctor->name }}</td>
                                    <td>{{ $appointment->chamber->name }}</td>
                                    <td>{{ $appointment->date }}</td>
                                    <td>{{ date('h:i A', strtotime($appointment->schedule->start_time)).' - '.date('h:i A', strtotime($appointment->schedule->end_time)) }}</td>
                                    <td>
                                        @if ($appointment->already_treated==1)
                                        <span class="badge badge-success">Tratado</span>
                                        @else
                                        <span class="badge bg-danger">Pendiente</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($appointment->already_treated==1)
                                        <a href="{{ route('user.show-appointment', $appointment->id) }}" class="btn btn-success btn-sm"> <i class="fa fa-eye" aria-hidden="true"></i></a>
                                        @else
                                        <a href="javascript:void(0);" class="btn btn-success btn-sm" disabled> <i class="fa fa-eye" aria-hidden="true"></i></a>
                                        @endif
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $appointments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<!--Dashboard End-->

@endsection

