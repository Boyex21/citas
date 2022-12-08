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
                    <h1>{{__('user.Blog')}}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><span>{{__('user.Blog')}}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->

<!--Blog Start-->
<div class="blog-page pt_40 pb_90">
    <div class="container">
        @if ($blogs->count() > 0)
        <div class="row">
            @foreach ($blogs as $blog)
                <div class="col-lg-4 col-sm-6">
                    <div class="blog-item">
                        <div class="blog-image">
                            <img src="{{ url($blog->image) }}" alt="">
                        </div>
                        <div class="blog-author">
                            <span><i class="fas fa-user"></i> {{__('user.Admin')}}</span>
                            <span><i class="far fa-calendar-alt"></i> {{ date('d F, Y', strtotime($blog->created_at->format('Y-m-d'))) }}</span>
                        </div>
                        <div class="blog-text">
                            <h3><a href="{{ route('blog-detail', $blog->slug) }}">{{ $blog->title }}</a></h3>
                            <p>
                                {{ $blog->short_description }}

                            </p>
                            <a class="sm_btn" href="{{ route('blog-detail', $blog->slug) }}">{{__('user.Learn More')}} →</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!--Pagination Start-->
        {{ $blogs->links('custom_paginator') }}
        <!--Pagination End-->

        @else
            <div class="row">
                <div class="col-12 text-center mt-3">
                    <h3 class="text-danger">{{__('user.Blog Not Found')}}</h3>
                </div>
            </div>
        @endif
    </div>
</div>
<!--Blog End-->


@endsection
