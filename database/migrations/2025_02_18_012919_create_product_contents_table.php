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
        Schema::create('product_contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->integer('parent')->nullable();
            $table->string('title');
            $table->string('file_type')->nullable()->default('video');
            $table->string('video_url')->nullable();
            $table->double('duration')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            // cascade
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_contents');
    }
};
