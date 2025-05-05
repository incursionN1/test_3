<?php

namespace App\Http\Controllers\orders;

use App\Models\orders;
use Illuminate\Http\Request;


class OrderGetController
{
    public function __invoke(Request $request)
    {
        $query = orders::query();
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        if ($request->has('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        $perPage = $request->per_page ?? 10;
        $orders = $query->paginate($perPage);

        return response()->json($orders, 200);
    }
}
