@if(session()->has($type))
    <p class="alert alert-{{ $type }}">{{ session($type) }}</p>
@endif
