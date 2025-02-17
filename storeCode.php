<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Payslip</title>
    <style>
        body {
            font-family: sans-serif;
        }

        .payslip {
            padding: 20px;
            margin: 20px auto;
            max-width: 700px;
        }

        .center-text {
            text-align: center;
        }

        .logo {
            display: block;
            margin: 0 auto;
            max-width: 60px;
            height: auto;
        }

        .company-header {
            text-align: center;
            margin-bottom: 15px;
        }

        .company-header h1 {
            margin: 0;
            color: #510404;
            font-size: 20px;
            font-weight: bold;
        }

        .payslip table {
            width: 100%;
            /* border: 1px solid black; */
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .payslip th, .payslip td {
            padding: 2px;
            border: 1px solid black;
            text-align: left;
        }

        .payslip .bold {
            font-weight: bold;
        }

        .payslip .right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="payslip">
        <div class="center-text">
            <img src="{{ public_path('images/logo_circle.jpg') }}" alt="Swarna Metals Logo" class="logo">
        </div>

        <div class="company-header">
            <h1>SWARNA METALS ZAMBIA LIMITED</h1>
        </div>

        <div class="title">
            <p><strong>Pay Slip</strong></p>
            <p><strong>Date Issued:</strong> {{ now()->format('d-m-Y') }}</p>
        </div>

        <table class="table">
            <tr>
                <th>Employee Name:</th>
                <td>{{ $employee->name }}</td>
                <th>Employee ID:</th>
                <td>{{ $employee->id_number }}</td>
            </tr>
            <tr>
                <th>Designation:</th>
                <td>{{ $employee->position }}</td>
                <th>Department/Team:</th>
                <td>{{ $employee->team }}</td>
            </tr>
            <tr>
                <th>Pay Period:</th>
                <td colspan="3">{{ now()->format('F Y') }}</td>
            </tr>
        </table>

        <table class="table">
            <thead>
                <tr>
                    <th>Component</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Basic Salary (Monthly)</td>
                    <td>{{ $basicPay = number_format((float) $employee->basic_salary, 2) }} ZMW</td>
                </tr>
                <tr>
                    <td> <strong>Allowances (Monthly)</strong></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Housing Allowance (30%)</td>
                    <td>{{ $hra = number_format((float) $employee->basic_salary*0.3, 2) }} ZMW</td>
                </tr>
                <tr>
                    <td>Transportation Allowance </td>
                    <td>{{ $conveyance = number_format((float) $employee->transport_allowance, 2) }} ZMW</td>
                </tr>
                <tr>
                    <td>Lunch Allowance </td>
                    <td>{{ $lunch_allowance = number_format((float) $employee->lunch_allowance , 2) }} ZMW</td>
                </tr>
                <tr>
                    <td>Other Allowances</td>
                    <td>{{ $otherAllowances = number_format((float) $employee->other_allowances, 2) }} ZMW</td>
                </tr>
                <?php
                    $grossEarnings = (float) $employee->basic_salary + (float) $employee->housing_allowance + (float) $employee->transport_allowance + (float) $employee->other_allowances + (float) $employee->lunch_allowance;
                    $totalDeductions = (float) $employee->pf + (float) $employee->tax + (float) $employee->loan_recovery + (float) $employee->other_deductions;

                    $netPay = $grossEarnings - $totalDeductions;

                    $formattedGrossEarnings = number_format($grossEarnings, 2);
                    $formattedTotalDeductions = number_format($totalDeductions, 2);
                    $formattedNetPay = number_format($netPay, 2);
                    $formattedAnnualGrossSalary = number_format($grossEarnings * 12, 2);
                    $napsa = number_format($grossEarnings * 0.05, 2);

                    if ($grossEarnings > 9200) {
                        $zra = number_format((5100 * 0) + (2000 * 0.2) + (2100 * 0.3) + (($grossEarnings - 9200) * 0.37), 2);
                    } elseif ($grossEarnings > 7100) {
                        $zra = number_format((5100 * 0) + (2000 * 0.2) + (($grossEarnings - 7100) * 0.3), 2);
                    } elseif ($grossEarnings > 5100) {
                        $zra = number_format((5100 * 0) + (($grossEarnings - 5100) * 0.2), 2);
                    } else {
                        $zra = number_format(0, 2);
                    }

                    $nhima = number_format( $employee->basic_salary * 0.01, 2);
                ?>
                <tr>
                    <th><strong>Monthly Gross Salary</strong></th>
                    <th>{{ $formattedGrossEarnings }} ZMW</th>
                </tr>

                <tr>
                    <td><strong>Deductions (Standard)</strong></td>
                    <td></td>
                </tr>

                <tr>
                    <td>NAPSA (5% on Gross)</td>
                    <td>{{ $napsa }} ZMW</td>
                </tr>

                <tr>
                    <td>PAYE (as per ZRA norms)</td>
                    <td>{{ $zra }} ZMW</td>
                </tr>

                <tr>
                    <td>Loan Recovery</td>
                    <td>{{ number_format((float) $employee->loan_recovery, 2) }} ZMW</td>
                </tr>

                <tr>
                    <td>NHIMA (1% on Basic)</td>
                    <td>{{$nhima }} ZMW</td>
                </tr>

                <tr>
                    <th><strong>Net Salary (Monthly Credited)</strong></th>
                    <th>{{ $formattedNetPay }} ZMW</th>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>


<div class="auth-buttons">
    @if(Auth::check())
        <a href="{{ route('users.logout') }}" class="btn btn-logout">Logout</a>
    @else
        <a href="{{ route('users.login') }}" class="btn btn-login">Login</a>
    @endif
</div>


<header class="main-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <!-- Logo -->
            <div class="header-logo d-flex align-items-center">
                <img src="{{ asset('images/logo_circle.jpg') }}" alt="Swarna Metals Logo" class="logo" style="width: 80px; height: auto; margin-right: 10px;">
            </div>
            <!-- Navbar Toggle (for smaller screens) -->
            <button class="navbar-toggler d-md-none" type="button" onclick="toggleMenu()">
                <span class="navbar-toggler-icon">&#9776;</span>
            </button>
            <nav id="navbarNav" class="nav-collapse d-md-block">
            <ul class="nav-links">
                <li><a href="/">Home</a></li>
                <li><a href="/about">About</a></li>
                <li><a href="/products-and-services">Products and Services</a></li>
                <li><a href="/jobs">Jobs</a></li>
                <li><a href="/about-plr-zambia">About PLR Zambia</a></li>
            </ul>
        </nav>
        </div>

        <!-- Navigation Links -->

    </div>
</header>


@extends('layouts.app')

@section('title', 'About PLR Zambia')

@section('content')
<style>
    table {
    width: 90%;
    margin-bottom: 30px;
    border-collapse: collapse;
    font-family: Arial, sans-serif;
    font-size: 18px;
    color: #333;
    }
    th {
    padding: 12px;
    text-align: left;
    border-bottom: 2px solid #444;
    background-color: #f4f4f4;
    }
    td {
    padding: 10px 15px;
    border-bottom: 1px solid #ddd;
    }
    tr:hover {
    background-color: #f9f9f9;
    }
    caption {
    font-size: 22px;
    font-weight: bold;
    margin-bottom: 15px;
    }
    .grade-header {
    font-weight: bold;
    background-color: #f2f2f2;
    }
    @media screen and (max-width: 768px) {
    table {
        font-size: 14px;
    }
    th, td {
        padding: 8px;
    }
    caption {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 5px;
        }
    }
</style>
<div class="container">
    <h1>About PLR Zambia</h1>

    <section>
        <h2>PLR Projects' Journey into Zambia</h2>
        <p>
            In 2011, M/S PLR conducted surveys in Tanzania and Zambia to identify investment opportunities in mining and allied industries.
            This initiative led to the incorporation of PLR Projects Zambia Limited, marking the company’s entry into Zambia’s mining sector.
            The initial focus was on establishing a ferroalloy business, which laid the foundation for the company’s growth.
        </p>
    </section>

    <section>
        <h2>Strategic Location and Logistics</h2>
        <p>
            Zambia, located in southern-central Africa, shares borders with Tanzania, the Democratic Republic of the Congo, Angola, Zimbabwe, Malawi, Namibia, and Mozambique.
            The nearest port facility is Dar es Salaam in Tanzania, approximately 1,900 kilometers by road from Mansa in Zambia’s Luapula Province, where the mining site is situated.
            The capital city, Lusaka, is about 800 kilometers from Mansa, with Serenje located along the route.
        </p>
    </section>

    <section>
        <h2>Ferro Alloy Plant</h2>
        <p>
            PLR Projects Zambia Limited planned to establish a Ferro Alloy Plant with an initial capacity of <strong>2 x 9 MVA</strong>, expandable up to <strong>54 MVA</strong>, in Serenje, Central Province.
            Land for the plant was acquired in Pensulo village, approximately 440 kilometers from Lusaka.
            Key raw materials such as manganese, quartz, dolomite, and coal are locally available, while coke is imported from neighboring Zimbabwe.
        </p>
        <p>
            The first phase of the <strong>9 MVA</strong> PLR Ferro Alloy Plant was completed, and commercial production began in May 2017.
            The plant is designed to produce ferro silicon, ferro manganese, and silico manganese. Initially, production focused on silico manganese.
            The product is exported to markets including Dubai, Japan, South Africa, Kenya, and Tanzania.
        </p>
        <p>
            Construction of the second phase of the Ferro Alloy Plant, with an additional <strong> 10 MVA </strong> capacity, was initiated and was expected to commence commercial production during 2019.
            This expansion underscores PLR Projects’ commitment to strengthening its presence in Zambia’s mining and industrial sectors.
        </p>
    </section>

    <section>
        <h2>Silico Manganese Specifications</h2>
        <p>
            Silico Manganese (SiMn) is a vital alloy used in steelmaking and foundry industries, offering strength, durability, and improved wear resistance.
            Below are the specifications of our standard grades to help meet your industrial requirements.
        </p>
    </section>
    <h4 style="text-align:center;">Standard Grades</h4>
    <section>
        <table>
            <thead>
            <tr>
                <th>Specification</th>
                <th>Details</th>
            </tr>
            </thead>
            <tbody>
            <tr class="grade-header">
                <td colspan="2">Grade: SiMn 60/14</td>
            </tr>
            <tr>
                <td>Manganese (Mn)</td>
                <td>60% minimum</td>
            </tr>
            <tr>
                <td>Silicon (Si)</td>
                <td>14% minimum</td>
            </tr>
            <tr>
                <td>Carbon (C)</td>
                <td>2.0% maximum</td>
            </tr>
            <tr>
                <td>Phosphorus (P)</td>
                <td>0.3% maximum</td>
            </tr>
            <tr>
                <td>Sulfur (S)</td>
                <td>0.03% maximum</td>
            </tr>

            <tr class="grade-header">
                <td colspan="2">Grade: SiMn 65/17</td>
            </tr>
            <tr>
                <td>Manganese (Mn)</td>
                <td>65% minimum</td>
            </tr>
            <tr>
                <td>Silicon (Si)</td>
                <td>17% minimum</td>
            </tr>
            <tr>
                <td>Carbon (C)</td>
                <td>2.0% maximum</td>
            </tr>
            <tr>
                <td>Phosphorus (P)</td>
                <td>0.3% maximum</td>
            </tr>
            <tr>
                <td>Sulfur (S)</td>
                <td>0.03% maximum</td>
            </tr>

            <tr class="grade-header">
                <td colspan="2">Grade: SiMn 68/18</td>
            </tr>
            <tr>
                <td>Manganese (Mn)</td>
                <td>68% minimum</td>
            </tr>
            <tr>
                <td>Silicon (Si)</td>
                <td>18% minimum</td>
            </tr>
            <tr>
                <td>Carbon (C)</td>
                <td>2.0% maximum</td>
            </tr>
            <tr>
                <td>Phosphorus (P)</td>
                <td>0.3% maximum</td>
            </tr>
            <tr>
                <td>Sulfur (S)</td>
                <td>0.03% maximum</td>
            </tr>
            </tbody>
        </table>
    </section>
    <h4 style="text-align:center;">Balance: Iron (Fe)</h4>
    <section>
        <table>
        <thead>
            <tr>
            <th colspan="2">Physical Properties</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <td>Appearance</td>
            <td>Metallic lumps with a steel-gray color</td>
            </tr>
            <tr>
            <td>Density</td>
            <td>~6.1 g/cm³</td>
            </tr>
            <tr>
            <td>Melting Range</td>
            <td>1060°C to 1350°C</td>
            </tr>
        </tbody>
        </table>

        <h2>Applications</h2>
        <h2>Silico Manganese is essential For</h2>
        <p><strong>1. Steel Making</strong></p>
        <ul>
            <li>Acts as a deoxidizer to remove oxygen impurities, producing cleaner, stronger steel.</li>
            <li>Serves as an alloying agent to enhance strength, hardness, and wear resistance.</li>
        </ul>

        <p><strong>2. Foundry Applications:</strong></p>
        <ul>
            <li>Improves elasticity, magnetic properties, and thermal resistance of metal castings.</li>
        </ul>
    </section>

    <section>
        <h2>Copper Business</h2>
        <p>
            In 2022, PLR Projects expanded its operations by establishing a new copper business under its subsidiary, Swarna Metals Zambia Limited (SMZL).
            Located on Sabina Mufulira Road, approximately 25 kilometers from Kitwe in Zambia’s Copperbelt Province, SMZL is a state-of-the-art greenfield hydrometallurgical copper extraction plant.
            The facility is designed to produce high-quality copper cathodes and copper concentrates, catering to the increasing demand in the global copper market.
        </p>
    </section>

    <section>
        <h2>Commitment to Zambia's Growth and Sustainability</h2>
        <p>
            SMZL integrates cutting-edge technology, sustainability, and operational excellence, positioning itself as a key player in Zambia’s copper processing industry.
            With a milling capacity of <strong>1,200 tons per day</strong>, expandable to <strong>2,400 tons per day</strong>, the plant reflects PLR’s commitment to value addition across the copper value chain.
            The vision of SMZL aligns with Zambia’s industrial growth strategy, fostering innovation and sustainable development in the Copperbelt Province.
        </p>
        <p>
            By diversifying its portfolio, PLR Projects has reinforced its role as a significant contributor to Zambia’s industrial and economic progress.
        </p>
    </section>

    <section>
        <h2>Why Choose Us</h2>
        <ul>
            <li><strong>Consistent Quality:</strong> We adhere to strict quality standards to ensure high-grade alloys.</li>
            <li><strong>Customized Solutions:</strong> Tailored specifications available to meet unique industrial needs.</li>
            <li><strong>Reliable Supply:</strong> Efficient production and logistics ensure timely delivery.</li>
        </ul>
        <p style="font-style: italic;">
            "Contact us today to learn more about our products and how they can support your operations."
        </p>
    </section>
</div>
@endsection


@extends('layouts.app')

@section('title', 'Products and Services')

@section('content')
<style>
    .gallery-img {
        width: 100%;
        height: 500px;
        /* aspect-ratio: 1 / 2; */
        border-radius: 10px;
        object-fit: cover;
    }

    .images-section .row {
        display: flex;
        justify-content: space-between;
    }
</style>

<section class="products-services mt-5">
    <div class="container">
        <h1 class="text-center">Our Products and Services</h1>
        <div class="content">
            <h2>Copper Cathodes</h2>
            <ul>
                <li><strong>Description:</strong> High-purity cathodes with 99.99% Cu content, suitable for industrial applications.</li>
                <li><strong>Applications:</strong> Electrical manufacturing, construction, and industrial machinery.</li>
                <li><strong>Key Features:</strong> Precision-crafted using advanced hydrometallurgical techniques.</li>
            </ul>

            <h2>Copper Concentrates</h2>
            <ul>
                <li><strong>Description:</strong> Premium-grade concentrates with 25% copper content, ideal for smelting and refining processes.</li>
                <li><strong>Applications:</strong> Base material for high-value copper products.</li>
                <li><strong>Key Features:</strong> Sustainably sourced from sulphide ores.</li>
            </ul>

            <h2>Future Goals</h2>
            <ul>
                <li>Expand milling capacity to 2,400 TPD by 2026.</li>
                <li>Establish global partnerships for copper exports.</li>
                <li>Contribute significantly to Zambia’s industrial growth through innovation and sustainability.</li>
            </ul>
        </div>

        <div class="images-section">
            <div class="row text-center">
                <div class="col-md-3">
                    <img src="{{ asset('images/cathode.jpeg') }}" alt="Image 1" class="img-fluid gallery-img">
                </div>
                <div class="col-md-3">
                    <img src="{{ asset('images/IMG-20241209-WA0101.jpg') }}" alt="Image 2" class="img-fluid gallery-img">
                </div>
                <div class="col-md-3">
                    <img src="{{ asset('images/1733738279178.png') }}" alt="Image 3" class="img-fluid gallery-img">
                </div>
                <div class="col-md-3">
                    <img src="{{ asset('images/IMG-20241209-WA0108_cropped.jpg') }}" alt="Image 4" class="img-fluid gallery-img">
                </div>
            </div>
        </div>
    </div>
</section>

@endsection


@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<section class="about-us">
    <div class="container">
        <div class="row">
            <!-- Left Column -->
            <h1 style="text-align: center; margin-bottom:10px;">About Us</h1>
            <div class="col-md-6">
                <h2>Our Commitment to Quality</h2>
                <p>
                    <strong>Swarna Metals Zambia Limited</strong> (SMZL) is a state-of-the-art greenfield hydrometallurgical
                    copper extraction plant, strategically located 25 kilometers from Kitwe, in Zambia's Copperbelt Province.
                    As a subsidiary of PLR Zambia Limited, SMZL is dedicated to producing high-quality copper cathodes
                    and copper concentrates to meet the growing demand in the global copper market.
                </p>
                <h3>Key Highlights</h3>
                <h4>Strategic Location</h4>
                <p>SMZL is located in Zambia’s Copperbelt Province, a region abundant in copper ore reserves, facilitating efficient operations and logistics.</p>
                <h4>Initial Milling Capacity</h4>
                <p>The plant has a starting capacity of 1,200 tons per day (TPD), with plans to expand to 2,400 TPD in the near future.</p>
                <h4>Production Targets (Phase 1)</h4>
                <ul>
                    <li><strong>Copper Concentrate:</strong> 12,000 metric tons annually.</li>
                    <li><strong>Copper Cathode:</strong> 2,400 metric tons annually with a purity of 99.99%.</li>
                </ul>
                <h4>Timeline</h4>
                <p>Commissioning is scheduled for Q1 2025, initiating full-scale production and positioning SMZL as a key contributor to Zambia's industrial advancement.</p>

                <h3>Key Contacts</h3>
                <h4>Mr. Jayakumar Peddireddy</h4>
                <ul>
                    <li><strong>Position:</strong>CEO, Swarna Metals Zambia</li>
                    <li><strong>Physical Address:</strong> J5, Zamsure Apartments, Lusaka, Zambia</li>
                </ul>
            </div>

            <!-- Right Column -->
            <div class="col-md-6">
                <h2>Innovative Mining Solutions</h2>
                <p>
                    With a focus on innovation, sustainability, and operational excellence, SMZL is poised to become a leading player in Zambia's thriving copper processing industry. The company's vision aligns with the country's industrial growth, ensuring value addition at every stage of the copper value chain.
                </p>

                <h3>Group Company Information</h3>
                <h4>Group Company Name: PLR Zambia Limited</h4>
                <h4>Contact Details:</h4>
                <h4>Mr. R N Niranjan Reddy</h4>
                <ul>
                    <li><strong>Position:</strong> CEO, PLR Zambia Ferro Alloys</li>
                    <li><strong>Physical Address:</strong> J8, Zamsure Apartments, Lusaka, Zambia</li>
                    <li><strong>Website:</strong> <a href="https://plrprojects.com" target="_blank">plrprojects.com</a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <h1 style="text-align: left; margin-bottom:10px;">Our Location</h1>
            <div class="col-md-6">
                <p>
                    Swarna Metals is located in Kitwe, Zambia, a hub for metal and mining industries, ensuring easy access to resources and markets.
                </p>
                <h2>Address</h2>
                <p>Address Sabina Mufulira Road, Kitwe - 50100, Copperbelt, Zambia</p>
                <h3>Hours</h3>
                <p>8 AM - 5 PM</p>
            </div>

            <div class="col-md-6">
                <iframe src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d174911.3188751776!2d28.05414839521786!3d-12.668204315985065!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x196ce3002a1d77bf%3A0xa596812ee0acff6b!2sFarm%20No%20F%2F4213%2FA%2C%20Kitwe-Mufilira%2C%20Kitwe!3m2!1d-12.6623824!2d28.155643599999998!5e0!3m2!1sen!2szm!4v1734504385088!5m2!1sen!2szm" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</section>

@endsection



@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <style>
            /* Smooth fade-in and float-in animation */
    @keyframes floatIn {
        0% {
            opacity: 0;
            transform: translateY(50px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Apply animation to specific sections */
    .animate-float-in {
        animation: floatIn 1s ease-out forwards;
        opacity: 0; /* Ensures the animation starts invisible */
    }

    /* Full-width background image for hero section */
    .hero-section {
        background-image: url('{{ asset('images/home-background-image.jpg')}}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        width: 100%;
        min-height: 75vh;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        position: relative;
    }

    /* Optional: Add a dark overlay for better text visibility */
    .hero-section::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6); /* Black overlay with transparency */
        z-index: 1; /* Ensures it sits above the background */
    }

    .hero-section .container {
        position: relative;
        z-index: 2; /* Content appears above the overlay */
    }

    .gallery-img {
        width: 100%;
        height: 300px;
        border-radius: 10px;
        object-fit: cover;
    }

    .images-section .row {
        display: flex;
        justify-content: space-between;
        margin: 0px 90px
    }

    .product-info {
        padding-top: 10px;
        text-align: left;
        font-size: 0.9em;
        color: #000000;
    }

    .product-info h5 {
        font-size: 30px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .product-info p {
        margin: 5px 0;
        font-size: 17px;
    }

    .product-info p strong {
        font-weight: bold;
    }

    .our-gallery {
        padding: 40px 0;
    }

    .gallery-container .row {
        margin-bottom: 30px;
    }

    .gallery-img {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 10px;
    }

    .our-gallery h2 {
        font-size: 2em;
        font-weight: bold;
        margin-bottom: 30px;
        color: #333;
    }

    .welcome-section .row {
        align-items: start;
    }

    </style>

    <section class="hero-section">
        <div class="container animate-float-in">
            <h1 class="display-3 fw-bold">Swarna Metals</h1>
            <p class="lead">Discover our products and services today.</p>
            <a href="/about" class="btn btn-primary px-4 py-2">Explore</a>
            <div class="mt-3">
                <p>★★★★★</p>
                <p class="fw-bold">QUALITY, RELIABILITY, INNOVATION, EXCELLENCE</p>
            </div>
        </div>
    </section>

    <section class="welcome-section py-5 bg-light">
        <div class="container animate-float-in">
            <div class="row align-items-start">
                <div class="col-md-6">
                    <h1 class="fw-bold" style="font-size: 48px;">Welcome to Swarna Metals</h1>
                    <p style="font-size: 20px;">
                        Swarna Metals Zambia Limited (SMZL) is a state-of-the-art
                        <span class="fw-bold">greenfield hydrometallurgical copper extraction plant</span>,
                        strategically located 25 kilometers from Kitwe, in Zambia's Copperbelt Province.
                    </p>
                    <a href="/about" class="btn btn-primary">Learn More</a>
                </div>
                <div class="col-md-6">
                    <img src="{{ asset('images/side-image.jpg')}}" alt="Swarna Plant" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </section>

    <section style="background-color:#a8dadc;">
        <div class="images-section" style=" padding-top:40px; padding-bottom:40px;">
           <h1 class="display-3 fw-bold" style="text-align: center; margin: 30px 0px;">Our Products and Services</h1>
            <div class="row text-center">
                <div class="col-md-4">
                    <img src="{{ asset('images/cathode.jpeg') }}" alt="Copper Cathodes" class="img-fluid gallery-img">
                    <div class="product-info">
                        <h5>Copper Cathodes</h5>
                        <p><strong>Description:</strong> High-purity cathodes with 99.99% Cu content, suitable for industrial applications.</p>
                        <p><strong>Applications:</strong> Electrical manufacturing, construction, and industrial machinery.</p>
                        <p><strong>Key Features:</strong> Precision-crafted using advanced hydrometallurgical techniques.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <img src="{{ asset('images/1733738279178.png') }}" alt="Copper Concentrates" class="img-fluid gallery-img">
                    <div class="product-info">
                        <h5>Copper Concentrates</h5>
                        <p><strong>Description:</strong> Premium-grade concentrates with 25% copper content, ideal for smelting and refining processes.</p>
                        <p><strong>Applications:</strong> Base material for high-value copper products.</p>
                        <p><strong>Key Features:</strong> Sustainably sourced from sulphide ores.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <img src="{{ asset('images/IMG-20241209-WA0101.jpg') }}" alt="Future Goals" class="img-fluid gallery-img">
                    <div class="product-info">
                        <h5>Future Goals</h5>
                        <p><strong>Expansion:</strong> Expand milling capacity to 2,400 TPD by 2026.</p>
                        <p><strong>Partnerships:</strong> Establish global partnerships for copper exports.</p>
                        <p><strong>Contributions:</strong> Contribute significantly to Zambia’s industrial growth through innovation and sustainability.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="our-gallery" style="width: 80%; margin: 0 auto;">
        <h2 class="text-center">Our Gallery</h2>
        <p class="text-center">Explore our products and services.</p>
        <div class="gallery-container">
            <div class="row">
                <div class="col-md-8">
                    <img src="{{ asset('images/swarna-truck.jpeg') }}" alt="Image 1" class="img-fluid gallery-img">
                </div>
                <div class="col-md-4">
                    <img src="{{ asset('images/side-image.jpg') }}" alt="Image 2" class="img-fluid gallery-img">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset('images/1733738279178.png') }}" alt="Image 3" class="img-fluid gallery-img">
                </div>
                <div class="col-md-8">
                    <img src="{{ asset('images/IMG-20241209-WA0101.jpg') }}" alt="Image 4" class="img-fluid gallery-img">
                </div>
            </div>
        </div>
    </section>

{{-- <a class="btn btn-success mt-4" href="{{ route('applications.create')}}">Apply now</a>
<br>
<a class="btn btn-info mt-4" href="{{ route('applications.track')}}">Track your application</a> --}}
@endsection

<!-- pd template  -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Payslip</title>
<style>
    body {
        font-family: sans-serif;
        background-image: url('{{ public_path('images/logo_circle.jpg') }}');
        background-repeat: no-repeat;
        background-position: center;
        background-size: 500px;
        opacity: 1;
    }

    .payslip {
        padding: 10px;
        margin: 10px auto;
        max-width: 700px;
        background: rgba(255, 255, 255, 0.78);
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .center-text {
        text-align: center;
    }

    .logo {
        display: block;
        margin: 0 auto 10px;
        max-width: 80px;
        height: auto;
    }

    .company-header {
        text-align: center;
        margin-bottom: 15px;
    }

    .company-header h1 {
        margin: 0;
        color: #510404;
        font-size: 30px;
        font-weight: bold;
    }

    .payslip table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
    }

    .payslip th, .payslip td {
        padding: 4px;
        border: 1px solid #000000;
        font-size: 12px;
        text-align: left;
    }

    .payslip .bold {
        font-weight: bold;
    }

    .payslip .right {
        text-align: right;
    }

    .payslip p {
        font-size: 11px;
    }

    .payslip h4 {
        margin-bottom: 0px;
    }
</style>

</head>
<body>
    <div class="payslip">
        <div class="center-text">
            <img src="{{ public_path('images/logo_circle.jpg') }}" alt="Swarna Metals Logo" class="logo">
        </div>

        <div class="company-header">
            <h1>SWARNA METALS ZAMBIA LIMITED</h1>
        </div>

        <div class="title">
            <h4><strong>Pay Slip</strong></h4>
        </div>
        <table>
            <tr>
                <th>Employee Name:</th>
                <td>{{ $employee->name }}</td>
                <th>Employee ID:</th>
                <td>{{ $employee->id_number }}</td>
            </tr>
            <tr>
                <th>Designation:</th>
                <td>{{ $employee->position }}</td>
                <th>Grade:</th>
                <td>{{ $employee->grade }}</td>
            </tr>
            <tr>
                <th>Department/Team:</th>
                <td colspan="3">{{ $employee->team }}</td>
            </tr>
        </table>

        <h4>Year-to-Date Summary</h4>
        <table>
            <tr>
                <th>Gross Pay YTD:</th>
                <td>{{ number_format($payslipData['gross_pay_ytd'], 2) }} ZMW</td>
                <th>Tax (ZRA) Paid YTD:</th>
                <td>{{ number_format($payslipData['tax_paid_ytd'], 2) }} ZMW</td>
            </tr>
            <tr>
                <th>NAPSA Contribution YTD:</th>
                <td>{{ number_format($payslipData['napsa_ytd'], 2) }} ZMW</td>
                <th>Pension Contribution YTD:</th>
                <td>{{ number_format($payslipData['pension_ytd'], 2) }} ZMW</td>
            </tr>
            <tr>
                <th>Leave Balance (Days):</th>
                <td>-</td>
                <td colspan="2"></td>
            </tr>
        </table>

        <h4>Earnings</h4>
        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Shift/Hrs</th>
                    <th>Amount (ZMW)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>E01</td>
                    <td>Basic Pay</td>
                    <td></td>
                    <td>{{ $employee->basic_salary }}</td>
                </tr>
                <tr>
                    <td>E02</td>
                    <td>Housing Allowance</td>
                    <td></td>
                    <td>{{ number_format($payslipData['housing_allowance'], 2) }}</td>
                </tr>
                <tr>
                    <td>E03</td>
                    <td>Lunch Allowance</td>
                    <td></td>
                    <td>{{ number_format($payslipData['lunch_allowance'], 2) }}</td>
                </tr>
                <tr>
                    <td>E04</td>
                    <td>Transport Allowance</td>
                    <td></td>
                    <td>{{ number_format($payslipData['transport_allowance'], 2) }}</td>
                </tr>
                <tr>
                    <td>E05</td>
                    <td>Overtime Pay</td>
                    <td>{{ number_format($payslipData['overtime_hours'], 2) }}</td>
                    <td>{{ number_format($payslipData['overtime_pay'], 2) }}</td>
                </tr>
                <tr>
                    <td>E06</td>
                    <td>Other Allowances</td>
                    <td></td>
                    <td>{{ number_format($payslipData['other_allowances'], 2) }}</td>
                </tr>
                <tr>
                    <th colspan="3">Total Earnings</th>
                    <th>{{ number_format($payslipData['total_earnings'], 2) }}</th>
                </tr>
            </tbody>
        </table>

        <h4>Deductions</h4>
        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Amount (ZMW)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>D01</td>
                    <td>NAPSA Contribution</td>
                    <td>{{ number_format($payslipData['napsa'], 2) }}</td>
                </tr>
                <tr>
                    <td>D02</td>
                    <td>Health Insurance (NHIMA)</td>
                    <td>{{ number_format($payslipData['health_insurance'], 2) }}</td>
                </tr>
                <tr>
                    <td>D03</td>
                    <td>Loan Recovery</td>
                    <td>{{ number_format($payslipData['loan_recovery'], 2) }}</td>
                </tr>
                <tr>
                    <td>D04</td>
                    <td>Other Deductions</td>
                    <td>{{ number_format($payslipData['other_deductions'], 2) }}</td>
                </tr>
                <tr>
                    <td>D05</td>
                    <td>Tax Deduction (ZRA)</td>
                    <td>{{ number_format($payslipData['tax_paid_ytd'], 2) }}</td>
                </tr>
                <tr>
                    <th colspan="2">Total Deductions</th>
                    <th>{{ number_format($payslipData['total_deductions'], 2) }}</th>
                </tr>
            </tbody>
        </table>

        <p><strong>Net Pay:</strong> {{ number_format($payslipData['net_pay'], 2) }} ZMW</p>
        <p><strong>Payment Method:</strong> {{ $employee->payment_method }}</p>

        <h4>Additional Information</h4>
        <p style="display: inline-block; margin-right: 20px;">
            <strong>Social Security Number:</strong> {{ $employee->social_security_number }}
        </p>
        <p style="display: inline-block;">
            <strong>Bank Name:</strong> {{ $employee->bank_name }}
        </p>
        <p style="display: inline-block; margin-right: 20px;">
            <strong>Branch Name:</strong> {{ $employee->branch_name }}
        </p>
        <p style="display: inline-block;">
            <strong>Bank Account Number:</strong> {{ $employee->bank_account_number }}
        </p>
        <p><strong>Prepared By:</strong>............................................................................................................................   <strong>Date:</strong>.............................................</p>
    </div>
</body>
</html>
<div class="qr-code">
            <img src="{{ public_path('images/qr-code-swarna.png') }}" alt="QR Code">
        </div>


<!-- --------------------------Admin Dashboard------------------------ -->
@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
@include('partials.sidebar')
            <h2 class="mb-4 text-center">Swarna Metals Admin Dashboard</h2>
            <!-- Key Metrics -->
            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-users"></i> Active Employees
                            </h5>
                            <p class="card-text h4">{{ $employeesTotal }}</p>
                            <a href="{{ route('employees.index') }}" class="btn btn-light btn-sm">Manage Employees</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-file-alt"></i> Total Applications
                            </h5>
                            <p class="card-text h4">{{ $applicationsTotal }}</p>
                            <a href="{{ route('applications.index') }}" class="btn btn-light btn-sm">View Details</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-chart-line"></i> Production Rate
                            </h5>
                            <p class="card-text h4">85%</p>
                            <a href="{{ route('not-implemented-yet') }}" class="btn btn-light btn-sm">View Reports</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card text-white bg-danger">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-warehouse"></i> Inventory
                            </h5>
                            <p class="card-text h4">1345</p>
                            <a href="{{ route('not-implemented-yet') }}" class="btn btn-light btn-sm">Track Inventory</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Monthly Production (Tons)</h5>
                            <canvas id="productionChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Production Breakdown</h5>
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Add ChartJS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const productionCtx = document.getElementById('productionChart').getContext('2d');
    new Chart(productionCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [{
                label: 'Production (Tons)',
                data: [120, 150, 170, 130, 180, 200, 210],
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.2)',
                fill: true
            }]
        },
        options: { responsive: true }
    });

    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'pie',
        data: {
            labels: ['Copper Cathodes', 'Copper Concentrate'],
            datasets: [{
                label: 'Revenue',
                data: [60, 40],
                backgroundColor: ['#ffcd56', '#4bc0c0'],
            }]
        },
        options: { responsive: true }
    });
</script>
@endsection

<!-- -----------------------------application store method ------------------------------------------------------------ -->
public function store(Request $request) {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'phone' => 'required|string|max:20',
            'nrc_number' => 'required|string|max:20',
            'position_applied_for' => 'required|string|max:255',
            'years_of_experience' => 'required|integer|min:0',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'cover_letter' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'certificates' => 'nullable|array',
            'certificates.*' => 'file|mimes:pdf,doc,docx|max:10240',
        ]);

        try {
            $application = Application::create(
                $request->except(['certificates', 'resume_path', 'cover_letter_path'])
            );

            if ($request->hasFile('resume')) {
                $resumePath = $request->file('resume')->store('resumes', 'public');
                $application->resume_path = $resumePath;
            }

            if ($request->hasFile('cover_letter')) {
                $coverLetterPath = $request->file('cover_letter')->store('cover_letters', 'public');
                $application->cover_letter_path = $coverLetterPath;
            }

            if ($request->has('certificates')) {
                foreach ($request->file('certificates') as $file) {
                    $certificatePath = $file->store('certificates', 'public');
                    Certificate::create([
                        'application_id' => $application->id,
                        'file_path' => $certificatePath,
                    ]);
                }
            }

            $application->save();

            return redirect()->route('applications.create')->with('success', $request->first_name.' '.  $request->last_name.' '.'Your Application was submitted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'There was an error processing your application. Please try again.'])->withInput();
        }
    }


public function store(Request $request) {
    $validatedData = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|string|email',
        'phone' => 'required|string|max:20',
        'nrc_number' => 'required|string|max:20',
        'position_applied_for' => 'required|string|max:255',
        'years_of_experience' => 'required|integer|min:0',
        'resume' => 'required|file|mimes:pdf,doc,docx|max:10240',
        'cover_letter' => 'required|file|mimes:pdf,doc,docx|max:10240',
        'certificates' => 'nullable|array',
        'certificates.*' => 'file|mimes:pdf,doc,docx|max:10240',
    ]);

    try {
        // Check for duplicate applications
        $existingApplication = Application::where('first_name', $validatedData['first_name'])
            ->where('last_name', $validatedData['last_name'])
            ->where('nrc_number', $validatedData['nrc_number'])
            ->where('position_applied_for', $validatedData['position_applied_for'])
            ->first();

        if ($existingApplication) {
            return back()->withErrors([
                'warning' => 'You have already submitted an application for this position.',
            ])->withInput();
        }

        // Create a new application
        $application = Application::create(
            $request->except(['certificates', 'resume_path', 'cover_letter_path'])
        );

        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
            $application->resume_path = $resumePath;
        }

        if ($request->hasFile('cover_letter')) {
            $coverLetterPath = $request->file('cover_letter')->store('cover_letters', 'public');
            $application->cover_letter_path = $coverLetterPath;
        }

        if ($request->has('certificates')) {
            foreach ($request->file('certificates') as $file) {
                $certificatePath = $file->store('certificates', 'public');
                Certificate::create([
                    'application_id' => $application->id,
                    'file_path' => $certificatePath,
                ]);
            }
        }

        $application->save();

        return redirect()->route('applications.create')
            ->with('success', $request->first_name . ' ' . $request->last_name . ' Your application was submitted successfully.');
    } catch (\Exception $e) {
        return back()->withErrors([
            'error' => 'There was an error processing your application. Please try again.',
        ])->withInput();
    }
}
