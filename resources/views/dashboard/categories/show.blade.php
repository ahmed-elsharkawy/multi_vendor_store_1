@extends('layouts.dashboard')

@section('title', $category->name)

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">$category->name</li>
@endsection

@section('content')
<table class="table">
    <thead>
        <th>Image</th>
        <th>Name</th>
        <th>Store</th>
        <th>Status</th>
        <th>Created At</th>
    </thead>
    <tbody>
        @php
            $products = $category->products()->with('store')->latest()->paginate(10);
        @endphp
        @foreach ($products as $category)
            <tr>
                <td>
                    @if($category->image)
                        <img src="{{ asset('storage/'.$category->image) }}" alt="" width="100" height="70">
                    @endif
                </td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->store->name }}</td>
                <td>{{ $category->status }}</td>
                <td>{{ $category->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $products->links() }}
@endsection
