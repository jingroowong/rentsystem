<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timeslot</title>
</head>

<body>
    @extends('layouts.adminApp')

    @section('content')
    <div class="ml-5 mt-2">
    @csrf
        @if(\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success')}}</p>
        </div><br />
        @endif
        <a href="{{ route('appointments.agentIndex') }}" class="btn btn-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <h2>Timeslots</h2> 
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($timeslots as $timeslot)
                    <tr>
                        <td>{{ $timeslot->timeslotID }}</td>
                        <td>{{ $timeslot->startTime}}</td>
                        <td>{{ $timeslot->endTime }}</td>
                        <td>{{ $timeslot->date }}</td>
                        <td>
                          @if( !$timeslot->appointment)
                            <form action="{{route('timeslots.destroy', $timeslot->timeslotID)}}" method="get" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                            @else
                            <span class="text-muted">Booked</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endsection
</body>

</html>