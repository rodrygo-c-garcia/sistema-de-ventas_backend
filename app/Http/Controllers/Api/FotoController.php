<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Foto;
use Illuminate\Http\Request;

class FotoController extends Controller
{

    public function index()
    {
        $fotos = Foto::all();
        return response()->json($fotos, 200);
    }

    public function store(Request $request)
    {
        // validar
        $request->validate([
            'id' => 'required|string|unique:fotos',
            'url' => 'required',
        ]);

        // guardar
        $imagen = new Foto();
        $imagen->id = $request->id;
        $imagen->url = $request->url;
        $imagen->save();

        return response()->json(['mensaje' => 'Imagen Registrada', 'data' => $imagen], 201);
    }
}
