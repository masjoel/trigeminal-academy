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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('seller_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('invoice')->nullable();
            $table->double('total_budget')->nullable();
            $table->double('total_discount')->nullable();
            $table->double('total_price')->nullable();
            $table->enum('payment_status', ['1', '2', '3', '4', '5'])->nullable()->default('1');
            $table->string('payment_url')->nullable();
            $table->text('delivery_address')->nullable();
            $table->string('shipper')->nullable();
            $table->double('shipping_cost')->nullable();
            $table->text('bukti_bayar')->nullable();
            $table->text('token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
