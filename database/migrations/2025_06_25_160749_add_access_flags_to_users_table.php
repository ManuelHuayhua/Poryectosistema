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
        Schema::table('users', function (Blueprint $table) {
            // Todas comienzan después de is_admin
            $table->boolean('inicio')->default(false)->after('is_admin');
            $table->boolean('usuarios')->default(false)->after('inicio');
            $table->boolean('des_contrato')->default(false)->after('usuarios');
            $table->boolean('configuracion')->default(false)->after('des_contrato');
            $table->boolean('ge_prestamo')->default(false)->after('configuracion');
            $table->boolean('ge_reportes')->default(false)->after('ge_prestamo');
            $table->boolean('grafica')->default(false)->after('ge_reportes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'inicio',
                'usuarios',
                'des_contrato',
                'configuracion',
                'ge_prestamo',
                'ge_reportes',
                'grafica',
            ]);
        });
    }
};
