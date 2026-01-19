<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="author" content="NobleUI">
    <meta name="keywords"
        content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <title>Admin Panel - Real estate</title>

    <!-- Fonts -->
    <link rel="preconnect" href="{{ asset('https://fonts.googleapis.com') }}">
    <link rel="preconnect" href="{{ asset('https://fonts.gstatic.com') }}" crossorigin>
    <link href="{{ asset('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap') }}"
        rel="stylesheet">
    <!-- End fonts -->

    {{-- Font awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    {{-- <!-- core:css --> --}}
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/core/core.css') }}">
    {{-- <!-- endinject --> --}}

    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/flatpickr/flatpickr.min.css') }}">
    <!-- End plugin css for this page -->

    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('backend/assets/fonts/feather-font/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <!-- endinject -->

    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/demo2/style.css') }}">
    <!-- End layout styles -->

    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.png') }}" />
    <!-- Plugin css for All types Data page -->


    {{-- Toaster css --}}
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

    @stack('style')


</head>

<body>
    <div class="main-wrapper">

        <!-- partial:partials/_sidebar.html -->
        @include('admin.body.sidebar')

        <!-- partial -->

        <div class="page-wrapper">

            <!-- partial:partials/_navbar.html -->
            @include('admin.body.header')
            <!-- partial -->

            @yield('admin')


            <!-- partial:partials/_footer.html -->
            @include('admin.body.footer')
            <!-- partial -->

        </div>
    </div>
    <script>
        window.userId = {{ auth()->id() }};
    </script>

    @vite(['resources/js/app.js'])

    <script src="{{ asset('backend/assets/vendors/core/core.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    {{-- Notification mess --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {


            // Give Vite a moment to load app.js

            window.authUserId = "{{ auth()->id() }}";
            console.log(window.authUserId);


            setTimeout(() => {
                if (!window.Echo) {
                    console.error('❌ Echo is not initialized. Check your app.js');
                    return;
                }

                if (!window.authUserId) {
                    console.error('❌ authUserId is not defined');
                    return;
                }

                console.log(`✅ Listening for notifications on User: ${window.authUserId}`);

                window.Echo
                    .private(`App.Models.User.${window.authUserId}`)
                    .listen('.contact.notification', (e) => {
                        console.log('✅ Contact event received:', e.message);

                        const badge = document.getElementById('notification-count');
                        if (badge) {
                            let count = parseInt(badge.innerText) || 0;
                            badge.innerText = count + 1;
                            badge.classList.remove('d-none');
                        }
                    });

            }, 500);

        });
    </script>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="{{ asset('backend/assets/js/code.js') }}"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;

                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;

                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;

                case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
        @endif
    </script>



    <script src="{{ asset('backend/assets/vendors/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/template.js') }}"></script>
    <script src="{{ asset('backend/assets/js/dashboard-dark.js') }}"></script>
    <script src="{{ asset('backend/assets/js/code/code.js') }}"></script>
    <script src="{{ asset('backend/assets/js/code/validate.min.js') }}"></script>

    @stack('script')
    @stack('edit.amenities.script')
    @stack('datatables')


</body>

</html>
