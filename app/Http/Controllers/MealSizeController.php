<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\MealSize;
use Illuminate\Http\Request;

class MealSizeController extends Controller
{
    /**
     * عرض أحجام وجبة معينة
     */
    public function index(Meal $meal)
    {
        $sizes = $meal->sizes()->ordered()->get();
        return view('admin.meals.sizes.index', compact('meal', 'sizes'));
    }

    /**
     * إضافة حجم جديد
     */
    public function store(Request $request, Meal $meal)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $meal->sizes()->create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'price' => $request->price,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة الحجم بنجاح'
        ]);
    }

    /**
     * تحديث حجم
     */
    public function update(Request $request, Meal $meal, MealSize $size)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $size->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'price' => $request->price,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الحجم بنجاح'
        ]);
    }

    /**
     * حذف حجم
     */
    public function destroy(Meal $meal, MealSize $size)
    {
        $size->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الحجم بنجاح'
        ]);
    }

    /**
     * تبديل حالة الحجم
     */
    public function toggleStatus(Meal $meal, MealSize $size)
    {
        $size->update(['is_active' => !$size->is_active]);

        return response()->json([
            'success' => true,
            'message' => $size->is_active ? 'تم تفعيل الحجم' : 'تم إلغاء تفعيل الحجم'
        ]);
    }
}
