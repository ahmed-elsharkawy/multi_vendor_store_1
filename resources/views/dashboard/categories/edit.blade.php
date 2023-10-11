@extends('layouts.dashboard')

@section('title', 'Edit Category')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
    <li class="breadcrumb-item active">Edit Category</li>
@endsection

@section('content')
    <form action="{{ route('dashboard.categories.update', $category->id) }}" class="form" method="post" enctype="multipart/form-data">
        @csrf
        @method('patch')
        @include('dashboard.categories._form', [
            'btn_txt' => 'Submit'
        ])
    </form>
@endsection
