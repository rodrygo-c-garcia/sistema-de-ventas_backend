<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $lista_productos = Producto::all();
        return response()->json($lista_productos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'precio' => 'number',
            'stock' => 'number',
            'imagen' => 'required|image|max:2048'
        ]);

        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->stock = $request->stock;
        $producto->imagen = $request->imagen;
        $producto->estado = $request->estado;
        $producto->categoria_id = $request->categoria_id;
        $producto->proveedor_id = $request->proveedor_id;
        $producto->save();

        return response()->json(['mensaje' => 'Producto Registrado', 'data' => $producto], 201);
    }
}
