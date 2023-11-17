<html>

<head>
    <meta charset="UTF-8">
    <title>Make Payment</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
    body {
        background-color: #eee;
    }

    .container {
        height: 100vh;

    }

    .card {
        border: none;
    }

    .form-control {
        border-bottom: 2px solid #eee !important;
        border: none;
        font-weight: 600
    }

    .form-control:focus {
        color: #495057;
        background-color: #fff;
        border-color: #8bbafe;
        outline: 0;
        box-shadow: none;
        border-radius: 0px;
        border-bottom: 2px solid blue !important;
    }

    .card-blue {
        background-color: #492bc4;
    }

    .hightlight {
        background-color: #5737d9;
        padding: 10px;
        border-radius: 10px;
        margin-top: 15px;
        font-size: 14px;
    }

    .yellow {
        color: #fdcc49;
    }

    .decoration {
        text-decoration: none;
        font-size: 14px;
    }

    .btn-success {
        color: #fff;
        background-color: #492bc4;
        border-color: #492bc4;
    }

    .btn-success:hover {
        color: #fff;
        background-color: #492bc4;
        border-color: #492bc4;
    }

    .decoration:hover {
        text-decoration: none;
        color: #fdcc49;
    }
    </style>

</head>

<body>
    <div class="container mt-5 px-5">
    <a href="{{ route('agentWallet') }}" class="btn btn-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <h1>Pay Posting Fee</h1>
        
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
                                        <option value="7">7 days</option>
                                        <option value="14">14 days</option>
                                        <option value="30">30 days</option>
                                    </select>
                                </div>

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary" style="width:300px;">Pay Now</button>
                                </div>
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


</body>

</html>