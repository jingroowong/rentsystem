<html>

<head>
    <meta charset="UTF-8">
    <title>View Notifications</title>
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
    </style>

</head>

<body>
    <div class="container">
        <h2>Notifications</h2>

        @if(count($notifications) > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Subject</th>
                        <th>Content</th>
                        <th>Time Received</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notifications as $notification)
                    <tr class="{{ $notification->status === 'Unread' ? 'unread' : 'read' }}">
                        <td>
                            <input type="checkbox" name="notification[]" value="{{ $notification->notificationID }}">
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
                <button class="btn btn-primary" id="mark-as-read">Mark as Read</button>
            </div>
            <div class="col text-right">
                <button class="btn btn-danger" id="delete">Delete</button>
            </div>
        </div>
        @else
        <p>No notifications available.</p>
        @endif
    </div>
</body>

</html>
