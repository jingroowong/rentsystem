<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Properties</title>


</head>

<body>
    @extends('layouts.adminApp')

    @section('content')
    <div class="ml-5 mt-2 property">
        <h2>Properties</h2>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('createProperty') }}" class="btn btn-success mb-4"> + Create Property</a>


        <!-- Search Bar -->
        <form action="{{ route('properties.search') }}" method="get" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control"
                    placeholder="Search properties by name, location, type, or price range">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
        @if($properties!=null)
        @if(count($properties) > 0 )

        <table class="table">
            <thead>
                <tr>
                    <th>Property ID</th>
                    <th>Property Name</th>
                    <th>Property Type</th>
                    <th>Property Address</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @foreach($properties as $property)
                <tr>
                    <td>{{ $property->propertyID }}</td>
                    <td>{{ $property->propertyName }}</td>
                    <td>{{ $property->propertyType }}</td>
                    <td>{{ $property->propertyAddress }}</td>
                    @if( $property->propertyAvailability == true )
                    <td>Active</td>
                    @else
                    <td>N/A</td>
                    @endif
                    <td>
                        <a href="{{ route('properties.showAgent', $property->propertyID) }}"
                            class="btn btn-primary">View As
                            Tenant</a>
                        <a href="{{ route('properties.edit', $property->propertyID) }}"
                            class="btn btn-secondary">Update</a>
                        <a href="#" class="btn btn-danger" onclick="confirmDelete(
        '{{ route('properties.destroy', $property->propertyID) }}',
        '{{ $property->propertyName }}',
        '{{ $property->propertyType }}',
        '{{ $property->propertyAddress }}',
        '{{ Storage::url($property->propertyPhotos[0]->propertyPath) }}'
    )">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @else
        <p>No record found..</p>
        @endif
        @endif

        @if($propertyRentals != null)
        <h4>Tenant Application</h4>
        @if(count($propertyRentals) > 0)

        <table class="table">
            <thead>
                <tr>
                    <th>Property ID</th>
                    <th>Property Name</th>
                    <th>Tenant</th>
                    <th>Status</th>
                    <th>Property Address</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($propertyRentals as $propertyRental)
                <tr>
                    <td>{{ $propertyRental->propertyID }}</td>
                    <td>{{ $propertyRental->property->propertyName }}</td>
                    <td>{{ $propertyRental->tenant->tenantName }}</td>
                    <td>{{ $propertyRental->rentStatus }}</td>
                    <td>{{ $property->propertyAddress }}</td>
                    <td>
                        <a href="{{ route('properties.approve', $propertyRental->propertyRentalID) }}"
                            class="btn btn-success">Approve</a>
                        <a href="{{ route('properties.reject', $propertyRental->propertyRentalID) }}"
                            class="btn btn-danger">Reject</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @else
        <p>No record found..</p>
        @endif
        @endif

        <!-- Bootstrap CSS -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Bootstrap JS -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <!-- Bootstrap Modal -->
        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog"
            aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteConfirmationModalLabel">Are you sure to delete the following
                            property?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Property Name:</strong> <span id="propertyName"></span></p>
                        <p><strong>Property Type:</strong> <span id="propertyType"></span></p>
                        <p><strong>Property Address:</strong> <span id="propertyAddress"></span></p>
                        <img id="propertyImage" src="" alt="Property Image" style="max-width: 100%; max-height: 200px;">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" onclick="proceedWithDeletion()">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
        function confirmDelete(deleteUrl, propertyName, propertyType, propertyAddress, propertyImage) {
            // Set modal content
            document.getElementById('propertyName').textContent = propertyName;
            document.getElementById('propertyType').textContent = propertyType;
            document.getElementById('propertyAddress').textContent = propertyAddress;
            document.getElementById('propertyImage').src = propertyImage;

            // Show the modal
            $('#deleteConfirmationModal').modal('show');

            // Set the deletion URL
            $('#deleteConfirmationModal').data('deleteUrl', deleteUrl);
        }

        function proceedWithDeletion() {
            // Get the deletion URL from the modal
            var deleteUrl = $('#deleteConfirmationModal').data('deleteUrl');

            // Redirect to the deletion URL
            window.location.href = deleteUrl;
        }
        </script>
    </div>
    @endsection
</body>

</html>