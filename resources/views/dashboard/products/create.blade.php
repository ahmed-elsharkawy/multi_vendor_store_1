@extends('layouts.dashboard')

@section('title', 'Products')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Products</li>
@endsection

@section('content')
    <form action="{{ route('dashboard.products.store') }}" method="post" class="form" enctype="multipart/form-data">
        @csrf
        @include('dashboard.products._form', ['btn-text' => 'save'])
    </form>
@endsection
