<?php

namespace App\Http\Controllers;

use App\Models\TipoPlantilla;
use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;

use function Pest\Laravel\json;

class TipoPlantillaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(TipoPlantilla::all());
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
        $tipoPlantilla = TipoPlantilla::create(
            [
                'clave' => $request['clave'],
                'tipo_plantilla' => $request['tipo_plantilla'],
                'baja' => 0
            ]
        );

        return response()->json([
            'message' => 'Tipo plantilla creada',
            'registro' => $tipoPlantilla,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoPlantilla $tipoPlantilla)
    {
        return response()->json(
            [
                TipoPlantilla::findOrFail($tipoPlantilla['tipo_plantilla_id'])
            ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoPlantilla $tipoPlantilla)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $tipoPlantilla = TipoPlantilla::findOrFail($id);
        $tipoPlantilla->update($request->all());

        return response()->json([
            $tipoPlantilla
        ], 200);
    }

    /**
     * Update status baja to true
     */

     public function baja(Request $request){
        $tipoPlantilla = TipoPlantilla::findOrFail($request['tipo_plantilla_id']);
        $tipoPlantilla->update(['baja' => 1]);

        return response()->json([
            'message' => 'Tipo plantilla ha sido de baja'
        ], 204);
     }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoPlantilla $tipoPlantilla)
    {
        TipoPlantilla::findOrFail($tipoPlantilla['tipo_plantilla_id'])->delete();

        return response()->json([
            'message' => 'Eliminación exitosa'
        ], 204);
    }
}
