<?php


namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Order;

class OrderController extends Controller
{
    /**
     * Show list of order
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::paginate(15);
        return response()->view('web.order.index', compact('orders'));
    }
}
