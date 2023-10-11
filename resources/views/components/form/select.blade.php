@props([
    'label' => 'Select',
    'name' => '',
    'options' => [],
    'value' => '',
])

<div class="form-group">
    <label>{{ $label }}</label>
    <select name="{{ $name }}" class="form-control">
        @foreach ($options as $key=>$name)
            <option value="{{ $key }}" @selected(old('parent_id', $value) == $key)>{{ $name }}</option>
        @endforeach
    </select>
</div>
