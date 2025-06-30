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
        Schema::create('aportes', function (Blueprint $table) {
            $table->id();                              // id BIGINT UNSIGNED AUTO_INCREMENT
            $table->string('numero_cliente')->unique(); // Ej. “CLI000123”
            $table->string('nombre');                  // “Juan”
            $table->string('apellido');                // “Pérez”
            $table->timestamps();                      // created_at / updated_at
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aportes');
    }
};
