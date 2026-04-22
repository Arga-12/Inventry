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

	<div class="flex h-screen">
	<x-navbar />
		<div class="flex-1 flex flex-col">
			<x-header />

			<main class="flex-1 flex justify-center p-6 overflow-y-auto">
	            <div class="w-full">
	                @yield('content')
	            </div>
        	</main>

			@if (request()->routeIs('peminjam-alat'))
				<x-card-peminjaman />
			@endif
		</div>
	</div>
	<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>