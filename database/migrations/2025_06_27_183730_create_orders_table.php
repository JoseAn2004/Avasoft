<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->decimal('total', 10, 2);

            // Estado del pedido: pendiente, pagado, en preparación, en camino, listo en tienda, entregado, cancelado
            $table->enum('estado', [
                'pendiente',
                'pagado',
                'en preparación',
                'en camino',
                'listo en tienda',
                'entregado',
                'cancelado'
            ])->default('pendiente');

            $table->timestamp('fecha')->useCurrent();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
