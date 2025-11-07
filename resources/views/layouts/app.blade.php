<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Portail RH</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Sidebar Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">

    @yield('styles')
</head>
<body class="h-full font-sans antialiased">
    <div class="flex h-full bg-gray-50 dark:bg-gray-900">
        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 transition-all duration-300 main-content" id="mainContent">
            <!-- Header -->
            @include('partials.header')

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
