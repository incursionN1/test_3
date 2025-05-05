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

class OrderPostController extends Controller
{


    public function __invoke(Request $request, CommonService $service)
    {
        $err =[];
        // валидация реквеста
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'warehouse_id' => 'required|integer|exists:warehouses,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.count' => 'required|integer|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        /*
         * $request {
                "customer_name": "Иван Иванов",
                "warehouse_id": "13",
                "items": [
                    {
                        "product_id": 1,
                        "count": 2
                    },
                    {
                        "product_id": 3,
                        "count": 1
                    }
                ]
            }
         */
        try {
            // Списываем товары со склада
            $service->updateStocks($request->items, $request->warehouse_id, false);
        } catch (\Exception $e) {
            $err[] = $service->createError('Заказ не создан', "Ошибка : " . $e->getMessage());
            return response()->json([
                'message'   => 'error',
                'err'       => $err,
            ], 400);
        }
        // собираем массив товаров
        foreach ($request->items as $itemData) {
                $items[] = [
                    'product_id'    => $itemData['product_id'],
                    'count'         => $itemData['count'],
                ];
            }
        // Создаём заказ
        $order = orders::create([
            'customer'      => $request->customer_name,
            'warehouse_id'  => $request->warehouse_id,
            'status'        => 'active',
        ]);
        // Добавляем в заказ товары
        foreach ($items as $item) {
            try {
                $order->order_items()->create($item);
            }catch (\Exception $e){
                $err[] = $service->createError('Заказ не создан', "Ошибка : " . $e->getMessage());
                return response()->json([
                    'message'   => 'error',
                    'err'       => $err,
                ], 400);
            }
        }
        // возвращаем ответ
        $result['order'] = $order->load('order_items.product');
        return response()->json([
            'message'   => 'successfully',
            'data'      => $result,
        ], 201);
    }
}
