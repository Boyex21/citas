@extends('layout')
@section('title')
    <title>{{__('user.Terms And Conditions')}}</title>
@endsection
@section('meta')
    <meta name="description" content="{{__('user.Terms And Conditions')}}">
@endsection

@section('public-content')
<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ $terms_conditions ? asset($terms_conditions->terms_condition_banner) : '' }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{__('user.Terms and Conditions')}}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><span>{{__('user.Terms and Conditions')}}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->

    <div class="about-style1 pt_50 pb_50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                     @if ($terms_conditions)
                         {!! clean($terms_conditions->terms_and_condition) !!}
                     @endif
                </div>
            </div>
        </div>
    </div>

@endsection
