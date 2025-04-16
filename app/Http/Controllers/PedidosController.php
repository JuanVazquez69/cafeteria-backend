<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pedidos;
use App\Models\VWPedidosManager;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pedidos = VWPedidosManager::all();
        return $pedidos;
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
                'clave' => 0,
                'tipo_pago_id' => $request['tipo_pago_id'],
                'user_id' => $request['user_id'],
                'entrega_ubicacion_id' => $request['entrega_ubicacion_id'],
                'cantidad_articulos' => $request['cantidad_articulos'],
                'total' => $request['total'],
                'status' => 0,
                'baja' => 0
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

        $pedido = DB::select('CALL procedure_pedidos_usuario(?)', [$request['user_id']]);

        return $pedido;
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

     public function baja(Request $request){
        $pedido = Pedidos::findOrFail(
            $request['pedido_id']
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
