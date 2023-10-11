@props([
    'name' => 'input field',
    'type' => 'text',
    'value' => '',
    'label' => false,
])

<div class="form-group m-0">

    @if($label)
        <label>{{ $label }}</label>
    @endif
    <input type="{{ $type }}" name="{{ $name }}" value="{{ old($name, $value) }}" {{ $attributes->class([
        'form-control',
        'invalid' => $errors->has($name)
    ]) }}>
    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
