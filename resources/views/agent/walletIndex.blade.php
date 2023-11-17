<html>

<head>
    <meta charset="UTF-8">
    <title>Wallet</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body>
<div class="container">

    <h1>Agent Wallet</h1> ID : {{ $walletID }}


    <div class="row">
        <div class="col-md-4">
            <h2>Your Balance: ${{ $walletBalance }}</h2>
            <a href="{{ route('pendingPayment') }}" class="link-secondary">View Pending Payment</a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('makePayment') }}" class="btn btn-primary btn-block  mt-2" style="width: 250px;">Make Payment for Rental Posting</a> </br>
            <a href="{{ route('topUpMoney') }}" class="btn btn-secondary btn-block  mt-2" style="width: 250px;">Top Up Wallet</a></br>
            <a href="{{ route('withdrawMoney') }}" class="btn btn-success btn-block mt-2" style="width: 250px;">Withdraw Money to Bank</a></br>
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
</body>

</html>