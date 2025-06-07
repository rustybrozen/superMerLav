<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
            // User info - nullable for guest orders
            $table->foreignId('user_id')->nullable()->constrained('users');
            
            // Guest customer info (when user_id is null)
            $table->string('guest_name', 100)->nullable();
            $table->string('guest_email', 100)->nullable();
            $table->string('guest_phone', 20)->nullable();
            
            // Shipping address (for both registered and guest users)
            $table->string('shipping_address', 255);
            $table->string('shipping_city', 100);
            $table->string('shipping_province', 100);
            $table->string('shipping_postal_code', 20)->nullable();
            $table->text('shipping_notes')->nullable();
            
            // Order details
            $table->timestamp('order_date')->useCurrent();
            $table->integer('subtotal'); // Before discounts
            $table->integer('discount_amount')->default(0); // Voucher discount
            $table->integer('shipping_fee')->default(0);
            $table->integer('total_price'); // Final amount
            
            // Payment & Status
            $table->string('payment_method', 50)->nullable();
            $table->enum('payment_status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            $table->enum('order_status', ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');
            
            // Tracking
            $table->string('tracking_number', 100)->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            
            // Applied voucher info
            $table->string('voucher_code', 50)->nullable();
            
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['order_status', 'created_at']);
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};