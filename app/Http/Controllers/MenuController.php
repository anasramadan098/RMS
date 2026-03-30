<?php

namespace App\Http\Controllers;

use App\Mail\BookingMail;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Ad;
use App\Models\feedback;
use App\Models\Meal;
use App\Models\Book;
use App\Models\Booking;
use App\Models\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MenuController extends Controller
{

    /**
     * Helper function لتحسين البيانات المرجعة
     */
    private function formatMealData($meal, $locale = 'ar')
    {
        return [
            'id' => $meal->id,
            'name' => $locale === 'ar' ? ($meal->name_ar ?? $meal->name) : ($meal->name_en ?? $meal->name),
            'description' => $locale === 'ar' ? ($meal->description_ar ?? $meal->description) : ($meal->description_en ?? $meal->description),
            'price' => (float) $meal->price,
            'image' => $meal->image,
            'order' => $meal->order ?? 0,
            'discount_number' => $meal->discount_number ?? 0,
            'expiration_date' => $meal->expiration_date ?? null,
            'category_id' => $meal->category_id,
            'sizes' => $meal->sizes ? $meal->sizes->map(function($size) use ($locale) {
                return [
                    'id' => $size->id,
                    'name' => $locale === 'ar' ? $size->name_ar : ($size->name_en ?? $size->name_ar),
                    'price' => (float) $size->price,
                    'sort_order' => $size->sort_order ?? 0
                ];
            }) : [],
            'extras' => $meal->extras ? $meal->extras->map(function($extra) use ($locale) {
                return [
                    'id' => $extra->id,
                    'name' => $locale === 'ar' ? $extra->name_ar : ($extra->name_en ?? $extra->name_ar),
                    'price' => (float) $extra->price,
                    'category' => $extra->category,
                    'sort_order' => $extra->sort_order ?? 0
                ];
            }) : []
        ];
    }

    /**
     * Helper function لتحسين بيانات الفئات
     */
    private function formatCategoryData($category, $locale = 'ar')
    {
        return [
            'id' => $category->id,
            'name' => $locale === 'ar' ? ($category->name_ar ?? $category->name ?? 'غير محدد') : ($category->name_en ?? $category->name ?? 'Unnamed'),
            'description' => $locale === 'ar' ? ($category->description_ar ?? $category->description ?? '') : ($category->description_en ?? $category->description ?? ''),
            'image' => $category->image,
            'type' => $category->type ?? 'food',
            'order' => $category->order ?? 0
        ];
    }
    /**
     * Display the restaurant menu
     */
    public function index()
    {
        $ads = Ad::all();
        $popular_meals = Meal::all()->where('is_popular' , '==' , '1');
        $feedbacks = feedback::all();
        $categories_ar = $this->getCategories('ar');
        $categories_en = $this->getCategories('en');


        $meals_ar = Meal::where('is_active', '1')
            ->with('sizes', 'extras')
            ->get()
            ->map(function($meal) {
                return $this->formatMealData($meal, 'ar');
            });

        $meals_en = Meal::where('is_active', '1')
            ->with('sizes', 'extras')
            ->get()
            ->map(function($meal) {
                return $this->formatMealData($meal, 'en');
            });



        return view('menu.index' , compact('ads' , 'popular_meals' , 'feedbacks' , 'categories_ar' , 'categories_en' , 'meals_ar' , 'meals_en'));
    }

    public function offers() {

        $ads = Ad::all()->where('active' , true);

        return view('menu.offers'  , compact('ads')) ;
    }

    public function login_page() {
        return view('menu.log-in');
    }
    
    public function login( Request $request) {
    
        $client = Client::where('phone' , $request->phone)->first();
        
        // if (!$client || !Hash::check($request->password, $client->password)) {
        if (!$client) {
            return response()->json([
                'status' => 'error',
                'message' => "Invalid credentials",
                'error' => 'n_f'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Login Successful',
            'client' => $client,
        ]);
    }

    public function signup(Request $request)
    { 
        if ( count( Client::where('email', $request->email)->get() ) > 0 )  {
            return response()->json([
                'status' => 'error',
                'message' => 'Email already exists',
            ], 401);
        }

        if ( count( Client::where('phone', $request->phone)->get() ) > 0 )  {
            return response()->json([
                'status' => 'error',
                'message' => 'Phone already exists',
            ], 401);
        }


        $client = Client::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);


        // Must EMAIL , PHONE BE UNIQUE
        if ($client) {

            return response()->json([
                'status' => 'success',
                'message' => 'Signup Successful',
                'client' => $client,
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Signup Failed',
        ]);
    }


    public function book_page() {
        return view('menu.booking');
    }
    public function book( Request $request)
    {
        

        $rules = [
            'name' => 'required',
            'phone' => 'required | numeric',
            'guests' => 'required | numeric',
            'datetime' => 'required | date',
            'event' => 'required | string',
        ];

        $request->validate($rules);

        $booking = Booking::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'guests' => $request->guests,
            'datetime' => $request->datetime,
            'event' => $request->event,
        ]);


        // Send Mail
        Mail::to('anas01100335498@gmail.com')->send(new BookingMail($booking));
    

        return redirect()->back()->with('msg', 'Your booking has been sent successfully');
    }

    public function auth() {
        return redirect()->route('menu.login')->with('msg', 'You must be logged in ');
    }
    /**
     * Get all categories for menu
     */
    public function getCategories($local)
    {
        try {
            // الحصول على اللغة من الطلب
            $locale = $local;

            // استخدام Cache لتسريع الاستجابة (5 دقائق)
            $cacheKey = "categories_active_{$locale}";
            $categoriesData = Cache::remember($cacheKey, 300, function () use ($locale) {
                $categories = Category::where('is_active', true)
                    ->select('id', 'name_ar', 'name_en', 'description_ar', 'description_en', 'image', 'type', 'order')
                    ->orderBy('order')
                    ->orderBy('id')
                    ->get();

                return $categories->map(function ($category) use ($locale) {
                    return $this->formatCategoryData($category, $locale);
                });
            });

            \Log::info('Active categories count: ' . $categoriesData->count());

            return response()->json($categoriesData);
        } catch (\Exception $e) {
            \Log::error('Error in getCategories: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to load categories',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get meals by category for menu
     */
    public function getMealsByCategory($categoryId)
    {
        try {
            // الحصول على اللغة من الطلب
            $locale = request()->get('locale', 'ar');

            // استخدام Cache لتسريع الاستجابة (3 دقائق)
            $cacheKey = "meals_category_{$categoryId}_{$locale}";
            $mealsData = Cache::remember($cacheKey, 180, function () use ($categoryId, $locale) {
                // التحقق من وجود الفئة
                $category = Category::find($categoryId);
                if (!$category) {
                    return null;
                }
                $meals = Meal::where('category_id', $categoryId)
                    ->where('is_active', true)
                    ->where('is_available', true)
                    ->with(['sizes' => function($query) {
                        $query->where('is_active', true)->orderBy('sort_order');
                    }, 'extras' => function($query) {
                        $query->where('is_active', true)->orderBy('sort_order');
                    }])
                    ->select('id', 'name_ar', 'name_en', 'description_ar', 'description_en', 'discount_number', 'expiration_date', 'price', 'image', 'order')
                    ->orderByRaw('CASE WHEN `order` = 0 THEN id ELSE `order` END')
                    ->get();

                return $meals->map(function ($meal) use ($locale) {
                    return $this->formatMealData($meal, $locale);
                });
            });

            // إذا لم توجد الفئة
            if ($mealsData === null) {
                \Log::warning('Category not found: ' . $categoryId);
                return response()->json([
                    'error' => 'Category not found',
                    'message' => 'The requested category does not exist'
                ], 404);
            }

            \Log::info('Active and available meals for category ' . $categoryId . ': ' . $mealsData->count());

            return response()->json($mealsData);
        } catch (\Exception $e) {
            \Log::error('Error in getMealsByCategory: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to load meals',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get categories for cashier (Arabic names only)
     */
    public function getCategoriesForCashier()
    {
        try {
            // استخدام Cache للكاشير (10 دقائق - أطول لأن البيانات لا تتغير كثيراً)
            $cacheKey = "categories_cashier_ar";
            $categoriesData = Cache::remember($cacheKey, 600, function () {
                $categories = Category::where('is_active', true)
                    ->select('id', 'name_ar', 'name_en', 'description_ar', 'description_en', 'image', 'type', 'order')
                    ->orderBy('order')
                    ->orderBy('id')
                    ->get();

                return $categories->map(function ($category) {
                    return $this->formatCategoryData($category, 'ar');
                });
            });

            return response()->json($categoriesData);
        } catch (\Exception $e) {
            Log::error('Error in getCategoriesForCashier: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to load categories',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get meals by category for cashier (Arabic names only)
     */
    public function getMealsByCategoryForCashier($categoryId)
    {
        try {
            Log::info('Getting meals for category (cashier): ' . $categoryId);

            // استخدام Cache للكاشير (5 دقائق)
            $cacheKey = "meals_cashier_category_{$categoryId}";
            $mealsData = Cache::remember($cacheKey, 300, function () use ($categoryId) {
                // التحقق من وجود الفئة
                $category = Category::find($categoryId);
                if (!$category) {
                    return null;
                }

                $meals = Meal::where('category_id', $categoryId)
                    ->where('is_active', true)
                    ->where('is_available', true)
                    ->with(['sizes' => function($query) {
                        $query->where('is_active', true)->orderBy('sort_order');
                    }, 'extras' => function($query) {
                        $query->where('is_active', true)->orderBy('sort_order');
                    }])
                    ->select('id', 'name_ar', 'name_en', 'description_ar', 'description_en', 'price', 'image', 'order')
                    ->orderByRaw('CASE WHEN `order` = 0 THEN id ELSE `order` END')
                    ->get();

                return $meals->map(function ($meal) {
                    return $this->formatMealData($meal, 'ar');
                });
            });

            // إذا لم توجد الفئة
            if ($mealsData === null) {
                \Log::warning('Category not found: ' . $categoryId);
                return response()->json([
                    'error' => 'Category not found',
                    'message' => 'The requested category does not exist'
                ], 404);
            }

            \Log::info('Active and available meals for category ' . $categoryId . ': ' . $mealsData->count());

            return response()->json($mealsData);
        } catch (\Exception $e) {
            \Log::error('Error in getMealsByCategoryForCashier: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to load meals',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * مسح الـ Cache لتحديث البيانات
     */
    public function clearCache()
    {
        try {
            // مسح cache الفئات
            Cache::forget('categories_active_ar');
            Cache::forget('categories_active_en');
            Cache::forget('categories_cashier_ar');

            // مسح cache الوجبات (جميع الفئات)
            $categories = Category::pluck('id');
            foreach ($categories as $categoryId) {
                Cache::forget("meals_category_{$categoryId}_ar");
                Cache::forget("meals_category_{$categoryId}_en");
                Cache::forget("meals_cashier_category_{$categoryId}");
            }

            return response()->json([
                'success' => true,
                'message' => 'تم مسح الـ Cache بنجاح'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error clearing cache: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to clear cache',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
