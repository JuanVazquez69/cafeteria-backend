<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ContenidoPedidos;
use Illuminate\Http\Request;

use function Pest\Laravel\json;

class ContenidoPedidosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(ContenidoPedidos::all());
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
        $contenido_pedido = ContenidoPedidos::create([
            'clave' => 0,
            'pedido_id' => $request['pedido_id'],
            'plantilla_detalle_id' => $request['plantilla_detalle_id'],
            'cantidad' => $request['cantidad'],
            'baja' => 0
        ]);

        return response()->json([
            'message' => 'Contenido Pedido creado',
            'registro' => $contenido_pedido
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        return response()->json([
            ContenidoPedidos::findOrFail($request['contenido_pedido_id'])
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
        $contenido_pedido = ContenidoPedidos::findOrFail($request['contenido_pedido_id']);
        $contenido_pedido->update($request->all());

        return response()->json([
            $contenido_pedido
        ], 200);
    }

    /**
     * Update the status 'baja' to true or 1
     */

     public function baja(ContenidoPedidos $contenidoPedidos) {
        $contenido_pedido = ContenidoPedidos::findOrFail($contenidoPedidos['contenido_pedido_id']);
        $contenido_pedido->update(['baja' => 1]);

        return response()->json([
            'message' => 'Contenido pedido dado de baja'
        ], 204);
     }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContenidoPedidos $contenidoPedidos)
    {
        ContenidoPedidos::findOrFail($contenidoPedidos['contenido_pedido_id'])->delete();

        return response()->json([
            'message' => 'Eliminación exitosa'
        ], 204);
    }
}
