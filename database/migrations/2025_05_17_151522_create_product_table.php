<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('productName');
            $table->integer('productQuantity');
            $table->string('productDetails');
            $table->string('productCategory');
            $table->timestamps();
        });

        Schema::create('productSize', function (Blueprint $table) {
            $table->id();
            $table->foreignId('productID')->constrained('product')->onDelete('cascade');
            $table->foreignId('userID')->constrained('users')->onDelete('cascade');
            $table->string('prod_size');
            $table->string('prod_model')->nullable();
            $table->string('prod_price')->nullable();
        });

            Schema::create('complainsProductFeedback', function (Blueprint $table) {
                $table->id();
                $table->foreignId('prod_id')->constrained('product')->onDelete('cascade');
                $table->foreignId('userID')->constrained('users')->onDelete('cascade');
                $table->string('comment');
                $table->string('complainImage')->nullable();
                $table->integer('ratings');
                $table->timestamps();
            });

        Schema::create('cart', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prod_id')->constrained('product')->onDelete('cascade');
            $table->foreignId('userID')->constrained('users')->onDelete('cascade');
            $table->integer('quantity');
            $table->string('prod_size');
            $table->decimal('totalPrice', 10, 2);
            $table->timestamps();
        });

        Schema::create('orderHistory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prod_id')->constrained('product')->onDelete('cascade');
            $table->foreignId('userID')->constrained('users')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('totalPrice', 10, 2);
            $table->string('orderCode');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orderHistory');
        Schema::dropIfExists('cart');
        Schema::dropIfExists('complainsProductFeedback');
        Schema::dropIfExists('productSize');
        Schema::dropIfExists('product');
    }
};
