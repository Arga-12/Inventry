<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;600;700&display=swap" rel="stylesheet">
    <title>Inventry</title>
    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">

    <div class="flex h-screen overflow-hidden">

        {{-- Sidebar --}}
        <x-navbar />

        {{-- Main content area --}}
        <div class="flex-1 relative flex flex-col h-screen min-w-0 bg-white overflow-y-auto">

            <x-header />

            {{-- Main content --}}
            <main class="flex-1 px-4 md:px-6 py-4 md:py-6">
                @yield('content')
            </main>

        </div>

        {{-- Keranjang sidebar (khusus peminjam) --}}
        @if (request()->routeIs('peminjam-alat'))
            <x-sidebar-keranjang />
        @endif
    </div>

    <x-pop-upsession />
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>

</html>