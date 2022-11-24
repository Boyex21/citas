@extends('layout')

@section('title')
<title>Error 505</title>
@endsection

@section('public-content')

<section class="wsus__404">
  <div class="container">
    <div class="row">
      <div class="col-xl-8 m-auto">
        <div class="wsus__404_text">
          <h2>505</h2>
          <h4>Versión HTTP no soportada</h4>
          <p>Por favor intentelo más tarde!</p>
          <a href="{{ route('login') }}" class="common_btn">Volver al Inicio <i class="fas fa-home-alt"></i></a>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
