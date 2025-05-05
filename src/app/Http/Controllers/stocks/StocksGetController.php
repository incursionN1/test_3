<?php


namespace App\Http\Controllers\stocks;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterRequest;
use App\Models\order_items;
use App\Models\Post;
use App\Models\products;
use App\Models\stocks;
use App\Models\warehouses;

class StocksGetController extends Controller
{
    public function __invoke()
    {
        $datas = stocks::all();

        foreach ($datas as $data) {
            $result[]= [
                'id' => $data->id,
                'warehouse_name' => $data->warehouses->name,
                'product_name' => $data->products->name,
                'stock' => $data->stock
            ];
        }
        return response()->json($result, 200);
    }
}
