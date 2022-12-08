@extends('layout')
@section('title')
    <title>{{ $seo->seo_title }}</title>
@endsection
@section('meta')
    <meta name="description" content="{{ $seo->seo_description }}">
@endsection

@section('public-content')

<!--Banner Start-->
<div class="banner-area flex" "background-image:url({{ asset($banner->image) }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{__('user.Our Experts')}}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><span>{{__('user.Our Experts')}}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->



<div class="doctor-search">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="s-container">
                <form action="{{ route('our-experts') }}">

                    <div class="s-box">
                        <select name="expert" class="form-control select2">
                            <option value="">{{__('user.Select Expert')}}</option>
                                @foreach ($doctors as $doctor)
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
                                        @if (request()->has('expert'))
                                        <option {{ request()->get('expert') == $doctor->slug ? 'selected' : ''  }} value="{{ $doctor->slug }}">{{ $doctor->name }}</option>
                                        @else
                                        <option value="{{ $doctor->slug }}">{{ $doctor->name }}</option>
                                        @endif
                                    @endif
                                @endforeach

                        </select>
                    </div>
                    <div class="s-box">
                        <select name="location" class="form-control select2">
                            <option value="">{{__('user.Select Location')}}</option>
                                @foreach ($locations as $location)
                                    @if (request()->has('location'))
                                    <option {{ request()->get('location') == $location->slug ? 'selected' : ''  }} value="{{ $location->slug }}">{{ $location->name }}</option>
                                    @else
                                    <option value="{{ $location->slug }}">{{ $location->name }}</option>
                                    @endif
                                @endforeach

                        </select>
                    </div>
                    <div class="s-box">
                        <select name="department" class="form-control select2">
                            <option value="">{{__('user.Select Department')}}</option>
                                @foreach ($departments as $department)
                                    @if (request()->has('department'))
                                    <option {{ request()->get('department') == $department->slug ? 'selected' : ''  }} value="{{ $department->slug }}">{{ $department->name }}</option>
                                    @else
                                    <option value="{{ $department->slug }}">{{ $department->name }}</option>
                                    @endif
                                @endforeach
                        </select>
                    </div>
                    <div class="s-button">
                        <button type="submit">{{__('user.search')}}</button>
                    </div>
                </form>
                </div>

            </div>
        </div>
    </div>
</div>

<!--Service Start-->
<div class="team-page pt_40 pb_70">
    <div class="container">
        <div class="row">
            @php
                $isExpert = false;
            @endphp
            @foreach ($experts as $expert)
                @php
                    $isShow = true;
                    $activePlan = App\Models\Order::where(['doctor_id' => $expert->id, 'status' => 1])->first();
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
                    @php
                        $isExpert = true;
                    @endphp
                    <div class="col-lg-3 col-md-4 col-6 col-sm-6 mt_30">
                        <div class="team-item">
                            <div class="team-photo">
                                <img src="{{ $expert->image ? asset($expert->image) : asset($defaultProfile->image) }}" alt="Team Photo">
                            </div>
                            <div class="team-text">
                                <a href="{{ route('show-expert', $expert->slug) }}">{{ $expert->name }}</a>
                                <p>{{ $expert->designation }}</p>
                                <p>
                                <i class="fas fa-street-view"></i> {{ $expert->location->name }}
                                </p>

                                @php
                                    $reviews = $expert->reviews->where('status', 1);
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
                                    @foreach ($expert->socialLinks as $socialLink)
                                    <li><a href="{{ $socialLink->link }}"><i class="{{ $socialLink->icon }}"></i></a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

        </div>

        {{ $experts->links('custom_paginator') }}

        @if (!$isExpert)
            <div class="row">
                <div class="col-12 text-center">
                    <h3 class="text-danger">{{__('user.Expert Not Found')}}</h3>
                </div>
            </div>
        @endif


    </div>
</div>
<!--Service End-->

@endsection
