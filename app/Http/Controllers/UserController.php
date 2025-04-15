<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'user' => $user->user_id,
            'token' => $user->createToken('auth_token')->plainTextToken,
        ], 200);
    }

    public function logout(Request $request){
        // Revocar todos los tokens del usuario (Sanctum)
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Sesión cerrada exitosamente'
        ]);
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

    public function show($user_id){
        $usuario = User::with('contactos')->find($user_id);

        return $usuario;
    }

    public function update(Request $request, $id){
        DB::beginTransaction();

        try{
            $usuario = User::findOrFail($id);

            $updateData = [
                'name' => $request['name'],
                'email' => $request['email'],
            ];

            if($request->has('password')){
                $updateData['password'] = Hash::make($request->password);
            }
            
            $usuario->update($updateData);
            foreach ($request->contactos as $contactoData){
                if(isset($contactoData['contacto_id'])){
                    $update_contacto = $usuario->contactos()
                        ->where('contacto_id', $contactoData['contacto_id'])
                        ->firstOrFail();

                    $update_contacto->update($contactoData);
                }else{
                    $newContacto = $usuario->contactos()->create($contactoData);
                }
            }
            DB::commit();

            return response()->json([
                $usuario
            ], 200);

        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'Error al actualizar usuario',
                'error' => $e->getMessage()
            ], 500);
        }
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
