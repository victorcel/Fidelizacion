<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cedula')->unique();
            $table->string('Nombres','90');
            $table->string('apellidos','90');
            $table->string('direccion','190');
            $table->string('telefono', '20')->unique();
            $table->date('fechaNacimiento');
            $table->unsignedInteger('departamento_id');
            $table->foreign('departamento_id')->references('id')->on('departamentos');
            $table->unsignedInteger('municipio_id');
            $table->foreign('municipio_id')->references('id')->on('municipios');
            $table->string('corregimientos','90');
            $table->string('observacion','255');
            $table->string('email', '90')->unique();
            $table->enum('estado', ['Activo', 'Inactivo']);
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
        Schema::dropIfExists('clientes');
    }
}
