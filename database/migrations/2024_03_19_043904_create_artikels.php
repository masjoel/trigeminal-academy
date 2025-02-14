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
        Schema::create('artikels', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('viewed')->default(0);
            $table->integer('favorit')->default(0);
            $table->integer('category_id')->default(0);
            $table->string('idkategori')->nullable();
            $table->datetime('tgl')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('excerpt')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_tags')->nullable();
            $table->string('jenis')->default('post');
            $table->enum('status', ['draft', 'pending review', 'rejected', 'published'])->default('published');
            $table->boolean('feature')->default(false);
            $table->boolean('onfokus')->default(false);
            $table->boolean('promo')->default(false);
            $table->string('foto_unggulan')->nullable();
            $table->integer('urut')->default(0);
            $table->datetime('expired_date')->nullable();
            $table->integer('expired_duration_day')->nullable();
            $table->string('availability_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artikels');
    }
};
