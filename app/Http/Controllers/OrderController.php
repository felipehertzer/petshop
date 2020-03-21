<?php


namespace App\Http\Controllers;


use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController
{
    public function create(Request $request){

        $validator = Validator::make($request->all(),
            [
                'petId' => 'required|numeric|exists:pets,id',
                'quantity' => 'required|numeric|min:1',
                'shipDate' => 'required|date_format:Y-m-d\TH:i:s.u\Z',
                'complete' => 'required|boolean',
                'status' => 'required|in:placed,approved,delivered',
            ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 405);
        }
        dd('aa');

        DB::beginTransaction();

        $order = new Order();
        $order->petId = $request->get('petId');
        $order->quantity = $request->get('quantity');
        $order->shipDate = $request->get('shipDate');
        $order->complete = $request->get('complete');
        $order->status = $request->get('status');
        $order->save();

        DB::commit();

        return response()->json('', 200);
    }

    public function findById($orderId){
        $order = Order::findOrFail($orderId);

        return response()->json($order, 200);
    }

    public function remove($orderId){
        $order = Order::findOrFail($orderId);
        $order->delete();

        return response()->json('', 200);
    }
}
