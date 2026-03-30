<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Cost;
use App\Models\Ingredient;
use App\Models\Meal;
use App\Models\Order;
use App\Models\Supply;
use App\Models\Project;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class SearchService
{
    /**
     * Search across all models
     */
    public function searchAll(string $query, int $limit = 50): array
    {
        $results = [
            'meals' => $this->searchmeals($query, $limit),
            'clients' => $this->searchClients($query, $limit),
            'orders' => $this->searchorders($query, $limit),
            'costs' => $this->searchCosts($query, $limit),
            'suppliers' => $this->searchSuppliers($query, $limit),
            'projects' => $this->searchProjects($query, $limit),
            'ingredients' => $this->searchIngredients($query, $limit),
        ];

        return $results;
    }

    /**
     * Get total count of search results
     */
    public function getTotalCount(array $results): int
    {
        return array_sum(array_map(function($collection) {
            return $collection->count();
        }, $results));
    }

    /**
     * Search meals
     */
    public function searchmeals(string $query, int $limit = 10): Collection
    {
        return Meal::where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhere('category', 'LIKE', "%{$query}%")
                  ->orWhere('brand', 'LIKE', "%{$query}%")
                  ->orWhere('sku', 'LIKE', "%{$query}%")
                  ->orWhere('supplier', 'LIKE', "%{$query}%")
                  ->orWhereHas('category', function($cq) use ($query) {
                      $cq->where('name', 'LIKE', "%{$query}%");
                  });
            })
            ->limit($limit)
            ->get();
    }

    /**
     * Search clients
     */
    public function searchClients(string $query, int $limit = 10): Collection
    {
        return Client::where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('email', 'LIKE', "%{$query}%")
                  ->orWhere('phone', 'LIKE', "%{$query}%")
                  ->orWhere('address', 'LIKE', "%{$query}%")
                  ->orWhere('city', 'LIKE', "%{$query}%")
                  ->orWhere('state', 'LIKE', "%{$query}%")
                  ->orWhere('country', 'LIKE', "%{$query}%");
            })
            ->limit($limit)
            ->get();
    }

    /**
     * Search orders
     */
    public function searchorders(string $query, int $limit = 10): Collection
    {
        return Order::with(['client', 'orderItems.meal'])
            ->where(function($q) use ($query) {
                $q->where('status', 'LIKE', "%{$query}%")
                  ->orWhere('payment_method', 'LIKE', "%{$query}%")
                  ->orWhere('notes', 'LIKE', "%{$query}%")
                  ->orWhereHas('client', function($cq) use ($query) {
                      $cq->where('name', 'LIKE', "%{$query}%");
                  });
            })
            ->limit($limit)
            ->get();
    }

    /**
     * Search costs (user-specific)
     */
    public function searchCosts(string $query, int $limit = 10): Collection
    {
        $userId = Auth::id();
        
        return Cost::with('user')
            ->where('user_id', $userId)
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->limit($limit)
            ->get();
    }

    /**
     * Search suppliers
     */
    public function searchSuppliers(string $query, int $limit = 10): Collection
    {
        return Supply::withCount('ingredients')
            ->where(function($q) use ($query) {
                $q->where('supplier_name', 'LIKE', "%{$query}%")
                  ->orWhere('contact_number', 'LIKE', "%{$query}%")
                  ->orWhere('email', 'LIKE', "%{$query}%");
            })
            ->limit($limit)
            ->get();
    }

    /**
     * Search projects (user-specific)
     */
    public function searchProjects(string $query, int $limit = 10): Collection
    {
        $userId = Auth::id();
        
        return Project::with('user')
            ->where('user_id', $userId)
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhere('status', 'LIKE', "%{$query}%");
            })
            ->limit($limit)
            ->get();
    }

    public function searchIngredients(string $query, int $limit = 10): Collection
    {
        return Ingredient::where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->limit($limit)
            ->get();
    }

    /**
     * Get search suggestions based on query
     */
    public function getSearchSuggestions(string $query, int $limit = 5): array
    {
        $suggestions = [];

        // meal suggestions
        $mealSuggestions = Meal::where('name', 'LIKE', "%{$query}%")
            ->limit($limit)
            ->pluck('name')
            ->toArray();

        // Client suggestions
        $clientSuggestions = Client::where('name', 'LIKE', "%{$query}%")
            ->limit($limit)
            ->pluck('name')
            ->toArray();

        // Supplier suggestions
        $supplierSuggestions = Supply::where('supplier_name', 'LIKE', "%{$query}%")
            ->limit($limit)
            ->pluck('supplier_name')
            ->toArray();

        // Ingredient suggestions
        $ingredientSuggestions = Ingredient::where('name', 'LIKE', "%{$query}%")
            ->limit($limit)
            ->pluck('name')
            ->toArray();
        
        // Merge all suggestions
        $suggestions = array_merge($mealSuggestions, $clientSuggestions, $supplierSuggestions, $ingredientSuggestions);
        
        return array_unique(array_slice($suggestions, 0, $limit));
    }

    /**
     * Format search results for display
     */
    public function formatResults(array $results): array
    {
        $formatted = [];

        foreach ($results as $type => $collection) {
            $formatted[$type] = [
                'count' => $collection->count(),
                'items' => $collection->map(function($item) use ($type) {
                    return $this->formatItem($item, $type);
                })
            ];
        }

        return $formatted;
    }

    /**
     * Format individual item for display
     */
    private function formatItem($item, string $type): array
    {
        switch ($type) {
            case 'meals':
                return [
                    'id' => $item->id,
                    'title' => $item->name,
                    'subtitle' => $item->category->name ?? 'No category',
                    'description' => $item->description,
                    'price' => $item->price ? '$' . number_format($item->price, 2) : null,
                    'url' => route('meals.show', $item->id),
                    'icon' => 'fas fa-box',
                    'color' => 'primary'
                ];

            case 'clients':
                return [
                    'id' => $item->id,
                    'title' => $item->name,
                    'subtitle' => $item->email,
                    'description' => $item->city . ', ' . $item->country,
                    'url' => route('clients.show', $item->id),
                    'icon' => 'fas fa-user',
                    'color' => 'success'
                ];

            case 'orders':
                return [
                    'id' => $item->id,
                    'title' => 'order #' . $item->id,
                    'subtitle' => $item->client->name ?? 'Unknown Client',
                    'description' => $item->meal->name_en?? 'Unknown meal',
                    'price' => '$' . number_format($item->total ?? $item->price, 2),
                    'url' => route('orders.show', $item->id),
                    'icon' => 'fas fa-chart-line',
                    'color' => 'info'
                ];

            case 'costs':
                return [
                    'id' => $item->id,
                    'title' => $item->name,
                    'subtitle' => 'Cost',
                    'description' => 'Amount: $' . number_format($item->amount, 2),
                    'url' => route('costs.edit', $item->id),
                    'icon' => 'fas fa-coins',
                    'color' => 'warning'
                ];

            case 'suppliers':
                return [
                    'id' => $item->id,
                    'title' => $item->supplier_name,
                    'subtitle' => $item->email,
                    'description' => $item->meals_count . ' meals',
                    'url' => route('supply.show', $item->id),
                    'icon' => 'fas fa-truck',
                    'color' => 'secondary'
                ];

            case 'projects':
                return [
                    'id' => $item->id,
                    'title' => $item->name,
                    'subtitle' => ucfirst($item->status),
                    'description' => $item->description,
                    'url' => route('projects.show', $item->id),
                    'icon' => 'fas fa-project-diagram',
                    'color' => 'dark'
                ];
                case 'ingredients':
                return [
                    'id' => $item->id,
                    'title' => $item->name,
                    'subtitle' => 'Stock: ' . $item->stock_quantity . ' ' . $item->unit,
                    'description' => 'Price: $' . number_format($item->price_per_unit, 2),
                    'url' => route('ingredients.show', $item->id),
                    'icon' => 'fas fa-box',
                    'color' => 'primary'
                ];

            default:
                return [
                    'id' => $item->id,
                    'title' => $item->name ?? 'Unknown',
                    'subtitle' => ucfirst($type),
                    'description' => '',
                    'url' => '#',
                    'icon' => 'fas fa-question',
                    'color' => 'secondary'
                ];
        }
    }
}
