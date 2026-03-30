<?php

namespace App\Http\Controllers;

use App\Models\feedback;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feedbacks = feedback::paginate(10);
        return view('feedbacks.index', compact('feedbacks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('feedbacks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'en_name' => 'required|string|max:255',
            'ar_name' => 'required|string|max:255',
            'stars' => 'required|integer|min:1|max:5',
            'en_comment' => 'nullable|string',
            'ar_comment' => 'nullable|string',
            'date' => 'required',
        ]);

        $formated_date = Carbon::parseFromLocale( $request->date , 'ar')->diffForHumans();
        
        $data = $request->only(['en_name', 'ar_name', 'stars', 'en_comment', 'ar_comment', 'date']);
        $data['date'] = $formated_date;

        
        
        feedback::create($data);

        return redirect()->route('feedbacks.index')->with('msg', __('feedbacks.feedback_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(feedback $feedback)
    {
    $feedback->human_date = \Carbon\Carbon::parse($feedback->date)->diffForHumans();
    return view('feedbacks.show', compact('feedback'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(feedback $feedback)
    {
        
        $formated_date = Carbon::parse($feedback->date)->format('Y-m-d');

        return view('feedbacks.edit', compact('feedback' , 'formated_date'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, feedback $feedback)
    {
        $request->validate([
            'en_name' => 'required|string|max:255',
            'ar_name' => 'required|string|max:255',
            'stars' => 'required|integer|min:1|max:5',
            'en_comment' => 'nullable|string',
            'ar_comment' => 'nullable|string',
            'date' => 'required|string',
        ]);

        $formated_date = Carbon::parseFromLocale( $request->date , 'ar')->diffForHumans();
        
        $data = $request->only(['en_name', 'ar_name', 'stars', 'en_comment', 'ar_comment', 'date']);
        $data['date'] = $formated_date;

        $feedback->update($data);

        return redirect()->route('feedbacks.index')->with('msg', __('feedbacks.feedback_updated'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(feedback $feedback)
    {
        $feedback->delete();
        return redirect()->route('feedbacks.index')->with('msg', __('feedbacks.feedback_updated'));
    }

}
