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
    Schema::create('caja_periodo', function (Blueprint $table) {
        $table->id();
        $table->decimal('monto_inicial', 10, 2);
        $table->decimal('saldo_actual', 10, 2)->default(0); // ← agregado aquí
        $table->date('periodo_inicio');
        $table->date('periodo_fin');
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
        Schema::dropIfExists('caja_periodo');
    }
};
