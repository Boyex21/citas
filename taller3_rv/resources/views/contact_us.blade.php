@extends('layout')
@section('title')
    <title>{{ $seo->seo_title }}</title>
@endsection
@section('meta')
    <meta name="description" content="{{ $seo->seo_description }}">
@endsection
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@section('public-content')


<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ $contact ? asset($contact->banner) : '' }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{__('user.Contact Us')}}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><span>{{__('user.Contact Us')}}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->

<!--Form Start-->
<div class="contauct-style1  pt_50 pb_65">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="about1-text mt_30">
                    @if ($contact)
                    <h1>{{ $contact->title }}</h1>
                    <p class="mb_30">
                        {!! clean(nl2br($contact->description)) !!}
                    </p>
                    @endif
                </div>
                <form id="contactForm">
                    @csrf
                    <div class="row contact-form">
                        <div class="col-lg-6 form-group">
                            <label>{{__('user.Name')}} *</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>{{__('user.Email')}} *</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>{{__('user.Phone')}}</label>
                            <input type="text" class="form-control" name="phone">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>{{__('user.Subject')}} *</label>
                            <input type="text" class="form-control" name="subject">
                        </div>
                        <div class="col-lg-12 form-group">
                            <label>{{__('user.Massege')}} *</label>
                            <textarea name="massege" class="form-control"></textarea>
                        </div>
                        <div class="form-group col-md-12">
                            @if($recaptchaSetting->status==1)
                            <div class="g-recaptcha" data-sitekey="{{ $recaptchaSetting->site_key }}"></div>
                            @endif
                        </div>
                        <div class="col-md-12 form-group">
                            <button id="contactBtn" type="submit" class="btn"> <i id="contact-spinner" class="loading-icon fa fa-spin fa-spinner mr-2 d-none"></i>  {{__('user.Send Massege')}}</button>



                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-5">
                <div class="contact-info-item bg1 mb_30 mt_30">
                    <div class="contact-info">
                        <span>
                            <i class="fa fa-phone"></i> {{__('user.Phone')}}:
                        </span>
                        <div class="contact-text">
                            @if ($contact)
                            {!! clean(nl2br($contact->phone)) !!}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="contact-info-item bg2 mb_30">
                    <div class="contact-info">
                        <span>
                            <i class="fa fa-envelope"></i> {{__('user.Email')}}:
                        </span>
                        <div class="contact-text">
                            @if ($contact)
                            {!! clean(nl2br($contact->email)) !!}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="contact-info-item bg3 mb_30">
                    <div class="contact-info">
                        <span>
                            <i class="fa fa-map"></i> {{__('user.Address')}}:
                        </span>
                        <div class="contact-text">
                            @if ($contact)
                            {!! clean(nl2br($contact->address)) !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Form End-->

<!--Google map start-->
<div class="map-area">
    @if($contact)
    {!! $contact->map !!}
    @endif
</div>
<!--Google map end-->





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
