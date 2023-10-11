@extends('layouts.dashboard')

@section('title', 'Edit Profile')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Edit profile</li>
@endsection

@section('content')

    <x-alert type="success" />

    <form action="{{ route('dashboard.profile.update') }}" class="form" method="post" enctype="multipart/form-data">
        @csrf
        @method('patch')
        @include('dashboard.profile._form', [
            'btn_txt' => 'Submit'
        ])
    </form>
@endsection
