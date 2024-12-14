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
            $table->string('usename')->unique();
            $table->string('password');
            $table->string('foto_profile');
            $table->string('nama');
            $table->integer('semester');
            $table->unsignedBigInteger('id_kompetensi')->nullable();
            $table->enum('role', ['admin', 'dosen', 'tendik', 'mahasiswa']);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('id_kompetensi')->references('id')->on('competence');
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
