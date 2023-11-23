<html>

<head>
    <meta charset="UTF-8">
    <title>Wallet</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body>
@extends('layouts.adminApp')

@section('content')
<div class="ml-5 mt-2">
@csrf
        @if(\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success')}}</p>
        </div><br />
        @endif
    <h2>Agent Wallet</h2> ID : {{ $walletID }}


    <div class="row">
        <div class="col-md-4">
            <h2>Your Balance: ${{ $walletBalance }}</h2>
            <a href="{{ route('pendingPayment') }}" class="link-secondary">View Pending Payment</a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('makePayment') }}" class="btn btn-primary btn-block mt-2">Make Payment for Rental Posting</a> </br>
            <a href="{{ route('topUpMoney') }}" class="btn btn-secondary btn-block  mt-2">Top Up Wallet</a></br>
            <a href="{{ route('withdrawMoney') }}" class="btn btn-success btn-block mt-2">Withdraw Money to Bank</a></br>
        </div>
    </div>
    <h2>Payment History</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Payment ID</th>
                <th>Description</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($agentTransactions as $transaction)
            <tr>
                <td>{{ $transaction-> transactionID}}</td>
                <td>{{ $transaction->transactionType }}</td>
                <td>RM{{ $transaction->transactionAmount }}</td>
                <td>{{ $transaction->transactionDate }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
</body>

</html>