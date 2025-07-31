<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('matricula', 10)->unique();
            $table->boolean('activo')->default(0);
            $table->string('nombre', 40);
            $table->string('apellido_paterno', 40);
            $table->string('apellido_materno', 40)->nullable();
            $table->string('correo', 100)->nullable();
            $table->string('foto', 100)->nullable();
            $table->string('area', 80);
            $table->string('puesto', 80);
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
        Schema::dropIfExists('empleados');
    }
}
