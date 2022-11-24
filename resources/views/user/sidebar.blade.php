<div class="dashboard-widget">
    <div class="dashboard-account-info">
        <img src="{{ $user->image ? asset($user->image) : asset('/uploads/website-images/default-avatar.jpg') }}" alt="">
        <h3>{{ $user->name }}</h3>
        <p>ID del Paciente: {{ $user->patient_id }}</p>
    </div>
    <ul>
        <li class="{{ Route::is('user.dashboard') ? 'active' : '' }}">
            <a href="{{ route('user.dashboard') }}"><i class="fa fa-chevron-right"></i> Inicio</a>
        </li>

        <li class="{{ Route::is('user.my-profile') ? 'active' : '' }}">
            <a href="{{ route('user.my-profile') }}"><i class="fa fa-chevron-right"></i> Mi Perfil</a>
        </li>

        <li class="{{ Route::is('user.appointment') || Route::is('user.show-appointment') ? 'active' : '' }}">
            <a href="{{ route('user.appointment') }}"><i class="fa fa-chevron-right"></i> Citas</a>
        </li>

        <li class="{{ Route::is('user.documents.index') || Route::is('user.documents.show') ? 'active' : '' }}">
            <a href="{{ route('user.documents.index') }}"><i class="fa fa-chevron-right"></i> Documentos</a>
        </li>

        <li class="{{ Route::is('user.change-password') ? 'active' : '' }}">
            <a href="{{ route('user.change-password') }}"><i class="fa fa-chevron-right"></i> Cambiar Contraseña</a>
        </li>

        <li>
            <a href="{{ route('user.logout') }}"><i class="fa fa-chevron-right"></i> Cerrar Sesión</a>
        </li>
    </ul>
</div>
