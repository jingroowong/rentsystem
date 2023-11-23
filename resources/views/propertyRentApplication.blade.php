@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="allRental">
        <h2>Your Properties Rentals</h2>



        @if(count($propertyRentals) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Property ID</th>
                    <th>Property Name</th>
                    <th>Property Address</th>
                    <th>Agent</th>
                    <th>Status</th>

                </tr>
            </thead>

            <tbody>
                @foreach($propertyRentals as $propertyRental)
                <tr>


                    <td>{{ $propertyRental->propertyID }}</td>
                    <td>{{ $propertyRental->property->propertyName }}</td>
                    <td>{{ $propertyRental->property->propertyAddress }}</td>
                    <td>{{ $propertyRental->property->agent->agentName }}</td>
                    <td>{{ $propertyRental->rentStatus }}</td>


                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>No record found..</p>
        @endif
    </div>
</br></br>
    <div class="Application">
        <h2>Your Properties Application</h2>


        @if(count($propertyRentals) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Property ID</th>
                    <th>Property Name</th>
                    <th>Property Address</th>
                    <th>Agent</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($propertyRentals as $propertyRental)
                <tr>
                    @if($propertyRental->rentStatus=="Approve by agent" || $propertyRental->rentStatus=="Pending for
                    agent")

                    <td>{{ $propertyRental->propertyID }}</td>
                    <td>{{ $propertyRental->property->propertyName }}</td>
                    <td>{{ $propertyRental->property->propertyAddress }}</td>
                    <td>{{ $propertyRental->property->agent->agentName }}</td>
                    <td>{{ $propertyRental->rentStatus }}</td>
                    <td>
                        @if($propertyRental->rentStatus == "Pending for agent")
                        <!-- Display information or message indicating that the status is completed -->
                        <span class="text-muted">Waiting for agent</span>
                        @else
                        <a href="{{ route('payments.create', $propertyRental->propertyRentalID) }}"
                            class="btn btn-success btn-lg">Proceed to payment</a>
                        @endif
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>No record found..</p>
        @endif
    </div>
    </br></br>
    <div class="Payment History">
        <h2>Your Payment History</h2>

        @if(count($propertyRentals) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Property ID</th>
                    <th>Property Name</th>
                    <th>Property Address</th>
                    <th>Advanced Rental</th>
                    <th>Security Deposit</th>
                    <th>Paid Amount</th>
                    <th>Payment Date</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($propertyRentals as $propertyRental)

                @if($propertyRental->rentStatus=="Paid"
                ||$propertyRental->rentStatus=="Completed"||$propertyRental->rentStatus=="Pending to refund")
                <tr>
                    <td>{{ $propertyRental->propertyID }}</td>
                    <td>{{ $propertyRental->property->propertyName }}</td>
                    <td>{{ $propertyRental->property->propertyAddress }}</td>
                    <td>{{ $propertyRental->property->rentalAmount}}</td>
                    <td>{{ $propertyRental->property->depositAmount}}</td>
                    <td>{{ $propertyRental->payment->paymentAmount}}</td>
                    <td>{{ $propertyRental->payment->paymentDate }}</td>
                    <td>
                        @if($propertyRental->rentStatus == "Completed")
                        <!-- Display information or message indicating that the status is completed -->
                        <span class="text-muted">Rent Completed</span>
                        @elseif($propertyRental->rentStatus == "Refund requested")
                        <!-- Display information or message indicating that the status is completed -->
                        <span class="text-muted">Refund Requested</span>
                        @elseif($propertyRental->rentStatus == "Refund approved")
                        <!-- Display information or message indicating that the status is completed -->
                        <span class="text-muted">Refund Approved</span>
                        @elseif($propertyRental->rentStatus == "Refund rejected")
                        <!-- Display information or message indicating that the status is completed -->
                        <span class="text-muted">Refund Rejected</span>
                        @else
                        <!-- Display buttons only if the status is not completed -->
                        <a href="{{ route('payments.release', $propertyRental->propertyRentalID) }}"
                            class="btn btn-success">Confirm Release Fund</a>
                        <a href="{{ route('refunds.create', $propertyRental->propertyRentalID) }}"
                            class="btn btn-danger">Make Refund</a>
                        @endif
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
        @else
        <p>No record found..</p>
        @endif
    </div>


</div>
@endsection