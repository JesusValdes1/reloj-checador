@extends('layouts.starter')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header py-2">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Empleados <small class="font-weight-light">Listado</small></h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i> Inicio</a></li>
				<li class="breadcrumb-item active">Empleados</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div><!-- /.container-header -->

<!-- Main content -->
<div class="content">

@if ( Session::get('mensaje-flash') )
<div class="d-none" id="msgToast" clase="{{ Session::get('clase-flash') }}" titulo="{{ Session::get('titulo-flash') }}" subtitulo="{{ Session::get('subtitulo-flash') }}" mensaje="{{ Session::get('mensaje-flash') }}"></div>
@endif

<div class="container-fluid">

	<div class="row">
		<div class="col-md-12">
			<div class="card card-secondary card-outline">
				<div class="card-header">
					<h3 class="card-title"><i class="fas fa-list-ol"></i> Listado de Empleados</h3>
					<div class="card-tools">
						<a href="{{ route('empleados.create') }}" class="btn btn-outline-primary"><i class="fas fa-plus"></i> Crear empleado</a>
					</div>
				</div> <!-- /.card-header -->
				<div class="card-body">
					<table class="table table-sm table-bordered table-striped" id="tablaEmpleados" width="100%">
						<thead>
							<tr>
								<th class="text-right" style="width:10px">#</th>
								<th>Matricula</th>
								<th class="text-center">Activo</th>
								<th>Nombre(s)</th>
								<th>Apellido Paterno</th>
								<th>Apellido Materno</th>
								<th>Correo Electrónico</th>
								<th>Área</th>
								<th>Puesto</th>
								<th class="text-center">Acciones</th>
							</tr> 
						</thead>
						<tbody class="text-nowrap">
						</tbody>
					</table>
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
	<script src="{{ asset('js/empleados.js?v=1.06') }}"></script>
@endsection
