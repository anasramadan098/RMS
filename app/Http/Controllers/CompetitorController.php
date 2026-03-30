<?php

namespace App\Http\Controllers;

use App\Models\Competitor;
use Illuminate\Http\Request;

class CompetitorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $competitors = Competitor::orderBy('id', 'desc')->paginate(10);
        return view('competitors.index', compact('competitors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('competitors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'avg_price_range' => 'required|numeric|min:0|max:999999.99',
            'twitter' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'tiktok' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'strengths' => 'nullable|string',
            'weaknesses' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Competitor::create($validated);

        return redirect()->route('competitors.index')
            ->with('success', __('competitors.competitor_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Competitor $competitor)
    {
        return view('competitors.show', compact('competitor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Competitor $competitor)
    {
        return view('competitors.edit', compact('competitor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Competitor $competitor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'avg_price_range' => 'required|numeric|min:0|max:999999.99',
            'twitter' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'tiktok' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'strengths' => 'nullable|string',
            'weaknesses' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $competitor->update($validated);

        return redirect()->route('competitors.index')
            ->with('success', __('competitors.competitor_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Competitor $competitor)
    {
        $competitor->delete();

        return redirect()->route('competitors.index')
            ->with('success', __('competitors.competitor_deleted'));
    }
}
