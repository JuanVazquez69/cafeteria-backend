<?php

namespace App\Http\Controllers;

use App\Models\PlantillaDetalles;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlantillaDetallesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            [
                PlantillaDetalles::all()
            ]
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
        $plantilla_detalles = PlantillaDetalles::create(
            [
                'plantilla_seccion_id' => $request['plantilla_seccion_id'],
                'orden' => $request['orden'],
                'etiqueta' => $request['etiqueta'],
                'descripcion' => $request['descripcion'],
                'tipo_campo_id' => $request['tipo_campo_id'],
                'longitud' => $request['longitud'],
                'obligatorio' => $request['obligatorio'],
                'valor_default' => $request['valor_default'],
                'valor_minimo' => $request['valor_minimo'],
                'valo_maximo' => $request['valor_maximo'],
                'valor_ideal' => $request['valor_ideal'],
                'baja' => 0
            ]
        );

        return response()->json(
            [
                'message' => 'Plantilla detalles creada',
                'registro' => $plantilla_detalles
            ], 201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(PlantillaDetalles $plantillaDetalles)
    {
        return response()->json(
            [
                'registro' => PlantillaDetalles::findOrFail($plantillaDetalles['plantilla_detalle_id']),
            ], 200
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PlantillaDetalles $plantillaDetalles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $plantilla_detalle = PlantillaDetalles::findOrFail($id);
        $plantilla_detalle->update(
            [
                'plantilla_seccion_id' => $request['plantilla_seccion_id'],
                'orden' => $request['orden'],
                'etiqueta' => $request['etiqueta'],
                'descripcion' => $request['descripcion'],
                'tipo_campo_id' => $request['tipo_campo_id'],
                'longitud' => $request['longitud'],
                'obligatorio' => $request['obligatorio'],
                'valor_default' => $request['valor_default'],
                'valor_minimo' => $request['valor_minimo'],
                'valo_maximo' => $request['valor_maximo'],
                'valor_ideal' => $request['valor_ideal'],
                'baja' => 0
            ]
        );

        return response()->json(
            [
                'registro' => $plantilla_detalle
            ],200
        );
    }

    /**
     * Update the status 'baja' to true or 1
     */

    public function baja(PlantillaDetalles $plantillaDetalles){
        $plantilla_detalle = PlantillaDetalles::findOrFail($plantillaDetalles['plantilla_detalle_id']);
        $plantilla_detalle->update(
            [
                'baja' => 0
            ]
        );

        return response()->json(
            [
                'message' => 'Plantilla detalle dada de baja'
            ],200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlantillaDetalles $plantillaDetalles)
    {
        PlantillaDetalles::finOrFail($plantillaDetalles['plantilla_detalle_id'])->delete();

        return response()->json(
            [
                'message' => 'Eliminación exitosa'
            ], 204
        );
    }
}
