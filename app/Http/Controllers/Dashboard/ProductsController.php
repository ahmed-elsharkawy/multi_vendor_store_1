<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['category' ,'store'])->paginate();
        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::select(['id', 'name'])->get();
        $product = new Product();
        return view('dashboard.products.create', compact('categories', 'product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $request->merge([
            'slug' => Str::slug($request->input('name')),
            'store_id' => auth()->user()->id,
        ]);

        $data = $request->except('image');
        $data['image'] = $this->uploadImage($request);
        Product::create($data);
        return redirect()->route('dashboard.products.index')->with('success', 'Product Added');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::select('id', 'name')->get();
        $tag_names = implode(',', $product->tags()->pluck('name')->toArray());
        return view('dashboard.products.edit', compact('categories', 'product', 'tag_names'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        // $product = Product::findOrFail($id);
        $oldPath = $product['image'];
        $data = $request->except(['image', 'tags']);
        $newImage = $this->uploadImage($request);
        if($newImage){
            $data['image'] = $newImage;
        }
        if($oldPath && isset($data['image'])){
            Storage::disk('public')->delete($oldPath);
        }
        $product->update($data);

        $tags = explode(',', $request->tags);
        $tag_ids = [];
        $tags_list = Tag::all();
        foreach($tags as $t_name){
            $tag = $tags_list->where('slug', Str::slug($t_name))->first();
            if(!$tag){
                $tag = Tag::create([
                    'name' => $t_name,
                    'slug' => Str::slug($t_name),
                ]);
            }
            $tag_ids[] = $tag->id;
        }
        $product->tags()->sync($tag_ids);
        return redirect()->route('dashboard.products.index')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        if($product->image){
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('dashboard.products.index')->with('info', 'Product has deleted');
    }


    /**
     * Get Trashed products list
     */
    public function trash(){
        $products = Product::onlyTrashed()->paginate();
        // dd($products);
        return view('dashboard.products.trash', compact(['products']));
    }

    /**
     * Restore Trashed Product
     */
    public function restore(Request $request, $id){
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();
        return redirect()->route('dashboard.products.trash')->with('success', 'Product restored successfully ');
    }

    /**
     *  Force_delete product
     */
    public function force_delete($id){
        $product = Product::onlyTrashed()->findOrFail($id);
        if($product->image){
            Storage::disk('public')->delete($product->image);
        }
        $product->forceDelete();
        return redirect()->route('dashboard.products.trash')->with('info', 'Product deleted forever ');
    }

    /**
     * uploadImage method
     */
    public function uploadImage($request){
        if(!$request->hasFile('image')){
            return ;
        }
        $file = $request->file('image');
        $path = $file->store('uploads', ['disk' => 'public']);
        return $path;
    }
}
