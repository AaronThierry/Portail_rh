<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Portail RH</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    @yield('styles')
</head>
<body>
    <div class="dashboard-layout">
        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            @include('partials.header')

            <!-- Page Content -->
            <main class="content-wrapper">
                @yield('content')
            </main>

            <!-- Footer -->
            @include('partials.footer')
        </div>
    </div>

    <!-- Custom Scripts -->
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    @yield('scripts')
</body>
</html>
