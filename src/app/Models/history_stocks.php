<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class history_stocks extends Model
{
    /** @use HasFactory<\Database\Factories\HistoryStocksFactory> */
    use HasFactory;
    protected $fillable = [
        'actions',
        'old_stock',
        'new_stock',
        'warehouse_id',
        'stocks_id',
        'created_at'
    ];

    public function warehouse()
    {
        return $this->belongsTo(warehouses::class);
    }

    public function stock()
    {
        return $this->belongsTo(stocks::class, 'stocks_id');
    }
}
