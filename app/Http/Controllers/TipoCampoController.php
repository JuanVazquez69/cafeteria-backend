<?php

namespace App\Http\Controllers;

use App\Models\TipoCampo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use function Pest\Laravel\delete;
use function Pest\Laravel\json;

class TipoCampoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(TipoCampo::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a list newly created resource in storage
     */

     public function storeList(Request $request){

        foreach ($request->all() as $registro){
            $campo = TipoCampo::create([
                'nombre' => $registro['nombre'],
                'valor' => $registro['valor'],
                'baja' => 0
            ]);
        }

        return response()->json([
            'message' => 'Lista de campos creada'
        ]);
     }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tipoCampo = TipoCampo::create(
            [
                'nombre' => $request['nombre'],
                'valor' => $request['valor'],
                'baja' => 0
            ]
        );

        return response()->json([
            'message' => 'Tipo campo creado',
            'registro' => $tipoCampo,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoCampo $tipoCampo)
    {
        return response()->json([
            TipoCampo::findOrFail($tipoCampo['tipo_campo_id'])
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoCampo $tipoCampo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $tipoCampo = TipoCampo::findOrFail($id);
        $tipoCampo->update($request->all());
        
        return response()->json([
            'actualizacion' => $tipoCampo,
        ], 200);
    }

    /**
     * Update the status baja to true
     */

     public function baja(Request $request){
        $tipoCampo = TipoCampo::findOrFail($request['tipo_campo_id']);
        $tipoCampo->update(['baja' => 1]);

        return response()->json(
            [
                'message' => 'Tipo de campo dado de baja'
            ], 204);
     }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoCampo $tipoCampo)
    {
        TipoCampo::finOrFail($tipoCampo['tipo_campo_id'])->delete();

        return response()->json([
            'message' => 'Eliminación exitosa',
        ], 204);
    }
}
