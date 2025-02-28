<?php

namespace App\Http\Controllers;

use App\Models\Contactos;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mockery\Matcher\Contains;

use function Pest\Laravel\json;

class ContactosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            [
                Contactos::all(),
            ]
        );
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
        $contacto = Contactos::create(
            [
                'clave' => $request['clave'],
                'user_id' => $request['user_id'],
                'tipo_contacto_id' => $request['tipo_contacto_id'],
                'contacto' => $request['contacto'],
                'baja' => 0
            ]
        );

        return response()->json(
            [
                'message' => 'Contacto creado',
                'registro' => $contacto
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Contactos $contactos)
    {
        return response()->json(
            [
                'registro' => Contactos::findOrFail($contactos['contacto_id']),
            ], 200
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contactos $contactos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $contacto = Contactos::findOrfail($id);
        $contacto->update(
            [
                'clave' => $request['clave'],
                'user_id' => $request['user_id'],
                'tipo_contacto_id' => $request['tipo_contacto_id'],
                'contacto' => $request['contacto'],
            ]
        );

        return response()->json(
            [
                'message' => 'Contacto actualizado',
                'registro' => $contacto
            ], 200
        );
    }

    /**
     * Update the status 'baja' to true or 1
     */

     public function baja(Contactos $contacto){
        $contactoDown = Contactos::findOrFail(
            $contacto['contacto_id']
        );
        $contactoDown->update(['baja' => 1]);

        return response()->json(
            [
                'message' => 'Contacto dado de baja'
            ], 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contactos $contactos)
    {
        Contactos::findOrFail($contactos['contacto_id']);

        return response()->json(
            [
                'message' => 'Eliminación exitosa'
            ], 204
        );
    }
}
