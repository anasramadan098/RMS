<?php

namespace App\Http\Controllers;

use App\Models\Cost;
use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\Supply;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ingredients = Ingredient::withCount('meals')->with('supplier')->paginate(10);
        
        return view('ingredients.index' , compact('ingredients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supply::all();
        return view('ingredients.create', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'unit' => 'required|string|max:50',
            'price_per_unit' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'expiry_date' => 'nullable|date',
            'image' => 'nullable|string',
            'is_active' => 'boolean',
            'supplier_id' => 'required|exists:suppliers,id',
        ]);
        $data = $request->all();
        $ingredient = new Ingredient($data);
        $ingredient->supplier_id = $request->input('supplier_id');
        $ingredient->save();

        // Create Cost
        $cost  = new Cost();
        
        $cost->name = $request->input('name');
        $cost->amount = $request->input('price_per_unit');
        $cost->save();

        return redirect()->route('ingredients.index')->with('msg', __('ingredients.ingredient_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Ingredient $ingredient)
    {
        $ingredient->load('meals');
        return view('ingredients.show', compact('ingredient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ingredient $ingredient)
    {
        $suppliers = Supply::all();
        return view('ingredients.edit', compact('ingredient', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ingredient $ingredient)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'unit' => 'required|string|max:50',
            'price_per_unit' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'expiry_date' => 'nullable|date',
            'image' => 'nullable|string',
            'is_active' => 'boolean',
            'supplier_id' => 'required|exists:suppliers,id',
        ]);

        $ingredient->update($request->all());
        $ingredient->supplier_id = $request->input('supplier_id');
        $ingredient->save();

        // Update Cost
        $cost = Cost::where('name', $ingredient->name)->first();
        $cost->amount = $request->input('price_per_unit');
        $cost->save();

        return redirect()->route('ingredients.index')->with('msg', __('ingredients.ingredient_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();
        return redirect()->route('ingredients.index')->with('msg', __('ingredients.ingredient_deleted'));
    }

    /**
     * Get low stock ingredients.
     */
    public function lowStock()
    {
        $ingredients = Ingredient::lowStock()->get();
        return response()->json($ingredients);
    }

    /**
     * Get out of stock ingredients.
     */
    public function outOfStock()
    {
        $ingredients = Ingredient::outOfStock()->get();
        return response()->json($ingredients);
    }
}
