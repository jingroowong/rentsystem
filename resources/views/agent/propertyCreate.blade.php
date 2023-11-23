<html>

<head>
    <meta charset="UTF-8">
    <title>Add New Property</title>
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
    .hidden {
        display: none;
    }

    /* CSS to set a fixed size for the images */
    #uploadedImages img,
    #propertyPreview img {
        width: 100px;
        /* Adjust the width as needed */
        height: auto;
        /* Maintain aspect ratio */
        margin: 5px;
        /* Add spacing between images */
    }

    #uploadedImages button {
        background-color: red;
        color: white;
        border: none;
        padding: 5px;
        cursor: pointer;
    }
    </style>
</head>

<body>
@extends('layouts.adminApp')

@section('content')
<div class="container">
<a href="{{ route('properties') }}" class="btn btn-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <h2>Create Property</h2>
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: 20%;" aria-valuenow="20" aria-valuemin="0"
                aria-valuemax="100">Stage 1</div>
        </div>
        <form method="POST" action="{{ route('properties.store') }}" enctype="multipart/form-data">
            @csrf


            <!-- Stage 1: Fill in Property Form -->
            <div class="stage" id="stage-1">
                <h3>Stage 1 : Fill in Property Details</h3>
                <div class="row">
                    <!-- Property Name -->
                    <div class="form-group col-md-6">
                        <label for="propertyName">Property Name</label>
                        <input type="text" class="form-control" id="propertyName" name="propertyName" required>
                    </div>

                    <!-- Property Description -->
                    <div class="form-group col-md-12">
                        <label for="propertyDesc">Property Description</label>
                        <textarea class="form-control" id="propertyDesc" name="propertyDesc" rows="4"
                            required></textarea>
                    </div>



                    <!-- Property Address -->
                    <div class="form-group col-md-6">
                        <label for="propertyAddress">Property Address</label>
                        <input type="text" class="form-control" id="propertyAddress" name="propertyAddress" required>
                    </div>

                    <!-- State (Dropdown) -->
                    <div class="form-group col-md-6">
                        <label for="stateID">State</label>
                        <select class="form-control" id="stateID" name="stateID" required>
                            @foreach($states as $state)
                            <option value="{{ $state->stateID }}">{{ $state->stateName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Number of Bedrooms -->
                    <div class="form-group col-md-6">
                        <label for="bedroomNum">Number of Bedrooms</label>
                        <input type="number" class="form-control" id="bedroomNum" name="bedroomNum" required>
                    </div>

                    <!-- Number of Bathrooms -->
                    <div class="form-group col-md-6">
                        <label for="bathroomNum">Number of Bathrooms</label>
                        <input type="number" class="form-control" id="bathroomNum" name="bathroomNum" required>
                    </div>
                    <!-- Property Type (Dropdown) -->
                    <div class="form-group col-md-6">
                        <label for="propertyType">Property Type</label>
                        <select class="form-control" id="propertyType" name="propertyType" required>
                            <option value="Residential apartment">Residential apartment</option>
                            <option value="House">House</option>
                            <option value="Condominium">Condominium</option>
                            <option value="Commercial spaces">Commercial spaces</option>
                        </select>
                    </div>

                    <!-- Property Size (Square Feet) -->
                    <div class="form-group col-md-6">
                        <label for="squareFeet">Property Size (Square Feet)</label>
                        <input type="number" class="form-control" id="squareFeet" name="squareFeet">
                    </div>

                    <!-- Furnishing Type (Radio Buttons) -->
                    <div class="form-group col-md-6">
                        <label>Furnishing Type</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="furnishingType" id="fullyFurnished"
                                value="Fully Furnished" required>
                            <label class="form-check-label" for="fullyFurnished">Fully Furnished</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="furnishingType" id="partialFurnished"
                                value="Partial Furnished">
                            <label class="form-check-label" for="partialFurnished">Partial Furnished</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="furnishingType" id="unfurnished"
                                value="Unfurnished">
                            <label class="form-check-label" for="unfurnished">Unfurnished</label>
                        </div>
                    </div>

                    <!-- Build Year -->
                    <div class="form-group col-md-6">
                        <label for="buildYear">Build Year</label>
                        <input type="number" class="form-control" id="buildYear" name="buildYear">
                    </div>

                    <!-- Rental Amount -->
                    <div class="form-group col-md-6">
                        <label for="rentalAmount">Rental Amount (MYR)</label>
                        <input type="number" step="0.01" class="form-control" id="rentalAmount" name="rentalAmount"
                            required>
                    </div>

                    <!-- Deposit Amount -->
                    <div class="form-group col-md-6">
                        <label for="depositAmount">Deposit Amount (MYR)</label>
                        <input type="number" step="0.01" class="form-control" id="depositAmount" name="depositAmount">
                    </div>

                    <!-- Property Availability (Radio Buttons) -->
                    <div class="form-group col-md-6">
                        <label>Property Availability</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="propertyAvailability" id="available"
                                value="1" required>
                            <label class="form-check-label" for="available">Available</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="propertyAvailability" id="notAvailable"
                                value="0" required>
                            <label class="form-check-label" for="notAvailable">Not Available</label>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                    </div>
                    </br>
                    </br>

                    <!-- Facilities (Checklist) -->
                    <div class="form-group col-md-6">
                        <label>Facilities (Check all that apply)</label><br>
                        @foreach($facilities->slice(0, 40) as $facility)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="facilities[]"
                                value="{{ $facility->facilityID }}">
                            <label class="form-check-label" for="{{ $facility->facilityID }}">
                                <i class="las {{ $facility->facilityIcon }}"></i> {{ $facility->facilityName }}
                            </label>


                        </div>
                        @endforeach
                    </div>

                    <div class="form-group col-md-6">
                        <label>Unit Features(Check all that apply)</label><br>
                        @foreach($facilities->slice(40) as $facility)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="facilities[]"
                                value="{{ $facility->facilityID }}">
                            <label class="form-check-label" for="{{ $facility->facilityID }}">
                                <i class="las {{ $facility->facilityIcon }}"></i> {{ $facility->facilityName }}
                            </label>


                        </div>
                        @endforeach
                    </div>
                </div>
                <button type="button" class="btn btn-primary" id="next-stage-2">Next</button>
            </div>

            <!-- Stage 2: Upload Photos -->
            <div class="stage hidden" id="stage-2">
                <h3>Stage 2: Upload Photos</h3>

                <!-- Property Photos (File Upload) -->
                <div class="form-group col-md-6">
                    <label for="propertyPhotos">Property Photos</label>
                    <input type="file" class="form-control" id="propertyPhotos" name="propertyPhotos[]" accept="image/*"
                        multiple required>
                </div>

                <!-- Display uploaded images -->
                <div id="uploadedImages"></div>

                <!-- Next button to move to Stage 3 -->
                <button type="button" class="btn btn-primary" id="next-stage-3">Next</button>
                <button type="button" class="btn btn-secondary" id="previous-stage-1">Previous</button>

                <script>
                // Function to display uploaded images
                function displayImages(event) {
                    const fileInput = event.target;
                    const uploadedImagesDiv = document.getElementById('uploadedImages');

                    // Clear the previous images
                    uploadedImagesDiv.innerHTML = '';

                    // Display each selected image
                    for (const file of fileInput.files) {
                        const img = document.createElement('img');
                        img.src = URL.createObjectURL(file);
                        img.alt = file.name;
                        uploadedImagesDiv.appendChild(img);

                        // Add a button to remove the image
                        const removeButton = document.createElement('button');
                        removeButton.textContent = 'X';

                        removeButton.addEventListener('click', function() {
                            img.remove();
                            removeButton.remove();
                            fileInput.value = ''; // Clear the input to allow re-uploading the same file
                        });
                        uploadedImagesDiv.appendChild(removeButton);
                    }
                }

                // Attach the displayImages function to the change event of the file input
                document.getElementById('propertyPhotos').addEventListener('change', displayImages);
                </script>
            </div>




            <!-- Stage 3: Preview -->
            <div class="stage hidden" id="stage-3">
                <h3>Stage 3: Preview</h3>
                <!-- Property Preview Container -->
                <div id="propertyPreview" class="card">
                    <div class="card-header">
                        <h4 class="card-title">Property Preview</h4>
                    </div>
                    <div class="card-body">
                        <!-- Property Name Preview -->
                        <p><strong>Property Name:</strong> <span id="previewPropertyName"></span></p>

                        <!-- Property Description Preview -->
                        <p><strong>Property Description:</strong> <span id="previewPropertyDesc"></span></p>

                        <!-- Property Address Preview -->
                        <p><strong>Property Address:</strong> <span id="previewPropertyAddress"></span></p>

                        <!-- State Preview -->
                        <p><strong>State:</strong> <span id="previewState"></span></p>

                        <!-- Number of Bedrooms Preview -->
                        <p><strong>Number of Bedrooms:</strong> <span id="previewBedroomNum"></span></p>

                        <!-- Number of Bathrooms Preview -->
                        <p><strong>Number of Bathrooms:</strong> <span id="previewBathroomNum"></span></p>

                        <!-- Property Type Preview -->
                        <p><strong>Property Type:</strong> <span id="previewPropertyType"></span></p>

                        <!-- Property Size Preview -->
                        <p><strong>Property Size (Square Feet):</strong> <span id="previewSquareFeet"></span></p>

                        <!-- Furnishing Type Preview -->
                        <p><strong>Furnishing Type:</strong> <span id="previewFurnishingType"></span></p>

                        <!-- Build Year Preview -->
                        <p><strong>Build Year:</strong> <span id="previewBuildYear"></span></p>

                        <!-- Rental Amount Preview -->
                        <p><strong>Rental Amount (MYR):</strong> <span id="previewRentalAmount"></span></p>

                        <!-- Deposit Amount Preview -->
                        <p><strong>Deposit Amount (MYR):</strong> <span id="previewDepositAmount"></span></p>

                        <!-- Property Availability Preview -->
                        <p><strong>Property Availability:</strong> <span id="previewPropertyAvailability"></span></p>


                        <!-- Photo Preview -->
                        <p><strong>Property Photos:</strong></p>
                        <div id="photoPreview"></div>
                    </div>
                </div>

                <!-- Next button to move to Stage 4 or Previous button to go back to Stage 2 -->
                <button type="button" class="btn btn-primary" id="next-stage-4">Next</button>
                <button type="button" class="btn btn-secondary" id="previous-stage-2">Previous</button>
            </div>

            <script>
            // Function to update the preview based on user input
            function updatePreview() {
                // Update Property Name Preview
                document.getElementById('previewPropertyName').innerText = document.getElementById('propertyName')
                    .value;

                // Update Property Description Preview
                document.getElementById('previewPropertyDesc').innerText = document.getElementById('propertyDesc')
                    .value;

                // Update Property Address Preview
                document.getElementById('previewPropertyAddress').innerText = document.getElementById('propertyAddress')
                    .value;

                // Update State Preview
                document.getElementById('previewState').innerText = document.getElementById('stateID').options[document
                    .getElementById('stateID').selectedIndex].text;

                // Update Number of Bedrooms Preview
                document.getElementById('previewBedroomNum').innerText = document.getElementById('bedroomNum').value;

                // Update Number of Bathrooms Preview
                document.getElementById('previewBathroomNum').innerText = document.getElementById('bathroomNum').value;

                // Update Property Type Preview
                document.getElementById('previewPropertyType').innerText = document.getElementById('propertyType')
                    .value;

                // Update Property Size Preview
                document.getElementById('previewSquareFeet').innerText = document.getElementById('squareFeet').value;

                // Update Furnishing Type Preview
                document.getElementById('previewFurnishingType').innerText = document.querySelector(
                    'input[name="furnishingType"]:checked').value;

                // Update Build Year Preview
                document.getElementById('previewBuildYear').innerText = document.getElementById('buildYear').value;

                // Update Rental Amount Preview
                document.getElementById('previewRentalAmount').innerText = document.getElementById('rentalAmount')
                    .value;

                // Update Deposit Amount Preview
                document.getElementById('previewDepositAmount').innerText = document.getElementById('depositAmount')
                    .value;

                // Update Property Availability Preview
                document.getElementById('previewPropertyAvailability').innerText = document.querySelector(
                    'input[name="propertyAvailability"]:checked').value === '1' ? 'Available' : 'Not Available';
            }


            // Function to update the facilities preview

            // Function to handle file input changes
            function handleFileInput() {
                const input = document.getElementById('propertyPhotos');
                const previewContainer = document.getElementById('photoPreview');

                // Clear previous previews
                previewContainer.innerHTML = '';

                // Display preview for each selected file
                for (const file of input.files) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'img-thumbnail';
                        previewContainer.appendChild(img);
                    };

                    reader.readAsDataURL(file);
                }
            }

            // Event listener for file input changes
            document.getElementById('propertyPhotos').addEventListener('change', handleFileInput);

            // Event listeners for input changes
            document.getElementById('propertyName').addEventListener('input', updatePreview);
            document.getElementById('propertyDesc').addEventListener('input', updatePreview);
            document.getElementById('propertyAddress').addEventListener('input', updatePreview);
            document.getElementById('stateID').addEventListener('change', updatePreview);
            document.getElementById('bedroomNum').addEventListener('input', updatePreview);
            document.getElementById('bathroomNum').addEventListener('input', updatePreview);
            document.getElementById('propertyType').addEventListener('change', updatePreview);
            document.getElementById('squareFeet').addEventListener('input', updatePreview);
            document.querySelectorAll('input[name="furnishingType"]').forEach(function(radio) {
                radio.addEventListener('change', updatePreview);
            });
            document.getElementById('buildYear').addEventListener('input', updatePreview);
            document.getElementById('rentalAmount').addEventListener('input', updatePreview);
            document.getElementById('depositAmount').addEventListener('input', updatePreview);
            document.querySelectorAll('input[name="propertyAvailability"]').forEach(function(radio) {
                radio.addEventListener('change', updatePreview);
            });
            </script>



            <!-- Stage 4: Payment -->
            <div class="stage hidden" id="stage-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Payment Details</h3>
                    </div>
                    <div class="card-body">
                        <p>Your current wallet balance: RM {{ $walletBalance }}</p>
                        <p>Posting Fee: RM 10.00 for the first 7 days of posting</p>
                        <hr>

                        <!-- Check if wallet balance is sufficient -->
                        @if ($walletBalance >= 10.00)
                        <!-- Wallet Balance (if using wallet) -->
                        <div id="walletBalance" class="alert alert-info">
                            Your wallet will be charged RM 10.00 for the posting fee.
                        </div>

                        <!-- Confirm button to move to Stage 5 or Previous button to go back to Stage 3 -->
                        <input type="submit" class="btn btn-success" id="confirmPayment" value="Confirm Payment">
                        <button type="button" class="btn btn-secondary" id="previous-stage-3">Previous</button>
                        @else
                        <!-- Display message and button to redirect to wallet top-up page -->
                        <div class="alert alert-danger">
                            Your wallet balance is insufficient. Please
                            <a href="{{ route('topUpMoney') }}" class="alert-link">top up your wallet</a>.
                        </div>
                        @endif
                    </div>
                </div>
            </div>


            <!-- Stage 5: Completed -->
            <div class="stage hidden" id="stage-5">
                <h3>Post Upload Completed</h3>
                <!-- Completion message and option to start a new property posting -->
                <a href="{{ route('properties') }}" class="btn btn-secondary mb-3">
                    <i class="fas fa-arrow-left"></i> Back to Home
                </a>
            </div>

        </form>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
        // JavaScript and jQuery code for handling stage transitions
        $(document).ready(function() {
            function updateProgressBar(stage) {
                // Define the total number of stages in your form
                const totalStages = 4;

                // Calculate the new width for the progress bar
                const newWidth = (stage / totalStages) * 100 + '%';

                // Update the progress bar width
                $('.progress-bar').css('width', newWidth);

                // Update the progress text (optional)
                $('.progress-bar').text('Stage ' + stage);
            }
            $('#next-stage-2').click(function() {
                // Move to Stage 2
                $('#stage-1').addClass('hidden');
                $('#stage-2').removeClass('hidden');
                updateProgressBar(2);
            });

            $('#next-stage-3').click(function() {
                // Move to Stage 3
                $('#stage-2').addClass('hidden');
                $('#stage-3').removeClass('hidden');
                updateProgressBar(3);
            });

            $('#next-stage-4').click(function() {
                // Move to Stage 4
                $('#stage-3').addClass('hidden');
                $('#stage-4').removeClass('hidden');
                updateProgressBar(4);
            });

            $('#previous-stage-1').click(function() {
                // Go back to Stage 1
                $('#stage-2').addClass('hidden');
                $('#stage-1').removeClass('hidden');
                updateProgressBar(1);
            });

            $('#previous-stage-2').click(function() {
                // Go back to Stage 2
                $('#stage-3').addClass('hidden');
                $('#stage-2').removeClass('hidden');
                updateProgressBar(2);
            });

            $('#previous-stage-3').click(function() {
                // Go back to Stage 3
                $('#stage-4').addClass('hidden');
                $('#stage-3').removeClass('hidden');
                updateProgressBar(3);
            });

            $('#confirm').click(function() {
                // Move to Stage 5 (or perform payment validation)
                $('#stage-4').addClass('hidden');
                $('#stage-5').removeClass('hidden');
                updateProgressBar(5);
            });

            $('#new-posting').click(function() {
                // Start a new property posting (optional)
                $('#stage-5').addClass('hidden');
                $('#stage-1').removeClass('hidden');
            });
        });
        </script>
    </div>

    @endsection
</body>

</html>