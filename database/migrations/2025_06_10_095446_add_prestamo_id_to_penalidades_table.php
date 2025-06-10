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
    Schema::table('penalidades', function (Blueprint $table) {
        $table->unsignedBigInteger('prestamo_id')->after('id');

        $table->foreign('prestamo_id')
              ->references('id')->on('prestamos')
              ->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
{
    Schema::table('penalidades', function (Blueprint $table) {
        $table->dropForeign(['prestamo_id']);
        $table->dropColumn('prestamo_id');
    });
}
};
