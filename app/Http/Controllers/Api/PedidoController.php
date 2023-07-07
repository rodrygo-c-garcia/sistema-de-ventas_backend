<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    public function index()
    {
        // retornamos los pedidos paginados con su cliente y el usuario
        $pedidos = Pedido::with('cliente', 'user')->paginate(10);
        return response()->json($pedidos, 200);
    }

    public function store(Request $request)
    {
        // Validamos los datos que veamos mas convenientes e importantes
        $request->validateWithBag('pedido', [
            'cod_factura' => 'required|unique:pedidos',
            'cliente_id' => 'required',
            'productos' => 'required'
        ]);

        // usamos un try catch para capturar errores y verificar que sea exito el registro de errores
        try {
            // obtenemos el usuario actual
            $user = Auth::user();
            // Buscamos cliente en nuestra base de datos
            $cliente = Cliente::findOrFail($request->cliente_id);

            // Generamos el pedido con sus atributos
            $pedido = Pedido::create([
                'cod_factura' => $request->cod_factura,
                'cliente_id' => $cliente->id,
                'user_id' => $user->id,
                'monto_total' => $request->monto_total,
                'utilidad' => $request->utilidad,
                'estado' => 0
            ]);

            // Validar la cantidad de productos valido para su registro
            if (count($request->productos) > 0) {
                // recorremos cada producto de nuestro arreglo productos
                foreach ($request->productos as $prod) {
                    $productoId = $prod['producto_id'];
                    $cantidad = $prod['cantidad'];

                    // obtenemos y verificamos si el id del producto existe en nuestra base de datos
                    $producto = Producto::findOrFail($productoId);

                    // verificamos si la cantidad del pruducto es valido con el stock que tenemos
                    if ($producto->stock >= $cantidad) {
                        // Indicamos la relacion de muchos a muchos con los datos adicionales
                        $pedido->productos()->attach($productoId, ['cantidad' => $cantidad]);
                    } else {
                        return response()->json(
                            [
                                'menssage' => 'La cantidad del producto es mayor al stock',
                                'error' => true,
                                'status' => 400
                            ],
                            400
                        );
                    }
                }
            }

            // Completar pedido
            $pedido->estado = 2;
            $pedido->save();

            return response()->json([
                'message' => 'Pedido completado',
                'error' => false,
                'status' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => $e->getMessage(),
                    'error' => true,
                    'status' => 422
                ],
                422
            );
        }
    }
}
