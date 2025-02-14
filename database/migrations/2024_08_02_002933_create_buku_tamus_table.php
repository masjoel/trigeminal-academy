<?php

use App\Models\Artikel;
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
        Schema::create('buku_tamu', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->nullable();
            $table->string('nama');
            $table->string('kelamin');
            $table->integer('umur');
            $table->string('telepon')->nullable();
            $table->foreignId('provinsi_id')->constrained('provinsis');
            $table->foreignId('kabupaten_id')->constrained('kabupatens');
            $table->foreignId('kecamatan_id')->constrained('kecamatans');
            $table->foreignId('desa_id')->constrained('kelurahans');
            $table->string('pendidikan');
            $table->string('pekerjaan');
            $table->string('instansi')->nullable();
            $table->string('jabatan')->nullable();
            $table->text('perangkat_desa_id');
            $table->string('keperluan');
            $table->string('status')->default('pending');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku_tamu');
    }
};
