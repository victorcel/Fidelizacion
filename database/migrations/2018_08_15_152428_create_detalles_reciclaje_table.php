<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetallesReciclajeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_reciclaje', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('reciclaje_id');
            $table->foreign('reciclaje_id')->references('id')->on('reciclajes');
            $table->unsignedInteger('producto_id');
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->string('descripcion','90');
            $table->unsignedInteger('puntos');
            $table->unsignedInteger('cantidad');
            $table->unsignedInteger('sub_total');
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
        Schema::dropIfExists('detalles_reciclaje');
    }
}
