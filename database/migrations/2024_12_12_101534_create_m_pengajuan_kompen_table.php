<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMPengajuanKompenTable extends Migration
{
    public function up()
    {
        Schema::create('m_pengajuan_kompen', function (Blueprint $table) {
            $table->id('pengajuan_kompen_id');
            $table->enum('status', ['diterima', 'ditolak', 'proses']);
            $table->unsignedBigInteger('kompen_id');
            $table->unsignedBigInteger('mahasiswa_id');
            $table->foreign('kompen_id')->references('kompen_id')->on('m_kompen');
            $table->foreign('mahasiswa_id')->references('mahasiswa_id')->on('m_mahasiswa');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('m_pengajuan_kompen');
    }
}
