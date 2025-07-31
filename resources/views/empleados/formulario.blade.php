@php
if ( isset($empleado->id) ) {
	$matricula = !empty(old()) ? old('matricula') : $empleado->matricula;
	$activo = !empty(old()) ? ( old('activo') && old('activo') == "on" ? true : false ) : $empleado->activo;
	$nombre = !empty(old()) ? old('nombre') : $empleado->nombre;
	$apellido_paterno = !empty(old()) ? old('apellido_paterno') : $empleado->apellido_paterno;
	$apellido_materno = !empty(old()) ? old('apellido_materno') : $empleado->apellido_materno;
	$correo = !empty(old()) ? old('correo') : $empleado->correo;
	$fotoAnterior = $empleado->foto;
	$foto = $empleado->foto;
	$area = !empty(old()) ? old('area') : $empleado->area;
	$puesto = !empty(old()) ? old('puesto') : $empleado->puesto;
} else {
	$matricula = !empty(old()) ? old('matricula') : "";
	$activo = !empty(old()) && old('activo') == "on" ? true : false;
	$nombre = !empty(old()) ? old('nombre') : "";
	$apellido_paterno = !empty(old()) ? old('apellido_paterno') : "";
	$apellido_materno = !empty(old()) ? old('apellido_materno') : "";
	$correo = !empty(old()) ? old('correo') : "";
	// $fotoAnterior = null;
	$foto = null;
	$area = !empty(old()) ? old('area') : "";
	$puesto = !empty(old()) ? old('puesto') : "";
}
@endphp

<div class="row">

	<div class="col-md-6">

		<div class="card card-info card-outline">

			<div class="card-header">
              <h3 class="card-title">Datos generales</h3>
            </div>

            <div class="card-body">

            	@csrf

    			<div class="row">

    				<div class="col-md-6 form-group">
						<label for="matricula">Matricula:</label>
						{{-- <?php if ( isset($empleado->id) ) : ?> --}}
							{{-- <input type="text" value="{{ $matricula }}" class="form-control form-control-sm text-uppercase" disabled> --}}
						{{-- <?php else: ?> --}}
							<input type="text" name="matricula" id="matricula" value="{{ $matricula }}" class="form-control form-control-sm text-uppercase campoSinDecimal @error('matricula') is-invalid @enderror" placeholder="Ingresa la matricula" maxlength="5" autocomplete="off">
							@error('matricula')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						{{-- <?php endif; ?> --}}
					</div>

    				<div class="col-md-6 form-group">
						<label for="activo">Activo:</label>
						<div class="input-group">
							<input type="text" class="form-control form-control-sm" value="Empleado Activo" disabled>
							<div class="input-group-append">
								<div class="input-group-text">
									<input type="checkbox" name="activo" id="activo" @if ( $activo ) checked @endif>
								</div>
							</div>
						</div>
					</div>

    			</div>

            	<div class="row">

					<div class="col-md-6">
						<div class="form-group">
							<label for="nombre">Nombre(s):</label>
							<input type="text" name="nombre" id="nombre" value="{{ $nombre }}" class="form-control form-control-sm text-uppercase @error('nombre') is-invalid @enderror" placeholder="Ingresa el nombre(s) del empleado" autocomplete="off">
							@error('nombre')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="apellido_paterno">Apellido Paterno:</label>
							<input type="text" name="apellido_paterno" id="apellido_paterno" value="{{ $apellido_paterno }}" class="form-control form-control-sm text-uppercase @error('apellido_paterno') is-invalid @enderror" placeholder="Ingresa el apellido paterno" autocomplete="off">
							@error('apellido_paterno')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="form-group">
							<label for="apellido_materno">Apellido Materno:</label>
							<input type="text" name="apellido_materno" id="apellido_materno" value="{{ $apellido_materno }}" class="form-control form-control-sm text-uppercase @error('apellido_materno') is-invalid @enderror" placeholder="Ingresa el apellido materno" autocomplete="off">
							@error('apellido_materno')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>

					{{-- Insertar la imágen --}}
					@php
						if ( is_null($foto) ) {
							// $previsual = App\Route::rutaServidor()."vistas/img/usuarios/default/anonymous.png";
							$previsual = "/images/user-default.jpg";
						} else {
							// $previsual = App\Route::rutaServidor().$foto;
							$previsual = asset('storage/' . $foto);
						}
					@endphp
					<div class="col-md-6 form-group">
						{{-- <label for="foto">Imágen:</label> --}}
						<label>Imágen:</label>
						<picture>
							<img src="<?php echo $previsual; ?>" id="imgFoto" class="img-fluid img-thumbnail previsualizar" style="width: 100%" data-toggle="modal" data-target="#cameraModal">
						</picture>
						<span class="text-muted d-none" style="font-size: 0.875rem;">Presione sobre la imágen si desea cambiarla (Resolución recomendada 500 x 500 pixeles)</span>
						@if ( isset($empleado->id) )
							<input type="hidden" name="fotoAnterior" value="<?php echo $fotoAnterior; ?>">
						@endif
						<input type="file" class="form-control form-control-sm" id="foto" name="foto" style="display: none">
					</div>
					{{-- Insertar la imágen --}}

				</div>

				<div class="form-group">
					<label for="correo">Correo Electrónico:</label>
					<input type="email" name="correo" id="correo" value="{{ $correo }}" class="form-control form-control-sm text-lowercase @error('correo') is-invalid @enderror" placeholder="Ingresa un correo electrónico" autocomplete="off">
					@error('correo')
					<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>

				<div class="row">
					<div class="col-md-6 form-group">
						<label for="area">Área:</label>
						<input type="text" name="area" id="area" value="{{ $area }}" class="form-control form-control-sm text-uppercase @error('area') is-invalid @enderror" placeholder="Ingresa el área" autocomplete="off">
						@error('area')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="col-md-6 form-group">
						<label for="puesto">Puesto:</label>
						<input type="text" name="puesto" id="puesto" value="{{ $puesto }}" class="form-control form-control-sm text-uppercase @error('puesto') is-invalid @enderror" placeholder="Ingresa el puesto (cargo)" autocomplete="off">
						@error('puesto')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
				</div>

            </div> <!-- <div class="card-body"> -->

		</div> <!-- <div class="card card-info card-outline> -->

	</div> <!-- <div class="col-md-6"> -->

	<div class="col-md-6">

		<div class="card card-warning card-outline">

			<div class="card-header">
              <h3 class="card-title">Registros</h3>
              @isset ( $empleado->id )
				<div class="card-tools">
					<button type="button" class="btn btn-tool btn-actualizar-registro-empleado" data-empleado-id="{{ $empleado->id }}" disabled>
						<span data-toggle="tooltip" data-placement="top" title="Actualizar">
							<i class="fas fa-sync-alt fa-lg text-dark"></i>
						<span>
					</button>
				</div>
				@endisset
            </div>

			<div class="card-body">
				@isset ( $empleado->id )
				<div class="row">
					<div class="col-12 col-sm-6 col-md-12 col-lg-6 form-group">
						<div class="input-group input-group-sm">
							<div class="input-group-prepend">
								<span class="input-group-text">Fecha Inicial</span>
							</div>
							<input type="date" class="form-control text-right" id="fecha_inicial" value="{{ $primerDiaMes }}" aria-label="Fecha Inicial">
						</div>
					</div>

					<div class="col-12 col-sm-6 col-md-12 col-lg-6 form-group">
						<div class="input-group input-group-sm">
							<div class="input-group-prepend">
								<span class="input-group-text">Fecha Final</span>
							</div>
							<input type="date" class="form-control text-right" id="fecha_final" value="{{ $fecha }}" aria-label="Fecha Final">
						</div>
					</div>

		            {{-- <div class="col-2">
						<button type="button" class="btn btn-outline-primary float-right btn-actualizar-registro-empleado" @isset($empleado->id) data-empleado-id="{{ $empleado->id }}" @endisset>
							<i class="bi bi-arrow-repeat"></i> Actualizar
						</button>
					</div> --}}
				</div>

				<div class="table-responsive">
					<table class="table table-sm table-bordered table-striped" id="tablaRegistrosEmpleado" width="100%">
						<thead class="thead-dark">
							<tr>
								<th class="text-right">#</th>
								<th>Empleado</th>
								<th>Área</th>
								<th>Puesto</th>
								<th>Registro</th>
								<th class="text-center">Fecha</th>
							</tr>
						</thead>
						<tbody class="text-nowrap">
							{{-- @isset($registros)
							@foreach ($registros as $registro)
							<tr>
								<td>{{ $registro->numero }}</td>
								<td>{{ $registro->empleado->nombreCompleto() ?? '' }}</td>
								<td>{{ $registro->empleado->area ?? '' }}</td>
								<td>{{ $registro->empleado->puesto ?? '' }}</td>
								<td>{{ $registro->created_at->format('d/m/Y H:i:s') }}</td>
							</tr>
							@endforeach
							@endisset --}}
						</tbody>
					</table>
				</div>
				@endisset
			</div> <!-- <div class="box-body"> -->

		</div> <!-- <div class="box box-warning"> -->

	</div>

</div> <!-- <div class="row"> -->

<div class="modal fade" id="cameraModal" tabindex="-1" role="dialog" aria-labelledby="cameraModalLabel" aria-hidden="true">
  	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    	<div class="modal-content" style="height: 90vh;">
      		<div class="modal-body p-0" style="height: 100%; position: relative;">
        		<video id="video" autoplay playsinline style="width: 100%; height: 100%; object-fit: cover;"></video>
        		<canvas id="canvas" style="display: none;"></canvas>

		        <!-- Botón flotante -->
		        <button type="button" class="btn btn-primary capturar-foto"
		                style="position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); z-index: 10;">
		          Tomar Foto
		        </button>

		        <!-- Botón cerrar flotante -->
		        <button type="button" class="btn btn-light"
		                data-dismiss="modal"
		                style="position: absolute; top: 10px; right: 10px; z-index: 10;">
		          	&times;
		        </button>
      		</div>
    	</div>
  	</div>
</div>
