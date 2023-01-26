<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return response()->json([
            'status' => 200,
            'orders' => $orders
        ]);
    }

    public function show($orderId)
    {
        $order = Order::where('id', $orderId)->first();
        $orderItems = OrderItem::where('order_id', $order->id)->get();
        if ($order) {
            return response()->json([
                'status' => 200,
                'data' => [
                    'order' => $order,
                    'orderItems' => $orderItems
                ]
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Order Id Not Found'
            ]);
        }
    }

    public function updateOrderStatus($orderId, Request $request)
    {
        $order = Order::where('id', $orderId)->first();
        if ($order) {
            $order->update([
                'status_message' => $request->status_message
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Status Updated Successfully',
                'order' => $order
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Status Updated Failed'
            ]);
        }
    }

    public function filterOrder($statusFilter, $date)
    {
        $todayDate = Carbon::now()->format('Y-m-d');
        $orders = Order::when($date != null, function ($q) use ($date) {
            return $q->whereDate('created_at', $date);
        }, function ($q) use ($todayDate) {
            return $q->whereDate('created_at', $todayDate);
        })
            ->when($statusFilter != null && $statusFilter != 'all', function ($q) use ($statusFilter) {
                return $q->where('status_message', $statusFilter);
            })
            ->get();
        return response()->json([
            'status' => 200,
            'orders' => $orders
        ]);
    }
}
