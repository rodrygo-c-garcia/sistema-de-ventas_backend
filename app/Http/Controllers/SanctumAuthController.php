<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SanctumAuthController extends Controller
{
    public function login(Request $request)
    {
        // validar datos
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // verificamos y obtenemos al usuario por su correco
        $user = User::where('email', $request->email)->first();
        // verificamos si existe el id y la contraseña del usuario en la BD
        if (isset($user->id) && Hash::check($request->password, $user->password)) {
            // creamos el token en formato de texto plano
            $token = $user->createToken("auth_token")->plainTextToken;
            return response()->json([
                "mensaje" => "Usuario Logueado",
                "access_token" => $token,
                "error" => false,
                'user' => $user
            ]);
        } else {
            return response()->json(["mensaje" => "Credenciales invalidas", "error" => true], 200);
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique|unique:users',
            'password' => 'required|confirmed',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        // encriptacion del password
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['mensaje' => 'Usuario Logueado', 'data' => $user], 201);
    }
}
