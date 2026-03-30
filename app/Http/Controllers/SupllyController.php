<?php

namespace App\Http\Controllers;

use App\Models\ingredient;
use App\Models\Supply;
use App\Services\FilterService;
use Illuminate\Http\Request;

class SupllyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, FilterService $filterService)
    {
        // Create a model instance for filter configuration
        $supplyModel = new Supply();

        // Extract filters from request
        $filters = $filterService->extractFilters($request, array_keys($supplyModel->getFilterableAttributes()));

        // Apply filters to the query
        $query = Supply::withCount('ingredients');
        if (!empty($filters)) {
            $query = $query->filter($filters);
        }

        // Get filtered supplies with pagination
        $supply = $query->paginate(10)->withQueryString();

        // Get filter data for the view
        $filterData = $filterService->getFilterData($supplyModel, $filters);

        return view('supply.index', compact('supply', 'filterData', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Supply $supply)
    {
        return view('supply.create' , compact('supply'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_name' => 'required|string|max:255',
            'contact_number' => 'required|min:0',
            'email' => 'nullable|email|min:0',
            'notes' => 'nullable|string|min:0',
            'is_active' => 'nullable | in:on,off',
        ]);
        $validated['is_active'] = $request->has('is_active') ? true : false;
        $supply = new Supply($validated);
        $supply->save();
        return redirect()->route('supply.index')->with('msg', __('suppliers.supplier_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Supply $supply)
    {
        $ingredients = ingredient::where('supply_id' , $supply->id)->get();
        return view('supply.show', compact('supply' , 'ingredients'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supply $supply)
    {
        $ingredients = ingredient::where('supply_id' , $supply->id)->get();
        return view('supply.edit', compact('supply' , 'ingredients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supply $supply)
    {
        $validated = $request->validate([
            'supplier_name' => 'required|string|max:255',
            'contact_number' => 'required|min:0',
            'email' => 'nullable|email|min:0',
            'notes' => 'nullable|string|min:0',
            'is_active' => 'nullable | in:on,off',
        ]);
        $validated['is_active'] = $request->has('is_active') ? true : false;
        $supply->update($validated);

        return redirect()->route('supply.index')->with('msg', __('suppliers.supplier_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supply $supply)
    {
        try {
            // Check if supplier has any ingredients
            $ingredientsCount = $supply->ingredients()->count();

            if ($ingredientsCount > 0) {
                return redirect()->route('supply.index')
                    ->with('error', __('suppliers.cannot_delete_supplier_has_ingredients', ['count' => $ingredientsCount]));
            }

            $supply->delete();
            return redirect()->route('supply.index')->with('msg', __('suppliers.supplier_deleted'));

        } catch (\Exception $e) {
            return redirect()->route('supply.index')
                ->with('error', __('suppliers.error_deleting_supplier'));
        }
    }
}
