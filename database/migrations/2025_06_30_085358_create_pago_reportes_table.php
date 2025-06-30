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
        Schema::create('pago_reportes', function (Blueprint $table) {
            $table->id();

            // 🔗 Relaciones
            $table->foreignId('aporte_id')->constrained('aportes')->onDelete('cascade');
            $table->foreignId('caja_periodo_id')->constrained('caja_periodo')->onDelete('cascade');

            // 💰 Monto aportado
            $table->decimal('monto', 10, 2);

            // 📅 Fecha de pago (editable)
            $table->date('fecha_pago');

            $table->timestamps(); // created_at / updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pago_reportes');
    }
};
