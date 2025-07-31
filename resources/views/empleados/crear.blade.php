@extends('layouts.starter')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header py-2">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Empleados <small class="font-weight-light">Crear</small></h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i> Inicio</a></li>
	            <li class="breadcrumb-item"><a href="{{ route('empleados.index') }}"> <i class="fas fa-list-alt"></i> Empleados</a></li>
				<li class="breadcrumb-item active">Crear empleado</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div><!-- /.container-header -->

<!-- Main content -->
<div class="content">
<div class="container-fluid">

	<div class="row">
		<div class="col-md-12">
			<div class="card card-primary card-outline">
				<div class="card-header">
					<h3 class="card-title"><i class="fas fa-plus"></i> Crear empleado</h3>
				</div> <!-- <div class="card-header"> -->
				<div class="card-body">
					@include('errores.form-messages')
					<form id="formSend" method="POST" action="{{ route('empleados.store') }}" enctype="multipart/form-data">
						@include('empleados.formulario')
						<button type="button" id="btnSend" class="btn btn-outline-primary">
							<i class="fas fa-save"></i> Guardar
						</button>
						<div class="list-group" id="msgSend"></div>
					</form>
				</div> <!-- /.card-body -->
			</div> <!-- /.card -->
		</div> <!-- /.col -->
	</div> <!-- ./row -->

</div><!-- /.container-fluid -->
</div><!-- /.content -->

@endsection

@section('scripts')
	<script src="{{ asset('js/empleados.js?v=1.03') }}"></script>
@endsection
