<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMSdmTable extends Migration
{
    public function up()
    {
        Schema::create('m_sdm', function (Blueprint $table) {
            $table->id('sdm_id');
            $table->string('sdm_nama');
            $table->string('nip', 18);
            $table->string('username', 20);
            $table->string('no_telepon');
            $table->string('password');
            $table->integer('prodi_id');
            $table->string('foto')->nullable();
            $table->integer('level_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('m_sdm');
    }
}
