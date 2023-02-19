<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $lista_categoria = Categoria::all();
        return response()->json($lista_categoria, 200);
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
}
