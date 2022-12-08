@extends('layout')
@section('title')
    <title>{{ $seo->seo_title }}</title>
@endsection
@section('meta')
    <meta name="description" content="{{ $seo->seo_description }}">
@endsection

@section('public-content')


@php
    $section = $sections->where('id', 1)->first();
@endphp
@if ($section->status == 1)
    <!--Slider Start-->
    <div class="slider banner_area">
        <div class="slide-carousel owl-carousel">
            @foreach ($sliders as $index => $slider)
                <div class="slider-item flex" style="background-image:url({{ asset($slider->image) }});">
                    <div class="bg-slider"></div>
                </div>
            @endforeach

        </div>
        <div class="slider_text_area">
            <div class="slider-text">
                <div class="text-animateds">
                    <h1>{{ $sliderContent->slider_title }}</h1>
                    <p>{{ $sliderContent->slider_description }}</p>
                </div>
                <form class="banner_search" action="{{ route('our-experts') }}">
                    <ul class="d-flex flex-wrap">
                        <li>
                            <select name="expert" class="select2">
                                <option value="">{{__('user.Select Expert')}}</option>
                                @foreach ($menuDoctors as $doctor)

                                @php
                                    $isShow = true;
                                    $activePlan = App\Models\Order::where(['doctor_id' => $doctor->id, 'status' => 1])->first();
                                    if ($activePlan) {
                                        if($activePlan->expired_date){
                                            if(date('Y-m-d') > $activePlan->expired_date){
                                            $isShow = false;
                                        }
                                        }

                                    }else{
                                        $isShow = false;
                                    }
                                @endphp
                                @if ($isShow)
                                <option value="{{ $doctor->slug }}">{{ $doctor->name }}</option>
                                @endif
                                @endforeach
                            </select>
                        </li>
                        <li>
                            <select class="select2" name="location">
                                <option value="">{{__('user.Select Location')}}</option>
                                @foreach ($locations as $location)
                                <option value="{{ $location->slug }}">{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </li>
                        <li>
                            <select class="select2" name="department">
                                <option value="">{{__('user.Select Department')}}</option>
                                @foreach ($departments as $department)
                                <option value="{{ $department->slug }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </li>
                        <li><button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button></li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
    <!--Slider End-->
@endif


@php
    $section = $sections->where('id', 2)->first();
@endphp
@if ($section->status == 1)
<!--Why Us Start-->
<div class="why-us-area pt_30 mb_100 xs_mb_70">
    <div class="container">
        <div class="row">
            @foreach ($features as $feature)
                <div class="col-lg-4 col-md-6 choose-col mt_30">
                    <div class="choose-item flex">
                        <div class="choose-icon">
                            <i class="{{ $feature->icon }}" aria-hidden="true"></i>
                        </div>
                        <div class="choose-text">
                            <h4>{{ $feature->title }}</h4>
                            <p>
                                {{ $feature->description }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>
<!--why Us End-->
@endif


@php
    $section = $sections->where('id', 3)->first();
@endphp
@if ($section->status == 1)
<!--Service Start-->
<div class="service-area bg-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="main-headline">
                    @php
                        $content = $contents->where('id', 1)->first();
                    @endphp
                    <h1>{{ $content->title }}</h1>
                    <p>{{ $content->description }}</p>
                </div>
            </div>
        </div>
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
        <div class="row">
            <div class="col-md-12">
                <div class="home-button ser-btn">
                    <a href="{{ route('service') }}">{{__('user.View All Service')}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Service End-->
@endif


@php
    $section = $sections->where('id', 4)->first();
@endphp
@if ($section->status == 1)
 <!--Counter Start-->
 <div class="counter-row" style="background-image: url({{ asset('user/img/shape-1.png') }})">
    <div class="container">
        <div class="row">
            @foreach ($achievements as $achievement)
                <div class="col-lg-3 col-6 mt_30 wow fadeInDown" data-wow-delay="0.2s">
                    <div class="counter-item">
                        <div class="counter-icon">
                            <i class="{{ $achievement->icon }}"></i>
                        </div>
                        <h2 class="counter">{{ $achievement->qty }}</h2>
                        <h4>{{ $achievement->title }}</h4>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </div>
    <!--Counter End-->
@endif



@php
    $section = $sections->where('id', 5)->first();
@endphp
@if ($section->status == 1)
<div class="testimonial-area">
    <div class="container">
    <div class="row">
            <div class="col-md-12 wow fadeInDown" data-wow-delay="0.1s">
                <div class="main-headline">
                    @php
                        $content = $contents->where('id', 2)->first();
                    @endphp
                    <h1>{{ $content->title }}</h1>
                    <p>{{ $content->description }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="testimonial-texarea mt_30">
                    <div class="owl-testimonial owl-carousel">
                        @foreach ($testimonials as $testimonial)
                            <div class="testimonial-item wow fadeIn" data-wow-delay="0.2s" style="background-image: url({{ asset('user/img/shape-3.png') }})">
                                <p class="wow fadeInDown" data-wow-delay="0.2s">
                                    {{ $testimonial->comment }}
                                </p>
                                <div class="testi-info wow fadeInUp" data-wow-delay="0.2s">
                                    <img src="{{ asset($testimonial->image) }}" alt="">
                                    <h4>{{ $testimonial->name }}</h4>
                                    <span>{{ $testimonial->designation }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Testimonial End-->
@endif


@php
    $section = $sections->where('id', 6)->first();
@endphp
@if ($section->status == 1)
<!--Team Area Start-->
<div class="team-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="main-headline">
                    @php
                        $content = $contents->where('id', 3)->first();
                    @endphp
                    <h1>{{ $content->title }}</h1>
                    <p>{{ $content->description }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="team-carousel owl-carousel">

                    @foreach ($doctors as $index => $doctor)
                        @php
                            $isShow = true;
                            $activePlan = App\Models\Order::where(['doctor_id' => $doctor->id, 'status' => 1])->first();
                            if ($activePlan) {
                                if($activePlan->expired_date){
                                    if(date('Y-m-d') > $activePlan->expired_date){
                                        $isShow = false;
                                    }
                                }

                            }else{
                                $isShow = false;
                            }
                        @endphp

                        @if ($isShow)
                        <div class="team-item">
                            <div class="team-photo">
                                <img src="{{ $doctor->image ? asset($doctor->image) : asset($defaultProfile->image) }}" alt="Team Photo">
                            </div>
                            <div class="team-text">
                                <a href="{{ route('show-expert', $doctor->slug) }}">{{ $doctor->name }}</a>
                                <p>{{ $doctor->designation }}</p>
                                <p>
                                <i class="fas fa-street-view"></i> {{ $doctor->location->name }}
                                </p>

                                @php
                                    $reviews = $doctor->reviews->where('status', 1);
                                    $reviewQty = $reviews->count();
                                    $totalReview = $reviews->sum('rating');

                                    if ($reviewQty > 0) {
                                        $average = $totalReview / $reviewQty;
                                        $intAverage = intval($average);
                                        $nextValue = $intAverage + 1;
                                        $reviewPoint = $intAverage;
                                        $halfReview=false;
                                        if($intAverage < $average && $average < $nextValue){
                                            $reviewPoint= $intAverage + 0.5;
                                            $halfReview=true;
                                        }
                                    }

                                @endphp

                                @if ($reviewQty > 0)
                                    <span>
                                        @for ($i = 1; $i <=5; $i++)
                                            @if ($i <= $reviewPoint)
                                            <i class="fas fa-star"></i>
                                            @elseif ($i> $reviewPoint )
                                                @if ($halfReview==true)
                                                <i class="fas fa-star-half-alt"></i>
                                                    @php
                                                        $halfReview=false
                                                    @endphp
                                                @else
                                                <i class="far fa-star"></i>
                                                @endif
                                            @endif
                                        @endfor
                                    </span>
                                @endif

                                @if ($reviewQty == 0)
                                    <span>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </span>
                                @endif



                            </div>
                            <div class="team-social">
                                <ul>
                                    @foreach ($doctor->socialLinks as $socialLink)
                                    <li><a href="{{ $socialLink->link }}"><i class="{{ $socialLink->icon }}"></i></a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!--Team Area End-->
@endif


@php
    $section = $sections->where('id', 7)->first();
@endphp
@if ($section->status == 1)
<!--Blog-Area Start-->
<div class="blog-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="main-headline">
                    @php
                        $content = $contents->where('id', 4)->first();
                    @endphp
                    <h1>{{ $content->title }}</h1>
                    <p>{{ $content->description }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="blog-carousel owl-carousel">

                    @foreach ($blogs as $index => $blog)
                        <div class="blog-item effect-item">
                            <a href="{{ route('blog-detail', $blog->slug) }}" class="image-effect">
                                <div class="blog-image">
                                    <img src="{{ $blog->image }}" alt="">
                                </div>
                            </a>
                            <div class="blog-text">
                                <div class="blog-author">
                                    <span><i class="fa fa-user"></i> {{__('user.Admin')}}</span>
                                    <span><i class="fa fa-calendar-o"></i> {{ $blog->created_at->format('d F, Y') }}</span>
                                </div>
                                <h3><a href="{{ route('blog-detail', $blog->slug) }}">{{ $blog->title }}</a></h3>
                                <p>
                                    {{ $blog->short_description }}
                                </p>
                                <a class="sm_btn" href="{{ route('blog-detail', $blog->slug) }}">{{__('user.Learn more')}} →</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!--Blog-Area End-->
@endif

@endsection
