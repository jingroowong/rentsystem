@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Timeslots</h1> <a href="{{ route('timeslots.create') }}" class="btn btn-primary">Create New Timeslot</a>
        
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
                            <a href="#" class="btn btn-info">View</a>
                            <a href="#" class="btn btn-warning">Edit</a>
                            <form action="#" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
