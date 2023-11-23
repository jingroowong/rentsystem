<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/sidebars/">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <style>
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }

    .adminSidebar body {
        min-height: 100vh;
        min-height: -webkit-fill-available;
    }

    html {
        height: -webkit-fill-available;
    }

    .adminSidebar {
        display: flex;
        flex-direction: column; /* Ensure a column layout */
        height: 100vh; /* Full height of the viewport */
        overflow-x: auto;
        overflow-y: hidden;
        overflow-x: hidden; /* Hide horizontal scrollbar */
    }

    .adminSidebar .flex-grow-1 {
        flex-grow: 1;
    }

    .adminSidebar .bars {
        font-size: 30px;
    }

    .nav-link.active {
        background-color: #007bff;
        color: #fff;
    }
    </style>

</head>

<body>
    <div class="adminSidebar border-right">
        <div class="d-flex flex-column bg-white py-5 my-4" style="width: 195px;">
            <div class="bars ml-3">
                <i class="las la-user-check"></i> 
                <span class="ml-3">Admin</span>
            </div>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
               
                <li class="nav-item">
                    <a href="#" class="nav-link link-dark" aria-current="page" onclick="handleNavClick(this)">
                        <i class="las la-user"></i>
                        Profile
                    </a>
                </li>
                <li>
                    <a href="{{route('properties')}}" class="nav-link link-dark" onclick="handleNavClick(this)">
                        <i class="las la-money-bill"></i>
                        Property
                    </a>
                </li>
                 <!-- Admin Only Start -->
                <li>
                    <a href="{{route('refunds')}}" class="nav-link link-dark" onclick="handleNavClick(this)">
                        <i class="las la-hand-holding-usd"></i>
                        Refund
                    </a>
                </li>
                
                <li>
                    <a href="{{route('reports')}}" class="nav-link link-dark" onclick="handleNavClick(this)">
                        <i class="las la-file-alt"></i>
                        Reports
                    </a>
                </li>

                 <!-- Admin Only End -->
                <li>
                    <a href="{{route('notifications')}}" class="nav-link link-dark" onclick="handleNavClick(this)">
                        <i class="las la-envelope-open"></i>
                        Notifications
                    </a>
                </li>

                 <!-- Agent Only Start -->
                 <li>
                    <a href="{{route('agentWallet')}}" class="nav-link link-dark" onclick="handleNavClick(this)">
                    <i class="las la-wallet"></i>
                        Wallet
                    </a>
                </li>

                <li>
                    <a href="{{route('appointments.agentIndex')}}" class="nav-link link-dark" onclick="handleNavClick(this)">
                    <i class="las la-calendar"></i>
                        Schedule
                    </a>
                </li>

                  <!-- Agent Only End -->
                <li>
                    <a href="#" class="nav-link link-dark" onclick="handleNavClick(this)">
                        <i class="las la-sign-out-alt"></i>
                        Log Out
                    </a>
                </li>
            </ul>
            <hr>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        function handleNavClick(element) {
            // Remove 'active' class from all nav links
            var navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => link.classList.add('link-dark', 'text-dark'));
            
            // Add 'active' class to the clicked link
            element.classList.remove('link-dark', 'text-dark');
            element.classList.add('active');

            // Save active link to cookie
            document.cookie = 'activeLink=' + element.textContent.trim() + '; path=/';
        }

        // Check cookie for active link on page load
        document.addEventListener('DOMContentLoaded', function() {
            var activeLink = getCookie('activeLink');
            if (activeLink) {
                var navLinks = document.querySelectorAll('.nav-link');
                navLinks.forEach(link => {
                    if (link.textContent.trim() === activeLink) {
                        link.classList.remove('link-dark', 'text-dark');
                        link.classList.add('active');
                    }
                });
            }
        });

        // Function to get cookie value by name
        function getCookie(name) {
            var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
            if (match) return match[2];
        }
    </script>
</body>

</html>
