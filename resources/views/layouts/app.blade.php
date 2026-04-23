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

	<div class="flex h-screen overflow-x-hidden">
	    <x-navbar />

	    {{-- WRAPPER UTAMA --}}
	    <div class="flex flex-1">

	        {{-- KONTEN KIRI (HEADER + MAIN) --}}
	        <div class="flex flex-col flex-1 min-w-0">
	            <x-header />

	            <main class="flex-1 p-6 overflow-y-auto">
	                @yield('content')
	            </main>
	        </div>

	        {{-- SIDEBAR KANAN --}}
	        @if (request()->routeIs('peminjam-alat'))
	            <aside class="w-80 shrink-0 border-l bg-white">
	                <x-card-peminjaman />
	            </aside>
	        @endif

	    </div>
	</div>
	<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>