@extends('web.layouts.app')

@section('title', 'Orders')

@section('content')
    <div class="card">
        <div class="card-header">
            Pets
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pets as $pet)
                    <tr>
                        <td>
                            {{ $pet->id }}
                        </td>
                        <td>
                            {{ $pet->name }}
                        </td>
                        <td>
                            {{ $pet->category->name }}
                        </td>
                        <td>
                            {{ $pet->status }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $pets->links() }}
        </div>
    </div>
    <a href="{{ url('/') }}" class="btn btn-primary btn-lg">Back</a>
@endsection
