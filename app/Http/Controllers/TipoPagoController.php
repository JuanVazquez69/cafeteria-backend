<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TipoPago;
use Illuminate\Http\Request;

class TipoPagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(TipoPago::all());
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
        $tipoPago = TipoPago::create(
            [
                'clave' => $request['clave'],
                'tipo_pago' => $request['tipo_pago'],
                'baja' => 0
            ]
            );

            return response()->json([
                'message' => 'Tipo pago creado',
                'registro' => $tipoPago
            ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(
            [
                TipoPago::findOrFail($id)
            ], 200
        );
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
        $tipoPago = TipoPago::findOrFail($request['tipo_pago_id']);
        $tipoPago->update($request->all());

        return response()->json([
            $tipoPago
        ], 200);
    }

    /**
     * Update the status 'baja' to true or 1
     */

     public function baja(TipoPago $tipoPago){
        $tipopago = TipoPago::findOrFail(
            $tipoPago['tipo_pago_id']
        );
        $tipopago->update(['baja' => 1]);

        return response()->json(
            [
                'message' => 'Tipo pago dado de baja'
            ], 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoPago $tipago)
    {
        TipoPago::findOrFail($tipago['tipo_pago_id'])->delete();

        return response()->json([
            'message' => 'Eliminación exitosa'
        ], 204);
    }
}
