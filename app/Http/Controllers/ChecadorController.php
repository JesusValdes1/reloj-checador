<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveChecadorRequest;
use App\Models\Checador;
use App\Models\Empleado;
use App\Models\ChecadorRegistro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ChecadorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('checadores.index', ['titulo' => 'Checadores - Listado']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexChecador(Request $request)
    {
        $ip = $request->ip();

        $checador = Checador::where('ip', $ip)
                        ->where('activo', true)
                        ->first();

        return view('checador.index', [
            'titulo' => 'Checador',
            'ip' => $ip,
            'autorizado' => $checador !== null,
            'horaServidor' => now()->format('Y-m-d H:i:s')
        ]);
    }

    public function list()
    {
        $checadores = Checador::get();

        $columnas = array();
        array_push($columnas, [ "data" => "consecutivo" ]);
        array_push($columnas, [ "data" => "ip" ]);
        array_push($columnas, [ "data" => "activo" ]);
        array_push($columnas, [ "data" => "nombre" ]);
        array_push($columnas, [ "data" => "descripcion" ]);
        array_push($columnas, [ "data" => "ubicacion" ]);
        array_push($columnas, [ "data" => "acciones" ]);
        
        $token = csrf_token();
        
        $registros = array();
        foreach ($checadores as $key => $value) {
            $rutaEdit = route('checadores.edit', ['checadore' => $value->id]);
            $rutaDestroy = route('checadores.destroy', ['checadore' => $value->id]);
            $folio = mb_strtoupper(e($value['nombre']));

            array_push( $registros, [
                "consecutivo" => ($key + 1),
                "ip" => e($value["ip"]),
                "activo" => ($value["activo"]) ? 'Si' : 'No',
                "nombre" => mb_strtoupper(e($value["nombre"])),
                "descripcion" => mb_strtoupper(e($value["descripcion"])),
                "ubicacion" => mb_strtoupper(e($value["ubicacion"])),
                "acciones" => "<a href='{$rutaEdit}' class='btn btn-xs btn-warning'><i class='fas fa-pencil-alt'></i></a>
                            <form method='POST' action='{$rutaDestroy}' style='display: inline'>
                                <input type='hidden' name='_method' value='DELETE'>
                                <input type='hidden' name='_token' value='{$token}'>
                                <button type='button' class='btn btn-xs btn-danger eliminar' folio='{$folio}'>
                                    <i class='far fa-times-circle'></i>
                                </button>
                            </form>"
            ] );
        }

        $respuesta = [
			'codigo' => 200,
			'error' => false,
			'datos' => [
				'columnas' => $columnas,
				'registros' => $registros
			]
        ];

        return $respuesta;
    }

    public function descargaRegistros(Request $request)
    {
        try {

            $fechaInicial = $request->fechaInicial;
            $fechaFinal = $request->fechaFinal;
            $checador = $request->checador_id;

            $registros = ChecadorRegistro::with('checador', 'empleado')
                                            ->where('checador_id', $checador)
                                            ->whereBetween('created_at', [
                                                $fechaInicial . ' 00:00:00',
                                                $fechaFinal . ' 23:59:59'
                                            ])
                                            ->orderBy('created_at', 'DESC')->get();

            $columnas = array();
            array_push($columnas, [ "data" => "consecutivo" ]);
            array_push($columnas, [ "data" => "empleado" ]);
            array_push($columnas, [ "data" => "area" ]);
            array_push($columnas, [ "data" => "puesto" ]);
            array_push($columnas, [ "data" => "registro" ]);
            array_push($columnas, [ "data" => "fechaRegistro" ]);

            $contador = 1;
            $data = $registros->map(function($registro) use (&$contador) {
                $fechaRegistro = \DateTime::createFromFormat('Y-m-d H:i:s', $registro->fecha)->format('Y-m-d H:i:s');

                return [
                    'consecutivo' => $contador++,
                    'empleado' => mb_strtoupper($registro->empleado->nombreCompleto()),
                    'area' => mb_strtoupper($registro->empleado->area),
                    'puesto' => mb_strtoupper($registro->empleado->puesto),
                    'registro' => $registro->entrada ? 'ENTRADA' : 'SALIDA',
                    'fechaRegistro' => $fechaRegistro,
                ];
            });

            return response()->json([
                'columnas' => $columnas,
                'historico' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudieron obtener los datos.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getValidacionFoto(Request $request)
    {
        try {
            $matricula = $request->input('matricula');

            $empleado = Empleado::where('matricula', $matricula)->first();
            // $empleado = Empleado::findOrFail($matricula);

            if (!$empleado) {
                return response()->json([
                    'error' => true,
                    'message' => 'Empleado no encontrado.'
                ]);
            }

            // Validar si está activo
            if (!$empleado->activo) {
                return response()->json([
                    'error' => true,
                    'message' => 'El empleado no está activo.'
                ]);
            }

            if ($request->hasFile('foto_actual')) {
                $fotoActual = $request->file('foto_actual');
                $pathActual = storage_path("app/temp/actual_{$matricula}.jpg");
                $fotoActual->move(dirname($pathActual), basename($pathActual));

                $pathFotoEmpleado = storage_path("app/public/fotos/{$matricula}.jpg");

                if (!file_exists($pathFotoEmpleado)) {
                    return response()->json([
                        'error' => true,
                        'message' => 'Foto registrada del empleado no encontrada.'
                    ]);
                }

                // Ejecutar script Python
                // $scriptPath = public_path('recognize_face.py');
                // $command = escapeshellcmd("python3 $scriptPath " . escapeshellarg($pathFotoEmpleado) . " " . escapeshellarg($pathActual));
                // exec($command, $outputLines, $exitCode);
                // $output = implode("\n", $outputLines);

                // if ($exitCode !== 0 || trim($output) !== "Cara reconocida!") {
                //     return response()->json([
                //         'error' => true,
                //         'message' => 'La persona escaneada no coincide con la registrada.'
                //     ]);
                // }

                $ip = $request->ip();
                $checador = Checador::where('ip', $ip)
                                    ->where('activo', true)
                                    ->first();

                // ChecadorRegistro::create([
                //     'checador_id' => $checador->id,
                //     'empleado_id' => $empleado->id
                // ]);

                return response()->json([
                    'error' => false,
                    'message' => 'Asistencia registrada correctamente',
                    'empleado' => [
                        'matricula' => $empleado->matricula,
                        // 'nombre' => $empleado->nombreCompleto(),
                        // 'area' => $empleado->area,
                        // 'puesto' => $empleado->puesto,
                        'foto' => asset("storage/fotos/{$matricula}.jpg"),
                    ]
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'No se recibió la foto capturada.'
                ]);
            }

        } catch (Exception $e) {
            $respuesta = [
                'codigo' => 500,
                'error' => true,
                'errorMessage' => $e->getMessage()
            ];
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fecha = date_format(new \DateTime(), "Y-m-d");
        $primerDiaMes = date("Y-m-01");

        return view('checadores.crear', [
            'titulo' => 'Checadores - Crear',
            'fecha' => $fecha,
            'primerDiaMes' => $primerDiaMes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveChecadorRequest $request)
    {
    	$validated = $request->validated();

        $validated['activo'] = $request->boolean('activo');

        if ( Checador::create($validated) )
			return redirect()->route('checadores.index')
				->with([
					'clase-flash' => 'bg-success',
					'titulo-flash' => 'Crear checador',
					'subtitulo-flash' => 'OK',
					'mensaje-flash' => 'El checador ha sido registrado'
				]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeRegistro(Request $request)
    {
        try {
            $matricula = $request->matricula;

            $empleado = Empleado::where('matricula', $matricula)->first();
            $fecha = Carbon::createFromFormat('d/m/Y H:i:s', $request->fecha)->format('Y-m-d H:i:s');

            if (!$empleado) {
                return response()->json([
                    'error' => true,
                    'message' => 'Empleado no encontrado.'
                ]);
            }

            // Validar si está activo
            if ($empleado->activo) {
                $ip = $request->ip();
                $checador = Checador::where('ip', $ip)
                                    ->where('activo', true)
                                    ->first();

                ChecadorRegistro::create([
                    'checador_id' => $checador->id,
                    'empleado_id' => $empleado->id,
                    'entrada' => $request->entrada,
                    'fecha' => $fecha
                ]);

                return response()->json([
                    'error' => false,
                    'message' => 'Asistencia registrada correctamente',
                    'empleado' => [
                        'nombre' => $empleado->nombreCompleto(),
                        'area' => $empleado->area,
                        'puesto' => $empleado->puesto,
                        'foto' => asset("storage/fotos/{$matricula}.jpg"),
                        'fecha' => $fecha,
                        'registro' => $request->entrada ? 'ENTRADA' : 'SALIDA',
                    ]
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'El empleado no está activo.'
                ]);
            }
        } catch (Exception $e) {
            $respuesta = [
                'codigo' => 500,
                'error' => true,
                'errorMessage' => $e->getMessage()
            ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $registros = ChecadorRegistro::where('checador_id', $id)->get();
        $total = $registros->count();

        foreach ($registros as $index => $registro) {
            $registro->numero = $total - $index;
        }

        $fecha = date_format(new \DateTime(), "Y-m-d");
        $primerDiaMes = date("Y-m-01");

        return view('checadores.editar', [
            'titulo' => 'Checadores - Editar',
            'checador' => Checador::findOrFail($id),
            'registros' => $registros,
            'fecha' => $fecha,
            'primerDiaMes' => $primerDiaMes
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaveChecadorRequest $request, $id)
    {
        $validated = $request->validated();

        $validated['activo'] = $request->boolean('activo');

        if ( Checador::find($id)->update($validated) )
			return redirect()->route('checadores.index')
				->with([
					'clase-flash' => 'bg-success',
					'titulo-flash' => 'Editar checador',
					'subtitulo-flash' => 'OK',
					'mensaje-flash' => 'El checador ha sido actualizado'
				]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ( Checador::destroy($id) )
			return redirect()->route('checadores.index')
				->with([
					'clase-flash' => 'bg-success',
					'titulo-flash' => 'Eliminar checador',
					'subtitulo-flash' => 'OK',
					'mensaje-flash' => 'El checador ha sido eliminado'
				]);
    }
}
