<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(){
        return response()->json(User::all());
    }

    public function login(Request $request){
        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            throw ValidationException::withMessages([
                'email' => ['Las credenciales son incorrectas']
            ]);
        }

        return response()->json([
            'message' => 'Login correcto',
            'perfil' => $user->perfil_id, 
            'token' => $user->createToken('auth_token')->plainTextToken,
        ], 200);
    }

    public function store(Request $request){
        $usuario = User::create([
            'perfil_id' => $request['perfil_id'],
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => $request['password'],
            'baja' => 0
        ]); 

        $contactos = $usuario->contactos()->createMany($request['contactos']);
        
        
        return response()->json([
            'message' => 'Usuario creado exitosamente'
        ], 200);
    }

    public function show(Request $request){
        

        return response()->json([
            User::findOrFail()
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
