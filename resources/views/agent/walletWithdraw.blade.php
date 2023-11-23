<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Wallet Withdrawal</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
@extends('layouts.adminApp')

@section('content')
<div class="ml-5 mt-2">

    <a href="{{ route('agentWallet') }}" class="btn btn-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <h2>Withdrawal</h2>

        <!-- Display Wallet Balance -->
        <p>Your Wallet Balance: {{ $agentBalance }}</p>
        <form method="POST" action="{{ route('withdraw') }}" enctype="multipart/form-data">
            @csrf
            <!-- Withdrawal Amount -->
            <div class="form-group">
                <label for="withdrawAmount">Withdrawal Amount</label>
                <div class="input-group">
                    <select class="custom-select" id="withdrawAmount" name="withdrawAmount">
                        <option value="50">$50</option>
                        <option value="100">$100</option>
                        <option value="200">$200</option>
                        <option value="500">$500</option>
                        <option value="1000">$1000</option>
                        <option value="5000">$5000</option>
                    </select>
                    <input type="text" class="form-control" id="withdrawAmount" name="withdrawAmount"
                        placeholder="Enter Custom Amount">
                </div>
            </div>

            <!-- Bank Selection -->
            <div class="form-group">
                <label for="bank">Select Bank</label>
                <select class="custom-select" id="bank" name="bank">
                    <option value="ambank">AmBank</option>
                    <option value="maybank">Maybank</option>
                    <option value="cimb">CIMB Bank</option>
                    <option value="publicbank">Public Bank</option>
                    <option value="rhb">RHB Bank</option>
                    <option value="hongleong">Hong Leong Bank</option>
                    <option value="standardchartered">Standard Chartered Bank</option>
                    <option value="ocbc">OCBC Bank</option>
                    <option value="uob">United Overseas Bank (UOB)</option>
                    <option value="hsbc">HSBC Bank</option>
                    <option value="bankislam">Bank Islam</option>
                    <option value="affinbank">Affin Bank</option>
                </select>


            </div>

            <!-- Bank Account Number -->
            <div class="form-group">
                <label for="accountNumber">Bank Account Number</label>
                <input type="text" class="form-control" id="accountNumber" name="accountNumber">
            </div>

            <!-- Withdraw Button -->
            <button type="submit" class="btn btn-primary" id="withdrawButton">Withdraw</button>
            <p class="text-muted"> Note: After clicking on the button, your withdrawal will be processed by RentSpace.
                It may takes 1-3 working days to receive the amount of money to credited to your bank. </p>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   
    @endsection
</body>

</html>