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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('instructor_id')->nullable();
            $table->string('instructor')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->double('size')->nullable();
            $table->text('description')->nullable();
            $table->double('budget')->nullable();
            $table->double('price')->nullable();
            $table->double('discount')->nullable();
            $table->double('stock')->nullable();
            $table->double('stock_min')->nullable();
            $table->boolean('in_stock')->default(true);
            $table->boolean('publish')->default(true);
            $table->string('level')->nullable()->default('pemula');
            $table->string('image_url')->nullable();
            $table->string('video_url')->nullable();
            $table->integer('video_duration')->nullable();
            $table->string('download_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
