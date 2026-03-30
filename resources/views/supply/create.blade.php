@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{__('suppliers.add_supplier')}}</h2>
    <form action="{{ route('supply.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">{{__('suppliers.supplier_name')}}</label>
            <input type="text" class="form-control" id="name" name="supplier_name" value="{{ old('supplier_name', $supply->supplier_name) }}" required>
        </div>

        <div class="mb-3">
            <label for="number" class="form-label">{{__('suppliers.contact_person')}}</label>
            <input type="tel" class="form-control" id="number" name="contact_number" value="{{ old('contact_number', $supply->contact_number) }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{__('suppliers.email')}}</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $supply->email) }}">
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">{{__('suppliers.notes')}}</label>
            <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $supply->notes) }}</textarea>
        </div>
        

        <button type="submit" class="btn btn-primary">{{__('suppliers.create_supplier')}}</button>
        <a href="{{ route('supply.index') }}" class="btn btn-secondary">{{__("suppliers.delete_supplier")}}</a>
    </form>
</div>
@endsection