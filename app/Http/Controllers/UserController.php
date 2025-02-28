<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        return response()->json(User::all());
    }

    public function store(Request $request){
        $usuario = User::create([
            'perfil_id' => $request['perfil_id'],
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => $request['password'],
            'baja' => 0
        ]);
        
        return response()->json([
            'message' => 'Usuario creado exitosamente'
        ], 200);
    }

    public function show($id){
        return response()->json([
            User::findOrFail($id)
        ], 200);
    }

    public function update(Request $request, $id){
        $usuario = User::findOrFail($id);
        $usuario->update($request->all());
        return response()->json([
            $usuario
        ], 200);
    }

    public function baja($id){
        $usuario = User::findOrFail($id);
        $usuario->update(['baja' => 1]);
        return response()->json(
            [
                'message' => 'Usuario dado de baja'
            ], 204);
    }

    public function destroy($id){
        User::findOrFail($id)->delete();
        return response()->json(
            [
                'message' => 'Eliminación exitosa'
        ], 204);
    }
}
