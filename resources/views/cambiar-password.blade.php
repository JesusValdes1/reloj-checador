@extends('layouts.starter')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header py-2">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<h1 class="m-0 text-capitalize">{{ $usuarioAutenticado->nombre }} {{ $usuarioAutenticado->apellidoPaterno }} <small class="font-weight-light">Cambiar Contraseña </small></h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i> Inicio</a></li>
				<li class="breadcrumb-item active">Cambiar Contraseña</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</section><!-- /.container-header -->

<!-- Main content -->
<section class="content">

@if ( Session::get('mensaje-flash') )
<div class="d-none" id="msgToast" clase="{{ Session::get('clase-flash') }}" titulo="{{ Session::get('titulo-flash') }}" subtitulo="{{ Session::get('subtitulo-flash') }}" mensaje="{{ Session::get('mensaje-flash') }}"></div>
@endif

<div class="container-fluid">

	<div class="row">
		{{-- <div class="col-md-12"> --}}
		<div class="col-md-6">
			<div class="card card-primary card-outline">
				<div class="card-header">
					<h3 class="card-title"><i class="fas fa-edit"></i> Cambiar Contraseña</h3>
				</div> <!-- <div class="card-header"> -->
				<div class="card-body">
					@include('errores.form-messages')
					<form id="formSend" method="POST" action="{{ route('cambiar-password.update') }}">
						<input type="hidden" name="_method" value="PUT">
						@csrf

		            	<div class="form-group">
							<label for="password">Contraseña Actual:</label>
							<input type="password" name="password" value="" class="form-control form-control-sm" placeholder="Contraseña Actual">
						</div>

						<div class="form-group">
							<label for="newPassword">Nueva Contraseña:</label>
							<input type="password" name="newPassword" value="" class="form-control form-control-sm" placeholder="Nueva Contraseña">
						</div>

						<div class="form-group">
							<label for="confirmPassword">Confirmar Contraseña:</label>
							<input type="password" name="confirmPassword" value="" class="form-control form-control-sm" placeholder="Confirmar Contraseña">
						</div>

						<button type="button" id="btnSend" class="btn btn-outline-primary btn-flat">
							<i class="fas fa-save"></i> Actualizar
						</button>
						<div class="list-group" id="msgSend"></div>
					</form>
				</div> <!-- /.card-body -->
			</div> <!-- /.card -->
		</div> <!-- /.col -->
	</div> <!-- ./row -->

</div><!-- /.container-fluid -->
</section><!-- /.content -->

@endsection

@section('scripts')
	<script src="{{ asset('js/cambiar-password.js?v=1.00') }}"></script>
@endsection
