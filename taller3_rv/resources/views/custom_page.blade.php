

@extends('layout')
@section('title')
    <title>{{ $page->page_name }}</title>
@endsection
@section('meta')
    <meta name="description" content="{{ $page->page_name }}">
@endsection
@section('public-content')

    <!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ asset($page->banner_image) }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{ $page->page_name }}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><span>{{ $page->page_name }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->

      <!--================================
    PRIVACY & POLICY START
  =================================-->
  <section class="wsus__privacy mt_70 xs_mt_30 mb_100 xs_mb_75">
    <div class="container">
      <div class="row">
        <div class="col-xl-12 m-auto">
          <div class="wsus__privacy_text">
            {!! clean($page->description) !!}
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--================================
    PRIVACY & POLICY END
  =================================-->

@endsection

