@props([
    'name' => '',
    'checked' => '',
    'options' => [],
])

<div class="form-group">
    <label>{{ ucwords($name) }}</label>
    @foreach ($options as $key => $value )
        <div class="form-check">
            <input class="form-check-input" type="radio" id="{{ $value }}" name="{{ $name }}" value="{{ $value }}" @checked(old($name, $checked) == $value)>
            <label class="form-check-label" for="{{ $value }}">{{ $key }}</label>
        </div>
        @error($name)
            <div class="text-danger" style=" font-size: 0.875rem/* 14px */; line-height: 1.25rem/* 20px */;">{{ $message }}</div>
        @enderror
    @endforeach
</div>
