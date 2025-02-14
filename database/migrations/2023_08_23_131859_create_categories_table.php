<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('parent')->default(0);
            $table->unsignedInteger('iduser');
            $table->unsignedInteger('urut')->default(0);
            $table->string('kategori', 255);
            $table->string('deskripsi', 255)->nullable();
            $table->string('slug', 255);
            $table->string('kategori_key', 255)->nullable();
            $table->string('belongs_to', 255)->nullable();
            $table->enum('status', ['publish', 'draft'])->default('publish');
            $table->string('foto', 255)->nullable();
            $table->string('ikon', 255)->nullable();
            $table->string('tipe', 30)->default('general');
            $table->enum('showtab', ['tidak', 'ya'])->default('tidak');
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('kategori_key');
            $table->index('urut');
            $table->index('belongs_to');
            $table->index('parent');
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};