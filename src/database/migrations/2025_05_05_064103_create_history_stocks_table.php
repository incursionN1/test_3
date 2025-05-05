<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('history_stocks', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->useCurrent();
            $table->string('actions', 15)->nullable();
            $table->integer('old_stock')->nullable();
            $table->integer('new_stock')->nullable();
            $table->unsignedBigInteger('warehouse_id');
            $table->unsignedBigInteger('stocks_id');
            $table->unsignedBigInteger('product_id');

            $table->foreign('warehouse_id')
                ->references('id')
                ->on('warehouses');

            $table->foreign('stocks_id')
                ->references('id')
                ->on('stocks');

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
        Schema::dropIfExists('history_stocks');
    }
};
