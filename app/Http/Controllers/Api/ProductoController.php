<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $lista_productos = Producto::with('categoria')->get();
        return response()->json($lista_productos, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'stock' => 'required',
            'precio_compra' => 'required',
            'precio_venta' => 'required',
            //'imagen' => 'required|image|max:2048'
        ]);

        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->cod_barras = $request->cod_barras;
        $producto->precio_compra = $request->precio_compra;
        $producto->precio_venta = $request->precio_venta;
        $producto->precio_venta = $request->precio_venta;
        $utilidad = $request->precio_venta - $request->precio_compra;
        $producto->utilidad = $utilidad;
        $producto->stock = $request->stock;
        $producto->imagen = $request->imagen;
        $producto->categoria_id = $request->categoria_id;
        $producto->save();

        return response()->json(['mensaje' => 'Producto Registrado', 'data' => $producto], 201);
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::where('id', $id)->first();
        // Si existe el producto procedemos a guardar
        if ($producto) {
            $request->validate([
                'nombre' => 'required|required',
                'stock' => 'required',
                'precio_compra' => 'required',
                'precio_venta' => 'required',
            ]);

            $producto->nombre = $request->nombre;
            $producto->cod_barras = $request->cod_barras;
            $producto->precio_compra = $request->precio_compra;
            $producto->precio_venta = $request->precio_venta;
            $utilidad = $request->precio_venta - $request->precio_compra;
            $producto->utilidad = $utilidad;
            $producto->stock = $request->stock;
            $producto->categoria_id = $request->categoria_id;
            $producto->save();

            return response()->json(['mensaje' => 'Producto Modificado', 'data' => $producto], 201);
        }
        return response()->json(['mensaje' => 'El producto no existe'], 400);
    }

    public function destroy($id)
    {
        $producto = Producto::where('id', $id)->first();
        if ($producto) {
            $producto->delete();
            return response()->json(['mensaje' => 'Producto eliminado'], 204);
        }
        return response()->json(['mensaje' => 'El producto no se encuentra'], 400);
    }
}
