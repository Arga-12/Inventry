<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;600;700&display=swap" rel="stylesheet">
    <title>Login - Inventry</title>
    <style>
        body { font-family: 'Jost', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen w-screen flex flex-col items-center justify-center gap-6 px-4 py-8">

    {{-- Logo: di luar card di mobile, di dalam card di desktop --}}
    <div class="flex items-center gap-4 md:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#363062] shrink-0" viewBox="0 0 48 48">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M5.5 5.5h7.75v7.75H5.5zm9.75 0H23v7.75h-7.75zm9.75 0h7.75v7.75H25zm9.75 0h7.75v7.75h-7.75zM5.5 15.25h7.75V23H5.5zm19.5 0h7.75V23H25zm9.75 0h7.75V23h-7.75zM5.5 25h7.75v7.75H5.5zm9.75 0H23v7.75h-7.75zM25 25h7.75v7.75H25zm9.75 0h7.75v7.75h-7.75zM5.5 34.75h7.75v7.75H5.5zm9.75 0H23v7.75h-7.75zm9.75 0h7.75v7.75H25zm9.75 0h7.75v7.75h-7.75z" stroke-width="1"/>
        </svg>
        <div class="flex flex-col">
            <h1 class="font-bold text-3xl text-[#363062] tracking-wide leading-none">Inventry</h1>
            <h2 class="text-sm font-normal text-[#4D4C7D] tracking-wide mt-0.5">Lending Platform</h2>
        </div>
    </div>

    {{-- Card --}}
    <div class="bg-white w-full max-w-5xl rounded-[20px] shadow-xl p-8 md:p-16 flex flex-col md:flex-row items-center justify-center gap-12 md:gap-24">

        {{-- Logo: hanya tampil di desktop (di dalam card) --}}
        <div class="hidden md:flex items-center gap-4 w-full md:w-1/2 justify-center md:justify-end">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-[#363062] shrink-0" viewBox="0 0 48 48">
                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M5.5 5.5h7.75v7.75H5.5zm9.75 0H23v7.75h-7.75zm9.75 0h7.75v7.75H25zm9.75 0h7.75v7.75h-7.75zM5.5 15.25h7.75V23H5.5zm19.5 0h7.75V23H25zm9.75 0h7.75V23h-7.75zM5.5 25h7.75v7.75H5.5zm9.75 0H23v7.75h-7.75zM25 25h7.75v7.75H25zm9.75 0h7.75v7.75h-7.75zM5.5 34.75h7.75v7.75H5.5zm9.75 0H23v7.75h-7.75zm9.75 0h7.75v7.75H25zm9.75 0h7.75v7.75h-7.75z" stroke-width="1"/>
            </svg>
            <div class="flex flex-col">
                <h1 class="font-bold text-5xl text-[#363062] tracking-wide mb-1">Inventry</h1>
                <h2 class="text-lg font-normal text-[#4D4C7D] tracking-wide">Lending Platform</h2>
            </div>
        </div>

        <div class="w-full md:w-1/2 max-w-sm flex flex-col justify-center">
            
            <div class="text-center mb-8">
                <h2 class="text-4xl font-bold text-[#363062] mb-2">Login</h2>
                <p class="text-[#4D4C7D]">Selamat datang kembali!</p>
            </div>

            @if($errors->any())
                <div class="bg-red-100 text-red-600 p-3 rounded-xl mb-4 text-sm text-center">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="/login" method="POST" class="flex flex-col gap-5">
                @csrf <div>
                    <label for="login_user" class="block text-sm font-semibold text-[#363062] mb-2">Email / Username</label>
                    <input type="text" name="login_user" id="login_user" value="{{ old('login_user') }}" 
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-[#363062] focus:ring-1 focus:ring-[#363062] transition" required>
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-[#363062] mb-2">Password</label>
                    <input type="password" name="password" id="password" 
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-[#363062] focus:ring-1 focus:ring-[#363062] transition" required>
                </div>

                <hr class="border-t-2 border-gray-200 my-2">

                <button type="submit" class="w-full py-3 bg-transparent border-2 border-[#363062] text-[#363062] font-bold text-lg rounded-xl hover:bg-[#363062] hover:text-white transition-all duration-300">
                    Login
                </button>
            </form>

        </div>

    </div>

</body>
</html>