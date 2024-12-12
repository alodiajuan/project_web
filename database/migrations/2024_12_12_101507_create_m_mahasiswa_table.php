<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMMahasiswaTable extends Migration
{
    public function up()
    {
        Schema::create('m_mahasiswa', function (Blueprint $table) {
            $table->id('mahasiswa_id');
            $table->string('mahasiswa_nama');
            $table->string('nim', 10);
            $table->string('username', 20);
            $table->enum('semester', ['1', '2', '3', '4', '5', '6', '7', '8']);
            $table->string('password');
            $table->string('kompetensi');
            $table->string('foto', 255)->nullable();
            $table->unsignedBigInteger('prodi_id');
            $table->unsignedBigInteger('kompetensi_id');
            $table->unsignedBigInteger('level_id');
            $table->foreign('prodi_id')->references('prodi_id')->on('m_prodi');
            $table->foreign('kompetensi_id')->references('kompetensi_id')->on('m_kompetensi');
            $table->foreign('level_id')->references('level_id')->on('m_level');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('m_mahasiswa');
    }
}
