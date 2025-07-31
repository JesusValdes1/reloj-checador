<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecadorRegistrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checador_registros', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('checador_id');
            $table->unsignedInteger('empleado_id');
            $table->boolean('entrada')->default(0);
            $table->dateTime('fecha');
            $table->timestamps();

            $table->foreign('checador_id')->references('id')->on('checadores');
            $table->foreign('empleado_id')->references('id')->on('empleados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checador_registros');
    }
}
