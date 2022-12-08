@extends('layout')
@section('title')
    <title>{{ $service->seo_title }}</title>
@endsection
@section('meta')
    <meta name="description" content="{{ $service->seo_description }}">
@endsection
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@section('public-content')

<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ asset($banner->image) }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{ $service->name }}</h1>
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

<!--Service Detail Start-->
<div class="service-detail-area pt_40">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="service-detail-text pt_30">

                <div class="row mb_30">
                    <div class="col-md-12">
                        <!-- Swiper -->
                        <div class="swiper-container pro-detail-top">
                            <div class="swiper-wrapper">
                                @foreach ($service->galleries as $gallery)
                                    <div class="swiper-slide">
                                        <div class="catagory-item">
                                            <div class="catagory-img-holder">
                                                <img src="{{ asset($gallery->image) }}" alt="">
                                                <div class="catagory-text">
                                                    <div class="catagory-text-table">
                                                        <div class="catagory-text-cell">
                                                            <ul class="catagory-hover">
                                                                <li><a href="{{ asset($gallery->image) }}" class="magnific"><i class="fa fa-search"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- Add Arrows -->
                            <div class="swiper-button-next swiper-button-white"></div>
                            <div class="swiper-button-prev swiper-button-white"></div>
                        </div>
                        <div class="swiper-container pro-detail-thumbs">
                            <div class="swiper-wrapper">
                                @foreach ($service->galleries as $gallery)
                                <div class="swiper-slide"><img src="{{ asset($gallery->image) }}" alt=""></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <h2>{{ $service->name }}</h2>
                <p>{{ $service->short_description }}</p>

                {!! clean($service->description) !!}
                </div>

                @if ($service->faqs->count() > 0)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="faq-service feature-section-text mt_50">
                                <h2>{{__('user.Frequently Asked Question')}}</h2>
                                <div class="feature-accordion" id="accordion">
                                    @foreach ($service->faqs as $index => $faq)
                                        <div class="faq-item card">
                                            <div class="faq-header" id="heading1-{{ $faq->id }}">
                                                <button class="faq-button {{ $index == 0 ? '' : 'collapsed' }}" data-toggle="collapse" data-target="#collapse1-{{ $faq->id }}" aria-expanded="true" aria-controls="collapse1-{{ $faq->id }}">{{ $faq->question }}</button>
                                            </div>

                                            <div id="collapse1-{{ $faq->id }}" class="collapse {{ $index == 0 ? 'show' : '' }}" aria-labelledby="heading1-{{ $faq->id }}" data-parent="#accordion">
                                                <div class="faq-body">
                                                    {{ $faq->answer }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($service->videos->count() > 0)
                    <div class="row mt_50 mb_75">
                        <div class="col-12">
                            <div class="video-headline">
                                <h3>{{__('user.Service Video')}}</h3>
                            </div>
                        </div>
                        @foreach ($service->videos as $video)
                                @php
                                    $video_id=explode("=",$video->video_link);
                                @endphp
                            <div class="col-md-6">
                                <div class="video-item mt_30">
                                    <div class="video-img">
                                        <img src="https://img.youtube.com/vi/{{ $video_id[1] }}/0.jpg" alt="">
                                        <div class="video-section">
                                            <a class="video-button mgVideo" href="{{ $video->video_link }}"><span></span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
            <div class="col-md-4">
                <div class="service-sidebar pt_30">
                    <div class="service-widget">
                        <ul>
                            @foreach ($services as $sidebar_service)
                                <li class="{{ $service->id == $sidebar_service->id ? 'active' : '' }}"><a href="{{ route('service.detail', $sidebar_service->slug) }}"><i class="fa fa-chevron-right"></i> {{ $sidebar_service->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="service-widget-contact mt_45">
                        @if ($contact)
                        <h2>{{ $contact->title }}</h2>
                        <p class="mb_30">
                            {!! clean(nl2br($contact->description)) !!}
                        </p>
                        <ul>
                            <li><i class="fa fa-phone"></i>
                                {!! clean(nl2br($contact->phone)) !!}
                            </li>
                            <li><i class="fa fa-envelope"></i>
                                {!! clean(nl2br($contact->email)) !!}
                            </li>
                            <li><i class="fa fa-map-marker"></i>
                                {!! clean(nl2br($contact->address)) !!}
                            </li>
                        </ul>

                        @endif

                    </div>
                    <div class="service-qucikcontact event-form mt_30">
                        <h3>{{__('user.Quick Contact')}}</h3>
                        <form id="contactForm">
                            @csrf
                            <div class="form-row row">
                                <div class="form-group col-md-12">
                                    <input type="text" name="name" class="form-control" placeholder="{{__('user.Name')}}">
                                </div>
                                <div class="form-group col-md-12">
                                    <input type="email" name="email" class="form-control" placeholder="{{__('user.Email')}}">
                                </div>
                                <div class="form-group col-md-12">
                                    <input type="text" name="phone" class="form-control" placeholder="{{__('user.Phone')}}">
                                </div>
                                <div class="form-group col-md-12">
                                    <input type="text" name="subject" class="form-control" placeholder="{{__('user.Subject')}}">
                                </div>

                                <div class="form-group col-md-12">
                                    <textarea class="form-control" name="massege" placeholder="{{__('user.Massege')}}"></textarea>
                                </div>

                                <div class="form-group col-md-12">
                                    @if($recaptchaSetting->status==1)
                                    <div class="g-recaptcha" data-sitekey="{{ $recaptchaSetting->site_key }}"></div>
                                    @endif
                                </div>

                                <div class="form-group col-md-12">
                                    <button id="contactBtn" type="submit" class="btn"><i id="contact-spinner" class="loading-icon fa fa-spin fa-spinner mr-2 d-none"></i> {{__('user.Send Message')}}</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Service Detail End-->



<script>
    (function($) {
        "use strict";
        $(document).ready(function () {
            $("#contactForm").on('submit', function(e){
                e.preventDefault();
                var isDemo = "{{ env('APP_VERSION') }}"
                if(isDemo == 0){
                    toastr.error('This Is Demo Version. You Can Not Change Anything');
                    return;
                }

                $("#contact-spinner").removeClass('d-none')
                $(".contact-icon").addClass('d-none')
                $("#contactBtn").attr('disabled',true);


                $.ajax({
                    type: 'POST',
                    data: $('#contactForm').serialize(),
                    url: "{{ route('send-contact-message') }}",
                    success: function (response) {
                        if(response.status == 1){
                            toastr.success(response.message)
                            $("#contactForm").trigger("reset");
                            $("#contact-spinner").addClass('d-none')
                            $(".contact-icon").removeClass('d-none')
                            $("#contactBtn").attr('disabled',false);
                        }
                    },
                    error: function(response) {
                        $("#contact-spinner").addClass('d-none')
                        $(".contact-icon").removeClass('d-none')
                        $("#contactBtn").attr('disabled',false);

                        if(response.responseJSON.errors.name)toastr.error(response.responseJSON.errors.name[0])
                        if(response.responseJSON.errors.email)toastr.error(response.responseJSON.errors.email[0])
                        if(response.responseJSON.errors.subject)toastr.error(response.responseJSON.errors.subject[0])
                        if(response.responseJSON.errors.message)toastr.error(response.responseJSON.errors.message[0])

                        if(!response.responseJSON.errors.name || !response.responseJSON.errors.email || !response.responseJSON.errors.subject || !response.responseJSON.errors.message){
                            toastr.error("{{__('user.Please complete the recaptcha to submit the form')}}")
                        }
                    }
                });
            })


        });
    })(jQuery);

</script>
@endsection
