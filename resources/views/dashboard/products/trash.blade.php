@extends('layouts.dashboard')

@section('title', 'Trash Products')

@section('breadcrumb')
    <li class="breadcrumb-item">Products</li>
    <li class="breadcrumb-item active">Trash Products</li>
@endsection

@section('content')
    <a href="{{ route('dashboard.products.index') }}" class="btn btn-primary my-2">Products</a>

    <x-alert type='success' />
    <x-alert type='info' />

    <form action="{{ URL::current() }}" method="GET" class="d-flex justify-content-between align-items-center mt-2 mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <x-form.input name="name" type="text" class="" placeholder="name" value="{{ request('name') }}" />
        </div>
        <select class="form-control w-25" name="status">
            <option value="">All</option>
            <option value="active" @selected(request('status') == 'active')>Active</option>
            <option value="inactive" @selected(request('status') == 'inactive')>Inactive</option>
        </select>
        <button class="btn btn-primary mx-2" type="submit">Search</button>
    </form>

    <table class="table">
        <thead>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Store</th>
            <th>Status</th>
            <th>Created At</th>
            <th colspan="2">Actions</th>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    {{-- <td>
                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}" alt="" width="100" height="70">
                        @endif
                    </td> --}}
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->store->name }}</td>
                    <td>{{ $product->status }}</td>
                    <td>{{ $product->deleted_at }}</td>
                    <td>
                        <form action="{{ route('dashboard.products.restore', ['product' => $product->id]) }}" method="post">
                            @csrf
                            @method('put')
                            <button class="btn btn-outline-info" type="submit">Restore</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('dashboard.products.force_delete', ['product' => $product->id]) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-outline-danger" type="submit">Force Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $products->withQueryString()->links() }}
@endsection
