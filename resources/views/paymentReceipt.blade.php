<html>

<head>
    <meta charset="UTF-8">
    <title>Make Payment</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">

    <style>
    .propertyPhoto img {
        width: 400px;
        height: 200px;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="border rounded-5">

            <section class="w-100 p-4 justify-content-center">
                <div class="card">
                    <div class="card-body">
                        <div class="container mb-5 mt-3">
                            <div class="row d-flex align-items-baseline">
                                <div class="col-xl-9">
                                    <p style="color: #7e8d9f;font-size: 20px;">Invoice &gt;&gt; <strong>ID:
                                            #{{$propertyRental->propertyRentalID}}</strong></p>
                                </div>
                            </div>
                            <div class="container">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <img class="logo" src="{{Storage::url('property-photos/rentSpaceLogo.png')}}"
                                            alt="RentSpace Logo">
                                        <p class="pt-2">RentSpace</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-8">
                                        <ul class="list-unstyled">
                                            <li class="text-muted">To: <span
                                                    style="color:#8f8061 ;">{{$propertyRental->tenant->tenantName}}</span>
                                            </li>
                                            <li class="text-muted">{{$propertyRental->property->propertyName}}</li>
                                            <li class="text-muted">{{$propertyRental->property->propertyAddress}}</li>
                                            <li class="text-muted"><i class="fas fa-phone"></i>
                                                {{$propertyRental->tenant->tenantPhone}}</li>
                                        </ul>
                                    </div>
                                    <div class="col-xl-4">
                                        <p class="text-muted">Invoice</p>
                                        <ul class="list-unstyled">
                                            <li class="text-muted"><i class="fas fa-circle" style="color:#8f8061 ;"></i>
                                                <span
                                                    class="fw-bold">ID:</span>#{{$propertyRental->property->propertyID}}
                                            </li>
                                            <li class="text-muted"><i class="fas fa-circle" style="color:#8f8061 ;"></i>
                                                <span class="fw-bold">Creation Date: </span>{{$propertyRental->date}}
                                            </li>
                                            <li class="text-muted"><i class="fas fa-circle" style="color:#8f8061;"></i>
                                                <span class="me-1 fw-bold">Status:</span><span
                                                    class="badge bg-success text-black fw-bold">
                                                    Paid</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row my-2 mx-1 justify-content-center">
                                    <div class="col-md-2 mb-4 mb-md-0">
                                        <div class="rounded-5 overflow-hidden propertyPhoto"
                                            data-ripple-color="light">
                                            <img src="{{ Storage::url( $propertyRental->property->propertyPhotos[0]->propertyPath) }}"
                                                alt="Property Photo">

                                            <div class="hover-overlay">
                                                <div class="mask" style="background-color: hsla(0, 0%, 98.4%, 0.2)">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-7 mb-4 mb-md-0">
                                        <p class="fw-bold">{{$propertyRental->property->propertyName}}</p>
                                        <p class="mb-1">
                                            <span
                                                class="text-muted me-2">Type:</span><span>{{$propertyRental->property->propertyType}}</span>
                                        </p>
                                        <p class="mb-1">
                                            <span class="text-muted me-2">Built Year
                                            </span><span>{{$propertyRental->property->buildYear}}</span>
                                        </p>
                                        <p class="mb-1">
                                            <span class="text-muted me-2">Furnishing Type
                                            </span><span>{{$propertyRental->property->furnishingType}}</span>
                                        </p>
                                    </div>

                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-xl-8">
                                        <ul class="list-unstyled">
                                            <li class="text-muted ms-3"><span class="text-black me-4">Advanced
                                                    Rental</span>${{$propertyRental->property->rentalAmount}}</li>
                                            <li class="text-muted ms-3 mt-2"><span class="text-black me-4">Security
                                                    Deposit</span>${{$propertyRental->property->depositAmount}}</li>
                                        </ul>
                                        <p class="text-black float-start"><span class="text-black me-3"> Total
                                                Amount</span><span style="font-size: 25px;">$
                                                {{$propertyRental->payment->paymentAmount}}</span>
                                        </p>

                                    </div>
                                    <div class="col-xl-3">

                                        <p class="ms-3">Thank you for choosing RentSpace.</p>
                                        <a href="{{route('payments.index')}}"> Go Back </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
</section>
        </div>
</body>

</html>