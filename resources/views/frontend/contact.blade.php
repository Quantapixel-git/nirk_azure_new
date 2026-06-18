@extends('frontend.layouts.app')

@section('content')

<section class="py-5 bg-light">
    <div class="container">

        <!-- Heading -->
        <div class="text-center mb-5">
            <!--<span class="badge bg-primary px-3 py-2 mb-3">Get In Touch</span>-->
            <h1 class="fw-bold mb-3">Contact Us</h1>
            <p class="text-muted mx-auto" style="max-width:700px;">
                We'd love to hear from you. Whether you have a question about our products,
                services, orders, or anything else, our team is ready to answer all your
                questions and provide the support you need.
            </p>
        </div>

        <div class="row g-4">

            <!-- Contact Information -->
            <div class="col-lg-5">

                <div class="card border-0 shadow-lg h-100 rounded-4">
                    <div class="card-body p-5">

                        <h3 class="fw-bold mb-4">
                            Contact Information
                        </h3>

                        <p class="text-muted mb-5">
                            Reach out to us through any of the following channels.
                            Our support team is available to assist you.
                        </p>

                        <!-- Address -->
                        <div class="d-flex mb-4">
                            <div class="me-3" style="margin-right:20px;">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                     style="width:55px;height:55px;">
                                    <i class="las la-map-marker-alt fs-3"></i>
                                </div>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Address</h6>
                                <p class="text-muted mb-0">
                                   Banglore,<br>
                                   Kartanaka, India
                                </p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="d-flex mb-4">
                            <div class="me-3" style="margin-right:20px;">
                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                                     style="width:55px;height:55px;">
                                    <i class="las la-phone fs-3"></i>
                                </div>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Phone</h6>
                                <p class="text-muted mb-0">
                                    +91 91827 22519
                                </p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="d-flex">
                            <div class="me-3" style="margin-right:20px;">
                                <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center"
                                     style="width:55px;height:55px;">
                                    <i class="las la-envelope fs-3"></i>
                                </div>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Email</h6>
                                <p class="text-muted mb-0">
                              official@quantapixel.in
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Contact Form -->
            <div class="col-lg-7">

                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-body p-5">

                        <h3 class="fw-bold mb-4">
                            Send Us a Message
                        </h3>

                        <form action="{{ route('contact.store') }}" method="POST">
                            @csrf

                            <div class="row">

                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-semibold">
                                        Full Name
                                    </label>
                                    <input type="text"
                                           name="name"
                                           class="form-control form-control-lg"
                                           placeholder="Enter your name"
                                           required>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-semibold">
                                        Email Address
                                    </label>
                                    <input type="email"
                                           name="email"
                                           class="form-control form-control-lg"
                                           placeholder="Enter your email"
                                           required>
                                </div>

                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Phone Number
                                </label>
                                <input type="text"
                                       name="phone"
                                       class="form-control form-control-lg"
                                       placeholder="Enter your phone number"
                                       required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Message
                                </label>
                                <textarea name="content"
                                          rows="6"
                                          class="form-control"
                                          placeholder="Write your message here..."
                                          required></textarea>
                            </div>

                            <button type="submit"
                                    class="btn btn-primary btn-lg px-5 rounded-pill">
                                <i class="las la-paper-plane me-2"></i>
                                Send Message
                            </button>

                        </form>

                    </div>
                </div>

            </div>

        </div>

    </div>
</section>

@endsection