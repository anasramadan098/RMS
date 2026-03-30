<?php

namespace App\Http\Controllers;

use App\Services\SearchService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    /**
     * Display search results page
     */
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        $results = [];
        $totalCount = 0;
        $formattedResults = [];

        if (!empty($query) && strlen($query) >= 2) {
            $results = $this->searchService->searchAll($query);
            $totalCount = $this->searchService->getTotalCount($results);
            $formattedResults = $this->searchService->formatResults($results);
        }

        return view('search.index', compact('query', 'results', 'totalCount', 'formattedResults'));
    }

    /**
     * AJAX search for autocomplete
     */
    public function suggestions(Request $request): JsonResponse
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        try {
            $suggestions = $this->searchService->getSearchSuggestions($query, 8);

            // If no real suggestions found, provide helpful fallback suggestions
            if (empty($suggestions)) {
                $suggestions = [
                    __('search.search_all_records', ['query' => $query]),
                    __('search.find_products', ['query' => $query]),
                    __('search.find_clients', ['query' => $query]),
                    __('search.find_suppliers', ['query' => $query])
                ];
            }

            return response()->json($suggestions);
        } catch (\Exception $e) {
            Log::error('Search suggestions error', ['error' => $e->getMessage()]);

            // Return fallback suggestions on error
            return response()->json([
                __('search.search_for', ['query' => $query]),
                __('search.view_all_products'),
                __('search.view_all_clients'),
                __('search.view_all_sales')
            ]);
        }
    }

    /**
     * Quick search API endpoint
     */
    public function quick(Request $request): JsonResponse
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json([
                'query' => $query,
                'results' => [],
                'total' => 0
            ]);
        }

        $results = $this->searchService->searchAll($query, 5); // Limit for quick search
        $totalCount = $this->searchService->getTotalCount($results);
        $formattedResults = $this->searchService->formatResults($results);

        return response()->json([
            'query' => $query,
            'results' => $formattedResults,
            'total' => $totalCount,
            'search_url' => route('search.index', ['q' => $query])
        ]);
    }

    /**
     * Search within specific model type
     */
    public function searchType(Request $request, string $type)
    {
        $query = $request->get('q', '');
        $results = [];

        if (!empty($query) && strlen($query) >= 2) {
            switch ($type) {
                case 'meals':
                    $results = $this->searchService->searchProducts($query, 50);
                    break;
                case 'clients':
                    $results = $this->searchService->searchClients($query, 50);
                    break;
                case 'orders':
                    $results = $this->searchService->searchSales($query, 50);
                    break;
                case 'costs':
                    $results = $this->searchService->searchCosts($query, 50);
                    break;
                case 'suppliers':
                    $results = $this->searchService->searchSuppliers($query, 50);
                    break;
                case 'projects':
                    $results = $this->searchService->searchProjects($query, 50);
                    break;
                default:
                    abort(404);
            }
        }

        return view('search.type', compact('query', 'results', 'type'));
    }
}
