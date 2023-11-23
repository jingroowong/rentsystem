<html>

<head>
    <meta charset="UTF-8">
    <title>Make Payment</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
    .wallet .card {
        border: none;
    }

    .wallet .form-control {
        border-bottom: 2px solid #eee !important;
        border: none;
        font-weight: 600
    }

    .wallet .form-control:focus {
        color: #495057;
        background-color: #fff;
        border-color: #8bbafe;
        outline: 0;
        box-shadow: none;
        border-radius: 0px;
        border-bottom: 2px solid blue !important;
    }

    .wallet .card-blue {
        background-color: #492bc4;
    }

    .wallet .hightlight {
        background-color: #5737d9;
        padding: 10px;
        border-radius: 10px;
        margin-top: 15px;
        font-size: 14px;
    }

    .wallet .yellow {
        color: #fdcc49;
    }

    .wallet .decoration {
        text-decoration: none;
        font-size: 14px;
    }

    .wallet .btn-success {
        color: #fff;
        background-color: #492bc4;
        border-color: #492bc4;
    }

    .wallet .btn-success:hover {
        color: #fff;
        background-color: #492bc4;
        border-color: #492bc4;
    }

    .wallet .decoration:hover {
        text-decoration: none;
        color: #fdcc49;
    }
    </style>

</head>

<body>
    @extends('layouts.adminApp')

    @section('content')
    <div class="ml-5 mt-2 wallet">
        <a href="{{ route('agentWallet') }}" class="btn btn-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <h2>Pay Posting Fee</h2>

        <div class="mb-4">
            <h2>Number of active property posts: {{ $activePropertyCount }}</h2>
            <p>Your current wallet balance: ${{ $walletBalance }}</p>
            <span>Please make the payment to avoid losing your potential tenant.</span>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card p-3">
                    <h6 class="text-uppercase">Payment details</h6>
                    <div class="card text-center">
                        <div class="card-body">
                            <form method="POST" action="{{ route('payment') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="duration">Select Posting Duration to extend:</label>
                                    <select name="duration" id="duration" class="form-control">
                                        <option value="7" data-discount="0">7 days</option>
                                        <option value="14" data-discount="10">14 days (-10% off)</option>
                                        <option value="30" data-discount="15">30 days (-15% off)</option>
                                    </select>
                                </div>

                                <div class="mt-3">
                                    <label for="amount">Total Amount:</label>
                                    <span id="totalAmount">$14.00</span>
                                    <input type="hidden" name="amount" id="amount" value="0">
                                </div>
                                <button type="submit" class="btn btn-primary" style="width:300px;">Pay Now</button>
        

                        </div>
                    </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-blue p-3 text-white mb-3">
                    <span>Your current package :</span>
                    <div class="d-flex flex-row align-items-end mb-3">
                        <h1 class="mb-0 yellow">Normal</h1>
                    </div>
                    <span>Enjoy discounts and benefits after you upgrade your account.</span>
                    <a href="#" class="yellow decoration">Upgrade package</a>
                    <div class="hightlight">
                        <span>100% Guaranteed support and updates for the next 5 years.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    // Add event listener to update the total amount based on the selected duration
    document.getElementById('duration').addEventListener('change', function() {
        // Get selected option
        const selectedOption = this.options[this.selectedIndex];

        // Get duration and discount from the selected option
        const duration = parseInt(selectedOption.value);
        const discount = parseInt(selectedOption.getAttribute('data-discount'));

        // Calculate total amount with discount
        const baseAmount = 2 * duration;
        const discountedAmount = baseAmount - (baseAmount * discount) / 100;

        // Update displayed total amount
        document.getElementById('totalAmount').innerText = `$${discountedAmount.toFixed(2)}`;

        // Update hidden input value for form submission
        document.getElementById('amount').value = discountedAmount;
    });
    </script>
    @endsection
</body>

</html>