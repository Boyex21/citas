@php
    $user = Auth::guard('web')->user();
@endphp

<div class="dashboard-widget">
    <div class="dashboard-account-info">
        <img src="uploads/website-images/avatar_user.jpg" alt="">
        <h3>{{ $user->name }}</h3>
        <p>Paciente Cédula: {{ $user->cedula }}</p>
    </div>
     <ul>
         <li><a href="{{ route('dashboard') }}"><i class="fa fa-chevron-right"></i>Dashboard</a></li>
         <li><a href=""><i class="fa fa-chevron-right"></i>Citas</a></li>
         <li><a href=""><i class="fa fa-chevron-right"></i>Historial de Trasacciones</a></li>
         <li><a href="{{ route('mi-perfil') }}"><i class="fa fa-chevron-right"></i>Mi Perfil</a></li>
         <li><a href="{{ route('cambiar-contrasena') }}"><i class="fa fa-chevron-right"></i>Cambiar Contraseña</a></li>
         <li><a href=""><i class="fa fa-chevron-right"></i>Diagnosticos</a></li>
         <li><a href="{{ route('logout') }}"><i class="fa fa-chevron-right"></i>Cerrar</a></li>
     </ul>
 </div>
