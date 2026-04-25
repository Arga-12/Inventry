<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	<link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;600;700&display=swap" rel="stylesheet">
	<title>Inventry</title>
</head>
<body class="bg-gray-100 text-gray-900 font-sans">

    <div class="flex h-screen overflow-hidden">

        <div class="h-screen sticky left-0 top-0 bg-[#F5F5F5] border-r border-gray-300 w-80 shrink-0 z-20">
            <x-navbar />
        </div>

        <div class="flex-1 relative flex flex-col h-screen min-w-0 bg-white">
            
            <x-header />

            <main class="flex-1 overflow-y-auto p-6 pt-20">
                @yield('content')
            </main>

        </div>

        @if (request()->routeIs('peminjam-alat'))
            <aside class="w-80 h-screen shrink-0 bg-[#F5F5F5] border-l border-gray-300 flex flex-col z-20">
                <x-card-peminjaman />
            </aside>
        @endif

    </div>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>