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
        // obtemos los clientes paginados de 5 en 5
        $customers = Cliente::paginate(5);
        return response()->json($customers, 200);
    }

    public function searchCustomer(Request $request)
    {
        // Validamos que de que nuestro request tenga un campo llamado search
        $request->validate([
            'search' => 'nullable|string'
        ]);

        // obtenemos el termino de busqueda
        $searchTerm = '%' . $request->search . '%';

        // Verificamos si el campo search existe y si tiene un valor
        if ($request->has('search') && $request->filled('search')) {
            // Realizamos la consulta solo si el campo search tiene un valor
            $customersSearched = Cliente::where('nombre_completo', 'like', $searchTerm)
                ->orWhere('nit', 'like', $searchTerm)
                ->paginate(5);
        } else {
            // Si el campo search está vacío o no está presente, retornamos una respuesta vacía
            $customersSearched = collect();
        }

        return response()->json(['message' => 'Clientes encontrados', 'data' => $customersSearched], 200);
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
