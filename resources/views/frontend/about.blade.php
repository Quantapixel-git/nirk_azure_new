@extends('frontend.layouts.app')

@section('content')

<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-6">
                <span class="badge bg-primary mb-3 px-3 py-2">About Nirk Ecommerce</span>

                <h1 class="fw-bold mb-4">
                    Empowering Businesses Through Smart E-Commerce Solutions
                </h1>

                <p class="text-muted fs-5">
                    Nirk Ecommerce is a dedicated online marketplace offering a wide range of
                    products and tools tailored for e-commerce enthusiasts, business owners,
                    and digital creators. Our platform is designed to simplify online shopping
                    while providing access to quality products and services that support
                    business growth.
                </p>

                <p class="text-muted">
                    From business accessories and packaging solutions to software tools,
                    gadgets, and digital services, we help entrepreneurs discover everything
                    they need in one convenient place.
                </p>
            </div>

            <div class="col-lg-6 text-center">
                <img src="{{ asset('public/uploads/about.png') }}"
                     class="img-fluid rounded-4 shadow"
                     alt="About Nirk Ecommerce"
                     onerror="this.src='https://via.placeholder.com/600x450';">
            </div>

        </div>
    </div>
</section>


<!-- Mission & Vision -->

<section class="py-5">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="fw-bold">Our Vision & Mission</h2>
            <p class="text-muted">
                Building a trusted ecosystem for online sellers and growing businesses.
            </p>
        </div>

        <div class="row g-4">

            <div class="col-md-6">
                <div class="card border-0 shadow h-100">
                    <div class="card-body p-4">

                        <div class="mb-3">
                            <i class="las la-eye text-primary" style="font-size:50px;"></i>
                        </div>

                        <h3 class="fw-bold mb-3">Our Vision</h3>

                        <p class="text-muted">
                            To become a leading e-commerce marketplace that empowers
                            entrepreneurs, small businesses, and digital creators with
                            innovative products, tools, and services that help them
                            thrive in the digital economy.
                        </p>

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow h-100">
                    <div class="card-body p-4">

                        <div class="mb-3">
                            <i class="las la-bullseye text-success" style="font-size:50px;"></i>
                        </div>

                        <h3 class="fw-bold mb-3">Our Mission</h3>

                        <p class="text-muted">
                            Our mission is to provide a seamless shopping experience,
                            reliable service, secure transactions, and carefully curated
                            products that support business growth, productivity, and
                            success in the world of online commerce.
                        </p>

                    </div>
                </div>
            </div>

        </div>

    </div>
</section>


<!-- Why Choose Us -->

<section class="py-5 bg-light">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="fw-bold">Why Choose Nirk Ecommerce?</h2>
            <p class="text-muted">
                Everything you need to power your e-commerce journey.
            </p>
        </div>

        <div class="row g-4">

            <div class="col-md-3">
                <div class="text-center p-4 bg-white rounded-4 shadow-sm h-100">
                    <i class="las la-shopping-bag text-primary mb-3" style="font-size:55px;"></i>
                    <h5 class="fw-bold">Wide Product Range</h5>
                    <p class="text-muted mb-0">
                        Curated products designed for online businesses and entrepreneurs.
                    </p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="text-center p-4 bg-white rounded-4 shadow-sm h-100">
                    <i class="las la-lock text-success mb-3" style="font-size:55px;"></i>
                    <h5 class="fw-bold">Secure Payments</h5>
                    <p class="text-muted mb-0">
                        Safe and reliable payment methods for worry-free transactions.
                    </p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="text-center p-4 bg-white rounded-4 shadow-sm h-100">
                    <i class="las la-shipping-fast text-warning mb-3" style="font-size:55px;"></i>
                    <h5 class="fw-bold">Fast Service</h5>
                    <p class="text-muted mb-0">
                        Quick order processing and dependable customer support.
                    </p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="text-center p-4 bg-white rounded-4 shadow-sm h-100">
                    <i class="las la-chart-line text-danger mb-3" style="font-size:55px;"></i>
                    <h5 class="fw-bold">Business Growth</h5>
                    <p class="text-muted mb-0">
                        Products and solutions designed to help your business scale.
                    </p>
                </div>
            </div>

        </div>

    </div>
</section>


<!-- Contact Section -->

<section class="py-5">
    <div class="container">

        <div class="row align-items-center">

            <div class="col-lg-6">
                <h2 class="fw-bold mb-4">Get In Touch</h2>

                <p class="text-muted">
                    Have questions or need assistance? Our team is always ready to help.
                    Reach out to us and we'll be happy to assist you.
                </p>

                <div class="mt-4">

                    <p>
                        <i class="las la-envelope text-primary me-2"></i>
                        info@nirk.in
                    </p>

                    <p>
                        <i class="las la-phone text-primary me-2"></i>
                        +91 XXXXX XXXXX
                    </p>

                    <p>
                        <i class="las la-map-marker text-primary me-2"></i>
                        India
                    </p>

                </div>
            </div>

            <div class="col-lg-6">
                <div class="bg-primary text-white p-5 rounded-4 shadow">
                    <h3 class="fw-bold">Nirk Ecommerce</h3>

                    <p class="mb-0">
                        Making e-commerce simpler, smarter, and more accessible for
                        entrepreneurs, businesses, and creators worldwide.
                    </p>
                </div>
            </div>

        </div>

    </div>
</section>

@endsection