<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\MealExtra;
use Illuminate\Http\Request;

class MealExtraController extends Controller
{
    /**
     * عرض إضافات وجبة معينة
     */
    public function index(Meal $meal)
    {
        $extras = $meal->extras()->ordered()->get();
        return view('admin.meals.extras.index', compact('meal', 'extras'));
    }

    /**
     * إضافة إضافة جديدة
     */
    public function store(Request $request, Meal $meal)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $meal->extras()->create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'price' => $request->price,
            'category' => $request->category,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة الإضافة بنجاح'
        ]);
    }

    /**
     * تحديث إضافة
     */
    public function update(Request $request, Meal $meal, MealExtra $extra)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $extra->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'price' => $request->price,
            'category' => $request->category,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الإضافة بنجاح'
        ]);
    }

    /**
     * حذف إضافة
     */
    public function destroy(Meal $meal, MealExtra $extra)
    {
        $extra->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الإضافة بنجاح'
        ]);
    }

    /**
     * تبديل حالة الإضافة
     */
    public function toggleStatus(Meal $meal, MealExtra $extra)
    {
        $extra->update(['is_active' => !$extra->is_active]);

        return response()->json([
            'success' => true,
            'message' => $extra->is_active ? 'تم تفعيل الإضافة' : 'تم إلغاء تفعيل الإضافة'
        ]);
    }
}
