@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">
                                <i class="fas fa-utensils text-primary me-2"></i>
                                {{ __('kitchen.kitchen') }}
                            </h4>
                            <p class="text-muted mb-0">{{ __('kitchen.manage_pending_orders') }}</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="badge bg-warning text-dark fs-6 me-3">
                                <i class="fas fa-clock me-1"></i>
                                <span id="pending-count">{{ $orders->count() }}</span> {{ __('kitchen.pending_orders') }}
                            </div>
                            <div class="badge bg-success fs-6" id="connection-status">
                                <i class="fas fa-wifi me-1"></i>
                                {{ __('kitchen.connected') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Grid -->
    <div class="row" id="orders-container">
        @forelse($orders as $order)
            @include('kitchen.partials.order-card', ['order' => $order])
        @empty
            <div class="col-12" id="no-orders-message">
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                        <h5 class="mt-3 text-muted">{{ __('kitchen.no_pending_orders') }}</h5>
                        <p class="text-muted">{{ __('kitchen.all_orders_completed') }}</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>

<!-- Success Toast -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="success-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <i class="fas fa-check-circle me-2"></i>
            <strong class="me-auto">{{ __('kitchen.success') }}</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body" id="toast-message">
            {{ __('kitchen.order_completed_successfully') }}
        </div>
    </div>
</div>

<!-- Error Toast -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="error-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-danger text-white">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong class="me-auto">{{ __('kitchen.error') }}</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body" id="error-message">
            {{ __('kitchen.error_processing_order') }}
        </div>
    </div>
</div>

@endsection


<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
// Define completeOrder function first (before DOMContentLoaded)
function completeOrder(orderId, button) {
    console.log('completeOrder called with:', orderId, button);

    // Disable button and show loading
    button.disabled = true;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>{{ __("kitchen.completing") }}...';

    fetch(`/kitchen/complete/${orderId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove order card with animation
            const orderCard = document.getElementById(`order-${orderId}`);
            if (orderCard) {
                orderCard.style.transition = 'all 0.3s ease';
                orderCard.style.transform = 'scale(0.8)';
                orderCard.style.opacity = '0';

                setTimeout(() => {
                    orderCard.remove();
                    updatePendingCount();
                    checkIfNoOrders();
                }, 300);
            }

            showToast('success', data.message);
        } else {
            showToast('error', data.message);
            // Re-enable button
            button.disabled = false;
            button.innerHTML = originalText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('error', 'حدث خطأ أثناء معالجة الطلب');
        // Re-enable button
        button.disabled = false;
        button.innerHTML = originalText;
    });
}

// Make function globally available
window.completeOrder = completeOrder;

// Helper functions
function updatePendingCount() {
    const count = document.querySelectorAll('[id^="order-"]').length;
    document.getElementById('pending-count').textContent = count;
}

function checkIfNoOrders() {
    const container = document.getElementById('orders-container');
    const orderCards = container.querySelectorAll('[id^="order-"]');

    if (orderCards.length === 0) {
        const noOrdersHtml = `
            <div class="col-12" id="no-orders-message">
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                        <h5 class="mt-3 text-muted">لا توجد طلبات معلقة</h5>
                        <p class="text-muted">جميع الطلبات مكتملة!</p>
                    </div>
                </div>
            </div>
        `;
        container.innerHTML = noOrdersHtml;
    }
}

function showToast(type, message) {
    const toastId = type === 'success' ? 'success-toast' : 'error-toast';
    const messageId = type === 'success' ? 'toast-message' : 'error-message';

    document.getElementById(messageId).textContent = message;

    const toast = new bootstrap.Toast(document.getElementById(toastId));
    toast.show();
}

document.addEventListener('DOMContentLoaded', function() {
    // Smart Real-time System: Try Pusher first, fallback to Polling
    console.log('🚀 Initializing Smart Real-time System...');

    let realTimeMethod = 'polling'; // Default to polling for reliability
    let pollingInterval;
    let lastOrderCount = {{ $orders->count() }};
    let lastUpdateTime = Date.now();

    // Try to initialize Pusher if credentials are available
    let pusher = null;
    let channel = null;

    @if(env('PUSHER_APP_KEY') && env('PUSHER_APP_KEY') !== 'your_app_key')
        try {
            console.log('🔄 Attempting Pusher connection...');
            pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
                cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
                forceTLS: true,
                authEndpoint: '/broadcasting/auth',
                auth: {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }
            });

            channel = pusher.subscribe('kitchen');
            realTimeMethod = 'pusher';
            console.log('✅ Pusher initialized successfully');
        } catch (error) {
            console.warn('⚠️ Pusher failed, using polling:', error);
            realTimeMethod = 'polling';
        }
    @else
        console.log('📡 No Pusher credentials, using polling system');
    @endif

    // Setup Pusher events if available
    if (pusher && channel) {
        pusher.connection.bind('connected', function() {
            console.log('✅ Pusher connected successfully');
            realTimeMethod = 'pusher';
            updateConnectionStatus(true);
            // Stop polling if it's running
            if (pollingInterval) {
                clearInterval(pollingInterval);
                console.log('🛑 Stopping polling - Pusher is working');
            }
        });

        pusher.connection.bind('disconnected', function() {
            console.log('❌ Pusher disconnected, switching to polling');
            realTimeMethod = 'polling';
            updateConnectionStatus(false);
            startPolling();
        });

        pusher.connection.bind('error', function(err) {
            console.error('💥 Pusher error, switching to polling:', err);
            realTimeMethod = 'polling';
            updateConnectionStatus(false);
            startPolling();
        });
    }

    // Setup Pusher channel events if available
    if (channel) {
        channel.bind('pusher:subscription_succeeded', function() {
            console.log('✅ Successfully subscribed to kitchen channel');
        });

        channel.bind('pusher:subscription_error', function(err) {
            console.error('❌ Failed to subscribe to kitchen channel:', err);
            realTimeMethod = 'polling';
            startPolling();
        });

        // Listen for new orders
        channel.bind('order.created', function(data) {
            console.log('🆕 New order received via Pusher:', data);
            addNewOrder(data.order);
            updatePendingCount();
            showNotification('طلب جديد!', `طلب رقم ${data.order.order_number} من ${data.order.client_name}`, 'info');
        });

        // Listen for order status updates
        channel.bind('order.status.updated', function(data) {
            console.log('🔄 Order status updated via Pusher:', data);
            if (data.new_status === 'completed') {
                removeOrder(data.order_id);
                updatePendingCount();
            }
        });

        console.log('📡 Pusher channel events setup completed');
    }

    // Smart Polling System
    function startPolling() {
        if (pollingInterval) {
            clearInterval(pollingInterval);
        }

        console.log('🔄 Starting smart polling system...');
        updateConnectionStatus(true);

        pollingInterval = setInterval(function() {
            if (realTimeMethod === 'polling') {
                fetch('/kitchen/pending-orders', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const currentOrderCount = data.orders.length;

                        // Check if there are new orders
                        if (currentOrderCount > lastOrderCount) {
                            const existingOrderIds = Array.from(document.querySelectorAll('[id^="order-"]'))
                                .map(el => parseInt(el.id.replace('order-', '')));

                            data.orders.forEach(order => {
                                if (!existingOrderIds.includes(order.id)) {
                                    console.log('📦 Polling detected new order:', order);
                                    addNewOrder(order);
                                    showNotification('{{ __("kitchen.new_order") }}', `{{ __("kitchen.order_number") }} ${order.order_number}`, 'info');
                                }
                            });
                        }

                        // Check if orders were completed (removed)
                        if (currentOrderCount < lastOrderCount) {
                            const currentOrderIds = data.orders.map(order => order.id);
                            const existingOrderElements = document.querySelectorAll('[id^="order-"]');

                            existingOrderElements.forEach(el => {
                                const orderId = parseInt(el.id.replace('order-', ''));
                                if (!currentOrderIds.includes(orderId)) {
                                    console.log('✅ Polling detected completed order:', orderId);
                                    removeOrderSilently(orderId);
                                }
                            });
                        }

                        lastOrderCount = currentOrderCount;
                        updatePendingCount();
                        updateConnectionStatus(true);
                        lastUpdateTime = Date.now();
                    }
                })
                .catch(error => {
                    console.error('❌ Polling error:', error);
                    updateConnectionStatus(false);
                });
            }
        }, 3000); // Poll every 3 seconds
    }

    // Initialize the appropriate real-time method
    if (realTimeMethod === 'polling') {
        console.log('🚀 Starting with polling system');
        startPolling();
    } else {
        console.log('🚀 Starting with Pusher, polling on standby');
        // Start polling after 5 seconds if Pusher doesn't connect
        setTimeout(() => {
            if (realTimeMethod !== 'pusher' || (pusher && pusher.connection.state !== 'connected')) {
                console.log('⚠️ Pusher not connected, switching to polling');
                realTimeMethod = 'polling';
                startPolling();
            }
        }, 5000);
    }

    // Page visibility optimization
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            // Page is hidden, reduce polling frequency
            if (pollingInterval && realTimeMethod === 'polling') {
                clearInterval(pollingInterval);
                console.log('📱 Page hidden, reducing polling frequency');
                pollingInterval = setInterval(function() {
                    if (realTimeMethod === 'polling') {
                        fetch('/kitchen/pending-orders', {
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                lastOrderCount = data.orders.length;
                                updatePendingCount();
                            }
                        })
                        .catch(error => console.error('Background polling error:', error));
                    }
                }, 10000); // Poll every 10 seconds when hidden
            }
        } else {
            // Page is visible, restore normal polling
            if (realTimeMethod === 'polling') {
                console.log('📱 Page visible, restoring normal polling');
                startPolling();
            }
        }
    });

    // Connection status indicator
    function updateConnectionStatus(connected) {
        const statusElement = document.getElementById('connection-status');
        const method = realTimeMethod === 'pusher' ? 'Pusher' : 'Polling';

        if (connected) {
            statusElement.className = 'badge bg-success fs-6';
            statusElement.innerHTML = `<i class="fas fa-wifi me-1"></i>متصل (${method})`;
        } else {
            statusElement.className = 'badge bg-danger fs-6';
            statusElement.innerHTML = `<i class="fas fa-wifi me-1"></i>غير متصل`;
        }
    }

    // Helper functions

    function addNewOrder(order) {
        const container = document.getElementById('orders-container');
        const noOrdersMessage = document.getElementById('no-orders-message');
        
        // Remove no orders message if exists
        if (noOrdersMessage) {
            noOrdersMessage.remove();
        }

        // Create new order card
        const orderCard = createOrderCard(order);
        container.insertAdjacentHTML('afterbegin', orderCard);
        
        // Add animation
        const newCard = document.getElementById(`order-${order.id}`);
        newCard.style.opacity = '0';
        newCard.style.transform = 'translateY(-20px)';
        
        setTimeout(() => {
            newCard.style.transition = 'all 0.3s ease';
            newCard.style.opacity = '1';
            newCard.style.transform = 'translateY(0)';
        }, 100);
    }

    function removeOrder(orderId) {
        const orderCard = document.getElementById(`order-${orderId}`);
        if (orderCard) {
            orderCard.style.transition = 'all 0.3s ease';
            orderCard.style.transform = 'scale(0.8)';
            orderCard.style.opacity = '0';

            setTimeout(() => {
                orderCard.remove();
                checkIfNoOrders();
            }, 300);
        }
    }

    function removeOrderSilently(orderId) {
        const orderCard = document.getElementById(`order-${orderId}`);
        if (orderCard) {
            orderCard.style.transition = 'all 0.3s ease';
            orderCard.style.transform = 'scale(0.8)';
            orderCard.style.opacity = '0';

            setTimeout(() => {
                orderCard.remove();
                checkIfNoOrders();
            }, 300);
        }
    }

    function updatePendingCount() {
        const count = document.querySelectorAll('[id^="order-"]').length;
        document.getElementById('pending-count').textContent = count;
    }

    function checkIfNoOrders() {
        const container = document.getElementById('orders-container');
        const orderCards = container.querySelectorAll('[id^="order-"]');

        if (orderCards.length === 0) {
            const noOrdersHtml = `
                <div class="col-12" id="no-orders-message">
                    <div class="card shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                            <h5 class="mt-3 text-muted">لا توجد طلبات معلقة</h5>
                            <p class="text-muted">جميع الطلبات مكتملة!</p>
                        </div>
                    </div>
                </div>
            `;
            container.innerHTML = noOrdersHtml;
        }
    }

    function createOrderCard(order) {
        console.log('Creating order card for:', order);

        // Handle items - check if items exist and is array
        let itemsHtml = '';
        if (order.items && Array.isArray(order.items) && order.items.length > 0) {
            itemsHtml = order.items.map(item => `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <span class="fw-bold">${item.meal_name || 'وجبة غير محددة'}</span>
                        ${item.notes ? `<br><small class="text-muted">${item.notes}</small>` : ''}
                    </div>
                    <span class="badge bg-primary">${item.quantity || 1}</span>
                </div>
            `).join('');
        } else {
            itemsHtml = '<div class="text-muted">لا توجد أصناف محددة</div>';
        }

        return `
            <div class="col-xl-4 col-lg-6 col-md-6 mb-4" id="order-${order.id}">
                <div class="card shadow-sm h-100 border-start border-warning border-4">
                    <div class="card-header bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-bold text-primary">
                                <i class="fas fa-receipt me-2"></i>
                                طلب #${order.order_number}
                            </h6>
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                ${order.created_at}
                            </small>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">{{ __("kitchen.client") }}:</span>
                                <span class="fw-bold">${order.client_name}</span>
                            </div>
                            ${order.table_number ? `
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">{{ __("kitchen.table") }}:</span>
                                    <span class="fw-bold">${order.table_number}</span>
                                </div>
                            ` : ''}
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">{{ __("kitchen.total") }}:</span>
                                <span class="fw-bold text-success">${order.total_amount} {{ __("app.currency") }}</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <h6 class="fw-bold mb-2">{{ __("kitchen.items") }}:</h6>
                            ${itemsHtml}
                        </div>

                        ${order.special_instructions ? `
                            <div class="mb-3">
                                <h6 class="fw-bold mb-2">ملاحظات خاصة:</h6>
                                <p class="text-muted small">${order.special_instructions}</p>
                            </div>
                        ` : ''}
                    </div>
                    <div class="card-footer bg-light">
                        <button type="button"
                                class="btn btn-success w-100 fw-bold"
                                onclick="completeOrder(${order.id}, this)">
                            <i class="fas fa-check me-2"></i>
                            {{ __("kitchen.complete_order") }}
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    function showToast(type, message) {
        const toastId = type === 'success' ? 'success-toast' : 'error-toast';
        const messageId = type === 'success' ? 'toast-message' : 'error-message';

        document.getElementById(messageId).textContent = message;

        const toast = new bootstrap.Toast(document.getElementById(toastId));
        toast.show();
    }

    function showNotification(title, message, type) {
        if ('Notification' in window && Notification.permission === 'granted') {
            new Notification(title, {
                body: message,
                icon: '/favicon.ico'
            });
        }

        // Also show as toast
        showToast('success', `${title}: ${message}`);
    }



    // Request notification permission
    if ('Notification' in window && Notification.permission === 'default') {
        Notification.requestPermission();
    }

    // Debug: Check if function is available
    console.log('completeOrder function available:', typeof window.completeOrder);

    // Alternative approach: Add event listeners to buttons
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('complete-order-btn') || e.target.closest('.complete-order-btn')) {
            const button = e.target.classList.contains('complete-order-btn') ? e.target : e.target.closest('.complete-order-btn');
            const orderId = button.getAttribute('data-order-id');

            if (orderId && typeof window.completeOrder === 'function') {
                window.completeOrder(orderId, button);
            } else {
                console.error('completeOrder function not available or orderId missing');
            }
        }
    });
});

// Alternative global function definition (fallback)
if (typeof window.completeOrder === 'undefined') {
    window.completeOrder = function(orderId, button) {
        console.log('Using fallback completeOrder function');

        // Disable button and show loading
        button.disabled = true;
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>{{ __("kitchen.completing") }}...';

        fetch(`/kitchen/complete/${orderId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                status: 'completed'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove order card with animation
                const orderCard = document.getElementById(`order-${orderId}`);
                if (orderCard) {
                    orderCard.style.transition = 'all 0.3s ease';
                    orderCard.style.transform = 'scale(0.8)';
                    orderCard.style.opacity = '0';

                    setTimeout(() => {
                        orderCard.remove();
                        // Update pending count
                        const count = document.querySelectorAll('[id^="order-"]').length;
                        document.getElementById('pending-count').textContent = count;

                        // Check if no orders
                        if (count === 0) {
                            const container = document.getElementById('orders-container');
                            const noOrdersHtml = `
                                <div class="col-12" id="no-orders-message">
                                    <div class="card shadow-sm">
                                        <div class="card-body text-center py-5">
                                            <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                                            <h5 class="mt-3 text-muted">لا توجد طلبات معلقة</h5>
                                            <p class="text-muted">جميع الطلبات مكتملة!</p>
                                        </div>
                                    </div>
                                </div>
                            `;
                            container.innerHTML = noOrdersHtml;
                        }
                    }, 300);
                }

                // Show success toast
                const toast = new bootstrap.Toast(document.getElementById('success-toast'));
                document.getElementById('toast-message').textContent = data.message;
                toast.show();
            } else {
                // Show error toast
                const toast = new bootstrap.Toast(document.getElementById('error-toast'));
                document.getElementById('error-message').textContent = data.message;
                toast.show();

                // Re-enable button
                button.disabled = false;
                button.innerHTML = originalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);

            // Show error toast
            const toast = new bootstrap.Toast(document.getElementById('error-toast'));
            document.getElementById('error-message').textContent = 'حدث خطأ أثناء معالجة الطلب';
            toast.show();

            // Re-enable button
            button.disabled = false;
            button.innerHTML = originalText;
        });
    };
}
</script>


