<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    use HasFactory;
    protected $table = 'fotos';
    // asignación masiva para los atributos id y url
    // protected $fillable = ['id', 'url'];
    // public $incrementing = false;

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
