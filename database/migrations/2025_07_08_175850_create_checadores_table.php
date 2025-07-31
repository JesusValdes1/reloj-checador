<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checadores', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('ip', 20)->unique();
            $table->boolean('activo')->default(0);
            $table->string('nombre', 80)->unique();
            $table->tinyText('descripcion')->nullable();
            $table->string('ubicacion', 100);
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
        Schema::dropIfExists('checadores');
    }
}
