@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">#{{ $bill->bill_number }}</h3>
            <a onclick="printSaleBill()" class="btn btn-outline-primary"><i class="fas fa-print"></i> Print</a>
        </div>
        <div class="card-body" id="sale-bill">
            <h4 class="mb-3">{{ $billData['project_name'] ?? '' }}</h4>
            <div class="mb-2"><strong>Date:</strong> {{ $billData['date'] ?? '' }}</div>
            <div class="mb-2"><strong>Client Name:</strong> {{ $billData['client']['name'] ?? '' }}</div>
            <div class="mb-2"><strong>Client Email:</strong> {{ $billData['client']['email'] ?? '' }}</div>
            <div class="mb-2"><strong>Client ID:</strong> {{ $billData['client']['id'] ?? '' }}</div>
            <hr>
            <h5>Meals</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Meal ID</th>
                        <th>Meal Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>   
                </thead>
                <tbody>
                    @foreach($billData['meals'] as $i => $item)
                    <tr>
                        <td>{{ $item['meal_id'] }}</td>
                        <td>{{ $item['meal_name'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>{{ $item['price'] }}</td>
                        <td>{{ $item['total'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-end">
                <strong>Total: ${{ number_format($billData['summary']['total_amount'], 2) }}</strong>
            </div>
            <hr>
            @if (isset($billData['project_qr']))
                <div class="text-center mt-4">
                    
                    <img src="{{$billData['project_qr']}}"  alt="QR Code">

                    <div class="mt-2"><small>Scan for more</small></div>
                </div>
            @endif
        </div>
    </div>
</div>


<script>
    function printSaleBill() {
    var printContents = document.getElementById('sale-bill').innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    location.reload();
}
</script>

@endsection
