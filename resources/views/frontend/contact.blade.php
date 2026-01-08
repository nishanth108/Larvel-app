@extends('frontend.guest_dashboard')
@section('guest')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    <body class="contact-page">
        <main class="main">
            <!-- Page Title -->
            <div class="page-title" data-aos="fade">
                <div class="heading">
                    <div class="container">
                        <div class="row d-flex justify-content-center text-center">
                            <div class="col-lg-8">
                                <h1>Contact</h1>
                                <p class="mb-0">
                                    Odio et unde deleniti. Deserunt numquam exercitationem. Officiis
                                    quo odio sint voluptas consequatur ut a odio voluptatem. Sit
                                    dolorum debitis veritatis natus dolores. Quasi ratione sint. Sit
                                    quaerat ipsum dolorem.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <nav class="breadcrumbs">
                    <div class="container">
                        <ol>
                            <li><a href="index.html">Home</a></li>
                            <li class="current">Contact</li>
                        </ol>
                    </div>
                </nav>
            </div>
            <!-- End Page Title -->

            <!-- Contact Section -->
            <section id="contact" class="contact section">
                <div class="container" data-aos="fade-up" data-aos-delay="100">
                    <div class="mb-4" data-aos="fade-up" data-aos-delay="200">
                        <iframe style="border: 0; width: 100%; height: 270px"
                            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d48389.78314118045!2d-74.006138!3d40.710059!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a22a3bda30d%3A0xb89d1fe6bc499443!2sDowntown%20Conference%20Center!5e0!3m2!1sen!2sus!4v1676961268712!5m2!1sen!2sus"
                            frameborder="0" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <!-- End Google Maps -->

                    <div class="row gy-4">
                        <div class="col-lg-4">
                            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                                <i class="bi bi-geo-alt flex-shrink-0"></i>
                                <div>
                                    <h3>Address</h3>
                                    <p>A108 Adam Street, New York, NY 535022</p>
                                </div>
                            </div>
                            <!-- End Info Item -->

                            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                                <i class="bi bi-telephone flex-shrink-0"></i>
                                <div>
                                    <h3>Call Us</h3>
                                    <p>+1 5589 55488 55</p>
                                </div>
                            </div>
                            <!-- End Info Item -->

                            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
                                <i class="bi bi-envelope flex-shrink-0"></i>
                                <div>
                                    <h3>Email Us</h3>
                                    <p>info@example.com</p>
                                </div>
                            </div>
                            <!-- End Info Item -->
                        </div>

                        <div class="col-lg-8">

                            {{-- Form data --}}
                            <form action="{{ route('contact.store') }}" method="POST" id="myForm">
                                @csrf

                                <div class="row gy-4">

                                    <div class="col-md-6">
                                        <input type="text" name="name" class="form-control" placeholder="Your Name">
                                        <small class="text-danger error-name"></small>
                                    </div>

                                    <div class="col-md-6">
                                        <input type="email" name="email" class="form-control" placeholder="Your Email">
                                        <small class="text-danger error-email"></small>
                                    </div>

                                    <div class="col-md-12">
                                        <input type="text" name="subject" class="form-control" placeholder="Subject">
                                        <small class="text-danger error-subject"></small>
                                    </div>

                                    <div class="col-md-12">
                                        <textarea name="message" rows="6" class="form-control" placeholder="Message"></textarea>
                                        <small class="text-danger error-message"></small>
                                    </div>

                                    <div class="col-md-12 text-center">
                                        <div id="formMessage" class="mt-2"></div>
                                        <button type="submit" class="btn btn-success">Send Message</button>
                                    </div>

                                </div>
                            </form>


                        </div>
                        <!-- End Contact Form -->
                    </div>
                </div>
            </section>
            <!-- /Contact Section -->
        </main>

        <!-- Scroll Top -->
        <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
                class="bi bi-arrow-up-short"></i></a>

        <!-- Preloader -->
        <div id="preloader"></div>

        <!-- Vendor JS Files -->
        <script src="{{ asset('backend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        {{-- <script src="{{ asset('backend/assets/vendor/php-email-form/validate.js') }}"></script> --}}
        <script src="{{ asset('backend/assets/vendor/aos/aos.js') }}"></script>
        <script src="{{ asset('backend/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('backend/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <script>
            $(document).ready(function() {

                $('#myForm').on('submit', function(e) {
                    e.preventDefault();

                    let form = $(this);
                    let url = form.attr('action');
                    let submitBtn = form.find('button[type="submit"]');

                    // Clear previous messages
                    $('small.text-danger').html('');
                    $('#formMessage').html('');

                    $.ajax({
                        url: url,
                        type: "POST",
                        data: form.serialize(),

                        beforeSend: function() {
                            submitBtn.prop('disable', true);
                            submitBtn.html(`
                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                            Sending...`)
                        },

                        success: function(response) {
                            toastr.success(response.message);
                            form.trigger('reset');
                        },

                        error: function(xhr) {

                            if (xhr.status === 401) {
                                $('#formMessage').html(
                                    '<span class="text-danger">Please login to submit this form.</span>'
                                );
                                return;
                            }


                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;
                                $.each(errors, function(field, message) {
                                    $('.error-' + field).html(message[0]);
                                });
                            }
                        },
                        complete: function() {
                            submitBtn.prop('disabled', false);
                            submitBtn.html('send message')
                        }
                    });
                });

            });
        </script>


        <!-- Toastr JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>






    </body>
@endsection
