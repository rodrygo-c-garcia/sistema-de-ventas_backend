<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $customers = Cliente::paginate(5);
        return response()->json($customers, 200);
    }

    // funcion para guardar un registro de cliente
    public function store(Request $request)
    {
        $request->validateWithBag('cliente', [
            'nombre_completo' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clientes',
            'telefono' => 'required|integer|min:60000000|max:79999999',
            'nit' => 'required|integer|min:1000|max:9999',
            'direccion' => 'required|string|max:255',
        ]);

        Cliente::create([
            'nombre_completo' => $request->nombre_completo,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'nit' => $request->nit,
            'direccion' => $request->direccion,
        ]);

        return response()->json([
            "mensaje" => "Cliente creado con exito",
            "status" => 200
        ], 200);
    }
}
