<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="{{ route('admin.dashboard') }}">{{ $setting->sidebar_lg_header }}</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="{{ route('admin.dashboard') }}">{{ $setting->sidebar_sm_header }}</a>
    </div>
    <ul class="sidebar-menu">
      <li class="{{ Route::is('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> <span>Inicio</span></a>
      </li>

      @if(Auth::guard('admin')->user()->admin_type==1)
      <li class="{{ Route::is('admin.admin.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.admin.index') }}"><i class="fas fa-user"></i> <span>Administradores</span></a>
      </li>
      @endif

      <li class="nav-item dropdown {{ Route::is('admin.doctor') || Route::is('admin.show-doctor') || Route::is('admin.staff') || Route::is('admin.chamber') || Route::is('admin.review') || Route::is('admin.department.*') || Route::is('admin.location.*') ? 'active' : '' }}">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i><span>Doctores</span></a>

        <ul class="dropdown-menu">
          <li class="{{ Route::is('admin.doctor') || Route::is('admin.show-doctor') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.doctor') }}">Lista de Doctores</a>
          </li>

          <li class="{{ Route::is('admin.department.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.department.index') }}">Departamentos</a>
          </li>

          <li class="{{ Route::is('admin.location.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.location.index') }}">Ubicaciones</a>
          </li>

          <li class="{{ Route::is('admin.staff') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.staff') }}">Secretarias</a>
          </li>

          <li class="{{ Route::is('admin.chamber') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.chamber') }}">Especialidades</a>
          </li>
        </ul>
      </li>

      <li class="nav-item dropdown {{  Route::is('admin.customer-list') || Route::is('admin.customer-show') || Route::is('admin.pending-customer-list') ? 'active' : '' }}">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-user"></i> <span>Pacientes</span></a>
        <ul class="dropdown-menu">
          <li class="{{ Route::is('admin.customer-list') || Route::is('admin.customer-show') || Route::is('admin.send-email-to-all-customer') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.customer-list') }}">Lista de Pacientes</a>
          </li>
          
          <li class="{{ Route::is('admin.pending-customer-list') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.pending-customer-list') }}">Pacientes Pendientes</a>
          </li>
        </ul>
      </li>

      <li class="nav-item dropdown {{ Route::is('admin.medicine.*') || Route::is('admin.appointment') ? 'active' : '' }}">
        <a href="#" class="nav-link has-dropdown"><i class="fa fa-stethoscope"></i> <span>Citas</span></a>
        <ul class="dropdown-menu">
          <li class="{{ Route::is('doctor.create-appointment') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.create-appointment') }}">Crear Citas</a>
          </li>

          <li class="{{ Route::is('admin.appointment') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.appointment') }}">Historial de Citas</a>
          </li>

          <li class="{{ Route::is('admin.medicine.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.medicine.index') }}">Medicinas</a>
          </li>
        </ul>
      </li>

      <li class="{{ Route::is('admin.general-setting') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.general-setting') }}"><i class="fas fa-cog"></i> <span>Ajustes</span></a>
      </li>
    </ul>
  </aside>
</div>