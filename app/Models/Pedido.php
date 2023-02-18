<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $table = 'pedidos';

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
        return $this->belongsToMany(Producto::class)->withPivot(["cantidad"]);
    }
}
