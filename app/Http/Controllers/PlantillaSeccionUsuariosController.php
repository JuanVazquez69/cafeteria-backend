<?php

namespace App\Http\Controllers;

use App\Models\PlantillaSeccionUsuarios;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use function Pest\Laravel\json;

class PlantillaSeccionUsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(PlantillaSeccionUsuarios::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $plantilla_seccion_usuarios = PlantillaSeccionUsuarios::create(
            [
                'plantilla_seccion_id' => $request['plantilla_seccion_id'],
                'user_id' => $request['user_id'],
                'baja' => 0
            ]
        );

        return response()->json([
            'message' => 'Plantilla sección usuarios creada',
            'registro' => $plantilla_seccion_usuarios
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(PlantillaSeccionUsuarios $plantillaSeccionUsuarios)
    {
        return response()->json(
            [
                'registro' => PlantillaSeccionUsuarios::findOrFail($plantillaSeccionUsuarios['plantilla_seccion_usuarios_id']),
            ], 200
            );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PlantillaSeccionUsuarios $plantillaSeccionUsuarios)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $plantilla_seccion_usuarios = PlantillaSeccionUsuarios::findOrFail($id);
        $plantilla_seccion_usuarios->update($request->all());

        return response()->json(
            [
                'registro' => $plantilla_seccion_usuarios,
            ], 200
        );
    }

     /**
     * Update the status 'baja' to true or 1
     */

     public function baja(PlantillaSeccionUsuarios $plantillaSeccionUsuarios){
        $plantilla_seccion_usuarios_down = PlantillaSeccionUsuarios::findOrFail(
            $plantillaSeccionUsuarios['tipo_contacto_id']
        );
        $plantilla_seccion_usuarios_down->update(['baja' => 1]);

        return response()->json(
            [
                'message' => 'Plantilla sección usuarios dado de baja'
            ], 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlantillaSeccionUsuarios $plantillaSeccionUsuarios)
    {
        PlantillaSeccionUsuarios::findOrFail($plantillaSeccionUsuarios['plantilla_seccion_usuarios_id'])->delete();

        return response()->json(
            [
                'message' => 'Eliminación exitosa',
            ], 204
        );
    }
}
