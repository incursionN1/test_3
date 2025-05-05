<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class warehouses extends Model
{
    /** @use HasFactory<\Database\Factories\WarehousesFactory> */
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name']; // и другие поля

    public function stocks()
    {
        return $this->hasMany(stocks::class);
    }
}
