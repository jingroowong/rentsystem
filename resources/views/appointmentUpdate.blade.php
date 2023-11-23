<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment detail</title>
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
    <div class="container">
        <h2 class="mt-4 mb-4">Appointment details</h2>
        <div class="row">
            <!-- Display Property Photo -->
            <div class="col-md-6 propertyPhoto">
                <img src="{{ Storage::url($appointment->property->propertyPhotos[0]->propertyPath) }}"
                    alt="Property Photo">
                <!-- Step 3: Appointment Preview -->
                <div>
                    <!-- Display appointment details for preview -->

                    <div class="preview-details">
                        <table>
                            <tr>
                                <td>
                                    <p><strong>Property : </strong>
                                </td>
                                <td> {{ $appointment->property->propertyName }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p><strong>Location : </strong>
                                </td>
                                <td> {{ $appointment->property->propertyAddress}}</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p><strong>Date : </strong>
                                </td>
                                <td> {{$appointment->timeslot->date}}</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p><strong>Time : </strong>
                                </td>
                                <td>{{$appointment->timeslot->startTime}} - {{$appointment->timeslot->endTime}} </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p><strong>Name : </strong>
                                </td>
                                <td> {{$appointment->name }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p><strong>Email : </strong>
                                </td>
                                <td>{{$appointment->email}}</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p><strong>Contact Number : </strong>
                                </td>
                                <td> {{$appointment->contactNo}}</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p><strong>Number of Viewers : </strong>
                                </td>
                                <td> {{$appointment->headcount}}</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p><strong>Message to agent: </strong>
                                </td>
                                <td> {{$appointment->message}}</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <form action="{{route('appointments.update', $appointment->appID)}}" method="get">
                    @csrf

                    <div class="appointment-step">
                        <h4>Selects a new date and time slots</h4>
                        <!-- Display available dates using date picker -->
                        <label for="date">Select Date:</label>
                        <input type="date" id="date" name="date" onchange="updateTimeslots()">

                        <!-- Display available timeslots here -->
                        <label for="timeslot">Select Timeslot:</label>
                        <select name="timeslot" id="timeslot" disabled>
                            <!-- Timeslots will be dynamically populated here -->
                        </select>

                        <div id="availability-message"></div>
                        <div id="date-list" class="small"></div>
                    </div>
                    <input type="hidden" name="timeslotID" id="timeslotID" value="">
                    <input type="submit" class="btn btn-success" value="Confirm Update" >
                </form>
            </div>

        </div>
    </div>

    <script>
    function updateTimeslots() {
        // Retrieve selected date
        var selectedDate = document.getElementById('date').value;

        // Convert selected date to timestamp
        var selectedTimestamp = new Date(selectedDate).getTime();

        // Convert available timeslots to timestamps and filter
        var filteredTimeslots = <?php echo json_encode($availableTimeslots); ?>.filter(function(
            timeslot) {
            var timeslotTimestamp = new Date(timeslot.date).getTime();
            return timeslotTimestamp === selectedTimestamp;
        });

        var timeslotSelect = document.getElementById('timeslot');

        // Clear existing options
        timeslotSelect.innerHTML = '';

        // Enable the 'timeslot' select element
        timeslotSelect.disabled = false;

        // Populate options with filtered timeslots
        for (var i = 0; i < filteredTimeslots.length; i++) {
            var option = document.createElement('option');
            option.value = filteredTimeslots[i].timeslotID + ' ' + filteredTimeslots[i].date + ' ' +
                filteredTimeslots[
                    i].startTime + ' ' + filteredTimeslots[i].endTime;
            option.text = filteredTimeslots[i].startTime + ' - ' + filteredTimeslots[i].endTime;
            timeslotSelect.add(option);
        }

        var messageContainer = document.getElementById('availability-message');
        var dateListContainer = document.getElementById('date-list');


        // Display availability message
        if (filteredTimeslots.length > 0) {
            messageContainer.innerHTML = 'Timeslots are available on this date.';
            messageContainer.style.color = '#5cb85c'; // Green color for positive message
        } else {
            messageContainer.innerHTML = 'No available timeslots on this date.';
            messageContainer.style.color = '#d9534f'; // Red color for negative message
        }

        // Display list of distinct available dates
        var distinctDates = <?php echo json_encode($availableDates); ?>;
        dateListContainer.innerHTML = 'Hints : Available Dates = ' + distinctDates.join(', ');


        // Function to update preview details
        function updatePreview() {
            // Display the selected timeslot in the preview
            var selectedTimeslot = document.getElementById('timeslot').value;

            // Split the value into date and time
            var [timeslotID, selectedDate, selectedStartTime, selectedEndTime] = selectedTimeslot.split(' ');

            document.getElementById('timeslotID').value = timeslotID;

        }

        // Attach the function to form input change events
        document.getElementById('timeslot').addEventListener('change', updatePreview);

    }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>