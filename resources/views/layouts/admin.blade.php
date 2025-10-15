<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | Mentari</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- 🔹 Navbar -->
    <nav class="bg-indigo-700 text-white px-6 py-3 flex justify-between items-center shadow">
        <h1 class="font-bold text-lg">🌞 Mentari - Admin Panel</h1>
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>
            <a href="{{ route('admin.teachers.index') }}" class="hover:underline">Guru</a>
            <a href="{{ route('admin.students.index') }}" class="hover:underline">Siswa</a>
            <a href="{{ route('admin.classrooms.index') }}" class="hover:underline">Kelas</a>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="hover:underline text-red-300">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
    </nav>

    <!-- 🔹 Main Content -->
    <main class="p-6">
        @yield('content')
    </main>

    <!-- 🔹 Footer -->
    <footer class="text-center text-sm text-gray-500 py-4">
        &copy; {{ date('Y') }} Mentari App — SMKN 2 Bangkalan
    </footer>

</body>
</html>
