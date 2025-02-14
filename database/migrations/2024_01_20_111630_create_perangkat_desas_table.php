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
        Schema::create('perangkat_desas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->string('nik', 100)->nullable();
            $table->string('nama', 100)->nullable();
            $table->string('slug')->unique();
            $table->string('nip', 50)->nullable();
            $table->string('jabatan', 100)->nullable();
            $table->string('jabatan_tipe', 100)->default('Struktural');
            $table->string('status', 100)->default('draft');
            $table->tinyInteger('urut')->default(0);
            $table->text('deskripsi')->nullable();
            $table->string('avatar')->nullable();
            $table->string('kodedesa', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perangkat_desas');
    }
};
