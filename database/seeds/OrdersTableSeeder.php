<?php


use App\Order;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        //clear table
        Order::truncate();

        Order::create([
            'petId' => 1,
            'quantity' => '1',
            'shipDate' => \Carbon\Carbon::now(),
            'status' => 'placed',
            'complete' => false,
        ]);

        Order::create([
            'petId' => 5,
            'quantity' => '1',
            'shipDate' => \Carbon\Carbon::now()->addDay(),
            'status' => 'approved',
            'complete' => false,
        ]);

        Order::create([
            'petId' => 4,
            'quantity' => '1',
            'shipDate' => \Carbon\Carbon::now()->subDay(),
            'status' => 'delivered',
            'complete' => true,
        ]);

    }
}
