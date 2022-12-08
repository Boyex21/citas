@extends('layout')
@section('title')
    <title>{{ $seo->seo_title }}</title>
@endsection
@section('meta')
    <meta name="description" content="{{ $seo->seo_description }}">
@endsection

@section('public-content')

<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ asset($banner->image) }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{__('user.About Us')}}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><span>{{__('user.About Us')}}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->


<!--About Us Start-->
<div class="about-style1 pt_50 pb_50">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="about1-text sm_pr_0 pr_150 mt_30">
                    {!! clean($aboutUs->about_description) !!}
                </div>
            </div>
            <div class="col-lg-5">
                <div class="about1-bgimg mt_30" style="background-image:url({{ asset($aboutUs->background_image) }});">
                    <div class="about1-inner">
                        <img src="{{ asset($aboutUs->about_image) }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--About Us End-->

<!--Mission Start-->
<div class="mission-area bg-area pt_40 pb_90">
    <div class="container">
        <div class="row">
            <div class="col-md-6 pt_30">
                <div class="mission-img">
                    <img src="{{ asset($aboutUs->mission_image) }}" alt="">
                </div>
            </div>
            <div class="col-md-6 pt_30">
                <div class="mission-text">
                    {!! clean($aboutUs->mission_description) !!}
                </div>
            </div>
        </div>
        <div class="row mt_40">
            <div class="col-md-6 pt_30">
                <div class="mission-text">
                    {!! clean($aboutUs->vision_description) !!}
                </div>
            </div>
            <div class="col-md-6 pt_30">
                <div class="mission-img vision-img">
                    <img src="{{ asset($aboutUs->vision_image) }}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!--Mission End-->

@endsection
