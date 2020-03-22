@extends('web.layouts.app')

@section('title', 'Orders')

@section('content')
    <div class="card">
        <div class="card-header">
            Orders
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Pet</th>
                    <th>Quantity</th>
                    <th>ShipDate</th>
                    <th>Complete</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>
                            {{ $order->id }}
                        </td>
                        <td>
                            {{ $order->pet->name }}
                        </td>
                        <td>
                            {{ $order->quantity }}
                        </td>
                        <td>
                            {{ $order->shipDate }}
                        </td>
                        <td>
                            {{ $order->complete ? 'Yes' : 'No' }}
                        </td>
                        <td>
                            {{ $order->status }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $orders->links() }}
        </div>
    </div>
    <a href="{{ url('/') }}" class="btn btn-primary btn-lg">Back</a>
@endsection
