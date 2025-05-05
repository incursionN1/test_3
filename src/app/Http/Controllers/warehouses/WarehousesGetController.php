<?php


namespace App\Http\Controllers\warehouses;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterRequest;
use App\Models\order_items;
use App\Models\Post;
use App\Models\stocks;
use App\Models\warehouses;

class WarehousesGetController extends Controller
{
    public function __invoke()
    {
        $data = warehouses::all();
       return response()->json($data, 200);
    }
}
