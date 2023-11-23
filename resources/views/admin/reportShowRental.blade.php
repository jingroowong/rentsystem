<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .donut-inner {
            margin-top: 40%;

        }

        .donut-inner span {
            font-size: 50px;
            margin-left: -50vh;
        }
    </style>
</head>

<body>
    @extends('layouts.adminApp')

    @section('content')
    <div class="ml-5 mt-2">
    <a href="{{ route('reports') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back
        </a>
   
    <h2>Rental Transaction Report</h2>
        <p><strong>Period:</strong> {{ $startDate->format('d F Y') }} - {{ $endDate->format('d F Y') }}</p>

        <table class="table">
            <thead>
                <tr>
                    <th>Total Transaction Amount</th>
                    <th>Number of Days</th>
                    <th>Number of Transactions</th>
                    <th>Number of Refund Cases</th>


                    <th>Occupancy Rate</th>
                    <th>Total</th>
                    <th>Current</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $data['totalTransactionAmount'] }}</td>
                    <td>{{ $data['numberOfDays'] }}</td>
                    <td>{{ $data['numberOfTransactions'] }}</td>
                    <td>{{ $data['numberOfRefundCases'] }}</td>
                    <td>{{ $data['occupancyRate'] }} %</td>
                    <td>{{ $data['numberOfProperties'] }}</td>
                    <td>{{ $data['numberOfOccupancy'] }}</td>
                </tr>
            </tbody>
        </table>

        <h2>Occupancy Rate</h2>
        <div wire:ignore>
            <div class="chart-container d-flex justify-content-center" style="height: 50vh; width: 50vh;">
                <canvas id="donutChart"></canvas>
                <div class="donut-inner d-flex justify-content-center">
                    <span>{{ $data['occupancyRate'] }} %</span>
                </div>
            </div>
        </div>

        <h3>Transaction Types:</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Transaction Type</th>
                    <th>No. of Transaction</th>
                    <th>Refund</th>
                    <th>Percentage</th>
                    <th>Amount(RM)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['transactionTypes'] as $transactionType)
                <tr>
                    <td>{{ $loop->iteration}} </td>
                    <td>{{ $transactionType['type'] }}</td>
                    <td>{{ $transactionType['numberOfTransactions'] }}</td>
                    <td>{{ $transactionType['refund'] }}</td>
                    <td>{{ number_format($transactionType['numberOfTransactions'] / $data['numberOfTransactions'] * 100,
                        2)}}
                        %</td>
                    <td>{{ $transactionType['amount'] }}</td>

                </tr>
                @endforeach
            </tbody>
        </table>


        <script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('donutChart').getContext('2d');

        var data = {
            labels: ['Occupied', 'Empty'],
            datasets: [{
                data: [{{ $data['numberOfOccupancy'] }}, {{ $data['numberOfProperties'] }}],
                backgroundColor: ['rgba(255, 99, 132, 0.5)', 'rgba(255, 255, 255, 0.5)'],
                borderColor: ['rgba(255, 99, 132, 1)', 'rgba(255, 255, 255, 1)'],
                borderWidth: 1
            }]
        };

        var options = {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    display: false,
                },
                labels: {
                    render: 'percentage',
                    fontColor: 'black',
                    fontSize: 14,
                    fontStyle: 'bold',
                    position: 'default',
                    textMargin: 8,
                    overlap: true,
                }
            },
        };

        // Destroy existing chart if it exists
        if (window.myDonutChart) {
            window.myDonutChart.destroy();
        }

        window.myDonutChart = new Chart(ctx, {
            type: 'doughnut',
            data: data,
            options: options
        });

        // Draw label
        var fontSize = 20;
        ctx.font = fontSize + "px Arial";
        ctx.fillStyle = 'black';
        ctx.textAlign = 'center';
        ctx.fillText(collectionRateLabel, ctx.canvas.width / 2, ctx.canvas.height / 2);
    });
</script>

    </div>
    @endsection
</body>

</html>