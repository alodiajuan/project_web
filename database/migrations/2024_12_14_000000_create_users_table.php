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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('foto_profile');
            $table->string('nama');
            $table->integer('semester')->nullable();
            $table->unsignedBigInteger('id_kompetensi')->nullable();
            $table->unsignedBigInteger('id_prodi')->nullable();
            $table->enum('role', ['admin', 'dosen', 'tendik', 'mahasiswa']);
            $table->integer('alfa')->nullable();
            $table->integer('compensation')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('id_kompetensi')->references('id')->on('competence');
            $table->foreign('id_prodi')->references('id')->on('prodi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
    