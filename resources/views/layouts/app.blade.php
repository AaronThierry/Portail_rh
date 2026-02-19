<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Portail RH+</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/logo.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Sidebar Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}?v={{ time() }}">

    <!-- Modal Premium CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/modal.css') }}?v={{ time() }}">

    @yield('styles')
</head>
<body class="h-full font-sans antialiased">
    <div class="app-layout bg-gray-50 dark:bg-gray-900">
        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Header -->
        @include('partials.header')

        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            <!-- Page Content -->
            <main class="app-main">
                <div class="main-container">
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            @include('partials.footer')
        </div>
    </div>

    @yield('scripts')
</body>
</html>
