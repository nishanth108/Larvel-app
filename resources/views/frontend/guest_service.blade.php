@extends('frontend.guest_dashboard')
@section('guest')

    <body class="services-page">



        <main class="main">

            <!-- Page Title -->
            <div class="page-title" data-aos="fade">
                <div class="heading">
                    <div class="container">
                        <div class="row d-flex justify-content-center text-center">
                            <div class="col-lg-8">
                                <h1>Services</h1>
                                <p class="mb-0">Odio et unde deleniti. Deserunt numquam exercitationem. Officiis quo odio
                                    sint voluptas consequatur ut a odio voluptatem. Sit dolorum debitis veritatis natus
                                    dolores. Quasi ratione sint. Sit quaerat ipsum dolorem.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <nav class="breadcrumbs">
                    <div class="container">
                        <ol>
                            <li><a href="index.html">Home</a></li>
                            <li class="current">Services</li>
                        </ol>
                    </div>
                </nav>
            </div><!-- End Page Title -->

            <!-- Services Section -->
            <section id="services" class="services section">

                <div class="container">

                    <div class="row gy-4">

                        @foreach ($amenitie as $key => $item)
                            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                                <div class="service-item  position-relative">
                                    <div class="icon">
                                        <i class="bi bi-{{ $item->icon_name }}"></i>
                                    </div>
                                    <a href="{{ route('service') }}" class="stretched-link">
                                        <h3>{{ $item->amenities_name }}</h3>
                                    </a>
                                    <p>{{ $item->description }}</p>
                                </div>
                            </div><!-- End Service Item -->
                        @endforeach

                    </div>

                </div>

            </section><!-- /Services Section -->

        </main>

        <!-- Scroll Top -->
        <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
                class="bi bi-arrow-up-short"></i></a>

        <!-- Preloader -->
        <div id="preloader"></div>

        <!-- Vendor JS Files -->
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/vendor/php-email-form/validate.js"></script>
        <script src="assets/vendor/aos/aos.js"></script>
        <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
        <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>

        <!-- Main JS File -->
        <script src="assets/js/main.js"></script>

    </body>
@endsection
