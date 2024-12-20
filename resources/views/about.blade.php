@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<style>
    h2,h3 {
        font-size: 1.8rem;
        color: #444;
        border-bottom: 3px solid #ff5733;
        display: inline-block;
        padding-bottom: 5px;
    }

    .row p {
        font-size: 25px;
    }

    .row ul li {
        font-size: 20px;
    }

    @media (max-width: 768px) {
        .row p {
            font-size: 17px;
        }

        .row ul li {
            font-size: 14px;
        }
    }
</style>
<section class="about-us">
    <div class="container">
        <header class="text-center mb-5">
            <h1>About Us</h1>
        </header>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <h2>Our Commitment to Quality</h2>
                <p>
                    <strong>Swarna Metals Zambia Limited</strong> (SMZL) is a state-of-the-art greenfield hydrometallurgical copper extraction plant,
                    strategically located 25 kilometers from Kitwe, in Zambia's Copperbelt Province. As a subsidiary of PLR Zambia Limited, SMZL
                    is dedicated to producing high-quality copper cathodes and concentrates to meet the growing global demand.
                </p>
                <h3>Highlights</h3>
                <ul>
                    <li><strong>Strategic Location:</strong> Zambia’s Copperbelt Province, abundant in copper ore reserves.</li>
                    <li><strong>Capacity:</strong> Initial milling capacity of 1,200 tons/day, scaling to 2,400 tons/day.</li>
                    <li><strong>Production Targets:</strong> 12,000 metric tons of copper concentrate and 2,400 metric tons of copper cathode annually.</li>
                    <li><strong>Timeline:</strong> Commissioning in Q1 2025.</li>
                </ul>
            </div>

            <div class="col-lg-6 mb-4">
                <h2>Innovative Mining Solutions</h2>
                <p>
                    With a focus on innovation, sustainability, and operational excellence, SMZL is set to become a leader in Zambia’s copper
                    processing industry. Our vision aligns with Zambia's industrial growth, ensuring value addition at every stage of the copper value chain.
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <h3>Key Contacts</h3>
                <p><strong>Mr. Jayakumar Peddireddy</strong></p>
                <ul>
                    <li><strong>Position:</strong> CEO, Swarna Metals Zambia</li>
                    <li><strong>Address:</strong> J5, Zamsure Apartments, Lusaka, Zambia</li>
                </ul>
            </div>

            <div class="col-lg-6 mb-4">
                <h3>Group Company Information</h3>
                <p><strong>PLR Zambia Limited</strong></p>
                <p><strong> Mr. R N Niranjan Reddy</strong></p>
                <ul>
                    <li><strong>Position:</strong> CEO, PLR Zambia Ferro Alloys</li>
                    <li><strong>Address:</strong> J8, Zamsure Apartments, Lusaka, Zambia</li>
                    <li><strong>Website:</strong> <a href="https://plrprojects.com" target="_blank">plrprojects.com</a></li>
                </ul>
            </div>
        </div>

        <div class="row align-items-start">
            <div class="col-lg-6">
                <h3>Our Location</h3>
                <p>
                    Swarna Metals is located in Kitwe, Zambia, a hub for the metal and mining industries, ensuring easy access to resources and markets.
                </p>
                <p><strong>Address:</strong> Sabina Mufulira Road, Kitwe - 50100, Copperbelt, Zambia</p>
                <p><strong>Hours:</strong> 8 AM - 5 PM</p>
            </div>

            <div class="col-lg-6">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d174911.3188751776!2d28.05414839521786!3d-12.668204315985065!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x196ce3002a1d77bf%3A0xa596812ee0acff6b!2sFarm%20No%20F%2F4213%2FA%2C%20Kitwe-Mufilira%2C%20Kitwe!3m2!1d-12.6623824!2d28.155643599999998!5e0!3m2!1sen!2szm!4v1734504385088!5m2!1sen!2szm"
                    width="100%" height="350" style="border:0; border-radius: 8px;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
        </div>
    </div>
</section>
@endsection
