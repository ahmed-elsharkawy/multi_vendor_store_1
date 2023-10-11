
<x-form.input name="name" type="text" :value="$product->name" role="input" />

{{-- <x-form.select name="category_id" primary="Primary product" label="product Parent" :value="$product->category_id" :options="$categories" /> --}}

<div class="form-group">
    <label>product Parent</label>
    <select name="category_id" class="form-control">
        <option value="">Primary product</option>
        @foreach ($categories as $item)
            <option value="{{ $item->id }}" @selected(old('category_id', $product->category_id) == $item->id)>{{ $item->name }}</option>
        @endforeach
    </select>
    @error('category_id')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<x-form.textarea name="description" label="Description" :value="old('description', $product->description)" />

<x-form.file name="image" label="Image" :value="$product->image" />

{{-- <div class="form-group">
    <label>Image</label>
    <input type="file" name="image" @class(['form-control', 'pt-1', 'invalid' => $errors->has('image')]) accept="image/*">
    @error('image')
        <div class="text-danger">{{ $message }}</div>
    @enderror
    @if($product->image)
        <img src="{{ asset('storage/'.$product->image) }}" alt="" width="100" height="70">
    @endif
</div> --}}

<x-form.input name="price" type="number" :value="old('price', $product->price)" label="Price" />
<x-form.input name="compare_price" type="number" :value="old('compare_price', $product->compare_price)" label="Compare Price" />
<x-form.input name="tags" type="text" :value="old('tags', $tag_names)" label="Tags" />

<x-form.radio name='status' :checked="$product->status" :options="['Active' => 'active', 'Draft' => 'draft', 'Archived' => 'archived']" />

<div class="form-group">
    <button class="btn btn-success" type="submit">{{ $btn_txt ?? 'Save' }}</button>
</div>
