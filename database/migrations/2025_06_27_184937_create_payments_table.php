<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id'); // Relación con el pedido
            $table->string('metodo')->default('yape'); // Ej: yape, plin, etc.
            $table->string('codigo_operacion')->nullable(); // Código del comprobante (manual)
            $table->string('imagen_voucher')->nullable(); // Ruta de la imagen del QR
            $table->timestamp('fecha_pago')->nullable(); // Fecha del pago
            $table->timestamps();

            // Clave foránea
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
