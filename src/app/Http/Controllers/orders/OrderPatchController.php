<?php

namespace App\Http\Controllers\orders;

use App\Models\order_items;
use App\Models\orders;
use App\Models\stocks;
use App\Models\warehouses;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OrderPatchController
{

    public function __invoke(Request $request, orders $order,  CommonService $service)
    {
        $err =[];
        // валидация реквеста
        $validator = Validator::make($request->all(), [
            'customer_name' => '|string|max:255',
            'warehouse_id' => '|integer|exists:warehouses,id',
            'items.*.product_id' => '|integer|exists:products,id',
            'items.*.count' => '|integer|min:1',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
//        /*
//         * $request {
//                "customer_name": "Иван Иванов",
//                "warehouse_id": "13",
//                "items": [
//                    {
//                        "product_id": 1,
//                        "count": 2
//                    },
//                    {
//                        "product_id": 3,
//                        "count": 1
//                    }
//                ]
//            }
//         */
        if (!empty($request->customer_name))
        {
            $order->customer = $request->customer_name;
        }
        $oldOrders = $order->load('order_items.product');

        if (!empty($request->warehouse_id)) {
            // Проверяем  указан ли новый warehouse_id
            $warehouse = warehouses::find($request->warehouse_id);
            if ($warehouse) {
                try {
                    $result = DB::transaction(function () use ($service, $oldOrders, $order, $request,$err) {
                        // Возвращаем товары на  склад
                        $service->updateStocks($oldOrders->order_items->toArray(),$order->warehouse_id);
                        // Списываем товары со склада
                        $service->updateStocks($request->items,$request->warehouse_id,false);
                    }, 2);
                } catch (Exception $e) {
                    $err[] = $service->createError('Заказ не создан', "Ошибка транзакции: " . $e->getMessage());
                }

            }
            else{
                $err[] = $service->createError('Заказ не создан', "Склад не найден");
            }
            $order->warehouse_id = $request->warehouse_id;
            $order->save();
        }
        else {
            // Если warehouse_id не указан
            try {
                $result = DB::transaction(function () use ($service, $oldOrders, $order, $request) {
                    // Возвращаем товары на  склад
                    $service->updateStocks($oldOrders->order_items->toArray(),$order->warehouse_id);
                    // Списываем товары на новом складе
                    $service->updateStocks($request->items,$order->warehouse_id,false);
                }, 2);
            } catch (Exception $e) {
                $err[] = $service->createError('Заказ не создан', "Ошибка транзакции: " . $e->getMessage());
            }
        }
        // Удаляем старые данные
        order_items::where('orders_id', $order->id)->delete();
        // добавляем новые
        foreach ($request->items as $itemData) {
                $order->order_items()->create($itemData);
        }
        $order->warehouse_id = $request->warehouse_id;
        $order->save();
        $result['order'] = $order->load('order_items.product');
        // возвращаем ответ
        return response()->json([
            'message'   => 'Order created successfully',
            'data'      => $result,
            'err'       => $err,
        ], 200);
    }
}

