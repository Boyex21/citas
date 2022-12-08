@php
    $error_505=App\Models\ErrorPage::find(3);
@endphp
@extends('layout')
@section('title')
    <title>{{ $error_505->page_name }}</title>
@endsection
@section('public-content')
<!--================================
    500 START
  =================================-->
  <section class="wsus__404">
    <div class="container">
      <div class="row">
        <div class="col-xl-8 m-auto">
          <div class="wsus__404_text">
            <h2>{{ $error_505->page_number }}</h2>
            <h4> {{ $error_505->header }}</h4>
            <p>{{ $error_505->description }}</p>
            <a href="{{ route('home') }}" class="common_btn">{{__('user.Go to Home')}}<i class="fas fa-home-alt"></i></a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--================================
    500 END
  =================================-->

@endsection
