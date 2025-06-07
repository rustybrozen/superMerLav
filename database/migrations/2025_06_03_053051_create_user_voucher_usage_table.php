<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
    {
        Schema::create('user_voucher_usage', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('voucher_id')->constrained('vouchers');
            $table->integer('usage_count')->default(0);
            $table->timestamps();
            
            $table->unique(['user_id', 'voucher_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_voucher_usage');
    }
};
