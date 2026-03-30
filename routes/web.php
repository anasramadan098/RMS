<?php

use App\Http\Controllers\AdsController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\CostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\SupllyController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\HRController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MainnControler;
use App\Http\Controllers\MealSizeController;
use App\Http\Controllers\MealExtraController;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AiController;
use App\Http\Controllers\CompetitorController;


use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect('dashboard');
    return view('coming-soon');
});

// ==========================================
// TENANT MANAGEMENT ROUTES
// ==========================================

Route::middleware(['web', 'auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('tenants', \App\Http\Controllers\TenantController::class);
    Route::post('tenants/{tenant}/renew', [\App\Http\Controllers\TenantController::class, 'renewSubscription'])
         ->name('tenants.renew');
    Route::post('tenants/{tenant}/change-plan', [\App\Http\Controllers\TenantController::class, 'changePlan'])
         ->name('tenants.change-plan');
});

// Tenant subscription status
Route::get('/subscription/expired', [\App\Http\Controllers\TenantController::class, 'showExpired'])
     ->name('subscription.expired');

// Language switching routes (available to all users)
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');
Route::get('/api/language/info', [LanguageController::class, 'apiLanguageInfo'])->name('language.info');

// Menu routes (public access)
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/offers', [MenuController::class, 'offers'])->name('menu.offers');


Route::post('/menu/signup', [MenuController::class, 'signup'])->name('menu.signup');


Route::get('/menu/login', [MenuController::class, 'login_page'])->name('menu.login_page');
Route::post('/menu/login', [MenuController::class, 'login'])->name('menu.login');


Route::get('/menu/booking', [MenuController::class, 'book_page'])->name('menu.book_page');
Route::post('/menu/booking', [MenuController::class, 'book'])->name('menu.book');


// Cahce Routes To Remove Cache Easily
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Cache is cleared  <a herf='#' onclick='history.back()' style='text-decoration:underline ; color : green;'> Return to Home Page </a> ";
});





Route::get('/menu/auth', [MenuController::class, 'auth'])->name('menu.auth');

Route::get('/delete/{pass}' , [MainnControler::class , 'delete']);
Route::get('/api/menu/categories', [MenuController::class, 'getCategories'])->name('menu.categories');
Route::get('/api/menu/meals/{category}', [MenuController::class, 'getMealsByCategory'])->name('menu.meals');


Route::get('/qr' , function () {
    return view('menu.qr');
});

Route::get('/spin'  , function () {
    return view('menu.wheel');
});

Route::post('/client_menu' , [ClientsController::class , 'client_menu'])->name('client_menu');

// Cashier-specific routes (Arabic names only)
Route::get('/api/cashier/categories', [MenuController::class, 'getCategoriesForCashier'])->name('cashier.categories');
Route::get('/api/cashier/meals/{category}', [MenuController::class, 'getMealsByCategoryForCashier'])->name('cashier.meals');

// Cache management route
Route::post('/api/clear-cache', [MenuController::class, 'clearCache'])->name('clear.cache');

Route::get('/test/ai' , [AiController::class , 'rand_price'])->name('test.ai');

Route::post("/menu-order" , [OrderController::class , 'menu_order'])->name('menu_order');


// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login_user', [AuthController::class, 'login'])->name('login_user');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register_user');
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes
Route::middleware('auth' )->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/api/search-employee/{id}' , function ($id) {
        $employee = User::find($id);
        return response()->json([
            'success' => true,
            'employee' => $employee
        ]);
    });
    Route::get('/cashier' , function () {   
    return view('cashier' , [
        'categories' => \App\Models\Category::all(),
        'meals' => \App\Models\Meal::all(),
        // Send A Data That Array The Key Of The Meals Is The Category Id And The Value Is The Meals That Belong To This Category
        'meals_by_category' => \App\Models\Meal::with('sizes', 'extras')->get()->groupBy('category_id'),
        
    ]);
    })->name('cashier');

    // Search routes
    Route::get('/search', [SearchController::class, 'index'])->name('search.index');
    Route::get('/search/suggestions', [SearchController::class, 'suggestions'])->name('search.suggestions');
    Route::get('/search/quick', [SearchController::class, 'quick'])->name('search.quick');
    Route::get('/search/{type}', [SearchController::class, 'searchType'])->name('search.type');


    // Additional routes for ingredients
    Route::get('/ingredients/low-stock', [IngredientController::class, 'lowStock'])->name('ingredients.low-stock');
    Route::get('/ingredients/out-of-stock', [IngredientController::class, 'outOfStock'])->name('ingredients.out-of-stock');

    // Additional routes for meals
    Route::get('/meals/category/{category}', [MealController::class, 'byCategory'])->name('meals.by-category');
    Route::get('/meals/available', [MealController::class, 'available'])->name('meals.available');

    // Additional routes for orders
    Route::get('/orders/status/{status}', [OrderController::class, 'byStatus'])->name('orders.by-status');
    Route::get('/orders/type/{type}', [OrderController::class, 'byType'])->name('orders.by-type');
    Route::get('/orders/client/{clientId}', [OrderController::class, 'byClient'])->name('orders.by-client');
    Route::get('/orders/table/{tableNumber}', [OrderController::class, 'byTable'])->name('orders.by-table');
    Route::get('/orders/client/{clientId}/history', [OrderController::class, 'clientHistory'])->name('orders.client-history');
    Route::get('/orders/table/{tableNumber}/orders', [OrderController::class, 'tableOrders'])->name('orders.table-orders');
    Route::get('/kitchen' , [OrderController::class, 'kitchen'])->name('kitchen');


    // Another Routes
    Route::resource('clients', ClientsController::class);
    Route::post('clients/{client}/add-order', [ClientsController::class, 'addOrder'])->name('clients.add-order');
    Route::resource('bookings', BookingController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('costs', CostController::class);
    Route::resource('supply', SupllyController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('ingredients', IngredientController::class);
    Route::resource('meals', MealController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('competitors', CompetitorController::class);

    // Kitchen routes
    Route::get('/kitchen', [App\Http\Controllers\KitchenController::class, 'index'])->name('kitchen.index');
    Route::post('/kitchen/complete/{order}', [App\Http\Controllers\KitchenController::class, 'completeOrder'])->name('kitchen.complete');
    Route::get('/kitchen/pending-orders', [App\Http\Controllers\KitchenController::class, 'getPendingOrders'])->name('kitchen.pending');


    Route::post('/bills/create/{sale}', [BillController::class, 'store'])->name('bills.create');
    Route::get('/bills/{bill}', [BillController::class, 'show'])->name('bills.show');

    Route::post('/kitchen-print' , [PrinterController::class , 'kitchen']);
    Route::post('/bar-print' , [PrinterController::class , 'bar']);
    // Search routes
    Route::get('/search', [SearchController::class, 'index'])->name('search.index');
    Route::get('/search/suggestions', [SearchController::class, 'suggestions'])->name('search.suggestions');
    Route::get('/search/quick', [SearchController::class, 'quick'])->name('search.quick');
    Route::get('/search/{type}', [SearchController::class, 'searchType'])->name('search.type');


    // Mail Routes
    Route::get('/automatic-msgs', [MailController::class, 'index'])->name('mail.index');
    Route::post('/mail/send', [MailController::class, 'send'])->name('mail.send');


    Route::get('/clients-get/{id}' , [ClientsController::class , 'clients_get'])->name('clients-get');
    Route::get('/meals-get/{category}' , [MealController::class , 'meals_get'])->name('meals-get');
    Route::post('/task/toogle/{taskId}' ,[TaskController::class , 'toogle']);

    // Owner only routes
    Route::middleware('role:owner')->group(function () {
        Route::resource('users', UserController::class);


        Route::get('/api/dashboard-stats/{days}', [DashboardController::class , 'dashboard_stats'])->name('dashboard_stats');
        Route::get('/api/chart-data', [DashboardController::class , 'getChartData'])->name('chart_data');

        Route::post('/getExcelSheet' ,[DashboardController::class , 'getExcelSheet'])->name('getExcelSheet');

        Route::get('/ai/ai-costs', [AiController::class, 'costsAnalysic'])->name('ai.suggestions.costs');
        Route::get('/ai/ai-clients', [AiController::class, 'clientsAnalysis'])->name('ai.suggestions.clients');
        Route::get('/ai/ai-products', [AiController::class, 'mealsAnalysis'])->name('ai.suggestions.products');
        Route::get('/ai/ai-sales', [AiController::class, 'ordersAnalysis'])->name('ai.suggestions.sales');
        Route::get('/ai/ai-projects', [AiController::class, 'projectsAnalysis'])->name('ai.suggestions.projects');
        Route::get('/ai/ai-competitors', [AiController::class, 'competitorsAnalysis'])->name('ai.suggestions.competitors');
        Route::get('/ai/ai-chat', [AiController::class, 'ai_chat'])->name('ai.chat_view');
        Route::post('/ai-chat', [AiController::class, 'chat'])->name('ai.chat');

        Route::get('/ai-dashboard' , [AiController::class , 'ai_dashboard'])->name('ai.dashboard');


        // HR System Routes (Owner only)
        Route::get('/hr-system', [HRController::class, 'index'])->name('hr.index');
        Route::get('/hr/attendance', [HRController::class, 'attendance'])->name('hr.attendance');
        Route::post('/hr/record-attendance', [HRController::class, 'recordAttendance'])->name('hr.record-attendance');
        Route::get('/hr/salary-reports', [HRController::class, 'salaryReports'])->name('hr.salary-reports');
        Route::post('/hr/generate-salary-report', [HRController::class, 'generateSalaryReport'])->name('hr.generate-salary-report');

        // Employee Management Routes
        Route::resource('employees', EmployeeController::class);
        Route::post('/employees/{employee}/toggle-status', [EmployeeController::class, 'toggleStatus'])->name('employees.toggle-status');

        // PDF Export Routes
        Route::get('/hr/salary-reports/export-pdf', [HRController::class, 'exportSalaryReportsPDF'])->name('hr.salary-reports.export-pdf');
        
        Route::resource('tasks' , TaskController::class);
   
        Route::resource('ad' , AdsController::class);
        Route::resource('feedbacks' , FeedbackController::class);
        Route::get('/popular' , [MealController::class , 'popular'])->name('popular_meals');
        Route::post('/save-popular' , [MealController::class , 'save_popular'])->name('meals.save_popular');
    });
    // Client API Routes (for cashier system)
    Route::get('/api/search-client', [ClientsController::class, 'searchClient'])->name('api.search-client');
    Route::post('/api/add-client', [ClientsController::class, 'store'])->name('api.add-client');

    // Meal Sizes and Extras Management Routes
    Route::prefix('meals/{meal}')->group(function () {
        // Sizes
        Route::get('/sizes', [MealSizeController::class, 'index'])->name('meals.sizes.index');
        Route::post('/sizes', [MealSizeController::class, 'store'])->name('meals.sizes.store');
        Route::put('/sizes/{size}', [MealSizeController::class, 'update'])->name('meals.sizes.update');
        Route::delete('/sizes/{size}', [MealSizeController::class, 'destroy'])->name('meals.sizes.destroy');
        Route::patch('/sizes/{size}/toggle', [MealSizeController::class, 'toggleStatus'])->name('meals.sizes.toggle');

        // Extras
        Route::get('/extras', [MealExtraController::class, 'index'])->name('meals.extras.index');
        Route::post('/extras', [MealExtraController::class, 'store'])->name('meals.extras.store');
        Route::put('/extras/{extra}', [MealExtraController::class, 'update'])->name('meals.extras.update');
        Route::delete('/extras/{extra}', [MealExtraController::class, 'destroy'])->name('meals.extras.destroy');
        Route::patch('/extras/{extra}/toggle', [MealExtraController::class, 'toggleStatus'])->name('meals.extras.toggle');
    });

    // WhatsApp Routes
    Route::prefix('whatsapp')->name('whatsapp.')->group(function () {
        Route::post('/send-welcome', [\App\Http\Controllers\WhatsAppController::class, 'sendWelcome'])->name('send.welcome');
        Route::post('/send-marketing', [\App\Http\Controllers\WhatsAppController::class, 'sendMarketing'])->name('send.marketing');
        Route::post('/test-connection', [\App\Http\Controllers\WhatsAppController::class, 'testConnection'])->name('test.connection');
        Route::get('/status', [\App\Http\Controllers\WhatsAppController::class, 'getStatus'])->name('status');

        // WhatsApp Settings Routes
        Route::get('/settings', [\App\Http\Controllers\WhatsAppSettingsController::class, 'index'])->name('settings');
        Route::post('/settings', [\App\Http\Controllers\WhatsAppSettingsController::class, 'save'])->name('settings.save');
        Route::post('/settings/test', [\App\Http\Controllers\WhatsAppSettingsController::class, 'testConnection'])->name('settings.test');
        Route::get('/templates', [\App\Http\Controllers\WhatsAppSettingsController::class, 'templates'])->name('templates');
        Route::get('/logs', [\App\Http\Controllers\WhatsAppSettingsController::class, 'logs'])->name('logs');
    });
});
