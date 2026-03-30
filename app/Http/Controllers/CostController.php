<?php

namespace App\Http\Controllers;

use App\Models\Cost;
use App\Services\FilterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, FilterService $filterService)
    {
        // Create a model instance for filter configuration
        $costModel = new Cost();

        // Extract filters from request
        $filters = $filterService->extractFilters($request, array_keys($costModel->getFilterableAttributes()));

        $query = Cost::query();


        // Apply additional filters if any
        if (!empty($filters)) {
            $query->filter($filters);
        }

        // Get filtered costs with pagination
        $costs = $query->paginate(10)->withQueryString();

        // Get filter data for the view
        $filterData = $filterService->getFilterData($costModel, $filters);

        return view('costs.index', compact('costs', 'filterData', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get The Costs For The Authenticated User
        $costs = Cost::all();
        return view('costs.create', [
            'costs' => $costs,
            'user' => Auth::user()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valicreated_at the request
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'created_at' => 'required|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Create a new cost
        $cost = new Cost();
        $cost->name = $request->input('name');
        $cost->amount = $request->input('amount');
        $cost->created_at = $request->input('created_at');
        $cost->notes = $request->input('notes');
        $cost->save();

        return redirect()->route('costs.index')->with('msg', __('costs.cost_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Cost $cost)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cost $cost)
    {
        return view('costs.edit', [
            'cost' => $cost,
            'user' => Auth::user()
        ]);
    }

    /**
     * upcreated_ate the specified resource in storage.
     */
    public function update(Request $request, Cost $cost)
    {
        // Valicreated_at the request
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'created_at' => 'required|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        // upcreated_ate the cost
        $cost->name = $request->input('name');
        $cost->amount = $request->input('amount');
        $cost->created_at = $request->input('created_at');
        $cost->notes = $request->input('notes');
        $cost->save();

        return redirect()->route('costs.index')->with('msg', __('costs.cost_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cost $cost)
    {
        // Delete the cost
        $cost->delete();

        return redirect()->route('costs.index')->with('msg', __('costs.cost_deleted'));
    }
}
