<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        // retornamos los pedidos paginados con su cliente y el usuario
        $pedidos = Pedido::with('cliente', 'user')->paginate(10);
        return response()->json($pedidos, 200);
    }
}
