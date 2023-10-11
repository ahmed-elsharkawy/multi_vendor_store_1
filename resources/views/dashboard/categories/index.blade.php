@extends('layouts.dashboard')

@section('title', 'Categories')

@section('breadcrumb')
    <li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')
    <a href="{{ route('dashboard.categories.create') }}" class="btn btn-primary my-2">Add Category</a>
    <a href="{{ route('dashboard.categories.trash') }}" class="btn btn-outline-danger my-2">Trash</a>

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
            <th>Image</th>
            <th>ID</th>
            <th>Name</th>
            <th>Parent</th>
            <th>Products Count</th>
            <th>Status</th>
            <th>Created At</th>
            <th colspan="2">Actions</th>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>
                        @if($category->image)
                            <img src="{{ asset('storage/'.$category->image) }}" alt="" width="100" height="70">
                        @endif
                    </td>
                    <td>{{ $category->id }}</td>
                    <td><a href="{{ route('dashboard.categories.show', $category->id) }}">{{ $category->name }}</a></td>
                    <td>{{ $category->parent->name }}</td>
                    <td>{{ $category->products_number }}</td>
                    <td>{{ $category->status }}</td>
                    <td>{{ $category->created_at }}</td>
                    <td>
                        <a href="{{ route('dashboard.categories.edit', ['category' => $category->id]) }}" class="btn btn-outline-info">Edit</a>
                    </td>
                    <td>
                        <form action="{{ route('dashboard.categories.destroy', ['category' => $category->id]) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-outline-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $categories->withQueryString()->links() }}
@endsection
