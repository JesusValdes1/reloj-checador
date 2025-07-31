<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="{{ asset('images/icono.png') }}" type="image/png">
  @isset($titulo)
  <title>Reloj Checador | {{$titulo}}</title>
  @endisset
  @empty($titulo)
  <title>Reloj Checador | Inicio</title>
  @endempty
  <!-- Google Font: Source Sans Pro -->
  {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> --}}
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

  @yield('stylesPlugins')

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- CSS Personalizado -->
  <link rel="stylesheet" href="{{ asset('css/estilos.css?v=1.01') }}">

  @yield('styles')
</head>
<body class="hold-transition sidebar-mini sidebar-collapse layout-fixed layout-footer-fixed">
<div class="loadable align-items-center justify-content-center d-flex"><div class="loading"></div></div>
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light" @if ( Route::currentRouteName() == 'checador.index' ) style="margin-left: 0 !important" @endif>
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      @if ( Route::currentRouteName() != 'checador.index' )
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('index') }}" class="nav-link">Inicio</a>
      </li>
      {{-- <li class="nav-item d-none d-sm-inline-block"> --}}
      <li class="nav-item d-none">
        <a href="#" class="nav-link">Contacto</a>
      </li>
      @endif
    </ul>

    <div class="navbar-nav w-100 d-flex justify-content-center">
      @if ( config('app.env') == 'dev' )
      <span class="text-secondary font-weight-bold border border-warning py-1 px-2" style="border-width: 2px !important; border-style: dashed !important;">AMBIENTE DE DESARROLLO | PRUEBAS</span>
      @endif
      {{-- @if ( Route::currentRouteName() == 'checador.index' )
      <span 
        class="fecha-hora h5 text-primary font-weight-bold border border-transparent py-1 px-2 mb-0"
        data-hora="{{ $horaServidor }}">
          00/00/0000 00:00:00
      </span>
      @endif --}}
    </div>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      {{-- <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li> --}}

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown d-none">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          {{-- <span class="badge badge-danger navbar-badge">3</span> --}}
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right d-none">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{ asset('dist/img/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{ asset('dist/img/user8-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{ asset('dist/img/user3-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown d-none">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          {{-- <span class="badge badge-warning navbar-badge">15</span> --}}
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right d-none">
          <span class="dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item @if ( Route::currentRouteName() == 'checador.index' ) d-none @endif">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>

      {{-- @auth --}}
      @usuarioaut
      <li class="nav-item">
        <a class="nav-link" href="{{ route('salir') }}" role="button">
          <span data-toggle="tooltip" data-placement="top" title="Salir">
            <i class="text-primary fas fa-sign-out-alt"></i>
          <span>
        </a>
      </li>
      {{-- @endauth --}}

      {{-- @guest --}}
      {{-- @else
      <li class="nav-item">
        <a class="nav-link" href="{{ route('ingresar') }}" role="button">
          <span data-toggle="tooltip" data-placement="top" title="Ingresar">
            <i class="text-primary fas fa-sign-in-alt"></i>
          <span>
        </a>
      </li> --}}
      {{-- @endguest --}}
      @endusuarioaut

      <li class="nav-item d-none">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @if ( Route::currentRouteName() != 'checador.index' )
  @include('layouts.menu')
  @endif
  {{-- @include('layouts.menu', ['usuarioAutenticado' => $usuarioAutenticado]) --}}

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" @if ( Route::currentRouteName() == 'checador.index' ) style="margin-left: 0 !important" @endif>

    {{-- <div class="loadable align-items-center justify-content-center d-flex"><div class="loading"></div></div> --}}
    @yield ('content')

    <div class="position-fixed p-3" style="z-index: 1060; right: 0; bottom: 0;">
        <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="fas fa-square"></i>
                <strong class="pl-1 mr-auto">Reloj Checador</strong>
                <small class="ml-5">Ahora</small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body"></div>
        </div>
    </div> 
      
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer" @if ( Route::currentRouteName() == 'checador.index' ) style="margin-left: 0 !important" @endif>
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Todos los derechos reservados.
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2025 <a href="https://preacero.com.mx" target="_blank">Preacero Pellizzari México</a>.</strong>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/select2/js/i18n/es.js') }}"></script>

@yield('scriptsPlugins')

<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- Script Personalizado -->
<script src="{{ asset('js/scripts.js?v=1.02') }}"></script>

@yield('scripts')

</body>
</html>
