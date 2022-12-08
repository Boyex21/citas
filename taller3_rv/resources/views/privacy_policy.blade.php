@extends('layout')
@section('title')
    <title>{{__('user.Privacy Policy')}}</title>
@endsection
@section('meta')
    <meta name="description" content="{{__('user.Privacy Policy')}}">
@endsection
@section('public-content')
  <!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ $privacyPolicy ? asset($privacyPolicy->privacy_banner) : '' }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{__('user.Privacy Policy')}}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><span>{{__('user.Privacy Policy')}}</span></li>
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
                @if ($privacyPolicy)
                {!! clean($privacyPolicy->privacy_policy) !!}
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
