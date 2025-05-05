<?php

namespace App\Http\Controllers\orders;

use App\Http\Controllers\Controller;
use App\Models\order_items;
use App\Models\orders;
use App\Models\products;
use App\Models\stocks;
use App\Models\warehouses;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderCancelController extends Controller
{


    public function __invoke(orders $order, CommonService $service)
    {

        if ($order->status === 'cancelled') {
            return response()->json(['message' => 'Заказ уже отменен'], 400);
        }

        if ($order->status === 'completed') {
            return response()->json(['message' => 'Завершенный заказ нельзя отменить'], 400);
        }

        $oldOrders = $order->load('order_items.product');
        $service->updateStocks($oldOrders->order_items->toArray(),$order->warehouse_id);

        $order->update(['status' => 'cancelled']);

        return response()->json(['message' => 'Заказ успешно отменен', 'order' => $order]);
    }
}
