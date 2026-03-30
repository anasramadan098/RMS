<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Meal;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\MealSize;
use App\Models\MealExtra;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $meals = Meal::with(['category', 'ingredients'])
                    ->withCount('orderItems')
                    ->paginate(10); 

        return view('products.index' , compact('meals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->get();
        $ingredients = Ingredient::active()->get();

        return view('products.create', compact('categories' , 'ingredients'));
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
            'price' => 'required|numeric|min:0',
            'preparation_time' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'category_id' => 'required|exists:categories,id',
            'ingredients' => 'nullable|array|min:1',
            'ingredients.*.id' => 'nullable|exists:ingredients,id',
            'ingredients.*.quantity' => 'nullable|numeric|min:0.01',
            'ingredients.*.notes' => 'nullable|string|max:255',
            // Sizes validation
            'sizes' => 'nullable|array',
            'sizes.*.name_ar' => 'required_with:sizes|string|max:255',
            'sizes.*.name_en' => 'nullable|string|max:255',
            'sizes.*.price' => 'required_with:sizes|numeric|min:0',
            'sizes.*.sort_order' => 'nullable|integer|min:0',
            // Extras validation
            'extras' => 'nullable|array',
            'extras.*.name_ar' => 'required_with:extras|string|max:255',
            'extras.*.name_en' => 'nullable|string|max:255',
            'extras.*.price' => 'required_with:extras|numeric|min:0',
            'extras.*.category' => 'nullable|string|max:255',
            'extras.*.sort_order' => 'nullable|integer|min:0',
            // New
            'discount_number' => 'nullable|integer', 
            'expiration_date' => 'nullable|date',
        ]);


        // معالجة رفع الصورة
        $data = $request->except('ingredients');
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/productImages'), $filename);
            $data['image'] = asset('productImages/' . $filename);
        }

        // تعيين القيم الافتراضية للحقول المنطقية
        $data['is_available'] = $request->has('is_available') ? 1 : 0;
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $data['order'] = $request->input('order') ?? Meal::count() + 1;
        $data['tenant_id'] = auth()->user()->tenant_id; // Assign tenant automatically

        $meal = Meal::create($data);
        
        // ربط المكونات بالوجبة
        if ($request->has('ingredients')) {
            foreach ($request->ingredients as $ingredient) {
                $meal->ingredients()->attach($ingredient['id'], [
                    'quantity' => $ingredient['quantity'],
                    'notes' => $ingredient['notes'] ?? null,
                ]);
            }
        }

        // حفظ الأحجام
        if ($request->has('sizes')) {
            foreach ($request->sizes as $sizeData) {
                $meal->sizes()->create([
                    'tenant_id' => auth()->user()->tenant_id, // Assign tenant to meal size
                    'name_ar' => $sizeData['name_ar'],
                    'name_en' => $sizeData['name_en'] ?? null,
                    'price' => $sizeData['price'],
                    'sort_order' => $sizeData['sort_order'] ?? 0,
                    'is_active' => true,
                ]);
            }
        }

        // حفظ الإضافات
        if ($request->has('extras')) {
            foreach ($request->extras as $extraData) {
                $meal->extras()->create([
                    'tenant_id' => auth()->user()->tenant_id, // Assign tenant to meal extra
                    'name_ar' => $extraData['name_ar'],
                    'name_en' => $extraData['name_en'] ?? null,
                    'price' => $extraData['price'],
                    'category' => $extraData['category'] ?? null,
                    'sort_order' => $extraData['sort_order'] ?? 0,
                    'is_active' => true,
                ]);
            }
        }

        $meal->load(['category', 'ingredients', 'sizes', 'extras']);
        return redirect()->route('meals.index')->with('msg', __('meals.meal_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Meal $meal)
    {
        $meal->load(['category', 'ingredients', 'orderItems', 'sizes', 'extras']);

        return view('products.show', compact('meal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meal $meal)
    {
        $categories = Category::active()->get();
        $ingredients = Ingredient::active()->get();
        $meal->load(['category', 'ingredients', 'sizes', 'extras']);

        return view('products.edit', compact('meal', 'categories', 'ingredients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Meal $meal)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'preparation_time' => 'nullable|integer|min:1',
            'image' => 'nullable|image|max:2048',
            'is_available' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'category_id' => 'required|exists:categories,id',
            'ingredients' => 'nullable|array|min:1',
            'ingredients.*.id' => 'nullable|exists:ingredients,id',
            'ingredients.*.quantity' => 'nullable|numeric|min:0.01',
            'ingredients.*.notes' => 'nullable|string|max:255',
            // Sizes validation
            'sizes' => 'nullable|array',
            'sizes.*.name_ar' => 'required_with:sizes|string|max:255',
            'sizes.*.name_en' => 'nullable|string|max:255',
            'sizes.*.price' => 'required_with:sizes|numeric|min:0',
            'sizes.*.sort_order' => 'nullable|integer|min:0',
            // Extras validation
            'extras' => 'nullable|array',
            'extras.*.name_ar' => 'required_with:extras|string|max:255',
            'extras.*.name_en' => 'nullable|string|max:255',
            'extras.*.price' => 'required_with:extras|numeric|min:0',
            'extras.*.category' => 'nullable|string|max:255',
            'extras.*.sort_order' => 'nullable|integer|min:0',
            // New
            'discount_number' => 'nullable|integer', 
            'expiration_date' => 'nullable|date',
        ]);

        // معالجة رفع الصورة
        $data = $request->except('ingredients');
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إذا وجدت
            if ($meal->image && file_exists(public_path( $meal->image))) {
                unlink(public_path( $meal->image));
            }
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/productImages'), $filename);
            $data['image'] = asset('productImages/' . $filename);
        }

        // تعيين القيم الافتراضية للحقول المنطقية
        $data['is_available'] = $request->has('is_available') ? 1 : 0;
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $data['order'] = $request->input('order') ?? $meal->id;

        // return $data;
        $meal->discount_number = $request->input('discount_number');
        $meal->expiration_date = $request->input('expiration_date');
        $meal->update($data);


        // إعادة ربط المكونات
        $meal->ingredients()->detach();
        if ($request->has('ingredients')) {
            foreach ($request->ingredients as $ingredient) {
                $meal->ingredients()->attach($ingredient['id'], [
                    'quantity' => $ingredient['quantity'],
                    'notes' => $ingredient['notes'] ?? null,
                ]);
            }
        }

        // حفظ الأحجام
        $meal->sizes()->delete(); // حذف الأحجام القديمة
        if ($request->has('sizes')) {
            foreach ($request->sizes as $sizeData) {
                $meal->sizes()->create([
                    'tenant_id' => auth()->user()->tenant_id,
                    'name_ar' => $sizeData['name_ar'],
                    'name_en' => $sizeData['name_en'] ?? null,
                    'price' => $sizeData['price'],
                    'sort_order' => $sizeData['sort_order'] ?? 0,
                    'is_active' => true,
                ]);
            }
        }

        // حفظ الإضافات
        $meal->extras()->delete(); // حذف الإضافات القديمة
        if ($request->has('extras')) {
            foreach ($request->extras as $extraData) {
                $meal->extras()->create([
                    'tenant_id' => auth()->user()->tenant_id,
                    'name_ar' => $extraData['name_ar'],
                    'name_en' => $extraData['name_en'] ?? null,
                    'price' => $extraData['price'],
                    'category' => $extraData['category'] ?? null,
                    'sort_order' => $extraData['sort_order'] ?? 0,
                    'is_active' => true,
                ]);
            }
        }

        $meal->load(['category', 'ingredients', 'sizes', 'extras']);

        return redirect()->route('meals.index')->with('msg', __('meals.meal_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meal $meal)
    {
        $meal->delete();
        // Remove Img
        if ($meal->image && file_exists(public_path( $meal->image))) {
            unlink(public_path($meal->image));
        }
        return redirect()->route('meals.index')->with('msg', __('meals.meal_deleted'));
    }

    /**
     * Get meals by category.
     */
    public function byCategory(Category $category)
    {
        $meals = $category->meals()->with('ingredients')->get();
        return response()->json($meals);
    }

    /**
     * Get available meals.
     */
    public function available()
    {
        $meals = Meal::available()->active()->with(['category', 'ingredients'])->get();
        return response()->json($meals);
    }

    /**
     * Get all meals.
     */
    public function apiIndex()
    {
        $locale = request()->get('locale', app()->getLocale());
        $meals = Meal::with(['category', 'ingredients'])->get();
        $meals = $meals->map(function ($meal) use ($locale) {
            return [
                'id' => $meal->id,
                'name' => $meal->getLocalizedName($locale),
                'description' => $meal->getLocalizedDescription($locale),
                'price' => $meal->price,
                'image' => asset($meal->image),
                'category' => $meal->category->name,
                'order' => $meal->order,
            ];
        });
        return response()->json($meals, 200);
    }
    public function meals_get($category)
    {
        $meals = Meal::where('category_id', $category)->get();
        return response()->json($meals, 200);
    }

    public function popular() {
        $meals = Meal::all();
        $popularMealIds = $meals->where('is_popular' , '==' , '1')->pluck('id')->toArray();
        return view('products.popular' , compact('meals' , 'popularMealIds'));
    }

    public function save_popular(Request $request) {

        $ids = $request->popular_meals;
        $meals = Meal::all();
        foreach ($meals as $meal) {
            if (!in_array($meal->id , $ids)) {
                $meal->is_popular = 0;
                $meal->save();
            } else {
                $meal->is_popular = 1;
                $meal->save();
            }
        }

        return redirect()->back()->with('msg', __('meals.meal_popular'));;
    } 
}
