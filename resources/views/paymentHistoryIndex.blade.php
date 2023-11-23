@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Payment History</h2>
        @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    
        @if(count($propertyRentals) > 0)
            <ul>
                @foreach($propertyRentals as $propertyRental)
                    <li>
                        <!-- Display payment details, adjust the fields accordingly -->
                        Amount: {{ $propertyRental->payment->paymentAmount }}, Date: {{ $propertyRental->payment->created_at }}
                    </li>
                @endforeach
            </ul>
        @else
            <p>No payment history available.</p>
        @endif
    </div>
@endsection
