@extends('layout')
@section('title')
    <title>{{__('user.Appointment')}}</title>
@endsection
@section('meta')
    <meta name="description" content="{{__('user.Appointment')}}">
@endsection

@section('public-content')


<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ asset($banner->image) }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{__('user.Appointment')}}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><span>{{__('user.Appointment')}}</span></li>
                    </ul>
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
                    <h2 class="d-headline">{{__('user.Appointment History')}}</h2>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{__('user.SN')}}</th>
                                    <th>{{__('user.Doctor')}}</th>
                                    <th>{{__('user.Chamber')}}</th>
                                    <th>{{__('user.Date')}}</th>
                                    <th>{{__('user.Schedule')}}</th>
                                    <th>{{__('user.Status')}}</th>
                                    <th>{{__('user.Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($appointments as $index => $appointment)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $appointment->doctor->name }}</td>
                                        <td>{{ $appointment->chamber->name }}</td>
                                        <td>{{ $appointment->date }}</td>
                                        <td>{{ date('h:i A', strtotime($appointment->schedule->start_time)) }} - {{ date('h:i A', strtotime($appointment->schedule->end_time)) }}</td>
                                        <td>
                                            @if ($appointment->already_treated == 1)
                                                <span class="badge badge-success">{{__('user.Treated')}}</span>
                                            @else
                                            <span class="badge bg-danger">{{__('user.Pending')}}</span>
                                            @endif
                                        <td>
                                            @if ($appointment->already_treated == 1)
                                            <a href="{{ route('user.show-appointment', $appointment->id) }}" class="btn btn-success btn-sm"> <i class="fa fa-eye" aria-hidden="true"></i></a>
                                            @else
                                            <a href="javascript:;" class="btn btn-success btn-sm" disabled> <i class="fa fa-eye" aria-hidden="true"></i></a>
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

