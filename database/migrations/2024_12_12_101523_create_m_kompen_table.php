<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMKompenTable extends Migration
{
    public function up()
    {
        Schema::create('m_kompen', function (Blueprint $table) {
            $table->id('kompen_id');
            $table->enum('status', ['proses', 'diterima', 'ditolak']);
            $table->date('tanggal_kompen')->nullable();
            $table->text('chatbox')->nullable();
            $table->unsignedBigInteger('tugas_id')->nullable();
            $table->unsignedBigInteger('mahasiswa_id')->nullable();
            $table->foreign('mahasiswa_id')->references('mahasiswa_id')->on('m_mahasiswa');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('m_kompen');
    }
}
