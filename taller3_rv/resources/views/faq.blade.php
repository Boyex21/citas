@extends('layout')
@section('title')
    <title>{{ $seo->seo_title }}</title>
@endsection
@section('meta')
    <meta name="description" content="{{ $seo->seo_description }}">
@endsection

@section('public-content')


<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{  asset($banner->image) }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{__('user.FAQ')}}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><span>{{__('user.FAQ')}}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->

<!--Faq Start-->
<div class="faq-area pt_20 pb_70">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="faq-service feature-section-text mt_50">

                    <div class="feature-accordion" id="accordion">
                        @foreach ($categories as $category)
                            @if($category->faqs->count() > 0)
                                <h2 class="mt_50">{{ $category->name }}</h2>
                                @foreach ($category->faqs as $index => $faq)
                                    <div class="faq-item card">
                                        <div class="faq-header" id="heading1-{{ $faq->id }}">
                                            <button class="faq-button collapsed" data-toggle="collapse" data-target="#collapse1-{{ $faq->id }}" aria-expanded="true" aria-controls="collapse1-{{ $faq->id }}">{{ $faq->question }}</button>
                                        </div>

                                        <div id="collapse1-{{ $faq->id }}" class="collapse" aria-labelledby="heading1-{{ $faq->id }}" data-parent="#accordion">
                                            <div class="faq-body">
                                                {!! clean($faq->answer) !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Faq End-->



@endsection
