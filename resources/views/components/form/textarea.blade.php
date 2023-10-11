@props([
    'name' => '',
    'value' => '',
    'label' => false,
])

<div class="form-group">
    @if($label)
        <label>{{ $label }}</label>
    @endif
    <textarea name="{{ $name }}" {{ $attributes->class([
        'form-control',
        'invalid' => $errors->has($name)
    ]) }}>{{ old($name, $value) }}</textarea>
    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
