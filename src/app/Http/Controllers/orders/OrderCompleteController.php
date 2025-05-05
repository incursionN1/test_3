<?php

namespace App\Http\Controllers\orders;

use App\Http\Controllers\Controller;
use App\Models\order_items;
use App\Models\orders;
use App\Models\products;
use App\Models\stocks;
use App\Models\warehouses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderCompleteController extends Controller
{

    public function __invoke(orders $order)
    {
        if ($order->status === 'completed' || $order-status === 'canceled') {
            return response()->json(['message' => 'Заказ уже завершен'], 400);
        }
        $order->update(['status' => 'completed']);

        $result['order'] = $order->load('order_items.product');
        return response()->json([
            'data'      => $result,
        ], 201);
    }
}
