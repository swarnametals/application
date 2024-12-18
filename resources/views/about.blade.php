@extends('layouts.app')

@section('title', 'About Us')

@section('content')

<style>
    .about-us h1, .about-us h2, .about-us h3, .about-us h4 {
        font-family: 'Arial', sans-serif;
        font-weight: bold;
    }

    .about-us p {
        line-height: 1.8;
        font-size: 16px;
    }

    .about-us ul {
        padding-left: 20px;
        list-style: disc;
    }

    .about-us ul li {
        margin-bottom: 5px;
    }

    @media (max-width: 768px) {
        iframe {
            height: 300px;
        }

        .about-us h1 {
            font-size: 24px;
        }

        .about-us h2, .about-us h3, .about-us h4 {
            font-size: 20px;
        }

        .about-us p, .about-us ul li {
            font-size: 14px;
        }
    }
</style>
<section class="about-us">
    <div class="container">
        <div class="row">
            <!-- Left Column -->
            <h1 class="text-center mb-4">About Us</h1>
            <div class="col-md-6 mb-4">
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
                    <li><strong>Position:</strong> CEO, Swarna Metals Zambia</li>
                    <li><strong>Physical Address:</strong> J5, Zamsure Apartments, Lusaka, Zambia</li>
                </ul>
            </div>

            <!-- Right Column -->
            <div class="col-md-6 mb-4">
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
            <h1 class="text-left mb-3">Our Location</h1>
            <div class="col-md-6">
                <p>
                    Swarna Metals is located in Kitwe, Zambia, a hub for metal and mining industries, ensuring easy access to resources and markets.
                </p>
                <h2>Address</h2>
                <p>Sabina Mufulira Road, Kitwe - 50100, Copperbelt, Zambia</p>
                <h3>Hours</h3>
                <p>8 AM - 5 PM</p>
            </div>

            <div class="col-md-6">
                <iframe src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d174911.3188751776!2d28.05414839521786!3d-12.668204315985065!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x196ce3002a1d77bf%3A0xa596812ee0acff6b!2sFarm%20No%20F%2F4213%2FA%2C%20Kitwe-Mufilira%2C%20Kitwe!3m2!1d-12.6623824!2d28.155643599999998!5e0!3m2!1sen!2szm!4v1734504385088!5m2!1sen!2szm"
                    width="100%" height="450" style="border:0; border-radius: 8px;"
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</section>
@endsection
