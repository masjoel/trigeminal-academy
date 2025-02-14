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
        Schema::create('adpdd_induks', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('nama')->nullable();
            $table->string('gol_darah')->nullable();
            $table->string('gender')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('agama')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('pekerjaan_lain')->nullable();
            $table->string('status_kawin')->nullable();
            $table->string('hubungan')->nullable();
            $table->string('warganegara')->nullable();
            $table->string('slug')->nullable();
            $table->string('bacahuruf')->default('L')->nullable();
            $table->string('kk')->nullable();
            $table->string('alamat')->nullable();
            $table->string('telpon')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('dusun')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('jkn')->default('Tidak Memiliki')->nullable();
            $table->string('ibu')->nullable();
            $table->string('ayah')->nullable();
            $table->string('mutasi')->default('-')->nullable();
            $table->string('paspor')->nullable();
            $table->string('kitas')->nullable();
            $table->string('akte_kelahiran')->nullable();
            $table->date('tgl_catat')->nullable();
            $table->string('akseptor_kb')->nullable();
            $table->string('image')->nullable();
            $table->integer('iduser')->nullable();
            $table->string('iddesa')->nullable();
            $table->string('idkec')->nullable();
            $table->string('kcds')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adpdd_induks');
    }
};
