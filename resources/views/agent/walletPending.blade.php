@extends('layouts.app')

@section('content')
    <div class="container">
    <a href="{{ route('agentWallet') }}" class="btn btn-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <h1>Property Rentals with Pending Payment</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Property ID</th>
                    <th>Tenant Name</th>
                    <th>Rental Amount</th>
                    <th>Due Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                
                <tr>
                        <td>R123456789</td>
                        <td>John Smith</td>
                        <td>RM 1500.00</td>
                        <td>11/8/2023</td>
                        <td>
                            <a href="#" class="btn btn-success">Request Payment</a>
                        </td>
                    </tr>
                    <tr>
                        <td>R231325125</td>
                        <td>Tom Danny</td>
                        <td>RM 500.00</td>
                        <td>12/8/2023</td>
                        <td>
                            <a href="#" class="btn btn-success">Request Payment</a>
                        </td>
                    </tr>
            </tbody>
        </table>
    </div>
@endsection
