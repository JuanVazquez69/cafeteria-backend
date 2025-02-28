<?php

namespace App\Http\Controllers;

use App\Models\PlantillaSecciones;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use function Pest\Laravel\json;

class PlantillaSeccionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'registros' => PlantillaSecciones::all(),
        ]);
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
        $plantillaSeccion = PlantillaSecciones::create([
            'plantilla_encabezado_id' => $request['plantilla_encabezado_id'],
            'orden' => $request['orden'],
            'nombre' => $request['nombre'],
            'descripcion' => $request['descripcion'],
            'created_at' => $request['created_at'],
            'updated_at' => $request['updated_at'],
            'baja' => $request['baja'],
        ]);

        return response()->json([
            'message' => 'Plantilla sección creada',
            'registro' => $plantillaSeccion,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(PlantillaSecciones $plantillaSecciones)
    {
        $plantila_seccion = PlantillaSecciones::findOrFail($plantillaSecciones['plantilla_seccion_id']);

        if(!$plantila_seccion){
            return response()->json([
                'message' => 'Plantilla sección no existe'
            ], 404);
        }
        
        return response()->json([
            'message' => 'Plantilla encontrada',
            'registro' => $plantila_seccion     
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PlantillaSecciones $plantillaSecciones)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $plantillaSecciones = PlantillaSecciones::findOrFail($id);
        $plantillaSecciones->update($request->all());

        return response()->json([
            'message' => 'Plantilla secciones a sido actualizada',
            'registro' => $plantillaSecciones,
        ], 200);
    }

    /**
     * Update the status 'baja' to true or 1
     */

     public function baja(PlantillaSecciones $plantillaSecciones){
        $plantillaSeccionesDown = PlantillaSecciones::findOrFail(
            $plantillaSecciones['plantilla_secciones_id']
        );
        $plantillaSeccionesDown->update(['baja' => 1]);

        return response()->json(
            [
                'message' => 'Plantilla secciones dada de baja'
            ], 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlantillaSecciones $plantillaSecciones)
    {
        PlantillaSecciones::findOrFail($plantillaSecciones['tipo_contacto_id']);

        return response()->json([
            'message' => 'Eliminación exitosa'
        ], 204);
    }
}
