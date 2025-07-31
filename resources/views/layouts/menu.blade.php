<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="/" class="brand-link">
    <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Reloj <b>Checador</b></span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      @usuarioaut
      <div class="image">
        <img src="{{ asset('dist/img/user-default.jpg') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block text-capitalize">{{ $usuarioAutenticado->nombre }} {{ $usuarioAutenticado->apellidoPaterno }}</a>
      </div>

      @else
      <div class="image">
        <img src="{{ asset('dist/img/user-default.jpg') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Invitado</a>
      </div>
      @endusuarioaut
    </div> --}}

    <!-- SidebarSearch Form -->
    {{-- <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div> --}}

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-item user-panel my-2 pb-2 @if ( Route::currentRouteName() == 'cambiar-password' ) menu-is-opening menu-open @endif">
          @usuarioaut
          <a href="#" class="nav-link pl-2 @if ( Route::currentRouteName() == 'cambiar-password' ) active @endif">
            <img src="{{ asset('images/user-default.jpg') }}" class="img-circle elevation-2 mr-1" alt="User Image">
            <p class="text-capitalize">
              {{ $usuarioAutenticado->nombre }} {{ $usuarioAutenticado->apellidoPaterno }}
              <i class="right fas fa-angle-left mt-1"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('cambiar-password') }}" class="nav-link @if ( Route::currentRouteName() == 'cambiar-password' ) active @endif">
                <i class="fas fa-lock nav-icon"></i>
                <p>Cambiar Contraseña</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('salir') }}" class="nav-link">
                <i class="fas fa-sign-out-alt nav-icon"></i>
                <p>Salir</p>
              </a>
            </li>
          </ul>
          @else
          <a href="#" class="nav-link pl-2">
            <img src="{{ asset('dist/img/user-default.jpg') }}" class="img-circle elevation-2 mr-1" alt="User Image">
            <p class="text-capitalize">
              Invitado
            </p>
          </a>
          @endusuarioaut
        </li>

        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="{{ route('index') }}" class="nav-link @if ( Route::currentRouteName() == 'index' ) active @endif">
            <i class="nav-icon fas fa-home"></i>
            <p>Inicio</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('checadores.index') }}" class="nav-link @if ( Route::currentRouteName() == 'checadores.index' ) active @endif">
            <i class="nav-icon fas fa-tablet-alt"></i>
            <p>Checadores</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('empleados.index') }}" class="nav-link @if ( Route::currentRouteName() == 'empleados.index' ) active @endif">
            <i class="nav-icon fas fa-users"></i>
            <p>Empleados</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('checador.index') }}" class="nav-link @if ( Route::currentRouteName() == 'checador.index' ) active @endif">
            <i class="nav-icon fas fa-barcode"></i>
            <p>Checador</p>
          </a>
        </li>

        @usuarioaut
        {{-- <li class="nav-item @if ( false ) menu-is-opening menu-open @endif">
          <a href="#" class="nav-link @if ( false ) active @endif">
            <i class="nav-icon fas fa-radiation-alt"></i>
            <p>
              Menu 1
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link @if ( false ) active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Opción 1</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link @if ( false ) active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Opción 2</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link @if ( false ) active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Opción 3</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link @if ( false ) active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Opción 4</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link @if ( false ) active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Opción 5</p>
              </a>
            </li>
          </ul>
        </li> --}}

        <li class="nav-header">REPORTES</li>
        <li class="nav-item @if ( false ) menu-is-opening menu-open @endif">
          <a href="#" class="nav-link @if ( false ) active @endif">
            <i class="nav-icon fas fa-print"></i>
            <p>Administrativos <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link @if ( false ) active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Reporte 1</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link @if ( false ) active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Reporte 2</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item @if ( false ) menu-is-opening menu-open @endif">
          <a href="#" class="nav-link @if ( false ) active @endif">
            <i class="nav-icon fas fa-print"></i>
            <p>Operativos <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link @if ( false ) active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Reporte 1</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link @if ( false ) active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Reporte 2</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link @if ( false ) active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Reporte 3</p>
              </a>
            </li>
          </ul>
        </li>

        {{-- <li class="nav-header">LIGAS EXTERNAS</li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-circle"></i>
            <p>Grupo 1 <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" target="_blank" class="nav-link">
                <i class="nav-icon fas fa-code-branch"></i>
                <p>Liga 1</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" target="_blank" class="nav-link">
                <i class="nav-icon fas fa-window-maximize"></i>
                <p>Liga 2</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" target="_blank" class="nav-link">
                <i class="nav-icon fas fa-coffee"></i>
                <p>Liga 3</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" target="_blank" class="nav-link">
                <i class="nav-icon fas fa-bug"></i>
                <p>Liga 4</p>
              </a>
            </li>
          </ul>
        </li> --}}

        @endusuarioaut        

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>