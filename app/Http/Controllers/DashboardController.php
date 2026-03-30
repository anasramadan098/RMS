<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Client;
use App\Models\Cost;
use App\Models\Meal;
use App\Models\Order;
use App\Models\Supply;
use App\Models\Ingredient;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DashboardController extends Controller
{
    /**
     * Show the dashboard based on user role
     */
    public function index()
    {

        $user = Auth::user();

        if ($user->isOwner()) {
            return $this->ownerDashboard();
        } else {
            return $this->employeeDashboard();
        }
    }

    /**
     * Show owner dashboard
     */
    private function ownerDashboard()
    {
        $totalEmployees = User::where('role', 'employee')->count();
        $totalUsers = User::count();


        return view('home', compact('totalEmployees', 'totalUsers'));
    }

    /**
     * Show employee dashboard
     */
    private function employeeDashboard()
    {
        $clients = Client::all();
        $user = Auth::user();
        $categories = Category::all();
        $meals = Meal::all();
        $tasks = Auth::user()->tasks()->get();
        $all_tasks = $tasks->where('status' , '!=' , 'completed')->count();
        return view('dashboard.employee', compact('clients', 'user', 'categories', 'meals' , 'tasks' , 'all_tasks'));
    }


    // API
        // dashboard_stats
    public function dashboard_stats($days)
    {
        // Client
        $client_count = Client::getNewClientsStats($days)['target_results']->count();
        $client_percentage = Client::getNewClientsStats($days)['percentage'];

        // Product
        $product_count = Meal::sortByDate($days)['target_results']->count();
        $product_percentage = Meal::sortByDate($days)['percentage'];
        // Cost
        $cost_count = Cost::getSumStatsByDate($days)['target_results']->sum('amount');
        $cost_percentage = Cost::getSumStatsByDate($days)['percentage'];
        // Order
        $sale_count = Order::sortByDate($days)['target_results']->count();
        $sale_percentage = Order::sortByDate($days)['percentage'];

        // Fix: Use sum() instead of count() for profits
        $profits_count = Order::sumPrices($days)['target_results']->sum('price');
        $profits_percentage = Order::sumPrices($days)['percentage'];

        // Get Supply
        $supply_count = Supply::getStatsByDate($days)['target_results']->count();
        $supply_percentage = Supply::getStatsByDate($days)['percentage'];

        return response()->json(compact(
            'client_count' ,
            'client_percentage',
            'product_count'  ,
            'product_percentage' ,
            'cost_count',
            'cost_percentage' ,
            'sale_count'  ,
            'sale_percentage' ,
            'profits_count'  ,
            'profits_percentage' ,
            'supply_count',
            'supply_percentage'
        ));
    }

    // Get chart data for dashboard
    public function getChartData()
    {
        $user_id = Auth::id();

        // Monthly sales data for the last 12 months

        $monthlyData = Order::selectRaw("strftime('%m-%Y', created_at) as month, COUNT(*) as sales, SUM(total_amount) as revenue")
        ->where('status', '!=', 'cancelled')
        ->groupBy('month')
        ->orderBy('created_at')
        ->limit(12)
        ->get()
        ->toArray();


        $monthlySales = array_column($monthlyData, 'sales');
        $monthlyRevenue = array_column($monthlyData, 'revenue');
        $monthlyLabels = array_column($monthlyData, 'month');

        // Meal categories distribution
        $categories = Meal::join('categories', 'meals.category_id', '=', 'categories.id')
            ->select('categories.name as category')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('categories.name')
            ->get()
            ->toArray();

        // Top 5 meals by orders
        $topProducts = Meal::select('meals.name')
            ->selectRaw('IFNULL(SUM(order_items.quantity), 0) as total_sold')
            ->leftJoin('order_items', 'meals.id', '=', 'order_items.meal_id')
            ->leftJoin('orders', 'order_items.order_id', '=', 'orders.id')
            ->where(function($query) {
                $query->whereNull('orders.status')
                      ->orWhere('orders.status', '!=', 'cancelled');
            })
            ->groupBy('meals.id', 'meals.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get()
            ->toArray();

        // Client growth over last 6 months
        $clientGrowth = [];
        $clientLabels = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthEnd = $date->copy()->endOfMonth();

            $clientCount = Client::where('created_at', '<=', $monthEnd)->count();
            $clientGrowth[] = $clientCount;
            $clientLabels[] = $date->format('M Y');
        }

        // Sales vs Costs comparison
        $salesVsCosts = [];
        $costsData = [];
        $salesVsCostsLabels = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthStart = $date->copy()->startOfMonth();
            $monthEnd = $date->copy()->endOfMonth();

            $salesAmount = Order::whereBetween('created_at', [$monthStart, $monthEnd])->where('status', '!=', 'cancelled')->sum('total_amount');
            $costsAmount = Cost::whereBetween('created_at', [$monthStart, $monthEnd])->sum('amount');

            $salesVsCosts[] = $salesAmount;
            $costsData[] = $costsAmount;
            $salesVsCostsLabels[] = $date->format('M Y');
        }

        // Revenue distribution by order type
        $paymentMethods = Order::select('order_type as payment_method')
            ->selectRaw('SUM(total_amount) as total_revenue')
            ->where('status', '!=', 'cancelled')
            ->groupBy('order_type')
            ->get()
            ->toArray();

        $sales_funnel = Client::select('type')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('type')
            ->get()
            ->toArray();

        $leads = 0;
        $prospects = 0;
        $customers = 0;

        foreach ($sales_funnel as $funnel) {
            if ($funnel['type'] == 'lead') {
                $leads = $funnel['count'];
            } elseif ($funnel['type'] == 'prospect') {
                $prospects = $funnel['count'];
            } elseif ($funnel['type'] == 'customer') {
                $customers = $funnel['count'];
            }
        }

        return response()->json([
            'monthly_sales' => [
                'labels' => $monthlyLabels,
                'sales' => $monthlySales,
                'revenue' => $monthlyRevenue
            ],
            'categories' => [
                'labels' => array_column($categories, 'category'),
                'data' => array_column($categories, 'count')
            ],
            'top_products' => [
                'labels' => array_column($topProducts, 'name'),
                'data' => array_column($topProducts, 'total_sold')
            ],
            'client_growth' => [
                'labels' => $clientLabels,
                'data' => $clientGrowth
            ],
            'sales_vs_costs' => [
                'labels' => $salesVsCostsLabels,
                'sales' => $salesVsCosts,
                'costs' => $costsData
            ],
            'payment_methods' => [
                'labels' => array_column($paymentMethods, 'payment_method'),
                'data' => array_column($paymentMethods, 'total_revenue')
            ],
            'stock_status' => [
                'in' => Ingredient::whereRaw('stock_quantity > min_stock_level')->count(),
                'low' => Ingredient::whereRaw('stock_quantity <= min_stock_level AND stock_quantity > 0')->count(),
                'out' => Ingredient::where('stock_quantity', '<=', 0)->count()
            ],
            'ingredients_alerts' => $this->getIngredientsAlerts(),
            'expiry_alerts' => $this->getExpiryAlerts(),
            'performace_status' => [
                'sales' => Order::where('status', '!=', 'cancelled')->count(),
                'clients' => Client::count(),
                'products' => Meal::count(),
                'costs' => Cost::count(),
                'supply' => Supply::count(),
            ],
            'sales_funnel' => [
                'leads' => $leads,
                'prospects' => $prospects,
                'customers' => $customers
            ]
        ]);
    }

    /**
     * Get ingredients that need attention (low stock or near expiry)
     */
    private function getIngredientsAlerts()
    {
        // Get ingredients with low stock
        $lowStockIngredients = Ingredient::whereRaw('stock_quantity <= min_stock_level')
            ->where('stock_quantity', '>', 0)
            ->select('name', 'stock_quantity', 'min_stock_level')
            ->get()
            ->map(function ($ingredient) {
                return [
                    'name' => $ingredient->name,
                    'type' => 'مخزون منخفض',
                    'value' => $ingredient->stock_quantity,
                    'threshold' => $ingredient->min_stock_level,
                    'status' => 'warning'
                ];
            });

        // Get out of stock ingredients
        $outOfStockIngredients = Ingredient::where('stock_quantity', '<=', 0)
            ->select('name', 'stock_quantity')
            ->get()
            ->map(function ($ingredient) {
                return [
                    'name' => $ingredient->name,
                    'type' => 'نفد المخزون',
                    'value' => 0,
                    'threshold' => 0,
                    'status' => 'danger'
                ];
            });

        // Combine all alerts
        $allAlerts = $lowStockIngredients->concat($outOfStockIngredients);

        return [
            'labels' => $allAlerts->pluck('name')->toArray(),
            'data' => $allAlerts->pluck('value')->toArray(),
            'types' => $allAlerts->pluck('type')->toArray(),
            'statuses' => $allAlerts->pluck('status')->toArray(),
            'count' => $allAlerts->count(),
            'details' => $allAlerts->toArray()
        ];
    }

    /**
     * Get ingredients that are near expiry
     */
    private function getExpiryAlerts()
    {
        // Get ingredients expiring within 7 days
        $nearExpiryIngredients = Ingredient::whereNotNull('expiry_date')
            ->where('expiry_date', '<=', now()->addDays(7))
            ->where('expiry_date', '>=', now())
            ->select('name', 'expiry_date')
            ->get()
            ->map(function ($ingredient) {
                $daysLeft = (int) now()->diffInDays($ingredient->expiry_date, false);
                return [
                    'name' => $ingredient->name,
                    'type' => 'ينتهي خلال ' . $daysLeft . ' أيام',
                    'value' => $daysLeft,
                    'expiry_date' => $ingredient->expiry_date->format('Y-m-d'),
                    'status' => $daysLeft <= 3 ? 'danger' : 'warning'
                ];
            });

        // Get expired ingredients
        $expiredIngredients = Ingredient::whereNotNull('expiry_date')
            ->where('expiry_date', '<', now())
            ->select('name', 'expiry_date')
            ->get()
            ->map(function ($ingredient) {
                $daysExpired = (int) now()->diffInDays($ingredient->expiry_date, false);
                return [
                    'name' => $ingredient->name,
                    'type' => 'منتهي منذ ' . abs($daysExpired) . ' أيام',
                    'value' => 0,
                    'expiry_date' => $ingredient->expiry_date->format('Y-m-d'),
                    'status' => 'danger'
                ];
            });

        // Combine all expiry alerts
        $allExpiryAlerts = $nearExpiryIngredients->concat($expiredIngredients);

        return [
            'labels' => $allExpiryAlerts->pluck('name')->toArray(),
            'data' => $allExpiryAlerts->pluck('value')->toArray(),
            'types' => $allExpiryAlerts->pluck('type')->toArray(),
            'statuses' => $allExpiryAlerts->pluck('status')->toArray(),
            'expiry_dates' => $allExpiryAlerts->pluck('expiry_date')->toArray(),
            'count' => $allExpiryAlerts->count(),
            'details' => $allExpiryAlerts->toArray()
        ];
    }

    public function getExcelSheet() {

        $type = request('type');
        $days = request('days');

        $data = [];
        $user_id = Auth::id();

        if ($type == 'clients' || $type == 'all') {
            $client_numbers = Client::getNewClientsStats($days)['target_results'];
            foreach ($client_numbers as $client) {
                $data['Clients'][] = [
                    'name' => $client->name,
                    'email' => $client->email,
                    'phone' => $client->phone,
                    'address' => $client->address,
                    'First Purchase' => $client->created_at,
                ];
            }
        } if ($type == 'meals' || $type == 'all') {
            $meal_numbers = Meal::getStatsByDate($days)['target_results'];
            foreach ($meal_numbers as $meal) {
                $data['Meals'][] = [
                    'name' => $meal->name_en,
                    'price' => $meal->price,
                    'created_at' => $meal->created_at,
                ];
            }
        } if ($type == 'costs' || $type == 'all') {
            $cost_numbers = Cost::getStatsByDate($days)['target_results'];
            foreach ($cost_numbers as $cost) {
                $data['Costs'][] = [
                    'name' => $cost->name,
                    'amount' => $cost->amount,
                    'created_at' => $cost->created_at,
                ];
            }
        } if ($type == 'orders' || $type == 'all') {
            $sales_numbers = Order::getStatsByDate($days)['target_results'];
            foreach ($sales_numbers as $sale) {
                $data['Orders'][] = [
                    'order_number' => $sale->order_number,
                    'customer_name' => $sale->customer_name,
                    'total_amount' => $sale->total_amount,
                    'status' => $sale->status,
                    'created_at' => $sale->created_at,
                ];
            }
        }
        if ($type == 'supply' || $type == 'all') {
            $supply_numbers = Supply::getStatsByDate($days)['target_results'];
            foreach ($supply_numbers as $supply) {
                $data['Supply'][] = [
                    'supplier_id' => $supply->id,
                    'supplier_name' => $supply->supplier_name,
                    'contact_number' => $supply->contact_number,
                    'email' => $supply->email,
                    'created_at' => $supply->created_at,
                ];
            }
        }


        // Excel Sheet with formatting
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $rowNum = 1;

        if ($data == []) {
            return redirect()->back()->with('msg', 'No data found for the selected type and date range.');
        }

        foreach ($data as $section => $rows) {
            // Section Title: Merge, Bold, Gray Background, Center
            $colCount = isset($rows[0]) ? count($rows[0]) : 1;
            $lastCol = chr(ord('A') + $colCount - 1);
            $mergeRange = "A{$rowNum}:{$lastCol}{$rowNum}";
            $sheet->mergeCells($mergeRange);
            $sheet->setCellValue('A' . $rowNum, $section);

            // Style for section title
            $sheet->getStyle($mergeRange)->applyFromArray([
            'font' => ['bold' => true, 'size' => 13],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D9D9D9'],
            ],
            ]);
            $rowNum++;

            // If there is data
            if (isset($rows[0]) && is_array($rows[0])) {
            // Headers: Bold, Different Background, Center
            $col = 'A';
            foreach (array_keys($rows[0]) as $header) {
                $sheet->setCellValue($col . $rowNum, $header);
                $sheet->getStyle($col . $rowNum)->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'BDD7EE'],
                ],
                ]);
                $col++;
            }
            $rowNum++;

            // Data rows: Centered
            foreach ($rows as $row) {
                $col = 'A';
                foreach ($row as $value) {
                $sheet->setCellValue($col . $rowNum, $value);
                $sheet->getStyle($col . $rowNum)->applyFromArray([
                    'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $col++;
                }
                $rowNum++;
            }
            }
            $rowNum++; // Separator row between sections
        }

        // Auto-size columns
        foreach (range('A', $lastCol) as $colID) {
            $sheet->getColumnDimension($colID)->setAutoSize(true);
        }

        // Save the file temporarily
        $writer = new Xlsx($spreadsheet);
        $fileName = 'report_' . date('Ymd_His') . '.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);

        // Return the file for download
        return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);

    }
}
