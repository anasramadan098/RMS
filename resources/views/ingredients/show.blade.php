@extends('layouts.app')
@section('page_name', __('ingredients.ingredient_details'))
@section('content')<div class="container {{ $textAlign }}">
    <h1>{{ __('ingredients.ingredient_details') }}</h1>    <div class="card">
        <div class="card-header {{ $textAlign }}">         
        </div>        <div class="card-body {{ $textAlign }}">
            <p class="card-text"><strong>{{ __('ingredients.name') }}:</strong> {{ $ingredient->name }}</p>            <p class="card-text"><strong>{{ __('ingredients.description') }}:</strong> {{ $ingredient->description ?? __('app.no_data') }}</p>
            <p class="card-text"><strong>{{ __('ingredients.quantity') }}:</strong> {{ $ingredient->stock_quantity }}</p>            <p class="card-text"><strong>{{ __('ingredients.unit') }}:</strong> {{ $ingredient->unit }}</p>
            <p class="card-text"><strong>{{ __('ingredients.cost') }}:</strong> @formatCurrency($ingredient->price_per_unit)</p>  
            
            
            <p class="card-text"><strong>{{ __('ingredients.expiry_date') }}:</strong> {{ $ingredient->expiry_date ? $ingredient->expiry_date->format('Y-m-d') : __('app.no_data') }}</p>
            
            
            <p class="card-text"><strong>{{ __('ingredients.supplier') }}:</strong> {{ $ingredient->supplier->name ?? __('app.no_data') }}</p>
            <p class="card-text"><strong>{{ __('ingredients.created_at') }}:</strong> {{ $ingredient->created_at->format('Y-m-d H:i:s') }}</p>            <p class="card-text"><strong>{{ __('ingredients.updated_at') }}:</strong> {{ $ingredient->updated_at->format('Y-m-d H:i:s') }}</p>
                        <div class="mt-3">
                <a href="{{ route('ingredients.edit', $ingredient->id) }}" class="btn btn-primary">                    {{ __('app.edit') }}
                </a>                <form action="{{ route('ingredients.destroy', $ingredient->id) }}" method="POST" class="d-inline">
                    @csrf                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('app.messages.confirm_delete', ['item' => __('ingredients.ingredient')]) }}')">                        {{ __('app.delete') }}
                    </button>                </form>
                <a href="{{ route('ingredients.index') }}" class="btn btn-secondary">                    {{ __('app.back') }}
                </a>            </div>
        </div>    </div>
</div>
@endsection



















