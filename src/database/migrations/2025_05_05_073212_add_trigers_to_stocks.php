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
        DB::unprepared('
        CREATE TRIGGER after_stock_insert AFTER INSERT ON stocks
        FOR EACH ROW
        BEGIN
             INSERT INTO history_stocks (actions, stocks_id, warehouse_id, old_stock, new_stock,product_id)
             VALUES ("INSERT", NEW.id, NEW.warehouse_id, NULL, NEW.stock, NEW.product_id);
        END
    ');

        DB::unprepared('
        CREATE TRIGGER after_stock_update AFTER UPDATE ON stocks
        FOR EACH ROW
        BEGIN
             INSERT INTO history_stocks (actions, stocks_id, warehouse_id, old_stock, new_stock,product_id)
             VALUES ("UPDATE", NEW.id, NEW.warehouse_id, OLD.stock, NEW.stock , NEW.product_id);
        END
    ');

        DB::unprepared('
        CREATE TRIGGER after_stock_delete BEFORE DELETE  ON stocks
        FOR EACH ROW
        BEGIN
             INSERT INTO history_stocks (actions, stocks_id, warehouse_id, old_stock, new_stock,product_id)
             VALUES ("DELETE ", OLD.id, OLD.warehouse_id, OLD.stock, NULL,OLD.product_id);
        END
    ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_stock_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS after_stock_update');
        DB::unprepared('DROP TRIGGER IF EXISTS after_stock_delete');
    }
};
