<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund</title>
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .icon {
        font-size: 18px;
    }

    .beware {
        font-size: 18px;
    }

    .propertyPhoto img {
        border-radius: 8px;
        width: 400px;
        height: 200px;

    }
    </style>
</head>

<body>
@extends('layouts.adminApp')

@section('content')
<div class="ml-5 mt-2">
<a href="{{ route('refunds') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <h2 class="mt-4 mb-4">Refund Application for {{ $refund->propertyRental->property->propertyName }}</h2>
        
        <!-- Display Property Details -->

        <div class="property-details">
            <p><strong>Address:</strong> {{ $refund->propertyRental->property->propertyAddress }}</p>
        </div>
        <form action="{{route('refunds.reject')}}" method="post" id="rejectForm">
            @csrf
            <div class="row">

                <div class="col-md-6">
                    <div class="tenantDetails">
                        <h3>Tenant details : </h3>
                        <table>
                            <tr>
                                <td>
                                    <p><strong>Tenant's Name : </strong>
                                </td>

                                <td> {{$refund->propertyRental->tenant->tenantName}}</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p><strong>Tenant's Email : </strong>
                                </td>
                                <td> {{$refund->propertyRental->tenant->tenantEmail}}</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p><strong>Tenant's Contact Number : </strong>
                                </td>
                                <td> {{$refund->propertyRental->tenant->tenantPhone}}</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Step 3: Agent Preview -->
                    <h3>Agent details : </h3>
                    <table>
                        <tr>
                            <td>
                                <p><strong>Agent's Name : </strong>
                            </td>
                            <td> {{$refund->propertyRental->property->agent->agentName}}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p><strong>Agent's Email : </strong>
                            </td>
                            <td> {{$refund->propertyRental->property->agent->agentEmail}}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p><strong>Agent's Contact Number : </strong>
                            </td>
                            <td> {{$refund->propertyRental->property->agent->agentPhone}}</p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            </br>
            <div class="row">
                <!-- Display Property Photo -->
                <div class="col-md-6 propertyPhoto">
                    <img src="{{ Storage::url($refund->propertyRental->property->propertyPhotos[0]->propertyPath) }}" alt="Property Photo">
                  
                    <div class="appointment-step" id="step-3">
                        <h3>Refund Reason</h3>

                       <h6>{{$refund->refundReason}}</h6>
                        </br>
                        <div class="btn-container">
                        <input type="hidden" name ="refundID" id="refundID" value="{{$refund->refundID}}">
                        @if($refund->refundStatus == "Approved")
                        <!-- Display information or message indicating that the status is completed -->
                        <span class="text-muted">Refund Approved</span>
                        @elseif($refund->refundStatus == "Rejected")
                        <!-- Display information or message indicating that the status is completed -->
                        <span class="text-muted">Refund Rejected</span>
                        @else
                            <a href="{{route('refunds.approve', ['refundID' => $refund->refundID])}}" class="btn btn-success"> Approve </a>
                            <button type="button" class="btn btn-danger" id="rejectButton"> Reject </button>     
                       @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

 <!-- Bootstrap Modal for Reject Reason -->
 <div class="modal fade" id="rejectReasonModal" tabindex="-1" role="dialog" aria-labelledby="rejectReasonModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectReasonModalLabel">Reject Reason</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="rejectReason">Enter Reason:</label>
                    <textarea class="form-control" id="rejectReason" name="rejectReason" rows="4"
                        placeholder="Enter the reason for rejection"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="confirmReject">Confirm Reject</button>
                </div>
            </div>
        </div>
    </div>
    <script>
    function toggleSubmitButton() {
        var checkbox = document.getElementById('readRulesCheckbox');
        var submitButton = document.getElementById('submitButton');

        // Enable the Next button if the checkbox is checked, otherwise disable it
        submitButton.disabled = !checkbox.checked;
    }
     </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function () {
            // Show modal when Reject button is clicked
            $('#rejectButton').click(function () {
                $('#rejectReasonModal').modal('show');
            });

            // Submit the rejection form with reason
            $('#confirmReject').click(function () {
                var rejectReason = $('#rejectReason').val();
                if (rejectReason.trim() !== '') {
                    // Set the reason value to a hidden input in the form
                    $('#rejectForm').append('<input type="hidden" name="rejectReason" value="' + rejectReason + '">');
                    // Submit the form
                    $('#rejectForm').submit();
                } else {
                    alert('Please enter a reason for rejection.');
                }
            });
        });
    </script>
@endsection
</body>

</html>