<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add New Timeslot</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div class="container mt-5">
        <div id="add-timeslot-form">
            <h2 class="mb-4">Add Timeslot</h2>
            <form method="POST" action="{{ route('timeslots.store') }}">
                @csrf
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Select Timeslots:</label>
                    <div class="timeslots-list">
                        @php
                        $start_time = strtotime('08:00');
                        $end_time = strtotime('18:00');
                        $interval = 30 * 60; // 30 minutes in seconds
                        @endphp
                        @for ($time = $start_time; $time <= $end_time; $time += $interval)
                            @php
                            $formatted_time = date('H:i', $time);
                            @endphp
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="timeslots[]"
                                    value="{{ $formatted_time }}" id="{{ $formatted_time }}">
                                <label class="form-check-label" for="{{ $formatted_time }}">
                                    {{ $formatted_time }}
                                </label>
                            </div>
                        @endfor
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
