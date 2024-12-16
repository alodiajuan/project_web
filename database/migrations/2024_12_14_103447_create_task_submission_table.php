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
        Schema::create('task_submission', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_mahasiswa');
            $table->unsignedBigInteger('id_task');
            $table->unsignedBigInteger('id_dosen')->nullable();
            $table->enum('acc_dosen', ['terima', 'tolak'])->nullable();
            $table->string('file')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();

            $table->foreign('id_mahasiswa')->references('id')->on('users');
            $table->foreign('id_task')->references('id')->on('task');
            $table->foreign('id_dosen')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_submission');
    }
};
