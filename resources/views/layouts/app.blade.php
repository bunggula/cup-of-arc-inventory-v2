<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cup Of Arc | Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fcfbf9; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); }
    </style>
</head>
<body class="flex min-h-screen" x-data="{ showAdd: false }">

    @if(session('success'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 3000)"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 -translate-y-10"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-500"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-10"
             class="fixed top-5 left-0 right-0 z-[999] flex justify-center pointer-events-none">
            
            <div class="glass border border-stone-100 px-6 py-3 rounded-2xl shadow-xl flex items-center gap-3 pointer-events-auto">
                <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <p class="text-[10px] font-black uppercase tracking-widest text-stone-800">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- Ipakita lang ang sidebar kung naka-login ang staff --}}
    @auth
        @include('layouts.sidebar')
    @endauth

    <div class="flex-1 flex flex-col min-w-0">
        {{-- Ipakita lang ang header kung naka-login ang staff --}}
        @auth
            @include('layouts.header')
        @endauth

        {{-- Kapag naka-login, may padding. Kapag nasa login page, naka-center ang content --}}
        <main class="{{ Auth::check() ? 'p-4 md:p-8 pb-32 md:pb-8' : 'flex-1 flex items-center justify-center' }}">
            @yield('content')
        </main>
    </div>

</body>
</html>