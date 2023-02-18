<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 70);
            $table->text('descripcion')->nullable();
            $table->float('precio', 10, 2)->default(0);
            $table->integer('stock')->default(0);
            $table->string("imagen")->nullable();
            $table->boolean("estado")->default(1);

            $table->bigInteger("categoria_id")->unsigned();
            $table->foreign("categoria_id")->references("id")->on("categorias");

            $table->bigInteger('proveedor_id')->unsigned();
            $table->foreign("proveedor_id")->references('id')->on("proveedors"); // relacion

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
