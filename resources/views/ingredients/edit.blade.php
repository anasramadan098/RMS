@extends('layouts.app')
@section('page_name', __('ingredients.edit_ingredient'))
@section('content')<div class="container mt-4 {{ $textAlign }}">
    <div class="row justify-content-center">        <div class="col-md-8">
            <div class="card">                <div class="card-header {{ $textAlign }}">{{ __('ingredients.edit_ingredient') }}</div>
                <div class="card-body">                    <form action="{{ route('ingredients.update', $ingredient->id) }}" method="POST">
                        @csrf                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('ingredients.ingredient_name') }}</label>                            <input type="text" name="name" class="form-control" id="name" 
                                value="{{ old('name', $ingredient->name) }}" required> 
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('ingredients.description') }}</label>
                            <textarea name="description" class="form-control" id="description" rows="3">{{ old('description', $ingredient->description) }}</textarea>                        </div>
                        <div class="mb-3">
                            <label for="stock_quantity" class="form-label">{{ __('ingredients.quantity') }}</label>
                            <input type="number" name="stock_quantity" class="form-control" id="stock_quantity" 
                                value="{{ old('stock_quantity', $ingredient->stock_quantity) }}" required> 
                        </div>
                        <div class="mb-3">                            <label for="unit" class="form-label">{{ __('ingredients.unit') }}</label>
                            <input type="text" name="unit" class="form-control" id="unit" 
                                value="{{ old('unit', $ingredient->unit) }}" required>                        </div>
                        <div class="mb-3">                            <label for="price_per_unit" class="form-label">{{ __('ingredients.cost') }}</label>
                            <input type="number" step="0.01" name="price_per_unit" class="form-control" id="price_per_unit" 
                                value="{{ old('price_per_unit', $ingredient->price_per_unit) }}" required>                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                            <label for="min_stock_level" class="form-label">{{ __('ingredients.min_stock_level') }}</label>
                            <input type="number" name="min_stock_level" class="form-control" id="min_stock_level" value="{{ old('min_stock_level' , $ingredient->min_stock_level) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="expiry_date" class="form-label">{{ __('ingredients.expiry_date') }}</label>
                                <input type="date" name="expiry_date" class="form-control" id="expiry_date" value="{{ old('expiry_date' , $ingredient->expiry_date ? $ingredient->expiry_date->format('Y-m-d') : '') }}">
                            </div>
                        </div>
                        <div class="mb-3">                            <label for="supplier_id" class="form-label">{{ __('ingredients.supplier') }}</label>
                            <select name="supplier_id" class="form-select" id="supplier_id">                                <option value="">{{ __('ingredients.select_supplier') }}</option>
                                @foreach($suppliers as $supplier)                                    <option value="{{ $supplier->id }}" 
                                        {{ old('supplier_id', $ingredient->supplier_id) == $supplier->id ? 'selected' : '' }}>                                        {{ $supplier->supplier_name }}
                                    </option>                                @endforeach
                            </select>                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('ingredients.index') }}" class="btn btn-secondary">                                {{ __('app.cancel') }}
                            </a>                            <button type="submit" class="btn btn-primary">
                                {{ __('app.update') }}                            </button>
                        </div>                    </form>
                </div>            </div>
        </div>    </div>
</div>
@endsection






































