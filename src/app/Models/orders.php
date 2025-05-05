<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    /** @use HasFactory<\Database\Factories\OrdersFactory> */
    use HasFactory;
    public $timestamps = false;
    public function warehouses()
    {
        return $this->belongsTo(warehouses::class, 'warehouse_id','id');
    }
    protected $fillable = [
        'customer',
        'status',
        'warehouse_id',
    ];
    public function order_items()
    {
        return $this->hasMany(order_items::class);
    }
}
