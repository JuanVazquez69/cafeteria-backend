<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EntregaUbicacion;
use Illuminate\Http\Request;

class EntregaUbicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(EntregaUbicacion::all());
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
        $ubicacion = EntregaUbicacion::create([
            'clave' => $request['clave'],
            'edificio' => $request['edificio'],
            'baja' => 0
        ]);

        return response()->json([
            'message' => 'Ubicaicon de entrega creada con exito',
            'registro' => $ubicacion
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            EntregaUbicacion::findOrFail($id)
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $ubicacion = EntregaUbicacion::findOrFail($request['entrga_ubicacion_id']);
        $ubicacion->update($request->all());

        return response()->json([
            $ubicacion
        ], 200);
    }

    /**
     * Update the status 'baja' to true or 1
     */

     public function baja(EntregaUbicacion $entrega_ubicacion){
        $entrega_ubicacion = EntregaUbicacion::findOrFail(
            $entrega_ubicacion['entrega_ubicacion_id']
        );
        $entrega_ubicacion->update(['baja' => 1]);

        return response()->json(
            [
                'message' => 'Ubicaion de entrega dado de baja'
            ], 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EntregaUbicacion $entrega_ubicacion)
    {
        EntregaUbicacion::findOrFail($entrega_ubicacion['entrega_ubicacion_id'])->delete();

        return response()->json([
            'message' => 'Eliminación eixtosa',
        ], 204);
    }
}
