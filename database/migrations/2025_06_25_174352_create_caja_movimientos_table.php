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
        Schema::create('caja_movimientos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('caja_periodo_id')
                  ->constrained('caja_periodo')
                  ->cascadeOnDelete();

            $table->decimal('monto', 10, 2);
            $table->decimal('saldo_resultante', 10, 2);
            $table->enum('tipo', ['ingreso', 'egreso']);
            $table->string('descripcion')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('caja_movimientos');
    }
};
