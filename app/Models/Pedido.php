<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $table = 'pedidos';

    // Para la asignacion masiva de los campos
    protected $fillable = ['cod_factura', 'cliente_id', 'user_id', 'monto_total', 'utilidad', 'estado'];

    public function clientes()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function productos()
    {
        // le especicficamos que nuestra tabla relacion tiene una columna que es "cantidad"
        return $this->belongsToMany(Producto::class, 'producto_pedido')->withPivot(["cantidad"]);
    }
}
