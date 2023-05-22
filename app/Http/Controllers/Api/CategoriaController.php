<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        return response()->json($categorias, 200);
    }

    public function store(Request $request)
    {
        // validar
        $request->validate([
            'nombre' => 'required|unique:categorias|max:50|min:3',
        ]);

        // guardar
        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->detalle = $request->detalle;
        $categoria->save();

        return response()->json(['mensaje' => 'Categoria Registrada', 'data' => $categoria], 201);
    }

    public function update(Request $request, $id)
    {
        $categoria = Categoria::where('id', $id)->first();

        if ($categoria) {
            $request->validate([
                'nombre' => 'required|max:50|min:3',
            ]);

            $categoria->nombre = $request->nombre;
            $categoria->detalle = $request->detalle;
            $categoria->save();

            return response()->json(['mensaje' => 'categoria modificada', 'data' => $categoria], 201);
        }
        return response()->json(['mensaje' => 'la categoria no existe'], 400);
    }

    public function destroy($id)
    {
        $categoria = Categoria::where('id', $id)->first();

        if ($categoria) {
            $categoria->delete();
            return response()->json(["mensaje" => "Categoria Eliminada"], 200);
        }
        return response()->json(["mensaje" => "No se encontro la categoria"], 404);
    }
}
