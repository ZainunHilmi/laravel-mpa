<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of orders with date filtering.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Order::with('kasir');
        
        // Get date filters from request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        // Apply date filters if provided
        if ($startDate && $endDate) {
            $query->whereDate('transaction_time', '>=', $startDate)
                  ->whereDate('transaction_time', '<=', $endDate);
        } elseif ($startDate) {
            $query->whereDate('transaction_time', '>=', $startDate);
        } elseif ($endDate) {
            $query->whereDate('transaction_time', '<=', $endDate);
        } else {
            // If no dates provided, show today's data only
            $today = Carbon::today();
            $query->whereDate('transaction_time', $today);
            $startDate = $today->format('Y-m-d');
            $endDate = $today->format('Y-m-d');
        }
        
        // Get filtered orders with pagination
        $orders = $query->orderBy('transaction_time', 'desc')->paginate(10);
        
        // Calculate total revenue from filtered data
        $totalRevenue = $query->sum('total_price');
        
        // Preserve query parameters in pagination
        $orders->appends($request->all());
        
        return view('pages.orders.index', compact('orders', 'totalRevenue', 'startDate', 'endDate'));
    }

    //view
    public function show($id)
    {
        $order = \App\Models\Order::with('kasir')->findOrFail($id);

        //get order items by order id
        $orderItems = \App\Models\OrderItem::with('product')->where('order_id', $id)->get();


        return view('pages.orders.view', compact('order', 'orderItems'));
    }
}
