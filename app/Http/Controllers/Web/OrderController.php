<?php


namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::paginate(15);
        return response()->view('web.order.index', compact('orders'));
    }
}
