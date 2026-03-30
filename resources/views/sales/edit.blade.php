@extends('layouts.app')

@section('page_name', __('orders.edit_order'))

@section('content')
<div class="container {{ $textAlign }}">
    <h1>{{ __('orders.edit_order') }}</h1>
    <form id="order-form" action="{{ route('orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="meal_id" class="form-label">{{ __('meals.meal') }}</label>
            <select name="meal_id" id="meal_id" class="form-select" required>
                <option value="">{{ __('orders.form.select_meal') }}</option>
                @foreach($meals as $meal)
                    <option value="{{ $meal->id }}"
                        {{ (old('meal_id', $order->meal_id) == $meal->id) ? 'selected' : '' }}>
                        {{ $meal->name_en}}
                    </option>
                @endforeach
            </select>
            @error('meal_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="client_id" class="form-label">{{ __('clients.client') }}</label>
            <div class="input-group">
                <select name="client_id" id="client_id" class="form-select" required>
                    <option value="">{{ __('orders.form.select_client') }}</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}"
                            {{ (old('client_id', $order->client_id) == $client->id) ? 'selected' : '' }}>
                            {{ $client->name }}
                        </option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-outline-primary" id="add-client-btn">{{ __('orders.form.add_new_client') }}</button>
            </div>
            @error('client_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div id="add-client-form" class="card mb-3" style="display: none;">
            <div class="card-body {{ $textAlign }}">
                <h5 class="card-title">{{ __('orders.form.add_new_client') }}</h5>
                <div id="add-client-errors" class="text-danger mb-2"></div>
                <div class="mb-2">
                    <label for="new_client_name" class="form-label">{{ __('clients.client_name') }}</label>
                    <input type="text" id="new_client_name" class="form-control" placeholder="{{ __('clients.placeholders.enter_client_name') }}">
                </div>
                <div class="mb-2">
                    <label for="new_client_email" class="form-label">{{ __('clients.email') }}</label>
                    <input type="email" id="new_client_email" class="form-control" placeholder="{{ __('clients.placeholders.enter_email') }}">
                </div>
                <button type="button" class="btn btn-success {{ $isRtl ? 'ms-2' : 'me-2' }}" id="save-client-btn">{{ __('clients.create_client') }}</button>
                <button type="button" class="btn btn-secondary" id="cancel-client-btn">{{ __('app.cancel') }}</button>
            </div>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">{{ __('orders.quantity') }}</label>
            <input type="number" name="quantity" id="quantity" class="form-control"
                value="{{ old('quantity', $order->quantity) }}" required placeholder="{{ __('orders.placeholders.enter_quantity') }}">
            @error('quantity')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">{{ __('orders.price') }}</label>
            <input type="number" step="0.01" name="price" id="price" class="form-control"
                value="{{ old('price', $order->price) }}" required placeholder="{{ __('orders.placeholders.enter_price') }}">
            @error('price')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="payment_method" class="form-label">{{ __('orders.payment_method') }}</label>
                <select name="payment_method" id="payment_method" class="form-select" required>
                    <option value="">{{ __('orders.select_payment_method') }}</option>
                    <option value="cash" {{ old('payment_method', $order->payment_method) == 'cash' ? 'selected' : '' }}>{{ __('orders.payment_methods.cash') }}</option>
                    <option value="credit_card" {{ old('payment_method', $order->payment_method) == 'credit_card' ? 'selected' : '' }}>{{ __('orders.payment_methods.credit_card') }}</option>
                    <option value="bank_transfer" {{ old('payment_method', $order->payment_method) == 'bank_transfer' ? 'selected' : '' }}>{{ __('orders.payment_methods.bank_transfer') }}</option>
                    <option value="other" {{ old('payment_method', $order->payment_method) == 'other' ? 'selected' : '' }}>{{ __('orders.payment_methods.other') }}</option>
                </select>
                @error('payment_method')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="status" class="form-label">{{ __('orders.status') }}</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="">{{ __('orders.select_status') }}</option>
                    <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>{{ __('orders.statuses.pending') }}</option>
                    <option value="completed" {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>{{ __('orders.statuses.completed') }}</option>
                    <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>{{ __('orders.statuses.cancelled') }}</option>
                </select>
                @error('status')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="mb-3">
            <label for="notes" class="form-label">{{ __('orders.notes') }}</label>
            <textarea name="notes" id="notes" class="form-control" rows="2" placeholder="{{ __('orders.placeholders.enter_notes') }}">{{ old('notes', $order->notes) }}</textarea>
            @error('notes')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary {{ $isRtl ? 'ms-2' : 'me-2' }}">{{ __('orders.update_order') }}</button>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">{{ __('app.cancel') }}</a>
    </form>

    <script>
        document.getElementById('add-client-btn').addEventListener('click', function() {
            document.getElementById('add-client-form').style.display = 'block';
        });

        document.getElementById('cancel-client-btn').addEventListener('click', function() {
            document.getElementById('add-client-form').style.display = 'none';
            document.getElementById('add-client-errors').innerText = '';
            document.getElementById('new_client_name').value = '';
            document.getElementById('new_client_email').value = '';
        });

        document.getElementById('save-client-btn').addEventListener('click', function() {
            let name = document.getElementById('new_client_name').value.trim();
            let email = document.getElementById('new_client_email').value.trim();
            let errors = '';

            if (!name) errors += 'Name is required. ';
            if (!email) errors += 'Email is required. ';

            if (errors) {
                document.getElementById('add-client-errors').innerText = errors;
                return;
            }

            fetch("{{ route('clients.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ "name": name, "email": email , "fromJs" : true})
            })
            .then(response => response.json())
            .then(data => {
                if (data.client) {
                    let clientSelect = document.getElementById('client_id');
                    let option = document.createElement('option');
                    option.value = data.client.id;
                    option.text = data.client.name;
                    option.selected = true;
                    clientSelect.appendChild(option);

                    document.getElementById('add-client-form').style.display = 'none';
                    document.getElementById('add-client-errors').innerText = '';
                    document.getElementById('new_client_name').value = '';
                    document.getElementById('new_client_email').value = '';
                } else if (data.errors) {
                    let errorMsg = '';
                    for (let key in data.errors) {
                        errorMsg += data.errors[key].join(' ') + ' ';
                    }
                    document.getElementById('add-client-errors').innerText = errorMsg;
                } else {
                    document.getElementById('add-client-errors').innerText = 'An error occurred.';
                }
            })
            .catch(() => {
                document.getElementById('add-client-errors').innerText = 'An error occurred.';
            });
        });
    </script>
</div>
    <script>
        // Prepare meal prices as a JS object
        const mealPrices = {
            @foreach($meals as $meal)
                "{{ $meal->id }}": {{ $meal->price }},
            @endforeach
        };

        function updatePrice() {
            const mealId = document.getElementById('meal_id').value;
            const quantity = parseFloat(document.getElementById('quantity').value) || 0;
            const priceInput = document.getElementById('price');
            if (mealId && mealPrices[mealId]) {
                priceInput.value = (mealPrices[mealId] * quantity).toFixed(2);
            } else {
                priceInput.value = '';
            }
        }

        document.getElementById('meal_id').addEventListener('change', updatePrice);
        document.getElementById('quantity').addEventListener('input', updatePrice);

        // Initial update on page load
        document.addEventListener('DOMContentLoaded', updatePrice);
    </script>
@endsection