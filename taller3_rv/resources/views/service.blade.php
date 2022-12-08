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
                    <h1>{{__('user.Service')}}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><span>{{__('user.Service')}}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->
<!--Service Start-->
<div class="service-area service-page bg-area">
    <div class="container">
        <div class="row service-row">
            <div class="col-md-12">
                <div class="service-coloum-area">
                    @foreach ($services as $service)
                        <div class="service-coloum">
                            <div class="service-item">
                                <i class="{{ $service->icon }}"></i>
                                <h3>{{ $service->name }}</h3>
                                <p>{{ $service->short_description }}</p>
                                <a href="{{ route('service.detail', $service->slug) }}">{{__('user.Learn more')}} →</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!--Service End-->


@endsection
