<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $query = Category::query();

        $categories = Category::with(['parent'])
            ->withCount([
                'products as products_number' => function($query){
                    $query->where('status', 'active');
                }])
                ->filter(request()
                ->query())
                ->paginate();
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::select(['id', 'name'])->get();
        $category = new Category();
        return view('dashboard.categories.create', compact('category', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(Category::rules());
        $request->merge([
            'slug' => Str::slug($request->post('name')),
        ]);
        $data = $request->except(['image']);
        $data['image'] = $this->upload_image($request);
        Category::create($data);
        return redirect()->route('dashboard.categories.index')->with('success', 'Category Added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('dashboard.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try{
            $category = Category::findOrFail($id);
        }catch(Throwable $e){
            return redirect('dashboard/categories')->with('info', 'there is no category with that domain!');
        }

        $categories = Category::select('id', 'name')
                    ->where('id', '!=', $id)
                    ->where(function($query) use($id){
                        $query->whereNull('parent_id')
                            ->orWhere('parent_id', '!=', $id);
                    })->get();
        return view('dashboard.categories.edit', compact('categories', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        // $request->validate(Category::rules($id));
        $category = Category::find($id);
        $old_path = $category['image'];
        $data = $request->except('image');

        $new_image = $this->upload_image($request);
        if($new_image){
            $data['image'] = $new_image;
        }

        if($old_path && isset($data['image'])){
            Storage::disk('public')->delete($old_path);
        }
        $category->update($data);
        return redirect()->route('dashboard.categories.index')->with('success', 'category updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        if($category->image){
            Storage::disk('public')->delete($category->image);
        }
        // Category::destroy($id);
        return redirect()->route('dashboard.categories.index')->with('info', 'Category Deleted!');
    }

    public function upload_image($request){
        if(!$request->hasFile('image')){
            return;
        }
        $file = $request->file('image');
        $path = $file->store('uploads', ['disk' => 'public']);
        return $path;
    }

    public function trash(){
        $categories = Category::onlyTrashed()->paginate();
        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore(Request $request, $id){
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('dashboard.categories.trash')->with('success', 'category restored successfully!');
    }

    public function force_delete($id){
        $category = Category::onlyTrashed()->findOrFail($id);
        if($category->image){
            Storage::disk('public')->delete($category->image);
        }
        $category->forceDelete();
        return redirect()->route('dashboard.categories.trash')->with('info', 'category deleted forever!');


    }
}
