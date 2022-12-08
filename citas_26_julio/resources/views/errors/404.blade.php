@extends('layout')

@section('title')
<title>Error 404</title>
@endsection

@section('public-content')

<section class="wsus__404">
  <div class="container">
    <div class="row">
      <div class="col-xl-8 m-auto">
        <div class="wsus__404_text">
          <h2>404</h2>
          <h4>Página no encontrada!</h4>
          <p>Lo que estas buscando no lo encontraras aquí!</p>
          <a href="{{ route('login') }}" class="common_btn">Volver al Inicio <i class="fas fa-home-alt"></i></a>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection