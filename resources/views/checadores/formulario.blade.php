@php
if ( isset($checador->id) ) {
	$ip = !empty(old()) ? old('ip') : $checador->ip;
	$activo = !empty(old()) ? ( old('activo') && old('activo') == "on" ? true : false ) : $checador->activo;
	$nombre = !empty(old()) ? old('nombre') : $checador->nombre;
	$descripcion = !empty(old()) ? old('descripcion') : $checador->descripcion;
	$ubicacion = !empty(old()) ? old('ubicacion') : $checador->ubicacion;
} else {
	$ip = !empty(old()) ? old('ip') : "";
	$activo = !empty(old()) && old('activo') == "on" ? true : false;
	$nombre = !empty(old()) ? old('nombre') : "";
	$descripcion = !empty(old()) ? old('descripcion') : "";
	$ubicacion = !empty(old()) ? old('ubicacion') : "";
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
						<label for="ip">IP:</label>
						<input type="text" name="ip" id="ip" value="{{ $ip }}" class="form-control form-control-sm text-uppercase @error('ip') is-invalid @enderror" placeholder="Ingresa la IP">
						@error('ip')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

    				<div class="col-md-6 form-group">
						<label for="activo">Activo:</label>
						<div class="input-group">
							<input type="text" class="form-control form-control-sm" value="Checador Activo" disabled>
							<div class="input-group-append">
								<div class="input-group-text">
									<input type="checkbox" name="activo" id="activo" @if ( $activo ) checked @endif>
								</div>
							</div>
						</div>
					</div>

					<div class="col-12 form-group">
						<label for="nombre">Nombre(s):</label>
						<input type="text" name="nombre" id="nombre" value="{{ $nombre }}" class="form-control form-control-sm text-uppercase @error('nombre') is-invalid @enderror" placeholder="Ingresa el nombre del checador">
						@error('nombre')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="col-12 form-group">
						<label for="descripcion">Descripción:</label>
						<textarea name="descripcion" id="descripcion" class="form-control form-control-sm text-uppercase @error('descripcion') is-invalid @enderror" placeholder="Ingresa una descripción" rows="3">{{ $descripcion }}</textarea>
						@error('descripcion')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>


					<div class="col-12 form-group">
						<label for="ubicacion">Ubicación:</label>
						<input type="text" name="ubicacion" id="ubicacion" value="{{ $ubicacion }}" class="form-control form-control-sm text-uppercase @error('ubicacion') is-invalid @enderror" placeholder="Ingresa la ubicación">
						@error('ubicacion')
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
				@isset ( $checador->id )
				<div class="card-tools">
					<button type="button" class="btn btn-tool btn-actualizar-registro-checador" data-checador-id="{{ $checador->id }}" disabled>
						<span data-toggle="tooltip" data-placement="top" title="Actualizar">
							<i class="fas fa-sync-alt fa-lg text-dark"></i>
						<span>
					</button>
				</div>
				@endisset
            </div>

			<div class="card-body">
				@isset ( $checador->id )
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
						<button type="button" class="btn btn-outline-primary float-right btn-actualizar-registro-checador" @isset($checador->id) data-checador-id="{{ $checador->id }}" @endisset>
							<i class="bi bi-arrow-repeat"></i> Actualizar
						</button>
					</div> --}}
				</div>

				<div class="table-responsive">
					<table class="table table-sm table-bordered table-striped" id="tablaRegistrosChecador" width="100%">
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
