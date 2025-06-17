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
        Schema::table('users', function (Blueprint $table) {
            $table->string('apellido_paterno')->nullable()->after('name');
            $table->string('apellido_materno')->nullable()->after('apellido_paterno');
            $table->string('nacionalidad')->nullable()->after('apellido_materno');
            $table->string('sexo')->nullable()->after('nacionalidad');
            $table->string('estado_civil')->nullable()->after('sexo');
            $table->date('fecha_nacimiento')->nullable()->after('estado_civil');
            $table->string('telefono')->nullable()->after('fecha_nacimiento');
            $table->string('celular')->nullable()->after('telefono');
            $table->string('direccion')->nullable()->after('celular');
            $table->string('tipo_origen')->nullable()->after('direccion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'apellido_paterno',
                'apellido_materno',
                'nacionalidad',
                'sexo',
                'estado_civil',
                'fecha_nacimiento',
                'telefono',
                'celular',
                'direccion',
                'tipo_origen',
            ]);
        });
    }
};
