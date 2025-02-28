<?php

namespace App\Http\Controllers;

use App\Models\AlimentosDetalles;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AlimentosDetallesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            [
                AlimentosDetalles::all(),
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
        $alimentos_detalles = AlimentosDetalles::create(
            [
                'alimento_id' => $request['alimento_id'],
                'plantilla_seccion_id' => $request['plantilla_seccion_id'],
                'valor' => $request['valor'],
                'archivo_ftp_id' => $request['archivo_ftp_id'],
                'baja' => 0
            ]
        );

        return response()->json(
            [
                'message' => 'Alimento detalles creados',
                'registro' => $alimentos_detalles
            ], 201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(AlimentosDetalles $alimentosDetalles)
    {
        return response()->json(
            [
                'registro' => AlimentosDetalles::findOrFail($alimentosDetalles['alimento_detalle_id']),
            ], 200
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AlimentosDetalles $alimentosDetalles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $alimentos_detalles = AlimentosDetalles::findOrFail($id);
        $alimentos_detalles->update(
            [
                'alimento_id' => $request['alimento_id'],
                'plantilla_seccion_id' => $request['plantilla_seccion_id'],
                'valor' => $request['valor'],
                'archivo_ftp_id' => $request['archivo_ftp_id'],
                'baja' => 0
            ]
        );

        return response()->json(
            [
                'registro' => $alimentos_detalles
            ], 200
        );
    }

    /**
     * Update the status 'baja' to true or 1
     */

     public function baja(AlimentosDetalles $alimentosDetalles){
        $alimentos_detalles = AlimentosDetalles::findOrFail($alimentosDetalles['alimento_detalle_id']);
        $alimentos_detalles->update(
            [
                'baja' => 1
            ]
        );

        return response()->json(
            [
                'message' => 'Alimetnos detalle dado de baja'
            ], 200
        );
     }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AlimentosDetalles $alimentosDetalles)
    {
        AlimentosDetalles::findOrFail($alimentosDetalles['alimento_detalle_id']);

        return response()->json(
            [
                'message' => 'Eliminación exitosa'
            ], 204
        );
    }
}
