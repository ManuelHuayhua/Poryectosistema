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
    Schema::create('prestamos', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('user_id'); // Relación con la tabla users
        $table->unsignedInteger('numero_prestamo'); // Número secuencial por usuario

        $table->decimal('monto', 10, 2); // Monto solicitado
        $table->decimal('interes', 5, 2)->default(0); // Porcentaje de interés

        $table->decimal('interes_pagar', 10, 2)->nullable(); // Monto en soles del interés base
        $table->decimal('interes_penalidad', 10, 2)->default(0); // Penalidad aplicada al interés por impago

     //   $table->decimal('penalidades_acumuladas', 10, 2)->default(0); // Penalidades acumuladas
     //   $table->decimal('total_pagar', 10, 2)->nullable(); // Total a pagar (monto + interés + penalidades)

        $table->date('fecha_inicio')->nullable(); // Fecha de aprobación
        $table->date('fecha_fin')->nullable();    // Fecha de vencimiento (28 días después)
        $table->date('fecha_pago')->nullable();   // Fecha de pago real

        $table->enum('estado', ['pendiente', 'aprobado', 'rechazado', 'pagado', 'renovado'])->default('pendiente');

        $table->text('descripcion')->nullable(); // Comentarios del admin

        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prestamos');
    }
};
