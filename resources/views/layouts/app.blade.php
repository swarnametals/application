<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{ asset('images/logo_circle.jpg') }}" type="image/x-icon">
  <title>@yield('title', 'Swarna Metals Zambia Limited (SMZL)')</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css')">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<style>
    body, html {
        height: 100%;
        margin: 0;
        padding-top: 55px;
    }

    /* body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    } */

    .main-header {
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 1000;
    }

    .main-header nav {
        background-color: rgb(255, 255, 255);
        color: rgb(1, 1, 1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 50px;
    }

    .logo {
        font-size: 1.5rem;
    }

    .main-header ul {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .main-header ul li {
        margin-right: 20px;
    }

    .main-header ul li a {
        color: rgb(0, 0, 0);
        text-decoration: none;
        transition: color 0.3s;
        /* font-weight: bold; */
        font-size: 20px;
    }

    .main-header ul li a:hover {
        color: #510404;
        text-decoration: underline;
    }

    .main-header .checkbtn {
        font-size: 30px;
        color: #510404;
        cursor: pointer;
        display: none;
    }

    #check {
        display: none;
    }

    @media (max-width: 768px) {
        .main-header .nav {
            padding: 10px 0px;
        }

        .main-header .checkbtn {
            display: block;
            order: 1;
            margin-right: 20px;
        }

        .main-header ul {
            position: fixed;
            top: 80px;
            right: -100%;
            background-color: rgb(255, 255, 255);
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: all 0.3s;
        }

        .main-header ul li {
        margin: 20px 0;
        }

        .main-header ul li a {
        font-size: 20px;
        }

        #check:checked ~ ul {
        right: 0;
        }
    }

    /* style for footer  */
    .main-footer {
        background-color: #003366; /* Dark blue background */
        color: white; /* White text color */
        margin-top: 40px;
        padding: 30px 0; /* Increased padding for better spacing */
        width: 100%;
    }

    .main-footer h5 {
        font-size: 25px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #ffffff;
    }

    .footer-link {
        color: #ffffff; /* White links */
        text-decoration: none; /* Remove underline */
        transition: color 0.3s ease;
        display: flex; /* Align icon and text */
        align-items: center;
        gap: 8px; /* Spacing between icon and text */
    }

    .footer-link:hover {
        color: #f1c40f; /* Gold on hover */
    }

    .main-footer p, .main-footer ul {
        margin: 0;
        padding: 0;
        line-height: 1.6;
    }

    .main-footer ul {
        list-style: none; /* Remove bullet points */
        padding-left: 0;
    }

    .main-footer .text-center {
        font-size: 14px;
        margin-top: 20px;
        color: #ffffff; /* Slightly lighter text for copyright */
    }

    .main-footer i {
        font-size: 16px; /* Adjust icon size */
        margin-right: 8px; /* Add space between icon and text */
        color: #ffffff; /* Gold icon color for better visibility */
    }

</style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">

  @include('layouts.header')
{{-- <div class="container mt-5"> --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')
{{-- </div> --}}

  @include('layouts.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleMenu() {
        const nav = document.getElementById('navbarNav');
        nav.classList.toggle('show');
    }
</script>

</body>
</html>




