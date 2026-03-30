<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('meals')
            ->orderBy('order')
            ->orderBy('id')
            ->paginate(10);
        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // For API, this method is not needed
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'image' => 'nullable|image',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $image = imagecreatefromstring($file->get());
            $filename = $request->name_en . '.webp';
            $path = public_path('categories/' . $filename);
            imagewebp($image, $path);
            imagedestroy($image);
            $data['image'] = 'categories/' . $filename;
        }


        Category::create($data);
        return redirect()->route('category.index')->with('msg', __('categories.category_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        // For API, this method is not needed
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'image' => 'nullable|image',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Remove Last Image If Found
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }

            $file = $request->file('image');
            $image = imagecreatefromstring($file->get());
            $filename = $request->name_en . '.webp';
            $path = public_path('categories/' . $filename);
            imagewebp($image, $path);
            imagedestroy($image);
            $data['image'] = 'categories/' . $filename;
        }
        
        $category->update($data);
        return redirect()->route('category.index')->with('msg', __('categories.category_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Remove Image
        if ($category->image and file_exists(public_path($category->image))) {
            unlink(public_path($category->image));
        }
        
        $category->delete();
        
        return redirect()->route('category.index')->with('msg', __('categories.category_deleted'));
    }
}
