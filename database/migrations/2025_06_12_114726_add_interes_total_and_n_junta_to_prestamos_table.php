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
        Schema::table('prestamos', function (Blueprint $table) {
          //  $table->decimal('interes_total', 10, 2)->nullable()->after('interes_acumulado');
            $table->integer('n_junta')->nullable()->after('descripcion');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prestamos', function (Blueprint $table) {
     //       $table->dropColumn('interes_total');
            $table->dropColumn('n_junta');
        });
    }
};
