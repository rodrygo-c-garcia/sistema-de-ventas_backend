<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    const REQUIRED_NUMERIC = 'required|numeric';

    public function index()
    {
        // especificamos las relacio.nes que tenemos en el modelo Producto categoria(), imagen()
        $productos = Producto::with(['categoria', 'imagen'])->get();
        return response()->json($productos, 200);
    }

    // Funcion para buscar productos
    public function searchProduct(Request $request)
    {
        $productos = [];
        if ($request->search != '') {
            $productos = Producto::where('nombre', 'like', '%' . $request->search . '%')
                ->orWhere('cod_barras', 'like', '%' . $request->search . '%')
                ->with(['categoria', 'imagen'])->get();
        }

        return response()->json(['mensaje' => 'Productos Encontrados', 'data' => $productos], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'stock' => self::REQUIRED_NUMERIC,
            'precio_compra' => self::REQUIRED_NUMERIC,
            'precio_venta' => self::REQUIRED_NUMERIC,
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
        $producto->imagen_id = $request->imagen_id;
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
                'nombre' => 'required',
                'stock' => self::REQUIRED_NUMERIC,
                'precio_compra' => self::REQUIRED_NUMERIC,
                'precio_venta' => self::REQUIRED_NUMERIC,
            ]);

            $producto->nombre = $request->nombre;
            $producto->cod_barras = $request->cod_barras;
            $producto->precio_compra = $request->precio_compra;
            $producto->precio_venta = $request->precio_venta;
            $utilidad = $request->precio_venta - $request->precio_compra;
            $producto->utilidad = $utilidad;
            $producto->stock = $request->stock;
            $producto->categoria_id = $request->categoria_id;
            $producto->imagen_id = $request->imagen_id;
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
