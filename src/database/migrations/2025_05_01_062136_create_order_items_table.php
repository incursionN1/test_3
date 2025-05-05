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
        Schema::create('order_items', function (Blueprint $table) {
            /*
             * id - unsigned big integer, AI, pk

                order_id - unsigned big integer, fk

                product_id - unsigned big integer, fk

                count - integer
             */

            $table->id();
            $table->unsignedBigInteger('orders_id');
            $table->integer('count');
            $table->unsignedBigInteger('product_id');


            $table->foreign('orders_id')
                ->references('id')
                ->on('orders');


            $table->foreign('product_id')
                ->references('id')
                ->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
