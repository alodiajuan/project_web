<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMKompenDetailTable extends Migration
{
    public function up()
    {
        Schema::create('m_kompen_detail', function (Blueprint $table) {
            $table->id('kompen_detail_id');
            $table->unsignedBigInteger('tugas_id');
            $table->unsignedBigInteger('mahasiswa_id');
            $table->string('progres_1');
            $table->string('progres_2');
            $table->foreign('mahasiswa_id')->references('mahasiswa_id')->on('m_mahasiswa');
            $table->foreign('tugas_id')->references('id')->on('m_tugas');
        });
    }

    public function down()
    {
        Schema::dropIfExists('m_kompen_detail');
    }
}
