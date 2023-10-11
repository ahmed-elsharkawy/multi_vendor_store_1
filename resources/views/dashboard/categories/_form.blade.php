
<x-form.input name="name" type="text" :value="$category->name" role="input" />

{{-- <x-form.select name="parent_id" primary="Primary Category" label="Category Parent" :value="$category->parent_id" :options="$categories" /> --}}

<div class="form-group">
    <label>Category Parent</label>
    <select name="parent_id" class="form-control">
        <option value="">Primary Category</option>
        @foreach ($categories as $item)
            <option value="{{ $item->id }}" @selected(old('parent_id', $category->parent_id) == $item->id)>{{ $item->name }}</option>
        @endforeach
    </select>
</div>

<x-form.textarea name="description" :value="old('description', $category->description)" />

<div class="form-group">
    <label>Image</label>
    <input type="file" name="image" @class(['form-control', 'pt-1', 'invalid' => $errors->has('image')]) accept="image/*">
    @error('image')
        <div class="text-danger">{{ $message }}</div>
    @enderror
    @if($category->image)
        <img src="{{ asset('storage/'.$category->image) }}" alt="" width="100" height="70">
    @endif
</div>

<x-form.radio name='status' :checked="$category->status" :options="['Active' => 'active', 'Inactive' => 'inactive']" />

{{-- <div class="form-group">
    <label>Status</label>
    <div class="form-check">
        <input class="form-check-input" id="active" type="radio" name="status" value="active" @checked(old('status', $category->status) == 'active')>
        <label class="form-check-label" for="active">
          Active
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" id="inactive" type="radio" name="status" value="inactive" @checked(old('status', $category->status) == 'inactive')>
        <label class="form-check-label" for="inactive">
          Inactive
        </label>
    </div>
    @error('status')
        <div class="text-danger" style=" font-size: 0.875rem/* 14px */; line-height: 1.25rem/* 20px */;">{{ $message }}</div>
    @enderror
</div> --}}

<div class="form-group">
    <button class="btn btn-success" type="submit">{{ $btn_txt ?? 'Save' }}</button>
</div>
