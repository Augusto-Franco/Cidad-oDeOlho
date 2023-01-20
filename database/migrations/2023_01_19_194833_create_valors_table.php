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
    Schema::create('valors', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_deputado');
        $table->foreign('id_deputado')->references('id')->on('deputados');
        $table->double('valorTotal');
        $table->string('nome');
        $table->integer('mes');
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
        Schema::dropIfExists('valors');
    }
};
