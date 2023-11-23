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
    body {
        background: #f5f5f5
    }

    .rounded {
        border-radius: 1rem
    }

    .nav-pills .nav-link {
        color: #555
    }

    .nav-pills .nav-link.active {
        color: white
    }

    input[type="radio"] {
        margin-right: 5px
    }

    .bold {
        font-weight: bold
    }

    .property-details img {
        border-radius: 8px;
        width: 300px;
        height: 200px;

    }
    </style>
</head>

<body>
    <div class="container">

        <a href="{{ route('properties.applicationIndex') }}" class="btn btn-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <h2>Advance rental for Property {{ $propertyRental->property->propertyName }} </h2>

        <div class="row m-0">
            <div class="col-6">
                <div class="row">
                    <div class="col-12 p-5 property-details">
                        <img src="{{ Storage::url( $propertyRental->property->propertyPhotos[0]->propertyPath) }}"
                            alt="Property Photo">
                    </div>

                    <div class="row m-0 bg-light">
                        <div class="col-md-4 col-6 ps-30 pe-0 my-4">
                            <i class="las la-building"></i> {{ $propertyRental->property->propertyType }}

                        </div>
                        <div class="col-md-4 col-6  ps-30 my-4">
                            <i class="las la-crop-alt"></i> {{ $propertyRental->property->squareFeet }} sqft

                        </div>
                        <div class="col-md-4 col-6 ps-30 my-4">
                            <i class="las la-brush"></i> {{  $propertyRental->property->furnishingType }}

                        </div>
                        <div class="col-md-4 col-6 ps-30 my-4">
                            <i class="las la-brush"></i> {{ $propertyRental->property->buildYear }} Year

                        </div>
                        <div class="col-md-4 col-6 ps-30 my-4">
                            <i class="las la-bed"></i> {{ $propertyRental->property->bedroomNum }} Bedroom

                        </div>
                        <div class="col-md-4 col-6 ps-30 my-4">
                            <i class="las la-bath"></i> {{ $propertyRental->property->bathroomNum }} Bathroom
                        </div>
                    </div>
                </div>


                <div class="row m-0">
                    <div class="col-12 px-4">
                        <div class="paymentDetails">
                            @php
                            $paymentAmount = $propertyRental->property->depositAmount +
                            $propertyRental->property->rentalAmount ;
                            @endphp

                            <div class="d-flex align-items-end mt-4 mb-2">
                                <p class="h4 m-0"><span class="pe-1">ID : </span><span
                                        class="pe-1">{{$propertyRental->propertyRentalID}}</span></p>
                                <P class="ps-3 textmuted">{{$propertyRental->property->agent->agentName}}</P>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <p class="textmuted">Advance Rental </p>
                                <p class="fs-14 fw-bold"> ${{ $propertyRental->property->rentalAmount }} </p>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <p class="textmuted">Security Deposit </p>
                                <p class="fs-14 fw-bold"> ${{ $propertyRental->property->depositAmount }}
                                </p>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <p class="textmuted">Agent Fee</p>
                                <p class="fs-14 fw-bold">Free</p>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <p class="textmuted fw-bold">Total</p>
                                
                                   <span class="h4"> <span
                                        class="fas fa-dollar-sign pe-1"></span> {{ number_format($paymentAmount,2) }}</span>
                               
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-6">
                <!-- Payment Method Selection -->
                <div class="row">
                   
                        <div class="card">
                            <div class="card-header">
                                <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                                    <!-- Credit card form tabs -->
                                    <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                        <li class="nav-item"> <a data-toggle="pill" href="#credit-card"
                                                class="nav-link active "> <i class="fas fa-credit-card mr-2"></i>
                                                Credit
                                                Card
                                            </a> </li>
                                        <li class="nav-item"> <a data-toggle="pill" href="#paypal" class="nav-link "> <i
                                                    class="fab fa-paypal mr-2"></i> Paypal
                                            </a> </li>
                                        <li class="nav-item"> <a data-toggle="pill" href="#net-banking"
                                                class="nav-link ">
                                                <i class="fas fa-mobile-alt mr-2"></i> Net Banking </a>
                                        </li>
                                    </ul>
                                </div> <!-- End -->
                                <!-- Credit card form content -->
                                <div class="tab-content">
                                    <!-- credit card info-->
                                    <div id="credit-card" class="tab-pane fade show active pt-3">
                                        <form role="form" onsubmit="event.preventDefault()">
                                            <div class="form-group"> <label for="username">
                                                    <h6>Card Owner</h6>
                                                </label> <input type="text" name="username"
                                                    placeholder="Card Owner Name" required class="form-control ">
                                            </div>
                                            <div class="form-group"> <label for="cardNumber">
                                                    <h6>Card number</h6>
                                                </label>
                                                <div class="input-group"> <input type="text" name="cardNumber"
                                                        placeholder="Valid card number" class="form-control " required>
                                                    <div class="input-group-append"> <span
                                                            class="input-group-text text-muted">
                                                            <i class="fab fa-cc-visa mx-1"></i> <i
                                                                class="fab fa-cc-mastercard mx-1"></i> <i
                                                                class="fab fa-cc-amex mx-1"></i> </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <div class="form-group"> <label><span class="hidden-xs">
                                                                <h6>Expiration Date</h6>
                                                            </span></label>
                                                        <div class="input-group"> <input type="number" placeholder="MM"
                                                                name="" class="form-control" required> <input
                                                                type="number" placeholder="YY" name=""
                                                                class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group mb-4"> <label data-toggle="tooltip"
                                                            title="Three digit CV code on the back of your card">
                                                            <h6>CVV <i class="fa fa-question-circle d-inline"></i>
                                                            </h6>
                                                        </label> <input type="text" required class="form-control">
                                                    </div>
                                                </div>
                                                <!-- Top-Up Amount -->
                                                <div class="form-group">
                                                    <label for="topUpAmount">
                                                        <h6>Payment Amount (MYR)</h6>
                                                    </label>
                                                    <input type="number" class="form-control" id="topUpAmount"
                                                        value="{{ $paymentAmount }}" readonly>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <!-- <button type="button"
                                                            class="subscribe btn btn-primary btn-block shadow-sm">
                                                            Confirm
                                                            Payment
                                                        </button> -->
                                                <a href="{{route('payments.store', ['propertyRentalID' => $propertyRental->propertyRentalID])}}"
                                                    class="subscribe btn btn-primary btn-block shadow-sm">
                                                    Confirm
                                                    Payment </a>
                                        </form>
                                    </div>
                                </div> <!-- End -->
                                <!-- Paypal info -->
                                <div id="paypal" class="tab-pane fade pt-3">
                                    <!-- Top-Up Amount -->
                                    <div class="form-group">
                                        <label for="topUpAmount">
                                            <h6>Payment Amount (MYR)</h6>
                                        </label>
                                        <input type="number" class="form-control" id="topUpAmount"
                                            value="{{ $paymentAmount }}" readonly>
                                    </div>
                                    <h6 class="pb-2">Select your paypal account type</h6>
                                    <div class="form-group "> <label class="radio-inline"> <input type="radio"
                                                name="optradio" checked> Domestic </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="optradio" class="ml-5">International
                                        </label>
                                    </div>
                                    <p> <button type="button" class="btn btn-primary "><i
                                                class="fab fa-paypal mr-2"></i>
                                            Log
                                            into my Paypal</button> </p>
                                    <p class="text-muted"> Note: After clicking on the button, you will be
                                        directed to a
                                        secure
                                        gateway for payment. After completing the payment process, you will
                                        be
                                        redirected
                                        back
                                        to the website to view details of your order. </p>
                                </div> <!-- End -->
                                <!-- bank transfer info -->
                                <div id="net-banking" class="tab-pane fade pt-3">
                                    <!-- Top-Up Amount -->
                                    <div class="form-group">
                                        <label for="topUpAmount">
                                            <h6>Payment Amount (MYR)</h6>
                                        </label>
                                        <input type="number" class="form-control" id="topUpAmount"
                                            value="{{ $paymentAmount }}" readonly>
                                    </div>
                                    <div class="form-group "> <label for="Select Your Bank">
                                            <h6>Select your Bank</h6>
                                        </label> <select class="form-control" id="ccmonth">
                                            <option value="" selected disabled>--Please select your Bank--
                                            </option>
                                            <option value="ambank">AmBank</option>
                                            <option value="maybank">Maybank</option>
                                            <option value="cimb">CIMB Bank</option>
                                            <option value="publicbank">Public Bank</option>
                                            <option value="rhb">RHB Bank</option>
                                            <option value="hongleong">Hong Leong Bank</option>
                                            <option value="standardchartered">Standard Chartered Bank
                                            </option>
                                            <option value="ocbc">OCBC Bank</option>
                                            <option value="uob">United Overseas Bank (UOB)</option>
                                            <option value="hsbc">HSBC Bank</option>
                                            <option value="bankislam">Bank Islam</option>
                                            <option value="affinbank">Affin Bank</option>
                                        </select> </div>
                                    <div class="form-group">
                                        <p> <button type="button" class="btn btn-primary "><i
                                                    class="fas fa-mobile-alt mr-2"></i> Proceed
                                                Payment</button>
                                        </p>
                                    </div>
                                    <p class="text-muted">Note: After clicking on the button, you will be
                                        directed to a
                                        secure
                                        gateway for payment. After completing the payment process, you will
                                        be
                                        redirected
                                        back
                                        to the website to view details of your order. </p>
                                </div> <!-- End -->
                                <!-- End -->
                            </div>
                        </div>
                   
                </div>
            </div>
        </div>
    </div>
    </div>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="  https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>

    <script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
    </script>


</body>

</html>