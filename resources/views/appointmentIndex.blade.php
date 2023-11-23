<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Appointments</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        @csrf
        @if(\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success')}}</p>
        </div><br />
        @endif
        <h2 class="mt-4 mb-4">Upcoming Appointments</h2>

        @if(count($appointments) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Appointment ID</th>
                    <th>Property</th>
                    <th>Timeslot</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->appID }}</td>
                    <td>{{ $appointment->property->propertyName }}</td>
                    <td>{{ $appointment->timeslot->startTime }} - {{ $appointment->timeslot->endTime }}</td>
                    <td>{{ $appointment->status }}</td>
                    <td>
                        <a href="{{ route('appointments.edit', $appointment->appID) }}"
                            class="btn btn-primary">Modify</a>
                        <a href="{{ route('appointments.show', $appointment->appID) }}"
                            class="btn btn-danger">Cancel</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @else
        <p>No upcoming appointments..</p>
        @endif
        <a href="#" class="btn btn-primary">Back to Dashboard</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>