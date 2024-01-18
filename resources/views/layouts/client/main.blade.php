<!DOCTYPE html>
<html class="no-js" lang="">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>SaaSpal - SaaS and Software Landing Page Template</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      rel="shortcut icon"
      type="image/x-icon"
      href="{{ asset('home/assets/img/favicon.png') }}"
    />
    @include('layouts.client.style')
    <style>
        .swal2-container {
            z-index: 9999;
        }
        </style>
        @stack('style')
        <!-- SweetAlert 2 CSS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @stack('scripts')
  </head>
  <body>

    <!-- ======== header start ======== -->
    @include('layouts.client.navbar')
    <!-- ======== header end ======== -->

    @yield('content')

    <!-- ======== footer start ======== -->
    @include('layouts.client.footer')
    <!-- ======== footer end ======== -->

    @if (Session::has('success_message_logout'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        Toast.fire({
            icon: 'success',
            title: '{{ Session::get('success_message_logout') }}'
        });
    </script>
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            Toast.fire({
                icon: 'error',
                title: 'Error!',
                html: '{{ $error }}'
            });
        </script>
    @endforeach
@endif
@include('layouts.client.script')
@stack('script')
  </body>
</html>
