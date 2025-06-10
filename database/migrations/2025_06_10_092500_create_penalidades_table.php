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
    Schema::create('penalidades', function (Blueprint $table) {
        $table->id();

        // Llaves compuestas hacia la tabla prestamos
        $table->unsignedBigInteger('user_id'); // viene de tabla users
        $table->unsignedInteger('numero_prestamo'); // secuencia por usuario
        $table->unsignedInteger('numero_penalizacion'); // penalización 1, 2, 3, etc.

        $table->decimal('suma_interes', 10, 2); // Total de intereses
        $table->decimal('interes_penalidad', 10, 2); // Penalidad actual
        $table->decimal('interes_debe', 10, 2); // Interés aún pendiente

        $table->timestamps();

        // Índice para consultas rápidas y validaciones
        $table->index(['user_id', 'numero_prestamo', 'numero_penalizacion']);

        // Relación con users
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        // Agrega esta única si quieres asegurar que no se repita penalización por préstamo
        $table->unique(['user_id', 'numero_prestamo', 'numero_penalizacion']);
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penalidades');
    }
};
