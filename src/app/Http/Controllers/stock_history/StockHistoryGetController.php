<?php

namespace App\Http\Controllers\stock_history;

use App\Http\Controllers\Controller;
use App\Models\history_stocks;
use App\Models\order_items;
use App\Models\orders;
use App\Models\products;
use App\Models\stocks;
use App\Models\warehouses;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockHistoryGetController extends Controller
{


    public function __invoke(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'warehouse_id' => 'nullable|integer|exists:warehouses,id',
            'stock_id' => 'nullable|integer|exists:stocks,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'per_page' => 'nullable|integer|min:1|max:100',
            'page' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $query = history_stocks::with(['warehouse', 'stock'])
            ->orderBy('created_at', 'desc');

        // Применяем фильтры
        if ($request->has('warehouse_id')) {
            $query->where('warehouse_id', $request->warehouse_id);
        }

        if ($request->has('stock_id')) {
            $query->where('stocks_id', $request->stock_id);
        }

        if ($request->has('start_date')) {
            $query->where('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date')) {
            $query->where('created_at', '<=', $request->end_date . ' 23:59:59');
        }

        $perPage = $request->per_page ?? 15;
        $histories = $query->paginate($perPage);

        return response()->json($histories, 200);
    }
}
