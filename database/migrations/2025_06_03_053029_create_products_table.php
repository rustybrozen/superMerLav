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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('short_desc', 100)->nullable();
            $table->text('long_desc')->nullable();
            $table->integer('price');
            $table->integer('quantity')->default(0);
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->string('image', 100)->default('assets/uploads/default.jpg');
            $table->integer('in_price')->nullable(); // Cost price
            $table->boolean('is_active')->default(true);
            $table->boolean('hot')->default(false);
            $table->timestamp('deleted_at')->nullable(); // For soft deletes
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
