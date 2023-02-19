<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index()
    {
        $lista_proveedores = Proveedor::all();
        return response()->json($lista_proveedores, 2000);
    }

    public function store(Request $request)
    {
        // validar
        $request->validate([
            'nombre_completo' => 'required',
            'telefono' => 'required|numeric|integer',
            'correo_electronico' => 'required|email|unique:proveedors,email'
        ]);

        $proveedor = new Proveedor();
        $proveedor->nombre_completo = $request->nombre_completo;
        $proveedor->direccion = $request->direccion;
        $proveedor->telefono = $request->telefono;
        $proveedor->correo_electronico = $request->correo_electronico;
        $proveedor->save();

        return response()->json(['mensaje' => 'Proveedor Rgistrado', 'data' => $proveedor], 201);
    }
}
