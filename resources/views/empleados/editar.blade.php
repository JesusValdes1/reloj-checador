@extends('layouts.starter')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header py-2">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Empleados <small class="font-weight-light">Editar</small></h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i> Inicio</a></li>
	            <li class="breadcrumb-item"><a href="{{ route('empleados.index') }}"> <i class="fas fa-list-alt"></i> Empleados</a></li>
				<li class="breadcrumb-item active">Editar empleado</li>
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
					<h3 class="card-title"><i class="fas fa-edit"></i> Editar empleado</h3>
				</div> <!-- <div class="card-header"> -->
				<div class="card-body">
					@include('errores.form-messages')
					<form id="formSend" method="POST" action="{{ route('empleados.update', ['empleado' => $empleado->id]) }}" enctype="multipart/form-data">
						<input type="hidden" name="_method" value="PUT">
						@include('empleados.formulario')
						<button type="button" id="btnSend" class="btn btn-outline-primary">
							<i class="fas fa-save"></i> Actualizar
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

@section('stylesPlugins')
	<!-- DataTables -->
	<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('scriptsPlugins')
	<!-- DataTables  & Plugins -->
	<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
	<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
	<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
	<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
	<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
@endsection

@section('scripts')
	<script src="{{ asset('js/empleados.js?v=1.03') }}"></script>
@endsection
