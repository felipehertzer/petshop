<?php

namespace App\Console\Commands;

use App\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;

class VerifyDeliveredOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deliveredOrder:verify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify Delivered Order';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $orders = Order::whereIn('status', ['placed', 'approved'])->where('shipDate', '<=', Carbon::now())->get();
        foreach ($orders as $order) {
            $order->status = 'delivered';
            $order->save();

            $order->pet->status = 'sold';
            $order->pet->save();
        }
        return true;
    }
}
