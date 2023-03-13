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
            'url' => 'required',
        ]);

        // guardar
        $imagen = new Foto();
        $imagen->id = $request->id;
        $imagen->url = $request->url;
        $imagen->delete_url = $request->delete_url;
        $imagen->save();

        return response()->json(['mensaje' => 'Imagen Registrada', 'data' => $imagen], 201);
    }

    public function update(Request $request, $id)
    {
        $imagen = Foto::where('id', $id)->first();

        if ($imagen) {
            // validar
            $request->validate([
                'url' => 'required',
            ]);

            // guardar
            $imagen->url = $request->url;
            $imagen->delete_url = $request->delete_url;
            $imagen->save();
            return response()->json(['mensaje' => 'Imagen Registrada', 'data' => $imagen], 201);
        }
        return response()->json(['mensaje' => 'Imagen No encontrada'], 400);
    }
}
