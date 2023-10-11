@extends('layouts.dashboard')
@section('title', 'Edit Product')

@section('content')
    <form action="{{ route('dashboard.products.update', $product->id) }}" enctype="multipart/form-data" method="POST">
        @csrf
        @method('PATCH')
        @include('dashboard.products._form')
    </form>
@endsection


@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@enderror

@push('script')
    <script src="{{ asset('tagify_js_1.js') }}"></script>
    <script src="{{ asset('tagify_js_2.js') }}"></script>
    <script>
        var inputElm = document.querySelector([name="tags"]),
        tagify = new Tagify (inputElm);

        inputElm.addEventListener('change', onChange)
    </script>
@endpush

@push('style')
    <link href="{{ asset('tagify_css_1.css') }}" rel="stylesheet" type="text/css" />
@endpush



{{-- @ --}}
