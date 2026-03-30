<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Client;
use App\Services\FilterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, FilterService $filterService)
    {
        // Create a model instance for filter configuration
        $bookingModel = new Booking();

        // Extract filters from request
        $filters = $filterService->extractFilters($request, ['name', 'phone', 'status', 'datetime' , 'event']);

        // Apply filters to the query with client relationship
        $query = Booking::with('client');
        
        // Apply filters
        if (!empty($filters)) {
            foreach ($filters as $field => $value) {
                if (!empty($value)) {
                    if ($field === 'name' || $field === 'phone' || $field === 'event') {
                        $query->where($field, 'LIKE', '%' . $value . '%');
                    } elseif ($field === 'status') {
                        $query->where($field, $value);
                    } elseif ($field === 'datetime') {
                        $query->whereDate($field, $value);
                    }
                }
            }
        }

        // Get filtered bookings with pagination
        $bookings = $query->orderBy('datetime', 'desc')->paginate(10)->withQueryString();

        // Get filter data for the view
        $filterData = [
            'name' => [
                'type' => 'text', 
                'label' => 'Name',
                'field' => 'name',
                'placeholder' => 'Enter name...',
                'value' => $filters['name'] ?? '',
                'required' => false
            ],
            'phone' => [
                'type' => 'text', 
                'label' => 'Phone',
                'field' => 'phone',
                'placeholder' => 'Enter phone number...',
                'value' => $filters['phone'] ?? '',
                'required' => false
            ],
            'status' => [
                'type' => 'select',
                'label' => 'Status',
                'field' => 'status',
                'placeholder' => 'Select status...',
                'value' => $filters['status'] ?? '',
                'required' => false,
                'options' => [
                    'pending' => 'Pending',
                    'confirmed' => 'Confirmed',
                    'cancelled' => 'Cancelled',
                    'completed' => 'Completed'
                ]
            ],
            'datetime' => [
                'type' => 'date', 
                'label' => 'Date',
                'field' => 'datetime',
                'placeholder' => 'Select date...',
                'value' => $filters['datetime'] ?? '',
                'required' => false
            ]
        ];

        return view('bookings.index', compact('bookings', 'filterData', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::where('is_active', true)->orderBy('name')->get();
        return view('bookings.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'guests' => 'required|integer|min:1|max:100',
            'datetime' => 'required|date|after:now',
            'event' => 'required|string|max:1000',
            'status' => 'nullable|in:pending,confirmed,cancelled,completed',
            'client_id' => 'nullable|exists:clients,id'
        ]);

        try {
            $booking = new Booking();
            $booking->name = $request->name;
            $booking->phone = $request->phone;
            $booking->guests = $request->guests;
            $booking->datetime = $request->datetime;
            $booking->event = $request->event;
            $booking->status = $request->status ?? 'pending';
            $booking->client_id = $request->client_id;
            $booking->save();

            return redirect()->route('bookings.index')
                           ->with('success', 'Booking created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withErrors(['error' => 'Failed to create booking: ' . $e->getMessage()])
                           ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $booking->load('client');
        return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        $clients = Client::where('is_active', true)->orderBy('name')->get();
        return view('bookings.edit', compact('booking', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'guests' => 'required|integer|min:1|max:100',
            'datetime' => 'required|date',
            'event' => 'required|string|max:1000',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'client_id' => 'nullable|exists:clients,id'
        ]);

        try {
            $booking->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'guests' => $request->guests,
                'datetime' => $request->datetime,
                'event' => $request->event,
                'status' => $request->status,
                'client_id' => $request->client_id
            ]);

            return redirect()->route('bookings.index')
                           ->with('success', 'Booking updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withErrors(['error' => 'Failed to update booking: ' . $e->getMessage()])
                           ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        try {
            $booking->delete();
            return redirect()->route('bookings.index')
                           ->with('success', 'Booking deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withErrors(['error' => 'Failed to delete booking: ' . $e->getMessage()]);
        }
    }

    /**
     * Update booking status
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);

        try {
            $booking->update(['status' => $request->status]);
            
            return response()->json([
                'success' => true,
                'message' => 'Booking status updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    }
}
