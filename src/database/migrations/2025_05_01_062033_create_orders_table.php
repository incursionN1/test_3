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

            /*
             * Таблица orders

                Поля:

                id - unsigned big integer, AI, pk

                customer - varchar(255) (имя клиента)

                created_at - timestamp

                completed at - timestamp

                warehouse_id - unsigned big integer, fk

                status - varchar(255) (“active”, “completed”, “canceled”)
             */
            $table->id();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('completed_at')->nullable();
            $table->unsignedBigInteger('warehouse_id');
            $table->string('customer',255);
            $table->enum('status', ['active', 'completed', 'canceled'])
                ->default('active');

            $table->foreign('warehouse_id')
                ->references('id')
                ->on('warehouses');

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
