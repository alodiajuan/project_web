<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMKompetensiTable extends Migration
{
    public function up()
    {
        Schema::create('m_kompetensi', function (Blueprint $table) {
            $table->id('kompetensi_id');
            $table->string('kompetensi_nama');
            $table->string('deskripsi');
            $table->integer('mahasiswa_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('m_kompetensi');
    }
}
