<?php

namespace App\Http\Controllers;

use App\Models\Alimentos;
use App\Http\Controllers\Controller;
use App\Models\AlimentosDetalles;
use App\Models\ArchivosFTP;
use App\Models\PlantillaEncabezados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\form;

class AlimentosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alimentos = Alimentos::select('alimentos', 'plantilla_encabezados.nombre as nombre_encabezado')
            ->where('alimentos.baja', 0)
            ->join('plantilla_encabezados', 'metodologias.plantilla_encabezado_id', '=', 'plantilla_encabezados.plantilla_encabezado_id')
            ->get()
            ->toArray();

        foreach($alimentos as $key => $alimento){
            $alimento['detalles'] = AlimentosDetalles::where('alimento_id', $alimento['alimento_id'])
                ->where('baja', 0)
                ->get()
                ->toArray();

            $archivos = AlimentosDetalles::join('plantilla_detalles', 'plantilla_detalles.plantilla_detalle_id', '=', 'alimentos_detalles.plantilla_detalle_id')
                ->where('alimentos_detalles.alimento_id', $alimento['alimento_id'])
                ->where('alimentos_detalles.baja', 0)
                ->whereIn('plantilla_detalles.tipo_campo', [18, 20])
                ->select('alimentos_detalles.*')
                ->get()
                ->toArray();

            $archivos_array = [];
            foreach($archivos as $archivo){
                $archivo = [
                    'plantilla_detalle_id' => $archivo['plantilla_detalle_id'],
                    'dataFiel' => 'df_' . $archivo['plantilla_detalle_id'],
                    'files' => explode(',', $archivo['valor'])
                ];

                $archivos_array = array_merge($archivos_array, [$archivo]);
            }
        
            $archivos_ftp = [];
            if(!empty($archivos_array)){
                foreach($archivos_array as $archivo){
                    $archivo['files'] = ArchivosFTP::whereIn('archivo_ftp_id', $archivo['files'])
                        ->where('baja', 0)
                        ->get()
                        ->toArray();
                    $archivos_ftp[] = $archivo;
                }
            }

            $alimento['archivos_ftp'] = $archivos_ftp;
            $alimentos[$key] = $alimento;
        }

        return response()->json(
            $alimentos
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $data = $request->json()->all();
            $plantilla_encabezado_id = $data['plantilla_encabezado_id'];
            $plantilla_encabezado = PlantillaEncabezados::findOrFail($plantilla_encabezado_id)->toArray();
            $clave_automatica = $plantilla_encabezado['clave_automatica'];
            $clave = $data['clabe'];

            if($clave_automatica == 1){
                $clave = Alimentos::where('baja', 0)
                    ->where('plantilla_encabezado_id', $plantilla_encabezado_id)
                    ->max('clave');
                    $clave = (is_null($clave) ? : $clave) + 1;
            }

            $alimento = Alimentos::create(
                [
                    'clave' => $clave,
                    'descripcion' => $data['descripcion'],
                    'plantilla_encabezado_id' => $plantilla_encabezado_id,
                    'baja' => 0,
                ]
            );

            $alimento_id = $alimento->alimento_id;
            foreach($data['datos_seccion'] as $seccion){
                foreach($seccion['datos_form']['data'] as $key => $detalle){
                    $nuevo_detalle = AlimentosDetalles::create(
                        [
                            'alimento_id' => $alimento_id,
                            'plantilla_seccion_id' => $seccion['plantilla_seccion_id'],
                            'plantilla_detalle_id' => $detalle['key'],
                            'valor' => $detalle['value'],
                            'baja' => 0,
                            'archivo_ftp_id' => $detalle['archivo_ftp_id']
                        ]
                    );
                }
            }

            DB::commit();

            return response()->json(
                [
                    'message' => 'Alimento creada con éxito',
                    'metodologia' => $alimento_id,
                    'clabe' => $clave,
                ], 201
            );
        }catch (\Exception $e){
            DB::commit();
            
            return response()->json(
                [
                    'message' => 'Error al guardar',
                    'error' => $e
                ], 500
                );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Alimentos $alimentos)
    {
        $alimento = Alimentos::findOrFail($alimentos['alimento_id']);

        return response()->json(
            [
                'registro' => $alimento
            ], 200
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alimentos $alimentos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try{
            $alimento_id = $id;
            $alimento = Alimentos::findOrFail($alimento_id);
            $data = $request->json()->all();
            $plantilla_encabezado_id = $data['plantilla_encabezado_id'];
            $plantilla_encabezado_aterior_id = $alimento->plantilla_encaabezado_id;
            $clave = $data['clave'];

            if($plantilla_encabezado_id != $plantilla_encabezado_aterior_id){
                $plantilla_encabezado = PlantillaEncabezados::findOrFail($plantilla_encabezado_id)->toArray();
                $clave_automatica = $plantilla_encabezado['clave_automatica'];

                if($clave_automatica == 1){
                    $clave = Alimentos::where('baja', 0)
                        ->where('plantilla_encabezado_id', $plantilla_encabezado_id)
                        ->max('clave');

                    $clave = (is_null($clave) ? 0 : $clave) + 1;
                }
            }

            $alimento->update(
                [
                    'clave' => $clave,
                    'plantilla_encabezado_id' => $plantilla_encabezado_id,
                ]
                );
            
            AlimentosDetalles::where('alimento_id', $alimento_id)
                ->where('baja', 0)
                ->update(
                    [
                        'baja', 0
                    ]
                    );
                
            foreach($data['datos_seccion'] as $seccion){
                foreach($seccion['datos_form']['data'] as $key => $detalle){
                    $nuevo_detalle = AlimentosDetalles::create(
                        [
                            'alimento_id' => $alimento_id,
                            'plantilla_seccion_id' => $seccion['plantilla_seccion_id'],
                            'plantilla_detalle_id' => $seccion['plantilla_detalle_id'],
                            'valor' => $detalle['value'],
                            'baja' => 0,
                            'archivo_ftp_id' => $detalle['archivo_ftp_id'],
                        ]
                        );
                }
            }

            DB::commit();

            return response()->json(
                [
                    'message' => 'Aliemnto fue actualizado con éxito'
                ],200
            );
        }catch (\Exception $e){
            DB::rollBack();

            return response()->json(
                [
                    'message' => 'Error al actualizar',
                    'error' => $e
                ], 500
            );
        }
    }

    /**
     * Update the status 'baja' to true or 1
     */

     public function baja(Alimentos $alimento){
        $alimento_down = Alimentos::findOrFail($alimento['alimento_id']);

        $alimento_down->update(['baja' => 1]);

        return response()->json(
            [
                'message' => 'alimentos dado de baja'
            ], 204);
     }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alimentos $alimentos)
    {
        $alimento_delete = Alimentos::findOrFail($alimentos['alimento_id']);

        if(!$alimento_delete){
            return response()->json(
                [
                    'message' => 'Alimento no encontrado'
                ], 404
            );
        }

        $alimento_delete->update(
            [
                'baja' => 1
            ]
        );

        return response()->json(
            [
                'message' => 'Eliminación éxitosa'
            ], 204
        );
    }
}
