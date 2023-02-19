<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos';

    public function categorias()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function proveedores()
    {

        return $this->belongsTo(Proveedor::class);
    }

    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class)->withPivot(["cantidad"]);
    }
}
