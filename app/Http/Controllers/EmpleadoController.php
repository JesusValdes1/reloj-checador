<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use App\Http\Requests\SaveEmpleadoRequest;
use App\Models\Empleado;
use App\Models\ChecadorRegistro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('empleados.index', ['titulo' => 'Empleados - Listado']);
    }

    public function list()
    {
        $empleados = Empleado::get();

        $columnas = array();
        array_push($columnas, [ "data" => "consecutivo" ]);
        array_push($columnas, [ "data" => "matricula" ]);
        array_push($columnas, [ "data" => "activo" ]);
        array_push($columnas, [ "data" => "nombre" ]);
        array_push($columnas, [ "data" => "apellido_paterno" ]);
        array_push($columnas, [ "data" => "apellido_materno" ]);
        array_push($columnas, [ "data" => "correo" ]);
        array_push($columnas, [ "data" => "area" ]);
        array_push($columnas, [ "data" => "puesto" ]);
        array_push($columnas, [ "data" => "acciones" ]);
        
        $token = csrf_token();
        
        $registros = array();
        foreach ($empleados as $key => $value) {
            $rutaEdit = route('empleados.edit', ['empleado' => $value->id]);
            $rutaDestroy = route('empleados.destroy', ['empleado' => $value->id]);
            $folio = \mb_strtoupper(GeneralHelper::fString($value['matricula']));

            array_push( $registros, [
                "consecutivo" => ($key + 1),
                "matricula" => GeneralHelper::fString($value["matricula"]),
                "activo" => ($value["activo"]) ? 'Si' : 'No',
                "nombre" => mb_strtoupper(GeneralHelper::fString($value["nombre"])),
                "apellido_paterno" => mb_strtoupper(GeneralHelper::fString($value["apellido_paterno"])),
                "apellido_materno" => mb_strtoupper(GeneralHelper::fString($value["apellido_materno"])),
                "correo" => mb_strtolower(GeneralHelper::fString($value["correo"])),
                "area" => mb_strtoupper(GeneralHelper::fString($value["area"])),
                "puesto" => mb_strtoupper(GeneralHelper::fString($value["puesto"])),
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

        $respuesta = array();
        $respuesta['codigo'] = 200;
        $respuesta['error'] = false;
        $respuesta['datos']['columnas'] = $columnas;
        $respuesta['datos']['registros'] = $registros;

        return $respuesta;
    }

    public function descargaRegistros(Request $request)
    {
        try {

            $fechaInicial = $request->fechaInicial;
            $fechaFinal = $request->fechaFinal;
            $empleado = $request->empleado_id;

            $registros = ChecadorRegistro::with('checador', 'empleado')
                                            ->where('empleado_id', $empleado)
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fecha = date_format(new \DateTime(), "Y-m-d");
        $primerDiaMes = date("Y-m-01");

        return view('empleados.crear', [
            'titulo' => 'Empleados - Crear',
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
    public function store(SaveEmpleadoRequest $request)
    {
        $validated = $request->validated();

        $validated['activo'] = $request->boolean('activo');

        if ($request->hasFile('foto')) {
            $matricula = $validated['matricula'];
            $archivo = $request->file('foto');
            $nombreArchivo = $matricula . '.jpg';
            
            $ruta_foto = 'fotos/' . $nombreArchivo;
            $archivo->storeAs('public/fotos', $nombreArchivo);

            // Guarda la ruta para usar desde el navegador
            $validated['foto'] = $ruta_foto;
        }

        if ( Empleado::create($validated) ) {

            return redirect()->route('empleados.index')
                ->with([
                        'clase-flash' => 'bg-success',
                        'titulo-flash' => 'Crear empleado',
                        'subtitulo-flash' => 'OK',
                        'mensaje-flash' => 'El empleado ha sido registrado'
                    ]);
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
        $registros = ChecadorRegistro::where('empleado_id', $id)->get();
        $total = $registros->count();

        foreach ($registros as $index => $registro) {
            $registro->numero = $total - $index;
        }

        $fecha = date_format(new \DateTime(), "Y-m-d");
        $primerDiaMes = date("Y-m-01");

        return view('empleados.editar', [
            'titulo' => 'Empleados - Editar',
            'empleado' => Empleado::findOrFail($id),
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
    public function update(SaveEmpleadoRequest $request, $id)
    {
        $validated = $request->validated();

        $validated['activo'] = $request->boolean('activo');
        $empleado = Empleado::where('id', $id)->first();

        $matriculaAnterior = $empleado->matricula;
        $matriculaNueva = $validated['matricula'];

        $rutaFotoAnterior = "public/fotos/{$matriculaAnterior}.jpg";
        $rutaFotoNueva = "public/fotos/{$matriculaNueva}.jpg";

        if ($request->hasFile('foto')) {
            $archivo = $request->file('foto');

            // Borra la foto anterior si existe
            if (Storage::exists($rutaFotoAnterior)) {
                Storage::delete($rutaFotoAnterior);
            }

            // Guarda la nueva con la matrícula nueva
            $archivo->storeAs('public/fotos', "{$matriculaNueva}.jpg");

            $validated['foto'] = "fotos/{$matriculaNueva}.jpg";
        } else {
            // Si NO se sube nueva foto pero cambió la matrícula, renombramos el archivo
            if ($matriculaAnterior !== $matriculaNueva && Storage::exists($rutaFotoAnterior)) {
                Storage::move($rutaFotoAnterior, $rutaFotoNueva);
                $validated['foto'] = "fotos/{$matriculaNueva}.jpg";
            }
        }

        if ( Empleado::find($id)->update($validated) ) {

            return redirect()->route('empleados.index')
                ->with(['clase-flash' => 'bg-success',
                        'titulo-flash' => 'Editar empleado',
                        'subtitulo-flash' => 'OK',
                        'mensaje-flash' => 'El empleado ha sido actualizado']);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $empleado = Empleado::where('id', $id)->first();

        if ($empleado->foto && Storage::exists('public/' . str_replace('storage/', '', $empleado->foto))) {
            Storage::delete('public/' . str_replace('storage/', '', $empleado->foto));
        }

        if ( Empleado::destroy($id) ) {

            return redirect()->route('empleados.index')
                    ->with(['clase-flash' => 'bg-success',
                            'titulo-flash' => 'Eliminar empleado',
                            'subtitulo-flash' => 'OK',
                            'mensaje-flash' => 'El empleado ha sido eliminado']);

        }
    }
}
