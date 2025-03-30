<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pedidos;
use Illuminate\Http\Request;

class PedidosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Pedidos::all());
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
        $pedido = Pedidos::create(
            [
                //'clave' => $request['clave'],
                'tipo_pago_id' => $request['tipo_pago_id'],
                'user_id' => $request['user_id'],
                'cantidad_articulos' => $request['cantidad_articulos'],
                'total' => $request['total'],
            ]
        );


        $contenido_pedido = $pedido->contenidoPedido()->createMany($request['contenido_pedido']);



        return response()->json([
            'message' => 'Pedido creado',
            'pedido' => $pedido,
            'contenido' => $contenido_pedido
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        return response()->json([
            Pedidos::findOrFail($request['pedido_id'])
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
        $pedido = Pedidos::findOrFail($request['pedido_id']);
        $pedido->update($request->all());

        return response()->json([
            $pedido
        ], 200);
    }

    /**
     * Update the status 'baja' to true or 1
     */

     public function baja(Pedidos $pedidos){
        $pedido = Pedidos::findOrFail(
            $pedidos['pedido_id']
        );
        $pedido->update(['baja' => 1]);

        return response()->json(
            [
                'message' => 'Pedido dado de baja'
            ], 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedidos $pedido)
    {
        Pedidos::findOrFail($pedido['pedido_id'])->delete();

        return response()->json([
            'message' => 'Eliminación exitosa'
        ], 204);
    }
}
