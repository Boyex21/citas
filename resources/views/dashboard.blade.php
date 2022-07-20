@extends('user.layout')
@section('title')
    <title>{{__('user.Dashboard')}}</title>
@endsection
@section('meta')
    <meta name="description" content="{{__('Dashboard')}}">
@endsection

@section('public-content')

<!--Banner Start-->
<div class="banner-area flex" style="background-image:url('uploads/website-images/login-page-banner.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>Dashboard</h1>
                <!--    <ul>
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><span>Usuario</span></li>
                    </ul>
                    -->
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
                @include('sidebar')
            </div>
            <div class="col-lg-9">
                <div class="detail-dashboard">
                    <div class="row">
                        <div class="col-lg-4 col-sm-6">
                            <div class="dash-item db-green flex mb_30">
                                <i class="fas fa-handshake"></i>
                                <h4>Citas Totales</h4>
                                <h2>100</h2>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="dash-item db-red flex mb_30">
                                <i class="fas fa-hourglass-start"></i>
                                <h4>Citas Completadas</h4>
                                <h2>80</h2>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="dash-item db-blue flex mb_30">
                                <i class="fas fa-check-circle"></i>
                                <h4>Citas Pendientes</h4>
                                <h2>20</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Dashboard End-->

@endsection
