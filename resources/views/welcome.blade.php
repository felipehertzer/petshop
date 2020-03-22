@extends('web.layouts.app')

@section('title', 'Main')

@section('content')
    <div class="title m-b-md">
        PetShop
    </div>

    <div class="links">
        <a href="{{ url('/pets') }}">Pets</a>
        <a href="{{ url('/orders') }}">Orders</a>
        <a href="{{ url('/categories') }}">Categories</a>
        <a href="{{ url('/users') }}">Users</a>
    </div>
@endsection
