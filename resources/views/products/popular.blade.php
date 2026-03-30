@extends('layouts.app')
@section('page_name', __('meals.popular_meals'))
@section('content')
<div class="container mt-4 {{ $textAlign }}">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header {{ $textAlign }}">{{ __('meals.select_popular_meals') }}</div>
                <div class="card-body">
                    <form action="{{ route('meals.save_popular') }}" method="POST">
                        @csrf
                        <div class="row">
                            @foreach($meals as $meal)
                                <div class="col-md-4 mb-3">
                                    <div class="form-check form-check-inline meal-checkbox-container">
                                        <input class="form-check-input popular-meal-checkbox" type="checkbox" id="meal_{{ $meal->id }}" name="popular_meals[]" value="{{ $meal->id }}" {{ in_array($meal->id, $popularMealIds) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="meal_{{ $meal->id }}">
                                            <span class="meal-name">{{ $meal->name_en }}</span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">{{ __('app.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* .meal-checkbox-container {
        display: flex;
        align-items: center;
        gap: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px;
        transition: 0.2s ease-in-out;
        cursor: pointer;
        height: 100%; 
    } */

    .meal-checkbox-container:hover {
        background-color: #f8f9fa;
        border-color: #007bff;
    }

    .meal-checkbox-container input[type="checkbox"] {
        transform: scale(1.2);
        margin-bottom: 10px;
    }

    .meal-checkbox-container img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 4px;
    }

    .meal-checkbox-container .meal-name {
        margin-top: 5px;
        font-weight: bold;
        color: #333;
    }

    .meal-checkbox-container input[type="checkbox"]:checked + label {
        background-color: #e9f7ef;
        border-color: #28a745;
    }
</style>

@endsection