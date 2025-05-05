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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderResumeController extends Controller
{


    public function __invoke(orders $order, CommonService $service)
    {
        $err =[];
        if ($order->status === 'active') {
            return response()->json(['message' => 'Заказ уже актиевн'], 400);
        }

        if ($order->status === 'completed') {
            return response()->json(['message' => 'Завершенный заказ нельзя отменить'], 400);
        }

        $oldOrders = $order->load('order_items.product');

        try {
            $service->updateStocks($oldOrders->order_items->toArray(),$order->warehouse_id, false);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ошибка', 'Описание' => $e->getMessage()]);
        }
        $order->update(['status' => 'active']);

        return response()->json(['message' => 'Заказ успешно возобновлён', 'order' => $order]);
    }
}
