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
        height: auto;
        border-radius: 8px;
        /* Rounded corners for images */
    }

    .agent-profile {
        border: 1px solid #ddd;
        padding: 20px;
        margin-top: 20px;
        border-radius: 8px;
        background-color: #fff;
        /* Add a background color for a card-like appearance */
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
                                <a role="button" tabindex="0" href="#location-section"
                                    class="actionable full-address__link btn btn-link primary">See on
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

                    <ul class="property-amenities__tab-header nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation"><button type="button"
                                id="react-aria-3-tab-Unit Features" role="tab" data-rr-ui-event-key="Unit Features"
                                aria-controls="react-aria-3-tabpane-Unit Features" aria-selected="true"
                                class="property-amenities__tab-header-item nav-link active">Property
                                Overview</button></li>
                        <li class="nav-item" role="presentation"><button type="button" id="react-aria-3-tab-Facilities"
                                role="tab" data-rr-ui-event-key="Facilities"
                                aria-controls="react-aria-3-tabpane-Facilities" aria-selected="false" tabindex="-1"
                                class="property-amenities__tab-header-item nav-link">Facilities</button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" id="react-aria-3-tabpane-Unit Features"
                            aria-labelledby="react-aria-3-tab-Unit Features" class="fade tab-pane active show">
                            <div class="property-amenities__body">
                                <div class="meta-table-root">
                                    <div class="row">

                                        <div class="description trimmed">{{ $property->propertyDesc}}
                                        </div>
                                    </div>
                                    <table class="row">
                                        <tbody>
                                            <tr class="row">
                                                <td class="meta-table__item-wrapper col-md-6 col-12">
                                                    <div class="meta-table__item">
                                                        <div class="row">
                                                            <div class="meta-table__item__label col-md-12 col-5">
                                                                Property
                                                                Type</div>
                                                            <div class="meta-table__item__value col-md-12 col-7">
                                                                <div class="meta-table__item__value-text">
                                                                    {{ $property->propertyType }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="meta-table__item-wrapper col-md-6 col-12">
                                                    <div class="meta-table__item">
                                                        <div class="row">
                                                            <div class="meta-table__item__label col-md-12 col-5">
                                                                <i class="las la-crop-alt"></i>Floor
                                                                Size
                                                            </div>
                                                            <div class="meta-table__item__value col-md-12 col-7">
                                                                <div class="meta-table__item__value-text">
                                                                    {{ $property->squareFeet }} sqft
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="row">
                                                <td class="meta-table__item-wrapper col-md-6 col-12">
                                                    <div class="meta-table__item">
                                                        <div class="row">
                                                            <div class="meta-table__item__label col-md-12 col-5">
                                                                <i class="las la-brush"></i>Furnishing
                                                            </div>
                                                            <div class="meta-table__item__value col-md-12 col-7">
                                                                <div class="meta-table__item__value-text">
                                                                    {{ $property->furnishingType }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="meta-table__item-wrapper col-md-6 col-12">
                                                    <div class="meta-table__item">
                                                        <div class="row">
                                                            <div class="meta-table__item__label col-md-12 col-5">
                                                                <i class="las la-brush"></i>Built Year
                                                            </div>
                                                            <div class="meta-table__item__value col-md-12 col-7">
                                                                <div class="meta-table__item__value-text">
                                                                    {{ $property->buildYear }} year
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="row">
                                                <td class="meta-table__item-wrapper col-md-6 col-12">
                                                    <div class="meta-table__item">
                                                        <div class="row">
                                                            <div class="meta-table__item__label col-md-12 col-5">
                                                                <i class="las la-bed"></i>Bedroom
                                                            </div>
                                                            <div class="meta-table__item__value col-md-12 col-7">
                                                                <div class="meta-table__item__value-text">
                                                                    {{ $property->bedroomNum }} bed
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="meta-table__item-wrapper col-md-6 col-12">
                                                    <div class="meta-table__item">
                                                        <div class="row">
                                                            <div class="meta-table__item__label col-md-12 col-5">
                                                                <i class="las la-bath"></i>Bathroom
                                                            </div>
                                                            <div class="meta-table__item__value col-md-12 col-7">
                                                                <div class="meta-table__item__value-text">
                                                                    {{ $property->bathroomNum }} bath
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" id="react-aria-3-tabpane-Facilities"
                        aria-labelledby="react-aria-3-tab-Facilities" class="fade tab-pane">
                        <div class="property-amenities__body">
                            <div class="property-amenities__row row">
                                @forelse($property->propertyFacilities ?? [] as $facility)
                                <div class="col-md-6 col-12">
                                    <div class="property-amenities__row-item"><i
                                            class="{{ $facility->facility->facilityIcon }}"></i>
                                        {{ $facility->facility->facilityName }}</div>
                                </div>
                                @empty
                                <li>No facilities available</li>
                                @endforelse
                            </div>


                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="section-divider"></div>
        <!-- Agent Profile -->
        <div class="agent-profile mt-4">
            <div class="card-header">
                <div class="agent-info-root">
                    <div class="avatar-wrapper">
                        <a href="#" class="actionable-link avatar-link">
                            <img class="hui-image-root avatar" src="{{Storage::url('property-photos/unnamed.jpg')}}"
                                alt="{{ $agent->agentName }}">
                        </a>
                    </div>
                    <div class="details-wrapper">
                        <div class="agent-name-wrapper">
                            <a href="#" class="actionable-link agent-name truncate-line">{{ $agent->agentName }}</a>
                        </div>
                        <div class="agent-description">
                            <div>REN: 17144</div>
                            <div>Phone: {{ $agent->agentPhone }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="contact-agent-actions">
                    <div class="contact-agent-actions">

                       
                            <a href="{{ route('appointment.create', ['propertyID' => $property->propertyID]) }}"
                                class="btn btn-primary">
                                <i class="pgicon-phone-o"></i> Book Appointment
                            </a>
                        

                        <div class="actionable-link actionable-text btn-outline-secondary btn"
                            data-automation-id="enquiry-widget-phone-btn">
                            <div class="reveal-animation-backgound"></div>
                            <div class="phone-number"><i class="pgicon-phone-o"></i>View agent profile</div>
                        </div>
                        <div class="actionable-link btn-outline-secondary btn"
                            data-automation-id="enquiry-widget-msg-btn"><i class="pgicon-mail-o"></i><span
                                class="label">Send Enquiry</span></div>
                    </div>
                </div>
                <div class="terms-and-policy">
                    I confirm that I have read the <a href="/privacy" rel="noopener noreferrer" target="_blank">privacy
                        policy</a> and allow my
                    information to be shared with this agent who may contact me later.
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js">
    </script>
</body>

</html>