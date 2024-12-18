<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('task', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_dosen');
            $table->string('judul');
            $table->text('deskripsi');
            $table->integer('bobot');
            $table->integer('semester');
            $table->integer('kuota');
            $table->string('file')->nullable();
            $table->string('url')->nullable();
            $table->unsignedBigInteger('id_jenis');
            $table->enum('tipe', ['file', 'url']);
            $table->dateTime('deadline');
            $table->timestamps();

            $table->foreign('id_jenis')->references('id')->on('type_task');
            $table->foreign('id_dosen')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task');
    }
};
