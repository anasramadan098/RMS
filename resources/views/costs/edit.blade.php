@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{__('costs.edit_cost')}}</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('costs.update', $cost->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">{{__('costs.name')}}</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $cost->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">{{__('costs.amount')}}</label>
            <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="{{ old('amount', $cost->amount) }}" required>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">{{__('costs.date')}}</label>
            <input type="date" class="form-control" id="date" name="created_at" value="{{ old('date', $cost->created_at->format('Y-m-d')) }}" required>
        </div>
        
        
        <div class="mb-3">
            <label for="notes" class="form-label">{{__('costs.notes')}}</label>
            <textarea class="form-control" id="notes" name="notes">{{ old('notes', $cost->notes) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">{{__('costs.create_cost')}}</button>
        <a href="{{ route('costs.index') }}" class="btn btn-secondary">{{__('costs.delete_cost')}}</a>
    </form>
</div>
@endsection