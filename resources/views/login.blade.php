<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{ asset('images/icono.png') }}" type="image/png">
  <title>Reloj Checador | Ingresar</title>

  <!-- Google Font: Source Sans Pro -->
  {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> --}}
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  {{-- <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css"> --}}
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  {{-- Estilos Personalizados --}}
  <link rel="stylesheet" href="{{ asset('css/login.css?v=1.00') }}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo d-flex flex-column justify-content-center align-items-center">
  	<img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="Plantilla Base AdminLTE" height="60" class="img-circle elevation-3">
  	<span style="font-weight: 400;">Reloj <b>Checador</b></span>
  </div>
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
  	<div class="card-header">
      <h3 class="card-title">Inicia tu sesión</h3>
  	</div>
    <div class="card-body login-card-body">

      <form action="/ingresar" method="POST" autocomplete="off">
      	@csrf
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="usuario" id="usuario" value="{{ old('usuario', Session::get('login-usuario') ) }}" placeholder="Usuario">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
          <small class="text-muted mt-1" style="font-size: 0.875rem;">No comparta sus credenciales de acceso con nadie</small>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        @if ($errors->any())
		<div class="alert alert-danger">
			<ul class="mb-0 pl-2">
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
		@endif
		<button type="submit" class="btn btn-primary btn-flat float-right"><i class="fas fa-sign-in-alt"></i> Ingresar</button>
        </div>
      </form>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
</body>
</html>
