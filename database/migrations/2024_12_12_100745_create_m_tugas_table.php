<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMTugasTable extends Migration
{
    public function up()
    {
        Schema::create('m_tugas', function (Blueprint $table) {
            $table->id('id');
            $table->string('tugas_nama');
            $table->date('tanggal_akhir');
            $table->date('tanggal_mulai');
            $table->integer('jam_kompen');
            $table->integer('sdm_id');
            $table->integer('tugas_id');
            $table->string('tugas_kode');
            $table->boolean('status_dibuka');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('m_tugas');
    }
}
