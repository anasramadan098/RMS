@extends('layouts.app')

@section('page_name', __('orders.create_order'))

@section('content')
<div class="container {{ $textAlign }}">
    <h1>{{ __('orders.create_order') }}</h1>
    <form id="order-form" action="{{ route('orders.store') }}" method="POST">
        @csrf

        {{-- <div class="mb-3">
            <label for="meal_id" class="form-label">{{ __('meals.meal') }}</label>
            <select name="meal_id" id="meal_id" class="form-select" required>
                <option value="">{{ __('orders.form.select_meal') }}</option>
                @foreach($meals as $meal)
                    <option value="{{ $meal->id }}"   {{ old('meal_id') == $meal->id ? 'selected' : '' }}>
                        {{ $meal->name_en}}
                    </option>
                @endforeach
            </select>
            @error('meal_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div> --}}

        <div class="mb-3">
            <label for="client_id" class="form-label">{{ __('clients.client') }}</label>
            <div class="input-group">
                <select name="client_id" id="client_id" class="form-select" required>
                    <option value="">{{ __('orders.form.select_client') }}</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
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


        <div class="row mb-3">

            <div class="col-md-6">
            {{-- order_type --}}
            <label for="order_type" class="form-label">{{ __('orders.order_type') }}</label>
            <select name="order_type" id="order_type" class="form-select" required>
                <option value="">{{ __('orders.select_order_type') }}</option>
                <option value="dine_in" {{ old('order_type') == 'dine_in' ? 'selected' : '' }}>{{ __('orders.order_types.dine_in') }}</option>
                <option value="takeaway" {{ old('order_type') == 'takeaway' ? 'selected' : '' }}>{{ __('orders.order_types.takeaway') }}</option>
                <option value="delivery" {{ old('order_type') == 'delivery' ? 'selected' : '' }}>{{ __('orders.order_types.delivery') }}</option>
            </select>
            @error('order_type')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            </div>
            <div class="col-md-6">
                <label for="table_number" class="form-label">{{ __('orders.table_number') }}</label>
                <input type="text" name="table_number" id="table_number" class="form-control" value="{{ old('table_number') }}" placeholder="{{ __('orders.placeholders.enter_table_number') }}">
                @error('table_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="payment_method" class="form-label">{{ __('orders.payment_method') }}</label>
                <select name="payment_method" id="payment_method" class="form-select" required>
                    <option value="">{{ __('orders.select_payment_method') }}</option>
                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>{{ __('orders.payment_methods.cash') }}</option>
                    <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>{{ __('orders.payment_methods.credit_card') }}</option>
                    <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>{{ __('orders.payment_methods.bank_transfer') }}</option>
                    <option value="wallet" {{ old('payment_method') == 'wallet' ? 'selected' : '' }}>{{ __('orders.payment_methods.wallet') }}</option>
                    <option value="other" {{ old('payment_method') == 'other' ? 'selected' : '' }}>{{ __('orders.payment_methods.other') }}</option>
                </select>
                @error('payment_method')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="status" class="form-label">{{ __('orders.status') }}</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="">{{ __('orders.select_status') }}</option>
                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>{{ __('orders.statuses.pending') }}</option>
                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>{{ __('orders.statuses.completed') }}</option>
                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>{{ __('orders.statuses.cancelled') }}</option>
                </select>
                @error('status')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="discount_amount" class="form-label">{{ __('orders.discount_amount') }}</label>
            <input type="number" step="0.01" min="0"  name="discount_amount" id="discount_amount" class="form-control" value="{{ old('discount_amount') ?? 0 }}" placeholder="{{ __('orders.placeholders.enter_discount_amount') }}">
            @error('discount_amount')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Items --}}
        <div class="mb-3">
            <label for="items" class="form-label">{{ __('orders.items') }}</label>
            <div id="items-container">
                <div class="item-row mb-2">
                    <select name="items[0][meal_id]" id="items[0][meal_id]" class="form-select" required>
                        <option value="">{{ __('orders.form.select_meal') }}</option>
                        @foreach($meals as $meal)
                            <option value="{{ $meal->id }}"   {{ old('items[0][meal_id]') == $meal->id ? 'selected' : '' }}>
                                {{ $meal->name_en}}
                            </option>
                        @endforeach
                    </select>
                    <input type="number" name="items[0][quantity]" id="items[0][quantity]" class="form-control" value="{{ old('items[0][quantity]') }}" required placeholder="{{ __('orders.form.enter_quantity') }}">
                </div>
            </div>
            <button type="button" class="btn btn-primary" id="add-item-btn">{{ __('orders.form.add_item') }}</button>
        </div>




        <div class="mb-3">
            <label for="notes" class="form-label">{{ __('orders.notes') }}</label>
            <textarea name="notes" id="notes" class="form-control" rows="2" placeholder="{{ __('orders.placeholders.enter_notes') }}">{{ old('notes') }}</textarea>
            @error('notes')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary {{ $isRtl ? 'ms-2' : 'me-2' }}">{{ __('orders.create_order') }}</button>
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
                body: JSON.stringify({ "name" : name, "email": email , "type" : "customer",  "fromJs" : true})
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


@endsection