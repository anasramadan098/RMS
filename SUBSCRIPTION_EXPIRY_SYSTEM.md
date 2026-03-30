# ✅ Subscription Expiry System

## 🎯 Overview

The system now automatically prevents users from accessing the application when their tenant's subscription expires after 30 days.

---

## 🔧 How It Works

### 1. **Subscription Period**
- Each subscription is valid for **30 days** from the `subscribtion_created` date
- After 30 days, the subscription is marked as **expired**
- Users cannot access the system with an expired subscription

### 2. **Automatic Checks**
The `EnsureTenantAssigned` middleware performs these checks on every request:

```php
1. Is user authenticated? → If no, redirect to login
2. Does user have a tenant? → If no, redirect to select tenant
3. Is tenant subscription active? → If no, logout and show error
```

### 3. **What Happens When Subscription Expires**

#### User Experience:
1. User tries to login or access any page
2. Middleware checks subscription status
3. If expired:
   - User is automatically logged out
   - Redirected to login page
   - Sees error message: *"Your subscription has expired. Please contact the administrator to renew your subscription."*

#### Admin Experience:
1. Admin can see all tenants and their subscription status
2. Can renew subscriptions from `/admin/tenants`
3. After renewal, users can immediately access the system again

---

## 📋 Tenant Model Methods

### `hasActiveSubscription()`
Checks if the tenant's subscription is still valid.

**Logic:**
```php
if (!is_subscribe) → false (manually disabled)
if (days_since_subscription > 30) → false (expired)
otherwise → true (active)
```

**Usage:**
```php
$tenant = auth()->user()->tenant;

if ($tenant->hasActiveSubscription()) {
    // Allow access
} else {
    // Deny access
}
```

### `getRemainingDaysAttribute`
Returns the number of days remaining in the subscription.

**Usage:**
```php
echo "Remaining days: " . $tenant->remaining_days;

// Output: Remaining days: 15
```

### `getSubscriptionStatusAttribute`
Returns subscription status as string: `'active'`, `'expired'`, or `'inactive'`.

**Usage:**
```php
echo "Status: " . $tenant->subscription_status;

// Output: Status: active
```

---

## 🚀 Usage Examples

### Check Subscription Status
```php
$tenant = Tenant::find(1);

// Check if active
if ($tenant->hasActiveSubscription()) {
    echo "Subscription is active";
} else {
    echo "Subscription expired";
}

// Get remaining days
echo "Days left: " . $tenant->remaining_days;

// Get status
echo "Status: " . $tenant->subscription_status;
```

### In Blade Templates
```blade
@if(auth()->user()->tenant->hasActiveSubscription())
    <span class="badge badge-success">Active</span>
@else
    <span class="badge badge-danger">Expired</span>
@endif

<p>Remaining: {{ auth()->user()->tenant->remaining_days }} days</p>
```

### Renew Subscription
```php
// In TenantController
public function renewSubscription(Tenant $tenant)
{
    $tenant->update([
        'subscribtion_created' => now(), // Reset to today
        'is_subscribe' => true,
    ]);
    
    return back()->with('success', 'Subscription renewed!');
}
```

---

## 📊 Database Schema

### tenants table
```sql
id                      INT PRIMARY KEY
name                    VARCHAR
email                   VARCHAR UNIQUE
phone                   VARCHAR
address                 TEXT
subscribtion_type       ENUM('basic', 'premium', 'enterprise')
subscribtion_created    TIMESTAMP        ← Used to calculate expiry
subscribtion_amount     DECIMAL(10,2)
is_subscribe            BOOLEAN          ← Manual enable/disable
created_at              TIMESTAMP
updated_at              TIMESTAMP
```

---

## 🔒 Security Features

### 1. Automatic Logout
When subscription expires:
- All users from that tenant are logged out immediately
- Session is destroyed
- Cannot re-login until subscription is renewed

### 2. Middleware Protection
Every protected route is checked by `EnsureTenantAssigned`:
```php
Route::middleware(['tenant'])->group(function () {
    // All these routes require active subscription
    Route::get('/dashboard', ...);
    Route::resource('orders', ...);
    // etc...
});
```

### 3. Global Scope
`BelongsToTenant` trait ensures users only see their tenant's data:
```php
// Even if someone bypasses middleware, they can't access other tenants' data
Meal::all(); // WHERE tenant_id = current_tenant_id
```

---

## ⚙️ Configuration

### Change Subscription Period
To change from 30 days to a different period:

**File:** `app/Models/Tenant.php`

```php
public function hasActiveSubscription(): bool
{
    if (!$this->is_subscribe) {
        return false;
    }

    if ($this->subscribtion_created) {
        $subscriptionDate = \Carbon\Carbon::parse($this->subscribtion_created);
        $daysSinceSubscription = $subscriptionDate->diffInDays(now());
        
        // Change 30 to desired number of days
        if ($daysSinceSubscription > 30) { // ← Change this value
            return false;
        }
    }

    return true;
}
```

### Different Plans with Different Durations
You can modify the logic to support different durations per plan:

```php
public function getSubscriptionDays(): int
{
    return match($this->subscribtion_type) {
        'basic' => 30,
        'premium' => 60,
        'enterprise' => 90,
        default => 30,
    };
}

public function hasActiveSubscription(): bool
{
    if (!$this->is_subscribe) {
        return false;
    }

    if ($this->subscribtion_created) {
        $subscriptionDate = \Carbon\Carbon::parse($this->subscribtion_created);
        $maxDays = $this->getSubscriptionDays();
        
        if ($subscriptionDate->copy()->addDays($maxDays)->isPast()) {
            return false;
        }
    }

    return true;
}
```

---

## 📱 User Interface

### Expired Subscription Page
Located at: `resources/views/tenant/expired.blade.php`

**Shows:**
- Tenant name and email
- Current plan type
- Subscription status (Active/Expired)
- Subscription start date
- Remaining days
- Amount paid
- Warning message

**Access:** `/subscription/expired`

---

## 🛠️ Admin Operations

### View All Tenants and Status
```bash
php artisan tinker
```

```php
// Get all tenants with expired subscriptions
$expiredTenants = Tenant::where('is_subscribe', true)
    ->whereHas('users')
    ->get()
    ->filter(fn($t) => !$t->hasActiveSubscription());

foreach ($expiredTenants as $tenant) {
    echo "{$tenant->name}: Expired {$tenant->remaining_days * -1} days ago\n";
}

// Get all active tenants
$activeTenants = Tenant::where('is_subscribe', true)
    ->get()
    ->filter(fn($t) => $t->hasActiveSubscription());

foreach ($activeTenants as $tenant) {
    echo "{$tenant->name}: {$tenant->remaining_days} days remaining\n";
}
```

### Bulk Renewal
```php
// Renew all expired subscriptions
Tenant::where('is_subscribe', true)->each(function($tenant) {
    if (!$tenant->hasActiveSubscription()) {
        $tenant->update([
            'subscribtion_created' => now(),
        ]);
        echo "Renewed: {$tenant->name}\n";
    }
});
```

---

## ⚠️ Important Notes

### 1. Testing
To test the expiry system:

```php
// Set subscription to 31 days ago
$tenant->update([
    'subscribtion_created' => now()->subDays(31),
]);

// Try to login - should be blocked
```

### 2. Grace Period (Optional)
If you want to add a grace period (e.g., 3 days):

```php
public function hasActiveSubscription(): bool
{
    if (!$this->is_subscribe) {
        return false;
    }

    if ($this->subscribtion_created) {
        $subscriptionDate = \Carbon\Carbon::parse($this->subscribtion_created);
        $daysSinceSubscription = $subscriptionDate->diffInDays(now());
        
        // 30 days + 3 days grace period
        if ($daysSinceSubscription > 33) {
            return false;
        }
    }

    return true;
}
```

### 3. Notifications
Consider adding email notifications before expiry:

```php
// In a scheduled command
$expiringSoon = Tenant::where('is_subscribe', true)
    ->get()
    ->filter(fn($t) => $t->remaining_days <= 7 && $t->remaining_days > 0);

foreach ($expiringSoon as $tenant) {
    // Send email notification
    Mail::to($tenant->email)->send(new SubscriptionExpiringSoon($tenant));
}
```

---

## 📞 Troubleshooting

### Issue: Users can still access after expiry
**Solution:** Make sure `EnsureTenantAssigned` middleware is applied to all routes:
```php
Route::middleware(['tenant'])->group(function () {
    // Your routes
});
```

### Issue: Subscription not calculating correctly
**Solution:** Check timezone settings in `config/app.php`:
```php
'timezone' => 'UTC', // or your local timezone
```

### Issue: Want to manually disable without waiting 30 days
**Solution:** Set `is_subscribe` to false:
```php
$tenant->update(['is_subscribe' => false]);
```

---

**Status:** ✅ **Complete & Working**  
**Subscription Period:** 30 days  
**Auto-Renewal:** No (manual only)  
**Grace Period:** None  
**Last Updated:** March 28, 2026
