<html>

<head>
    <meta charset="UTF-8">
    <title>Notifications</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
    /* Style for unread notifications */
    .unread {
        background-color: #f0f0f0;
    }

    /* Style for read notifications */
    .read {
        background-color: #ffffff;
        opacity: 0.8;
        /* Adjust the opacity to make it slightly dimmer */
    }

    .unreadNote{
        font-size:15px;
    }
    </style>

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
        <h2>Notifications  <span class="text-muted unreadNote"> ({{ $unreadCount }} unread notifications)</span>
</h2>

  <!-- Search Bar -->
  <form action="{{ route('notifications.search') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search notifications">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

        @if(count($notifications) > 0)
        <form action="#" method="POST" id="notification-form">
    @csrf

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                    <th>
                            <input type="checkbox" id="check-all">
                        </th>
                        <th>Subject</th>
                        <th>Content</th>
                        <th>Time Received</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notifications as $notification)
                    <tr class="{{ $notification->status === 'Unread' ? 'unread' : 'read' }}">
                        <td>
                            <input type="checkbox" class="notification-checkbox" name="notification[]" value="{{ $notification->notificationID }}">
                        </td>
                        <td>{{ $notification->subject }}</td>
                        <td>{{ $notification->content }}</td>
                        <td>{{ Carbon\Carbon::parse($notification->timestamp)->diffForHumans() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col">
                <button class="btn btn-primary" id="mark-as-read" type="button">Mark as Read</button>
            </div>
            <div class="col text-right">
                <button class="btn btn-danger" id="delete" type="button">Delete</button>
            </div>
        </div>
        @else
        <p>No notifications available.</p>
        @endif
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Check/Uncheck All
        document.getElementById('check-all').addEventListener('change', function () {
            const checkboxes = document.querySelectorAll('.notification-checkbox');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });

        // Mark as Read
        document.getElementById('mark-as-read').addEventListener('click', function () {
            document.getElementById('notification-form').action = '{{ route('notifications.markAsRead') }}';
            document.getElementById('notification-form').submit();
        });

        // Delete
        document.getElementById('delete').addEventListener('click', function () {
            document.getElementById('notification-form').action = '{{ route('notifications.delete') }}';
            document.getElementById('notification-form').submit();
        });
    });
</script>

    @endsection
</body>

</html>