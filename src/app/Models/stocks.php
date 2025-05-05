<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stocks extends Model
{
    /** @use HasFactory<\Database\Factories\StocksFactory> */
    use HasFactory;
    public $timestamps = false;
    protected $table = 'stocks';

    public function warehouses()
    {
        return $this->belongsTo(warehouses::class, 'warehouse_id','id');
    }
    public function products()
    {
        return $this->belongsTo(products::class, 'product_id','id');
    }
}
