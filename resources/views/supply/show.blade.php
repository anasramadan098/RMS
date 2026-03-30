@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">{{__('suppliers.supplier_details')}}</h1>
    <div class="card mb-4">
        <div class="card-header">
            <strong>{{__('suppliers.supplier_information')}}</strong>
        </div>
        <div class="card-body">
            <table class="table table-bordered mb-0">
                <tr>
                    <th>ID</th>
                    <td>{{ $supply->id }}</td>
                </tr>
                <tr>
                    <th>
                        <b>
                            {{__('suppliers.supplier_name')}}:
                        </b>
                    </th>
                    <td>{{ $supply->supplier_name }}</td>
                </tr>
                <tr>
                    <th>
                        <b>
                            {{__('suppliers.contact_person')}}:
                        </b>
                    </th>
                    <td>{{ $supply->contact_number }}</td>
                </tr>
                <tr>
                    <th>
                        <b>
                           {{__('suppliers.table.created_at')}}:
                        </b>
                    </th>
                    <td>{{ $supply->created_at }}</td>
                </tr>
                <tr>
                    <th>
                        <b>
                            {{__('suppliers.table.update_supplier')}}::
                        </b>
                    </th>
                    <td>{{ $supply->updated_at }}</td>
                </tr>
            </table>
        </div>
    </div>

    @if($products)
    <div class="card mb-4">
        <div class="card-header">
            <strong>{{__('suppliers.view_products')}}</strong>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach($products as $item)
                    <li class="list-group-item">
                        {{ $item->name }} => ({{ $item->stock ?? '' }})
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <a href="{{ route('supply.index') }}" class="btn btn-secondary">{{__('app.back')}}</a>
    <a href="{{ route('supply.edit', $supply) }}" class="btn btn-primary">{{__('app.edit')}}</a>
    <form action="{{ route('supply.destroy', $supply) }}" method="POST" class="d-inline" onsubmit="return confirm('{{__('suppliers.delete_supplier_confirm')}}');">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger">{{__('suppliers.delete_supplier')}}</button>
    </form>
</div>
@endsection