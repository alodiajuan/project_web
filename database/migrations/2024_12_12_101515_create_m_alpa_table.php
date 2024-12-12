<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMAlpaTable extends Migration
{
    public function up()
    {
        Schema::create('m_alpa', function (Blueprint $table) {
            $table->id('alpha_id');
            $table->unsignedBigInteger('mahasiswa_id');
            $table->integer('total_alpha');
            $table->date('tanggal_alpha');
            $table->foreign('mahasiswa_id')->references('mahasiswa_id')->on('m_mahasiswa');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('m_alpa');
    }
}
