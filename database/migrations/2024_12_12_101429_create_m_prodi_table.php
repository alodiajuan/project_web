<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMProdiTable extends Migration
{
    public function up()
    {
        Schema::create('m_prodi', function (Blueprint $table) {
            $table->id('prodi_id');
            $table->string('prodi_kode', 20);
            $table->string('prodi_nama');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('m_prodi');
    }
}
