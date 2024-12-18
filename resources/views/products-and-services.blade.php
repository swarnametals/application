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
        </div>

        <section class="future-goals">
            <h2>Future Goals</h2>
            <ul>
                <li>Expand milling capacity to 2,400 TPD by 2026.</li>
                <li>Establish global partnerships for copper exports.</li>
                <li>Contribute significantly to Zambia’s industrial growth through innovation and sustainability.</li>
            </ul>
        </section>

        <div class="images-section mt-5">
            <div class="row row-cols-1 row-cols-md-4 g-4 text-center">
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
