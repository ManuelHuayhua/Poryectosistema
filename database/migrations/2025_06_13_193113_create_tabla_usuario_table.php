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
        Schema::create('tabla_usuario', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('prestamo_id'); // Relación directa al préstamo

            $table->unsignedInteger('numero_prestamo');

            $table->string('item')->nullable();
            $table->string('renovacion')->nullable();
            $table->string('junta')->nullable();

            $table->date('fecha_prestamos')->nullable();
            $table->date('fecha_pago')->nullable();

            $table->decimal('monto', 10, 2)->nullable();
            $table->decimal('interes', 10, 2)->nullable();
            $table->decimal('interes_porcentaje', 5, 2)->nullable();

            $table->text('descripcion')->nullable();
            $table->string('estado')->nullable();

            $table->timestamps();

            // Índices
            $table->index(['user_id', 'numero_prestamo']);
            $table->index('prestamo_id');

            // Relaciones
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('prestamo_id')->references('id')->on('prestamos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
    {
        Schema::dropIfExists('tabla_usuario');
    }
};
