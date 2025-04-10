<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Perfil;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    public function index(){
        return response()->json(Perfil::all());
    }

    public function store(Request $request){
        $perfil = Perfil::create(
            [
                'clave' => $request['clave'],
                'perfil' => $request['perfil'],
                'baja' => 0
            ]
        );

        return response()->json([
            'message' => 'Perfil creado',
            'registro' => $perfil,
        ], 201);
    }

    public function show($id){
        return response()->json([
            Perfil::findOrFail($id),
        ], 200);
    }

    public function update($id, Request $request){
        $perfil = Perfil::findOrFail($id);
        $perfil->update($request->all());
        return response()->json([
            $perfil,
        ], 200);
    }

    public function baja(Request $request){
        $perfil = Perfil::findOrFail($request['perfil_id']);
        $perfil->update(['baja' => 1]);
        return response()->json([
            'message' => 'Perfil dado de baja',
        ], 200);
    }

    public function destroy($id){
        Perfil::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
