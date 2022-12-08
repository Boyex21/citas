@extends('layout')
@section('title')
    <title>{{__('user.Upcoming Meeting')}}</title>
@endsection
@section('meta')
    <meta name="description" content="{{__('user.Upcoming Meeting')}}">
@endsection

@section('public-content')


<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ asset($banner->image) }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{__('user.Upcoming Meeting')}}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><span>{{__('user.Upcoming Meeting')}}</span></li>
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
                    <h2 class="d-headline">{{__('user.Upcoming Meeting')}}</h2>
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th>{{__('user.SN')}}</th>
                                    <th>{{__('user.Doctor')}}</th>
                                    <th>{{__('user.Time')}}</th>
                                    <th>{{__('user.Duration')}}</th>
                                    <th>{{__('user.Meeting Id')}}</th>
                                    <th>{{__('user.Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i=0;
                                @endphp
                                @foreach ($histories as $index => $meeting)
                                    @php
                                            $now=date('Y-m-d h:i:A');
                                    @endphp
                                    @if ($now <= date('Y-m-d h:i:A',strtotime($meeting->meeting_time)))
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $meeting->doctor->name }}</td>
                                            <td>
                                                {{ date('Y-m-d h:i:A',strtotime($meeting->meeting_time)) }}
                                            </td>
                                            <td>{{ $meeting->duration }} {{__('user.Minutes')}}</td>
                                            <td>{{ $meeting->meeting_id }}</td>
                                            </td>
                                            <td>
                                                @if (env('APP_VERSION') == 0)
                                                    <a id="zoom_demo_mode" href="javascript:;"  class="btn btn-success btn-sm"><i class="fas fa-video"></i></a>
                                                @else
                                                <a target="_blank" href="{{ $meeting->meeting->join_url }}" class="btn btn-success btn-sm"><i class="fas fa-video"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $histories->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<!--Dashboard End-->

@endsection


