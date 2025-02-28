<?php

namespace App\Http\Controllers;

use App\Models\TipoContacto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TipoContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(TipoContacto::all());
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
        $tipoContacto = TipoContacto::create(
            [
                'clave' => $request['clave'],
                'tipo_contacto' => 'tipo_contacto',
                'baja' => 0
            ]
        );

        return response()->json([
            'message' => 'Tipo contacto creado',
            'registro' => $tipoContacto,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoContacto $tipoContacto)
    {
        return response()->json([
            TipoContacto::findOrFail($tipoContacto['tipo_contacto_id'])
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoContacto $tipoContacto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $tipoContacto = TipoContacto::findOrFail($id);
        $tipoContacto->update($request->all());

        return response()->json([
            $tipoContacto
        ], 200);
    }

    /**
     * Update the status 'baja' to true or 1
     */

    public function baja(TipoContacto $tipoContacto){
        $tipoContactoDown = TipoContacto::findOrFail(
            $tipoContacto['tipo_contacto_id']
        );
        $tipoContactoDown->update(['baja' => 1]);

        return response()->json(
            [
                'message' => 'Tipo contacto dado de baja'
            ], 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoContacto $tipoContacto)
    {
        TipoContacto::findOrFail($tipoContacto['tipo_contacto_id'])->delete();

        return response()->json([
            'message' => 'Eliminación exitosa'
        ], 204);
    }
}
