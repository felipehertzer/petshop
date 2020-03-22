<?php


namespace App\Http\Controllers\Api;


use App\Exceptions\ApiResponse;
use App\Http\Controllers\Controller;
use App\Order;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'petId' => [
                    'required', 'numeric',
                    Rule::exists('pets', 'id')->where(function ($query) {
                        return $query->where('status', 'available');
                    })
                ],
                'quantity' => 'required|numeric|min:1',
                'shipDate' => 'required|date_format:Y-m-d\TH:i:s.v\Z',
                'complete' => 'required|boolean',
                'status' => 'required|in:placed,approved,delivered',
            ]);
        if ($validator->fails()) {
            throw new ApiResponse('Invalid Order', 400);
        }

        DB::beginTransaction();

        $order = new Order();
        $order->petId = $request->get('petId');
        $order->quantity = $request->get('quantity');
        $order->shipDate = Carbon::createFromFormat('Y-m-d\TH:i:s.v\Z', $request->get('shipDate'));
        $order->complete = $request->get('complete');
        $order->status = $request->get('status');
        $order->save();

        $order->pet->status = 'pending';
        $order->pet->save();

        DB::commit();

        return response()->json($order, 200);
    }

    public function findById($orderId)
    {
        if (!is_numeric($orderId)) {
            throw new ApiResponse('Invalid ID supplied', 400);
        }

        try {
            $order = Order::findOrFail($orderId);
        } catch (ModelNotFoundException $e) {
            throw new ApiResponse('Order not found', 404);
        }

        return response()->json($order, 200);
    }

    public function remove($orderId)
    {
        if (!is_numeric($orderId)) {
            throw new ApiResponse('Invalid ID supplied', 400);
        }

        try {
            $order = Order::findOrFail($orderId);
            if ($order->shipDate->isFuture()) {
                DB::beginTransaction();

                $order->pet->status = 'available';
                $order->pet->save();

                $order->delete();

                DB::commit();

                return response()->json('', 200);
            } else {
                throw new ApiResponse('Order not found', 404);
            }
        } catch (ModelNotFoundException $e) {
            throw new ApiResponse('Order not found', 404);
        }
    }
}
