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
        Schema::create('perusahaan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->string('nama_client', 50)->nullable();
            $table->string('nama_app', 50)->nullable();
            $table->string('versi_app', 30)->nullable();
            $table->string('desc_app', 250)->nullable();
            $table->string('alamat_client', 200)->nullable();
            $table->string('signature', 100)->nullable();
            $table->string('email', 200)->nullable();
            $table->string('phone', 100)->nullable();
            $table->string('twitter', 200)->nullable();
            $table->string('facebook', 200)->nullable();
            $table->string('youtube', 200)->nullable();
            $table->string('instagram', 200)->nullable();
            $table->string('logo', 250)->nullable();
            $table->string('image_icon', 250)->nullable();
            $table->string('mcad', 100)->nullable();
            $table->string('init', 100)->nullable();
            $table->string('bank', 150)->nullable();
            $table->string('footnot', 250)->nullable();
            $table->string('endpoint')->nullable();
            $table->tinyInteger('jdigit')->default(0);
            $table->tinyInteger('jdelay')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perusahaan');
    }
};
