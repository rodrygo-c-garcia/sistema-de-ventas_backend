<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use NunoMaduro\Collision\Provider;

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
            'correo_electronico' => 'required|email'
        ]);

        $proveedor = new Proveedor();
        $proveedor->nombre_completo = $request->nombre_completo;
        $proveedor->direccion = $request->direccion;
        $proveedor->telefono = $request->telefono;
        $proveedor->correo_electronico = $request->correo_electronico;
        $proveedor->save();

        return response()->json(['mensaje' => 'Proveedor Registrado', 'data' => $proveedor], 201);
    }

    public function update(Request $request, $id)
    {
        $proveedor = Proveedor::where('id', $id)->first();

        if ($proveedor) {
            $proveedor->validate([
                'nombre_completo' => 'required',
                'telefono' => 'required|numeric|integer',
                'correo_electronico' => 'required|email'
            ]);

            $proveedor->nombre_completo = $request->nombre_completo;
            $proveedor->direccion = $request->direccion;
            $proveedor->telefono = $request->telefono;
            $proveedor->correo_electronico = $request->correo_electronico;
            $proveedor->save();

            return response()->json(['mensaje' => 'Proveedor Modificado', 'data' => $proveedor], 201);
        }
        return response()->json(['mensaje' => 'el proveedor no existe'], 400);
    }

    public function destroy($id)
    {
        $proveedor = Proveedor::where('id', $id)->first();
        if ($proveedor) {
            $proveedor->delete();
            return response()->json(['mensaje' => 'Proveedor eliminado'], 201);
        }
        return response()->json(['mensaje' => 'el proveedor no existe'], 400);
    }
}
