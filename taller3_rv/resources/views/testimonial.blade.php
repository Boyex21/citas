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
                    <h1>{{__('user.Testimonial')}}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><span>{{__('user.Testimonial')}}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->

<!--Testimonial Start-->
<div class="testimonial-page pt_40 pb_70">
    <div class="container">
        <div class="row">
            @foreach ($testimonials as $testimonial)
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="testimonial-item mt_30" style="background-image: url({{ asset('user/img/shape-3.png') }})">
                        <p>
                            {{ $testimonial->comment }}
                        </p>
                        <div class="testi-info">
                            <img src="{{ asset($testimonial->image) }}" alt="">
                            <h4>{{ $testimonial->name }}</h4>
                            <span>{{ $testimonial->designation }}</span>
                        </div>
                        <div class="testi-link">
                            <a href="javascript:;"><i class="fa fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!--Testimonial End-->
@endsection
