@extends('layouts.starter')

@section('content')

@if ($autorizado)
<div class="container-fluid" style="font-family: 'Inter', sans-serif;">
    {{-- <div class="row justify-content-center align-items-center" style="min-height: calc(100vh - 120px);"> --}}
    <div class="row">

        <!-- Checador -->
        {{-- <div class="col-md-8 d-flex justify-content-center"> --}}
        <div class="col-12">
            {{-- <div class="card shadow-lg border-primary w-100"> --}}
            <div class="card shadow-lg card-primary">
                {{-- <div class="card-header bg-primary text-white text-center"> --}}
                <div class="card-header">
                    {{-- <h3 class="mb-0 font-weight-medium">Checador de Asistencia</h3> --}}
                    <h3 class="card-title">
                        <span class="h4">
                            Checador de Asistencia
                            [ <span class="fecha-hora" data-hora="{{ $horaServidor }}">00/00/0000 00:00:00</span> ]
                        </span>
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="maximize">
                            <span data-toggle="tooltip" data-placement="top" title="Maximizar">
                                <i class="fas fa-expand fa-lg"></i>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="card-body text-center p-4">
                    <div class="row">
                        <!-- Cuadro de Cámara -->
                        <div class="col-sm-6 col-md-3">
                            <video id="videoCamara" autoplay playsinline muted style="width: 100%; height: 100%; object-fit: cover; border-radius: 0 0 0.25rem 0.25rem;"></video>
                        </div>

                        <div class="col-sm-6 col-md-9 d-flex flex-column justify-content-between mt-3 mt-sm-0">
                            <div class="form-group mb-sm-0">
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-lg btn-outline-primary px-4 opcion-registro">
                                        <input type="radio" name="tipo" id="option1" value="0">
                                        <i class="fas fa-walking fa-lg"></i> Entrada
                                    </label>
                                    <label class="btn btn-lg btn-outline-primary px-4 opcion-registro">
                                        <input type="radio" name="tipo" id="option2" value="1">
                                        <i class="fas fa-door-open fa-lg"></i> Salida
                                    </label>
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <label for="inputMatricula" class="h5 text-primary font-weight-bold">Escanea tu código de barras:</label>
                                <input type="text" id="inputMatricula" class="form-control form-control-lg text-center" placeholder="Escanea aquí" autofocus>
                            </div>
                        </div>

                        <div class="col-sm-12 d-flex flex-column justify-content-between mt-3">
                            <table class="table table-sm table-bordered" id="tabla-registros">
                              <thead class="bg-primary text-white">
                                <tr>
                                    <th scope="col" style="width: 250px;">REGISTRO</th>
                                    <th scope="col" style="width: 250px;">HORA</th>
                                    <th scope="col">NOMBRE</th>
                                </tr>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cuadro de Cámara -->
        {{-- <div class="col-md-5 d-flex justify-content-center">
            <div class="card shadow border-dark w-100">
                <div class="card-header bg-dark text-white text-center">
                    <h5 class="mb-0">Cámara</h5>
                </div>
                <div class="card-body p-0">
                    <video id="videoCamara" autoplay playsinline muted style="width: 100%; height: 100%; object-fit: cover; border-radius: 0 0 0.25rem 0.25rem;"></video>
                </div>
            </div>
        </div> --}}

    </div>
</div>
@else
    <div class="container text-center">
        <h1 class="text-danger">Acceso denegado</h1>
        <p>Tu IP (<strong>{{ $ip }}</strong>) no está autorizada para usar este checador.</p>
    </div>
@endif

@endsection

@section('scripts')
@if ($autorizado)
<script>
document.addEventListener('DOMContentLoaded', function () {
    const video = document.getElementById('videoCamara');

    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function (stream) {
                video.srcObject = stream;
                video.play();
            })
            .catch(function (err) {
                console.error("Error al acceder a la cámara: ", err);
            });
    } else {
        console.warn("getUserMedia no es compatible con este navegador.");
    }
});
</script>
@endif
<script src="{{ asset('js/face-api.min.js') }}"></script>
<script src="{{ asset('js/checador.js?v=1.10') }}"></script>
@endsection
