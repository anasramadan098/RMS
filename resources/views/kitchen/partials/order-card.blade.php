<div class="col-xl-4 col-lg-6 col-md-6 mb-4" id="order-{{ $order->id }}">
    <div class="card shadow-sm h-100 border-start border-warning border-4">
        <div class="card-header bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-primary">
                    <i class="fas fa-receipt me-2"></i>
                    طلب #{{ $order->order_number }}
                </h6>
                <small class="text-muted">
                    <i class="fas fa-clock me-1"></i>
                    {{ $order->created_at->format('H:i') }}
                </small>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">العميل:</span>
                    <span class="fw-bold">{{ $order->client->name ?? $order->customer_name ?? 'عميل مجهول' }}</span>
                </div>
                @if($order->table_number)
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">الطاولة:</span>
                        <span class="fw-bold">{{ $order->table_number }}</span>
                    </div>
                @endif
                <div class="d-flex justify-content-between">
                    <span class="text-muted">المجموع:</span>
                    <span class="fw-bold text-success">{{ number_format($order->total_amount, 2) }} جنيه</span>
                </div>
            </div>
            
            <div class="mb-3">
                <h6 class="fw-bold mb-2">الأصناف:</h6>
                @foreach($order->orderItems as $item)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <span class="fw-bold">{{ $item->meal->name_en?? 'وجبة محذوفة' }}</span>
                            @if($item->special_instructions)
                                <br><small class="text-muted">{{ $item->special_instructions }}</small>
                            @endif
                        </div>
                        <span class="badge bg-primary">{{ $item->quantity }}</span>
                    </div>
                @endforeach
            </div>
            
            @if($order->notes)
                <div class="mb-3">
                    <h6 class="fw-bold mb-2">ملاحظات خاصة:</h6>
                    <p class="text-muted small">{{ $order->notes }}</p>
                </div>
            @endif
        </div>
        <div class="card-footer bg-light">
            <button type="button"
                    class="btn btn-success w-100 fw-bold complete-order-btn"
                    data-order-id="{{ $order->id }}"
                    onclick="completeOrder({{ $order->id }}, this)">
                <i class="fas fa-check me-2"></i>
                إكمال الطلب
            </button>
        </div>
    </div>
</div>
