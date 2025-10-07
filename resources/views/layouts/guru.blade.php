<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mentari - Guru</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white border-b shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <!-- Kiri -->
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo-mentari.png') }}" alt="Mentari" class="h-8 w-8">
                <span class="font-semibold text-lg text-indigo-700">Catatan Pendampingan</span>
            </div>

            <!-- Kanan -->
            <div class="flex items-center gap-3 text-sm">
                <span class="hidden sm:inline text-gray-700 font-medium">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Konten -->
    <main class="max-w-6xl mx-auto p-4 sm:p-6">
        @yield('content')
    </main>

</body>
</html>
