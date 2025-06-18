<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
    Schema::create('tabla_intereses', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('user_id');           // Usuario que recibe el préstamo
        $table->unsignedBigInteger('prestamo_id');       // ID del préstamo (clave foránea)

        $table->decimal('meses_interes', 10, 2);
        $table->decimal('penalidad_interes', 10, 2);
        $table->decimal('pago_meses', 10, 2);
        $table->decimal('pago_interes', 10, 2);

        $table->timestamps();

        // Relaciones
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('prestamo_id')->references('id')->on('prestamos')->onDelete('cascade');

        // Opcional: índice para mejorar búsquedas combinadas
        $table->index(['user_id', 'prestamo_id']);
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tabla_intereses');
    }
};
