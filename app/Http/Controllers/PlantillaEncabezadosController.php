<?php

namespace App\Http\Controllers;

use App\Models\PlantillaEncabezados;
use App\Http\Controllers\Controller;
use App\Models\PlantillaDetalles;
use App\Models\PlantillaSecciones;
use App\Models\PlantillaSeccionUsuarios;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\type;

class PlantillaEncabezadosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /*
        $encabezados = PlantillaEncabezados::where('baja', 0)
            ->where('tipo_plantilla_id', $tipo_plantilla_id)
            ->get();
            */
        $encabezados = PlantillaEncabezados::get();

        foreach($encabezados as  $key_encabezado => $encabezado){
            $plantilla_encabezado_id = $encabezado->plantilla_encabezado_id;
            $encabezado->secciones = PlantillaSecciones::where('plantilla_encabezado_id', $plantilla_encabezado_id)
                ->where('baja', 0)
                ->get();
            foreach($encabezado->secciones as $key_tab => $tab){
                    $plantilla_seccion_id = $tab->plantilla_seccion_id;
                    $detalles = PlantillaDetalles::where('plantilla_seccion_id', $plantilla_seccion_id)
                        ->where('baja', 0)
                        ->get();
                    $encabezado->secciones[$key_tab]->detalles = $detalles->toArray();

                    $permisos = PlantillaSeccionUsuarios::where('plantilla_seccion_id', $plantilla_seccion_id)
                        ->where('baja', 0)
                        ->get();
                    
                    $encabezado->secciones[$key_tab]->permisos = array_column($permisos->toArray(), 'usuarios_id');
                }
                $encabezados[$key_encabezado] = $encabezado;
            }
            return $encabezados;
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
        //Iniciar la transacción
        DB::beginTRansaction();
        try{
            $data = $request->json()->all();

            //Guardar en PlantillaEncabezado
            $encabezado = PlantillaEncabezados::create([
                'clave' => $data['encabezado']['clave'],
                'nombre' => $data['encabezado']['nombre'],
                'descripcion' => $data['encabezado']['descripcion'],
                'baja' => 0,
                'tipo_plantilla_id' => $data['encabezado']['tipo_plantilla_id']
            ]);

            $plantilla_encabezado_id = $encabezado->plantilla_encabezado_id;

            //Guardar en PlantillaSeccion Y PlantillaDetalles
            foreach($data['secciones'] as $seccion){
                $nuevaSEccion = PlantillaSecciones::create([
                    'plantilla_encabezado_id' => $plantilla_encabezado_id,
                    'orden' => $seccion['orden'],
                    'nombre' => $seccion['nombre'],
                    'baja' => 0,
                    'descripcion' => $seccion['descripcion'],
                ]);

                $plantilla_seccion_id = $nuevaSEccion->plantilla_seccion_id;

                //SE insertan detalles de la sección
                foreach($seccion['detalles'] as $contenido){
                    $nuevosDetalles = PlantillaDetalles::create([
                        'plantilla_seccion_id' => $plantilla_seccion_id,
                        'orden' => (isset($contenido['orden']) ? $contenido['orden'] : 0),
                        'etiqueta' => (isset($contenido['etiqueta']) ? $contenido['etiqueta'] : ''),
                        'descripcion' => (isset($contenido['descripcion']) ? $contenido['descripcion'] : ''),
                        'tipo_campo_id' => (isset($contenido['tipo_campo_id']) ? $contenido['tipo_campo_id'] : ''),
                        'longitud' => (isset($contenido['longitud']) ? $contenido['longitud'] : 0),
                        'obligatorio' => (isset($contendio['obligatorio']) ? $contendio['obligatorio'] : 0),
                        'valor_default' => (isset($contendio['valor_default']) ? $contendio['valor_defult'] : ''),
                        'valor_minimo' => (isset($contenido['valor_minimo']) ? $contenido['valor_minimo'] : ''),
                        'valor_maximo' => (isset($contenido['valor_maximo']) ? $contenido['valor_maximo'] : ''),
                        'valor_ideal' => (isset($contendio['valor_ideal']) ? $contendio['valor_ideal'] : ''),
                        'baja' => 0
                    ]);
                }

                /*Se insertan permisos de la seccion
                $permisos = $seccion['permisos'];
                foreach($permisos as $key => $permiso){
                    PlantillaSeccionUsuarios::create([
                        'plantilla_seccion_id' => $plantilla_seccion_id,
                        'user_id' => $permiso,
                        'baja' => 0
                    ]);
                }
                */
            }
            //Confirmar la transacción
            DB::commit();

            return response()->json([
                'message' => 'plantilla fue creada con exito',
            ], 201);
            
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'Error al guardar la plantilla',
                'error' => $e
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PlantillaEncabezados $plantillaEncabezados)
    {
        return response()->json([
            'registro' => PlantillaEncabezados::findOrFail($plantillaEncabezados['plantilla_encabezado_id'])
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PlantillaEncabezados $plantillaEncabezados)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PlantillaEncabezados $plantillaEncabezados)
    {
        //Iniciar la transacción}
        DB::beginTransaction();
        try{
            $data = $request->json()->all();

            $plantilla_encabezado_id = $data['encabezado']['plantilla_encabezado_id'];
            $encabezado = PlantillaEncabezados::findOrFail($plantilla_encabezado_id);
            
            $encabezado->update($data['encabezado']);
            $encabezado->save();

            //Se consultan las secciones anteriores
            $secciones_originales = PlantillaSecciones::where('plantilla_encabezado_id', $plantilla_encabezado_id)
                ->where('baja', 0)
                ->get();

            $secciones_originales_id = array_column($secciones_originales->toArray(), 'plantilla_seccion_id');
            $secciones_nuevas_id = array_column($data['secciones'], 'plantilla_seccion_id');
            $secciones_eliminadas = array_diff($secciones_originales_id, $secciones_nuevas_id);

            //Se dan de baja las las secciones y sus detalles
            foreach ($secciones_eliminadas as $key => $seccion_eliminada){
                PlantillaDetalles::where('plantilla_seccion_id', $seccion_eliminada)
                    ->update(['baja' => 1]);
                PlantillaSecciones::where('plantilla_seccion_id', $seccion_eliminada)
                    ->update(['baja' => 1]);
            }

            foreach ($data['secciones'] as $key => $seccion){
                $nuevos_detalles_seccion = [];
                $seccion_nueva = false;
                $plantilla_seccion_id = null;

                if(!isset($seccion['plantilla_seccion_id'])){
                    $seccion_nueva = true;
                }else{
                    $plantilla_seccion_id = $seccion['plantilla_seccion_id'];

                    //Se modifica la sección
                    $seccion_index = array_search($plantilla_seccion_id, $secciones_originales_id);
                    $secciones_originales[$seccion_index]['orden'] = $seccion['orden'];
                    $secciones_originales[$seccion_index]['nombre'] = $seccion['nombre'];
                    $secciones_originales[$seccion_index]['descripcion'] = $seccion['descripcion'];
                    $secciones_originales[$seccion_index]->save();

                    //Se busca la sección y se actualiza
                    $contenido_originales = PlantillaDetalles::where('plantilla_seccion_id', $plantilla_seccion_id)
                        ->where('baja', 0)
                        ->get();
                    $contenido_originales_id = array_column($contenido_originales->toArray(), 'plantilla_detalle_id');
                    $contenido_nuevas_id = array_column($seccion['detalles'], 'id');
                    $contenido_eliminados = array_diff($contenido_originales_id, $contenido_nuevas_id);

                    //Eliminar detalles eliminados
                    foreach ($contenido_eliminados as $key => $contenido){
                        $contenido_index  = array_search($contenido['id'], $contenido_originales_id);
                        if($contenido_index !== false){
                            $contenido_originales[$contenido_index]['orden'] = (isset($contenido['orden']) ? $contenido['orden'] : 0);
                            $contenido_originales[$contenido_index]['etiqueta'] = (isset($contenido['etiqueta']) ? $contenido['etiqueta'] : "");
                            $contenido_originales[$contenido_index]['descripcion'] = (isset($contenido['descripcion']) ? $contenido['descripcion'] : "");
                            $contenido_originales[$contenido_index]['tipo_campo_id'] = (isset($contenido['tipo_campo_id']) ? $contenido['tipo_campo_id'] : "");
                            $contenido_originales[$contenido_index]['longitud'] = (isset($contenido['longitud']) ? $contenido['longitud'] : 0);
                            $contenido_originales[$contenido_index]['obligatorio'] = (isset($contenido['obligatorio']) ? $contenido['obligatorio'] : 0);
                            $contenido_originales[$contenido_index]['valor_default'] = (isset($contenido['valor_default']) ? $contenido['valor_default'] : "");
                            $contenido_originales[$contenido_index]['valor_minimo'] = (isset($contenido['valor_minimo']) ? $contenido['valor_minimo'] : "");
                            $contenido_originales[$contenido_index]['valor_maximo'] = (isset($contenido['valor_maximo']) ? $contenido['valor_maximo'] : "");
                            $contenido_originales[$contenido_index]['valor_ideal'] = (isset($contenido['valor_ideal']) ? $contenido['valor_ideal'] : "");
                            $contenido_originales[$contenido_index]['baja'] = 0;
                            $contenido_originales[$contenido_index]->save();
                        }else{
                            $contenido['id'] = null;
                            $nuevos_detalles_seccion[] = $contenido;
                        }
                    }
                }
                if($seccion_nueva){
                    //Se inserta la sección
                    $nuevaSeccion = PlantillaSecciones::create([
                        'plantilla_encabezado_id' => $plantilla_encabezado_id,
                        'orden' => $seccion['orden'],
                        'nombre' => $seccion['nombre'],
                        'descripcion' => $seccion['descripcion'],
                        'baja' => 0
                    ]);
                    $plantilla_seccion_id = $nuevaSeccion->plantila_seccion_id;
                    $nuevos_detalles_seccion = $seccion['detalles'];
                }
                foreach($nuevos_detalles_seccion as $key => $contenido){
                    $nuevosDetalles = PlantillaDetalles::create([
                        'plantilla_seccion_id' => $plantilla_seccion_id,
                        'orden' => (isset($contenido['orden']) ? $contenido['orden'] : 0),
                        'etiqueta' => (isset($contenido['etiqueta']) ? $contenido['etiqueta'] : ""),
                        'descripcion' => (isset($contenido['descripcion']) ? $contenido['descripcion'] : ""),
                        'tipo_campo_id' => (isset($contenido['tipo_campo_id']) ? $contenido['tipo_campo_id'] : ""),
                        'longitud' => (isset($contenido['longitud']) ? $contenido['longitud'] : 0),
                        'obligatorio' => (isset($contenido['obligatorio']) ? $contenido['obligatorio'] : 0),
                        'valor_default' => (isset($contenido['valor_default']) ? $contenido['valor_default'] : ""),
                        'valor_minimo' => (isset($contenido['valor_minimo']) ? $contenido['valor_minimo'] : ""),
                        'valor_maximo' => (isset($contenido['valor_maximo']) ? $contenido['valor_maximo'] : ""),
                        'valor_ideal' => (isset($contenido['valor_ideal']) ? $contenido['valor_ideal'] : ""),
                        'baja' => 0,
                    ]);
                }
            }

            //Se insertan permisos de la sección
            PlantillaSeccionUsuarios::where('plantilla_seccion_id', $plantilla_seccion_id)
                ->where('baja', 0)
                ->update(['baja' => 1]);

            //$permisos = $seccion['permisos'];

            /*
            foreach($permisos as $key => $permisos){
                PlantillaSeccionUsuarios::create([
                    'plantilla_seccion_id' => $plantilla_seccion_id,
                    'user_id' => $permisos,
                    'baja' => 0
                ]);
            }*/

            //confirmar la transacción
            DB::commit();
            return response()->json(
                [
                    'message' => 'Plantilla actualizada con exito'
                ], 200);
                
        }catch(\Exception $e){
            //Revertir la transacción en caso de error
            DB::rollBack();
            return response()->json(
                [
                    'message' => 'Error al aguardar cambios'
                ], 500);
        }
    }

    /**
     * Update baja to false
     */

     public function alta(Request $request){
        $encabezado = PlantillaEncabezados::findOrFail($request['plantilla_encabezado_id']);

        if(!$encabezado)
            return response()->json(['message' => 'Encabezado no encontrado']);

        if($encabezado->baja == 0){
            return response()->json(['message' => 'Encabezado ya dado de alta']);
        }

        $encabezado->update(['baja' => 0]);

        return response()->json([
            'message' => 'Encabezado dado de alta'
        ], 204);
     }

    /**
     * Update baja to true
     */

     public function baja(Request $request){
        $encabezado = PlantillaEncabezados::findOrFail($request['plantilla_encabezado_id']);

        if(!$encabezado)
            return response()->json(['message' => 'Encabezado no encontrado']);

        if($encabezado->baja == 1){
            return response()->json(['message' => 'Encabezado ya dado de baja']);
        }

        $encabezado->update(['baja' => 1]);

        return response()->json([
            'message' => 'Encabezado dado de baja'
        ], 204);
     }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlantillaEncabezados $plantillaEncabezados)
    {
        $encabezado = PlantillaEncabezados::findOrFail($plantillaEncabezados['plantilla_encabezado_id'])->destroy();

        return response()->json([
            'message' => 'Eliminación exitosa',
        ], 204);
    }
}
