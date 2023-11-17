<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Add New Property</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>

    </style>
</head>

<body>

    <div class="container">
        <h2>Create Property</h2>
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: 20%;" aria-valuenow="100" aria-valuemin="0"
                aria-valuemax="100">Stage 5</div>
        </div>

        <!-- Stage 5: Completed -->
        <div class="stage" id="stage-5">
            @if($success)
            <div class="alert alert-success" role="alert">
                Property Upload Completed Successfully!
            </div>
            @else
            <div class="alert alert-danger" role="alert">
                Error Uploading Property. Please try again.
            </div>
            @endif

            <!-- Completion message and option to start a new property posting -->
            <a href="{{ route('properties') }}" class="btn btn-secondary mb-3">
                <i class="fas fa-arrow-left"></i> Back to Home
            </a>
        </div>
    </div>

</body>

</html>
