@extends('layouts.starter')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header py-2">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h1 class="m-0">Inicio</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><i class="fas fa-home"></i> Inicio</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section><!-- /.container-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">

    	@csrf

        {{-- INICIO: Contenedor para el contenido que se actualizará --}}

        @usuarioaut
        <h1 class="m-0">Bienvenid@ <span class="text-capitalize">{{ $usuarioAutenticado->nombre }} {{ $usuarioAutenticado->apellidoPaterno }}</span></h1>
        @else
        <h1 class="m-0">Bienvenid@ Invitado</h1>
        {{-- @endguest --}}
        @endusuarioaut

        {{-- FIN: Contenedor para el contenido --}}

    </div> {{-- <div class="container-fluid"> --}}
</section> {{-- <section class="content"> --}}

@endsection

@section('modals')

@endsection

@section('stylesPlugins')

@endsection

@section('styles')
	<link rel="stylesheet" href="{{ asset('css/home.css?v=1.00') }}">
@endsection

@section('scriptsPlugins')

@endsection

@section('scripts')
  <script src="{{ asset('js/home.js?v=1.01') }}"></script>
@endsection
