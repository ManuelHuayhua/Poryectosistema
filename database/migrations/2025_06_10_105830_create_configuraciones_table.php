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
    Schema::create('configuraciones', function (Blueprint $table) {
        $table->id();
        $table->string('tipo_origen'); // ej: 'prestamo'
        $table->decimal('interes', 8, 2); // porcentaje: 10.00
        $table->decimal('penalidad', 8, 2); // porcentaje: 20.00
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
        Schema::dropIfExists('configuraciones');
    }
};
