<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Prism;

class Client extends Model
{
    use HasFactory, Filterable, BelongsToTenant;
    protected $table = 'clients';
    protected $fillable = [
        'tenant_id',
        'user_id',
        'name',
        'email',
        'phone',
        'whatsapp_phone',
        'whatsapp_notifications',
        'address',
        'city',
        'state',
        'country',
        'type',
        'profile_picture',
        'notes',
        'last_activity',
        'is_active',
        'date_of_birth',
        'gender',
        'preferred_language',
        'password'
    ];

    /**
     * Get filterable attributes for this model
     */


    public function getFilterableAttributes(): array
    {
        return [
            'name' => [
                'type' => 'text',
                'label' => __('clients.name'),
                'placeholder' => __('app.filters.filter_by', ['field' => __('clients.name')]),
            ],
            'email' => [
                'type' => 'email',
                'label' => __('clients.email'),
                'placeholder' => __('app.filters.filter_by', ['field' => __('clients.email')]),
            ],
            'phone' => [
                'type' => 'tel',
                'label' => __('clients.phone'),
                'placeholder' => __('app.filters.filter_by', ['field' => __('clients.phone')]),
            ],
            'type' => [
                'type' => 'select',
                'label' => __('clients.type'),
                'placeholder' => __('app.filters.select_option'),
                'options' => [
                    'customer' => __('clients.customer'),
                    'lead' => __('clients.lead'),
                    'prospect' => __('clients.prospect'),
                    'other' => __('clients.other'),
                ]
            ],
            'city' => [
                'type' => 'text',
                'label' => __('clients.city'),
                'placeholder' => __('app.filters.filter_by', ['field' => __('clients.city')]),
            ],
            'state' => [
                'type' => 'text',
                'label' => __('clients.state'),
                'placeholder' => __('app.filters.filter_by', ['field' => __('clients.state')]),
            ],
            'country' => [
                'type' => 'text',
                'label' => __('clients.country'),
                'placeholder' => __('app.filters.filter_by', ['field' => __('clients.country')]),
            ],
            'created_at' => [
                'type' => 'date',
                'label' => __('clients.registration_date'),
                'placeholder' => __('app.filters.filter_by', ['field' => __('clients.registration_date')]),
            ]
        ];
    }

    /**
     * Cast attributes to appropriate types
     */
    protected $casts = [
        'last_activity' => 'datetime',
        'date_of_birth' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Define the relationship with the User model
     */

    /**
     * Define the relationship with the Order model
     * Get all orders for this client
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Define the relationship with the Booking model
     * Get all bookings for this client
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get recent orders for this client
     */
    public function recentOrders($limit = 5)
    {
        return $this->orders()
                    ->with(['orderItems.meal'])
                    ->orderBy('created_at', 'desc')
                    ->limit($limit)
                    ->get();
    }

    /**
     * Get total amount spent by this client
     */
    public function getTotalSpentAttribute()
    {
        return $this->orders()
                    ->where('status', '!=', 'cancelled')
                    ->sum('total_amount');
    }

    /**
     * Get total number of orders for this client
     */
    public function getTotalOrdersAttribute()
    {
        return $this->orders()->count();
    }

    /**
     * Get client's favorite meals based on order history
     */
    public function getFavoriteMeals($limit = 3)
    {
        return \DB::table('order_items')
                  ->join('orders', 'order_items.order_id', '=', 'orders.id')
                  ->join('meals', 'order_items.meal_id', '=', 'meals.id')
                  ->where('orders.client_id', $this->id)
                  ->where('orders.status', '!=', 'cancelled')
                  ->select('meals.*', \DB::raw('SUM(order_items.quantity) as total_ordered'))
                  ->groupBy('meals.id', 'meals.name', 'meals.description', 'meals.price', 'meals.image', 'meals.category_id', 'meals.is_active', 'meals.is_available', 'meals.preparation_time', 'meals.created_at', 'meals.updated_at')
                  ->orderBy('total_ordered', 'desc')
                  ->limit($limit)
                  ->get();
    }

    /**
     * Get last order for this client
     */
    public function getLastOrderAttribute()
    {
        return $this->orders()
                    ->orderBy('created_at', 'desc')
                    ->first();
    }

    /**
     * Get average order value for this client
     */
    public function getAverageOrderValueAttribute()
    {
        $orders = $this->orders()->where('status', '!=', 'cancelled');
        $count = $orders->count();

        if ($count === 0) {
            return 0;
        }

        return $orders->sum('total_amount') / $count;
    }

    /**
     * Get client statistics
     */
    public function getStatistics()
    {
        $orders = $this->orders()->where('status', '!=', 'cancelled');

        return [
            'total_orders' => $this->total_orders,
            'total_spent' => $this->total_spent,
            'average_order_value' => $this->average_order_value,
            'last_order_date' => $this->last_order ? $this->last_order->created_at : null,
            'favorite_meals' => $this->getFavoriteMeals(5),
            'orders_this_month' => $orders->whereMonth('created_at', now()->month)->count(),
            'spent_this_month' => $orders->whereMonth('created_at', now()->month)->sum('total_amount'),
        ];
    }

    /**
     * Scope for active clients
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for clients by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
    /**
     * Get new clients statistics by date range
     */
    public static function getNewClientsStats($date)
    {


        // Get all clients for the user
        $all_results = static::all();

        // Get new clients within the specified date range
        $target_results = static::where('type', 'customer')
                               ->where('created_at', '>=', now()->subDays($date))
                               ->get();

        // Calculate percentage
        $per = $all_results->count() > 0 ? ($target_results->count() / $all_results->count()) * 100 : 0;

        // Determine if increase or decrease
        $symbol = '';
        if ($per > 0) {
            $symbol = '+';
        } elseif ($per < 0) {
            $symbol = '-';
        } else {
            $symbol = '';
        }

        // Format percentage
        $percentage = abs($per);
        $percentage = $symbol . number_format($percentage, 1) . '%';

        return [
            'target_results' => $target_results,
            'percentage' => $percentage,
        ];
    }

    public function MarketingEmailContent($client , $prompt = null) {
        // Make A Specif Respond From Client Data To Gemini

        $client_data = json_encode($this);
        $project_data = json_encode(Project::where('user_id' , Auth::user()->id)->first());
        // Make A SystemPromt That Make Gemini Understand That We Want To Make A Profesional Marketing Email Depends On user Data
        $systemPrompt = "You Are A Professional In Create Marketing Content And Email Marketing And You Have Experience Largeest than 20 years In Writing Emails For Different Products. I Will Provide To You A Client Data And You Should Provide To Me The Professional Email Directly For This Client. And Donot tell me anything or any tips so i will take the full message and put it in email template. So You Provide Me The Final Marketing Email Message Without Headlines And Doesn't Put Any Varibles or words to change In The Message like messages In [] Becuase You Are In Automative email system that i click on the button and you generate the content and the system send it automaticly to client. And This Is All Project or Compant Details: $project_data ";
        
        if (app()->getLocale() == 'ar') {
            $systemPrompt .= ' The Response Must Be In Arabic.';
        }
        
        
        $userPrompt = "
            Here Is Client Data :\n\n $client_data \n\n Please Provide To Me A Professional And Specif  Marketing Email For This Client To Make It Wants To Take An Action.
        ";
        $userPrompt .= $prompt ? " And This Is The Additional Prompt From User: $prompt" : '';

        try {

            $response = Prism::text()
            ->using(Provider::Gemini, 'gemini-2.0-flash')
            ->withSystemPrompt($systemPrompt)
            ->withPrompt($userPrompt)
            ->withMaxTokens(1500)
            ->generate()
            ->text;

            return $response;

        } catch (\Exception $e) {
            return redirect()->back()->with('msg' , __('app.check'));
        }



    }
}
