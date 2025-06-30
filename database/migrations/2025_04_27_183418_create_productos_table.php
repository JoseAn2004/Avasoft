<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('slug')->unique();
            $table->string('descripcion_corta')->nullable();
            $table->decimal('precio', 10, 2);
            $table->decimal('precio_descuento', 10, 2)->nullable();
            $table->integer('stock');
            $table->string('imagen_principal')->nullable();
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->foreignId('tipo_producto_id')->nullable()->constrained('tipo_productos')->onDelete('set null');
            $table->foreignId('marca_id')->nullable()->constrained('marcas')->onDelete('set null');
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->boolean('destacado')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('productos');
    }
};
