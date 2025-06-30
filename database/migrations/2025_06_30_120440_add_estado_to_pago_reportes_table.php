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
    public function up(): void
    {
        Schema::table('pago_reportes', function (Blueprint $table) {
            /* ▼ Elige una de las dos opciones: enum o string */

            // Opción A: enum (si tu BD lo soporta)
            $table->enum('estado', ['pendiente', 'pagado', 'anulado'])
                  ->after('fecha_pago')
                  ->default('pendiente');

            // ---O BIEN---

            // Opción B: string(20)
            // $table->string('estado', 20)->after('fecha_pago')->default('pendiente');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('pago_reportes', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
};
