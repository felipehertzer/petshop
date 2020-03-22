@extends('web.layouts.app')

@section('title', 'Categories')

@section('content')
    <div class="card">
        <div class="card-header">
            Categories
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th>Id</th>
                    <th width="200">Name</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>
                            {{ $category->id }}
                        </td>
                        <td>
                            {{ $category->name }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $categories->links() }}
        </div>
    </div>

    <a href="{{ url('/') }}" class="btn btn-primary btn-lg">Back</a>
@endsection
