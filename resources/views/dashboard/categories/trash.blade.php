@extends('layouts.dashboard')

@section('title', 'Trash Categories')

@section('breadcrumb')
    <li class="breadcrumb-item">Categories</li>
    <li class="breadcrumb-item active">Trash Categories</li>
@endsection

@section('content')
    <a href="{{ route('dashboard.categories.index') }}" class="btn btn-primary my-2">Categories</a>

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
            <th>Status</th>
            <th>Deleted At</th>
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
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->parent_id }}</td>
                    <td>{{ $category->status }}</td>
                    <td>{{ $category->deleted_at }}</td>
                    <td>
                        <form action="{{ route('dashboard.categories.restore', ['category' => $category->id]) }}" method="post">
                            @csrf
                            @method('put')
                            <button class="btn btn-outline-info" type="submit">Restore</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('dashboard.categories.force_delete', ['category' => $category->id]) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-outline-danger" type="submit">Force Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $categories->withQueryString()->links() }}
@endsection
