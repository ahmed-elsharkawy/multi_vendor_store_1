@props([
    'label' => false,
    'name' => 'image',
    'value' => '',
])

<div class="form-group">
    <label>{{ $label }}</label>
    <input type="file" name="{{ $name }}" @class(['form-control', 'pt-1', 'invalid' => $errors->has('image')]) accept="image/*">
    @error('image')
        <div class="text-danger">{{ $message }}</div>
    @enderror
    @if($value)
        <img src="{{ asset('storage/'.$value) }}" alt="" width="100" height="70">
    @endif
</div>
