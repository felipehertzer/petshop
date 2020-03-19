<?php


namespace App\Http\Controllers;


use App\Order;
use Illuminate\Http\Request;

class OrderController
{
    public function create(Request $request){
        $order = new Order();

        $order->save();
    }

    public function findById($orderId){
        $order = Order::findOrFail($orderId);
    }

    public function remove($orderId){
        $order = Order::findOrFail($orderId);
        $order->delete();
    }
}
