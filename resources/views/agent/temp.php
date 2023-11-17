<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Detail</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body {
            padding: 20px;
            font-family: 'Arial', sans-serif; /* Use a common font for better compatibility */
        }

        .carousel-item img {
            max-width: 100%;
            height: auto;
            border-radius: 8px; /* Rounded corners for images */
        }

        .agent-profile {
            border: 1px solid #ddd;
            padding: 20px;
            margin-top: 20px;
            border-radius: 8px;
            background-color: #fff; /* Add a background color for a card-like appearance */
        }

        /* Add some spacing to improve readability */
        h2,
        h4,
        p {
            margin-bottom: 10px;
        }

        .meta-table-root {
            margin-top: 20px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .agent-info-root {
                text-align: center;
            }

            .avatar-wrapper {
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="mt-4 mb-4">Property Details</h2>

        <!-- Property Photo Carousel -->
        <div id="propertyCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @foreach($property->propertyPhotos as $index => $photo)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <img src="{{ Storage::url($photo->propertyPath) }}" alt="Property Photo {{ $index + 1 }}">
                </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#propertyCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#propertyCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <div class="container-sm">
            <!-- Property Overview Section -->
            <div class="property-overview-section row">
                <div class="property-overview-root col">
                    <div class="location-info">
                        <h1 class="title">{{ $property->propertyName }}</h1>
                        <div class="full-address">
                            <p class="full-address__text">
                                {{ $property->propertyAddress }}
                                <a role="button" tabindex="0" href="#location-section" class="actionable full-address__link btn btn-link primary">See on
                                    Map</a>
                            </p>
                        </div>
                    </div>
                    <hr class="horizontal-divider" />
                    <div class="property-info">
                        <div class="price-summary">
                            <div class="price">
                                <h2 class="amount">RM {{ $property->rentalAmount }} /MONTH</h2>
                            </div>
                        </div>
                        <div class="price-divider"></div>
                    </div>
                    <hr class="horizontal-divider" />
                </div>
            </div>

            <!-- Property Amenities Section -->
            <section class="property-amenities-section">
                <div class="property-amenities-root">
                    <h2 class="meta-table__title col">Property details</h2>
                    <!-- ... (your existing tabs and content) ... -->
                </div>
            </section>
        </div>

        <!-- Agent Profile -->
        <div class="agent-profile mt-4">
            <div class="card-header">
                <div class="agent-info-root">
                    <div class="avatar-wrapper">
                        <a href="#" class="actionable-link avatar-link">
                            <img class="hui-image-root avatar" src="{{ $agent->avatar }}" alt="{{ $agent->agentName }}">
                        </a>
                    </div>
                    <div class="details-wrapper">
                        <div class="agent-name-wrapper">
                            <a href="#" class="actionable-link agent-name truncate-line">{{ $agent->agentName }}</a>
                        </div>
                        <div class="agent-description">
                            <div>REN: {{ $agent->renNumber }}</div>
                            <div>Phone: {{ $agent->agentPhone }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="contact-agent-actions">
                    <!-- ... (your existing contact actions) ... -->
                </div>
                <div class="terms-and-policy">
                    I confirm that I have read the <a href="/privacy" rel="noopener noreferrer" target="_blank">privacy policy</a> and allow my
                    information to be shared with this agent who may contact me later.
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
