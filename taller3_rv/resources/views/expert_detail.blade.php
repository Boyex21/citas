@extends('layout')
@section('title')
    <title>{{ $expert->seo_title }}</title>
@endsection
@section('meta')
    <meta name="description" content="{{ $expert->seo_description }}">
@endsection
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@section('public-content')

<!--Banner Start-->
<div class="banner-area flex" "background-image:url({{ asset($banner->image) }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{ $expert->name }}</h1>
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

<!--Team Detail Start-->
<div class="team-detail-page pt_40 pb_70">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="team-detail-photo">
                    <img src="{{ $expert->image ? asset($expert->image) : asset($defaultProfile->image) }}" alt="">
                </div>
            </div>
            <div class="col-lg-8">
                <div class="team-detail-text">
                    <h4>{{ $expert->name }}</h4>
                    <span class="d-block"><b>{{ $expert->designation }}</b></span>

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
                    <span class="d-block rating">
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
                    <span class="d-block rating">
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                    </span>
                    @endif

                    <h3 class="text-dark">{{__('user.Fee')}}: {{ $setting->currency_icon }}{{ $expert->fee }}</h3>
                    {!! clean($expert->about) !!}
                    <ul>
                        @foreach ($expert->socialLinks as $socialLink)
                        <li><a href="{{ $socialLink->link }}"><i class="{{ $socialLink->icon }}"></i></a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="team-exp-area bg-area pt_70 pb_70">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="team-headline">
                    <h2>{{__('user.Expert Information')}}</h2>
                </div>
            </div>
            <div class="col-md-12">
                <!--Tab Start-->
                <div class="event-detail-tab mt_50">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a class="active" href="#expreaness" data-toggle="tab">{{__('user.Create Appointment')}}</a>
                        </li>

                        <li >
                            <a  href="#education" data-toggle="tab">{{__('user.Working Days')}}</a>
                        </li>

                        <li>
                            <a href="#skill" data-toggle="tab">{{__('user.Qualifications')}}</a>
                        </li>

                        <li>
                            <a href="#review" data-toggle="tab">{{__('user.Review')}}</a>
                        </li>
                        <li>
                            <a href="#gallery" data-toggle="tab">{{__('user.Gallery')}}</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content event-detail-content">
                    <div id="education" class="tab-pane fade ">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="edu-table table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="day">{{__('user.Working Day')}}</th>
                                                <th class="schedule">{{__('user.Schedule')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $old_day_id = 0;
                                            @endphp
                                            @php
                                                $old_chamber_id = 0;
                                            @endphp
                                            @foreach ($expert->schedules as $schedule)
                                                @if ($old_day_id != $schedule->day_id)
                                                    <tr>
                                                        <td class="day">{{ $schedule->day->custom_day }}</td>

                                                        <td class="schedule">
                                                            @php
                                                                $times = $expert->schedules->where('day_id',$schedule->day_id);
                                                            @endphp
                                                            @foreach ($times as $time)
                                                                <span>{{ date('h:i A', strtotime($time->start_time)) }} - {{ date('h:i A', strtotime($time->end_time)) }}</span>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @endif
                                                @php
                                                    $old_day_id = $schedule->day_id;
                                                @endphp

                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="expreaness" class="tab-pane fade show active">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="appintment_text">
                                    <h3 class="small_title">{{__('user.Create Appointment')}}</h3>
                                    <form action="{{ route('create-appointment') }}" method="POST">
                                        @csrf
                                        <div class="select">
                                            <label>{{__('user.Consultation Type')}}</label>
                                            <select name="consultation_type">
                                                <option value="0">{{__('user.Offline')}}</option>
                                                @if ($activeOrder)
                                                    @if ($activeOrder->online_consulting == 1)
                                                        @if ($credential)
                                                            @if ($credential->status == 1)
                                                            <option value="1">{{__('user.Online')}}</option>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            </select>
                                        </div>

                                        <div class="select">
                                            <label>{{__('user.Chamber')}}</label>
                                            <select name="chamber" id="chamber_id">
                                                <option value="">{{__('user.Select Chamber')}}</option>
                                                @foreach ($expert->chambers->where('status', 1) as $chamber)
                                                <option value="{{ $chamber->id }}">{{ $chamber->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <input type="hidden" value="{{ $expert->id }}" name="doctor_id" id="doctor_id">

                                        <div class="select d-none" id="date_box">
                                            <label>{{__('user.Select Date')}}</label>
                                            <input type="text" class="datepicker2" name="date" id="date" autocomplete="off">
                                        </div>

                                        <div class="select d-none" id="schedule_box">
                                            <label>{{__('user.Schedule')}}</label>
                                            <select name="schedule" id="schedule">
                                                <option value="">{{__('user.Select Schedule')}}</option>
                                            </select>
                                        </div>
                                        <div class="select">
                                            @auth
                                                <button id="submitBtn" type="submit" disabled>{{__('user.Submit')}}</button>
                                            @else
                                                <button class="before-login-btn" id="submitBtn" type="button" disabled>{{__('user.Submit')}}</button>
                                            @endauth

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="skill" class="tab-pane fade">
                        {!! clean($expert->qualifications) !!}
                    </div>

                    <div id="review" class="tab-pane fade">
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="review_area">
                                <h3 class="small_title mb-4">{{__('user.Total Review')}} : {{ $totalComments }}</h3>
                                    @foreach ($comments as $comment)
                                        <div class="single_review">
                                            <div class="review_img">
                                                <img src="http://www.gravatar.com/avatar/75d23af433e0cea4c0e45a56dba18b30" alt="user" class="img-fluid w-100">
                                            </div>
                                            <div class="review_text">
                                                <h5>{{ $comment->user->name }} <span><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $comment->created_at->format('d F, Y') }}</span></h5>
                                                <p>{!! clean($comment->comment) !!}</p>
                                            </div>
                                        </div>
                                    @endforeach

                                    {{ $comments->links('custom_paginator') }}



                                </div>
                            </div>
                            <div class="col-lg-5">
                                <h3 class="small_title small_mar">{{__('user.write a review')}}</h3>
                                <form action="{{ route('store-review') }}" method="POST">
                                    @csrf
                                    <div class="rating_area">
                                        <span><i class="fa fa-star" aria-hidden="true"></i></span>
                                        <select name="rating">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="doctor_id" value="{{ $expert->id }}">
                                    <textarea rows="5" placeholder="{{__('user.Comment')}}" name="comment"></textarea>

                                    @if($recaptchaSetting->status==1)
                                        <div class="g-recaptcha mb-3" data-sitekey="{{ $recaptchaSetting->site_key }}"></div>
                                    @endif

                                    @auth
                                        <button type="submit">{{__('user.Submit')}}</button>
                                    @else
                                        <button class="before-login" type="button">{{__('user.Submit')}}</button>
                                    @endauth

                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="gallery" class="tab-pane fade">
                        @if ($activeOrder)
                            <div class="row">
                                <div class="col-12">
                                    @if ($expert->imageGelleries->take($activeOrder->maximum_image)->count() > 0)
                                    <h3 class="small_title mb-0">{{__('user.Image Gallery')}}</h3>
                                    <div class="gallery_position">
                                        <div class="row gallery_slider photo">
                                            @if ($activeOrder->maximum_image == -1)
                                                @foreach ($expert->imageGelleries as $gellery)
                                                    <div class="col-lg-4 col-md-4 col-sm-6">
                                                        <div class="imageGallery1">
                                                            <a class="gallery_item venobox" href="{{ asset($gellery->image) }}" title="Caption for gallery item 1">
                                                                <img src="{{ asset($gellery->image) }}" alt="Gallery image 1" />
                                                                <span class="plus"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                                            </a>
                                                        </div>

                                                    </div>
                                                @endforeach
                                            @else
                                                @foreach ($expert->imageGelleries->take($activeOrder->maximum_image) as $gellery)
                                                    <div class="col-lg-4 col-md-4 col-sm-6">
                                                        <div class="imageGallery1">
                                                            <a class="gallery_item venobox" href="{{ asset($gellery->image) }}" title="Caption for gallery item 1">
                                                                <img src="{{ asset($gellery->image) }}" alt="Gallery image 1" />
                                                                <span class="plus"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                                            </a>
                                                        </div>

                                                    </div>
                                                @endforeach
                                            @endif

                                        </div>
                                    </div>
                                    @endif

                                    @if ($expert->videoGelleries->take($activeOrder->maximum_video)->count() > 0)
                                    <h3 class="small_title mb-0 mt-4">{{__('user.Video Gellery')}}</h3>
                                    <div class="gallery_position">
                                        <div class="row">
                                            @if ($activeOrder->maximum_video == -1)
                                                @foreach ($expert->videoGelleries as $video)
                                                    @php
                                                        $video_id=explode("=",$video->video_link);
                                                    @endphp
                                                    <div class="col-lg-4 col-md-4 col-sm-6">
                                                        <div class="video-img gallery_item venobox">
                                                            <img src="https://img.youtube.com/vi/{{ $video_id[1] }}/0.jpg" alt="">
                                                            <div class="video-section">
                                                                <a class="video-button mgVideo" href="{{ $video->video_link }}"><span></span></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                @foreach ($expert->videoGelleries->take($activeOrder->maximum_video) as $video)
                                                    @php
                                                        $video_id=explode("=",$video->video_link);
                                                    @endphp
                                                    <div class="col-lg-4 col-md-4 col-sm-6">
                                                        <div class="video-img gallery_item venobox">
                                                            <img src="https://img.youtube.com/vi/{{ $video_id[1] }}/0.jpg" alt="">
                                                            <div class="video-section">
                                                                <a class="video-button mgVideo" href="{{ $video->video_link }}"><span></span></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif

                                        </div>
                                    </div>

                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <!--Tab End-->
            </div>

        </div>
    </div>
</div>
<!--Team Detail End-->


<script>
    (function($) {
        "use strict";
        $(document).ready(function () {
            $(".before-login").on("click", function(){
                toastr.error("{{__('user.Please Login First')}}");
            })
            $("#chamber_id").on("change", function(){
                var chamberId = $(this).val();
                if(!chamberId){
                    $("#date").val('');
                    $("#date_box").addClass('d-none');
                    var scheduleHtml = "<option>{{__('user.Select Schedule')}}</option>";
                    $("#schedule").html(scheduleHtml);
                    $("#schedule_box").addClass('d-none');
                    $("#submitBtn").prop("disabled", true);
                }else{
                    $("#date").val('');
                    $("#date_box").removeClass('d-none');
                    var scheduleHtml = "<option>{{__('user.Select Schedule')}}</option>";
                    $("#schedule").html(scheduleHtml);
                    $("#schedule_box").addClass('d-none');
                    $("#submitBtn").prop("disabled", true);
                }
            })

            $("#date").on("change", function(){
                var appDate = $(this).val();
                var chamberId = $("#chamber_id").val();
                var doctorId = $("#doctor_id").val();
                if(!appDate){
                    $("#schedule_box").addClass('d-none');
                }
                $.ajax({
                    type: 'GET',
                    url: "{{ route('get-schedule') }}",
                    data: {date : appDate, chamber : chamberId, doctor_id : doctorId},
                    success: function (response) {
                        if(response.status == 1){
                            $("#schedule").html(response.schedules)
                            $("#schedule_box").removeClass('d-none');

                            if(response.scheduleQty == 0){
                                toastr.error("{{__('user.Schedule Not Found')}}");
                                $("#schedule_box").addClass('d-none');
                            }
                        }

                        if(response.status == 0){
                            toastr.error(response.message);
                            $("#submitBtn").prop("disabled", true);
                        }
                    },
                    error: function(err) {
                        console.log(err);
                        $("#submitBtn").prop("disabled", true);
                    }
                });

            })

            $("#schedule").on("change", function(){
                var schedule = $(this).val();
                var appDate = $("#date").val();
                var doctorId = $("#doctor_id").val();
                $.ajax({
                    type: 'GET',
                    url: "{{ route('schedule-avaibility') }}",
                    data: {date : appDate, schedule: schedule, doctor_id : doctorId},
                    success: function (response) {
                        if(response.status == 1){
                            $("#submitBtn").prop("disabled", false);
                        }
                        if(response.status == 0){
                            toastr.error(response.message);
                            $("#submitBtn").prop("disabled", true);
                        }
                    },
                    error: function(err) {
                        console.log(err);
                        $("#submitBtn").prop("disabled", true);
                    }
                });

            })

            $(".before-login-btn").on("click", function(){
                toastr.error("{{__('user.Please Login First')}}")
            })

        });
    })(jQuery);
</script>
@endsection
