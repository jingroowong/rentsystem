<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Detail</title>
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
    body {
        padding: 20px;
        font-family: 'Arial', sans-serif;
        /* Use a common font for better compatibility */
    }

    .carousel-item img {
        max-width: 100%;
        max-height: 300px;
        border-radius: 8px;
    }

    .agentProfile {
        border: 1px solid blue;
        padding: 10px;
        border-radius: 8px;
        background-color: #fff;
    }

    .agentProfile img {
        max-width: 50px;
        max-height: 50px;
    }

    .agentBtn a {
        width: 70%;
        margin-top: 10px;
    }

    .facilities {
        font-size: 18px;
        padding: 10px;
    }

    .facilities i {
        margin-right: 20px;
    }

   

    .propertyDetail td {
        font-size: 18px;
        padding: 10px;
    }

    .propertyDetail i {
        margin-right: 20px;
    }

    .propertyDetail {
        width: 80%;
    }



    .price {
        color: blue;
        font-weight: bold;
        font-family: 'Tahoma';
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
        </br>
        <div class="container-sm">
            <!-- Property Overview Section -->
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="location-info">
                        <h1 class="title">{{ $property->propertyName }}</h1>
                        <div class="full-address">
                            <p class="full-address__text">
                                {{ $property->propertyAddress }}
                                <a role="button" tabindex="0" href="#location-section"
                                    class="actionable full-address__link btn btn-link primary">See on
                                    Map</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4 ">
                    <div class="price d-flex justify-content-center">
                        <h3 class="amount">RM {{ $property->rentalAmount }} /MONTH</h3>
                    </div>
                    <div class="rentButton d-flex justify-content-center">
                        <a href="{{ route('properties.apply', ['propertyID' => $property->propertyID]) }}" class="btn btn-danger btn-lg">Rent This Space</a>
                    </div>
                </div>
            </div>

            </br>
            <div class="row">
                <div class="col-12 col-md-8">
                    <!-- Property Amenities Section -->
                    <div class="property-amenities-root">
                        <h4 class="meta-table__title">Property details</h4>
                        <ul class="property-amenities__tab-header nav nav-tabs" role="tablist">
                            <li class="nav-item" role="presentation"><button type="button"
                                    id="react-aria-3-tab-Unit Features" role="tab"
                                    data-rr-ui-event-key="Property Overview"
                                    aria-controls="react-aria-3-tabpane-Property Overview" aria-selected="true"
                                    class="property-amenities__tab-header-item nav-link active">Property
                                    Overview</button>
                            </li>
                            <li class="nav-item" role="presentation"><button type="button"
                                    id="react-aria-3-tab-Facilities" role="tab" data-rr-ui-event-key="Facilities"
                                    aria-controls="react-aria-3-tabpane-Facilities" aria-selected="false" tabindex="-1"
                                    class="property-amenities__tab-header-item nav-link">Facilities</button>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div role="tabpanel" id="react-aria-3-tabpane-Property Overview"
                                aria-labelledby="react-aria-3-tab-Property Overview" class="fade tab-pane active show">
                                <div class="property-amenities__body">
                                    <div class="meta-table-root">
                                        <h6>
                                            {{ $property->propertyDesc}}
                                        </h6>
                                        <table class="propertyDetail">
                                            <tr>
                                                <td class="meta-table__item-wrapper ">
                                                    <i class="las la-building"></i> {{ $property->propertyType }}
                                                </td>
                                                <td class="meta-table__item-wrapper">
                                                    <i class="las la-crop-alt"></i> {{ $property->squareFeet }} sqft
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="meta-table__item-wrapper">
                                                    <i class="las la-brush"></i> {{ $property->furnishingType }}
                                                </td>
                                                <td class="meta-table__item-wrapper">
                                                    <i class="las la-brush"></i> {{ $property->buildYear }} Year
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="meta-table__item-wrapper">
                                                    <i class="las la-bed"></i> {{ $property->bedroomNum }} Bedroom
                                                </td>
                                                <td class="meta-table__item-wrapper">
                                                    <i class="las la-bath"></i> {{ $property->bathroomNum }}
                                                    Bathroom
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" id="react-aria-3-tabpane-Facilities"
                                aria-labelledby="react-aria-3-tab-Facilities" class="fade tab-pane">
                                <div class="property-amenities__body">
                                    <div class="meta-table-root row facilities">
                                        @forelse($property->propertyFacilities ?? [] as $facility)
                                        <div class="col-md-6 col-12">
                                            <i class="{{ $facility->facility->facilityIcon }}"></i>
                                            {{ $facility->facility->facilityName }}
                                        </div>

                                        @empty
                                        <li>No facilities available</li>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4 agentProfile">
                    <!-- Agent Profile -->
                    <div class="card-header row">
                        <div class="col-2">
                            <img class="avatar" src="{{Storage::url('property-photos/unnamed.jpg')}}"
                                alt="{{ $agent->agentName }}">
                        </div>
                        <div class="col-10">
                            <h5 class="card-title">{{ $agent->agentName }}</h5>
                            <p class="card-text"><small class="text-muted">REN: 17144</small></p>

                        </div>
                    </div>
                    <div class="card-body text-center agentBtn">
                        <a href="{{ route('appointment.create', ['propertyID' => $property->propertyID]) }}"
                            class="btn btn-primary"> Book Appointment </a>

                        <a href="#" class="btn btn-primary"> View agent profile</a>

                        <a href="#" class="btn btn-primary"> Send Enquiry </a>

                    </div>
                    <div class="terms-and-policy">
                        By clicking the link, I confirm that I have read the <a href="#">privacy policy</a> and
                        allow my
                        information to be
                        shared with this agent who may contact me later.
                    </div>
                </div>
            </div>
        </div>
        </section>

    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js">
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all tab headers and tab panels
        const tabHeaders = document.querySelectorAll('.property-amenities__tab-header-item');
        const tabPanels = document.querySelectorAll('.tab-pane');

        // Add click event listeners to each tab header
        tabHeaders.forEach((header, index) => {
            header.addEventListener('click', function() {
                // Remove 'active' class from all tab headers and tab panels
                tabHeaders.forEach(tabHeader => tabHeader.classList.remove('active'));
                tabPanels.forEach(tabPanel => tabPanel.classList.remove('show', 'active'));

                // Add 'active' class to the clicked tab header and corresponding tab panel
                header.classList.add('active');
                tabPanels[index].classList.add('show', 'active');
            });
        });
    });
    </script>
</body>

</html>