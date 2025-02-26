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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->string('nama', 100)->nullable();
            $table->string('slug', 100)->nullable();
            $table->text('alamat')->nullable();
            $table->string('telpon', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('photo', 100)->nullable();
            $table->text('keterangan')->nullable();
            $table->string('ktp', 50)->nullable();
            $table->string('npwp', 100)->nullable();
            $table->string('bank', 100)->nullable();
            $table->string('rekening', 100)->nullable();
            $table->enum('approval', ['pending', 'approved'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
