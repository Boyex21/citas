@php
    $error_404=App\Models\ErrorPage::find(1);
@endphp
@extends('layout')
@section('title')
    <title>{{ $error_404->page_name }}</title>
@endsection
@section('public-content')
  <!--================================
    404 START
  =================================-->
  <section class="wsus__404">
    <div class="container">
      <div class="row">
        <div class="col-xl-8 m-auto">
          <div class="wsus__404_text">
            <h2>{{ $error_404->page_number }}</h2>
            <h4> {{ $error_404->header }}</h4>
            <p>{{ $error_404->description }}</p>
            <a href="{{ route('home') }}" class="common_btn">{{__('user.Go to Home')}}<i class="fas fa-home-alt"></i></a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--================================
    404 END
  =================================-->

@endsection
