@php
    $error_500=App\Models\ErrorPage::find(2);
@endphp
@extends('layout')
@section('title')
    <title>{{ $error_500->page_name }}</title>
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
            <h2>{{ $error_500->page_number }}</h2>
            <h4> {{ $error_500->header }}</h4>
            <p>{{ $error_500->description }}</p>
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
