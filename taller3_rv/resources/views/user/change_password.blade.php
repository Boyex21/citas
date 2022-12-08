@extends('layout')
@section('title')
    <title>{{__('user.Dashboard')}}</title>
@endsection
@section('meta')
    <meta name="description" content="{{__('user.Dashboard')}}">
@endsection

@section('public-content')


<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ asset($banner->image) }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{__('user.Dashboard')}}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><span>{{__('user.Dashboard')}}</span></li>
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
                    <h2 class="d-headline">{{__('user.Change Password')}}</h2>

                    <form action="{{ route('user.update-password') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-12">
                                <label>{{__('user.Current Password')}} <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="current_password">
                            </div>

                            <div class="form-group col-12">
                                <label>{{__('user.New Password')}}</label>
                                <input type="password" class="form-control" name="password">
                            </div>

                            <div class="form-group col-12">
                                <label>{{__('user.Confirm Password')}} <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-primary">{{__('user.Update')}}</button>
                            </div>
                        </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<!--Dashboard End-->

@endsection

