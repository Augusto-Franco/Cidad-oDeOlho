<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeputadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deputados', function (Blueprint $table) {
            $table->string('id');
            $table->string('nome');
            $table->string('nomeServidor');
            $table->string('partido');
            $table->string('endereco');
            $table->string('telefone');
            $table->string('fax');
            $table->string('email');
            $table->string('atividadeProfissional');
            $table->string('naturalidadeMunicipio');
            $table->string('naturalidadeUf');
            $table->string('dataNascimento');
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
        Schema::dropIfExists('deputados');
    }
}