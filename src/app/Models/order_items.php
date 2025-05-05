<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_items extends Model
{
    /** @use HasFactory<\Database\Factories\order_itemsFactory> */
    use HasFactory;
    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(orders::class);
    }

    public function product()
    {
        return $this->belongsTo(products::class);
    }
    protected $fillable = [
        'orders_id',
        'product_id',
        'count',
    ];
}
