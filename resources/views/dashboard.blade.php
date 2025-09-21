<x-app-layout>
    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="bg-white shadow rounded-lg p-4 text-center">
                <p class="text-gray-500">Jumlah Siswa</p>
                <p class="text-2xl font-bold text-indigo-600">{{ \App\Models\Student::count() }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-4 text-center">
                <p class="text-gray-500">Jumlah Guru</p>
                <p class="text-2xl font-bold text-indigo-600">{{ \App\Models\Teacher::count() }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-4 text-center">
                <p class="text-gray-500">Jumlah Kelas</p>
                <p class="text-2xl font-bold text-indigo-600">{{ \App\Models\Classroom::count() }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-4 text-center">
                <p class="text-gray-500">Catatan Pendampingan</p>
                <p class="text-2xl font-bold text-indigo-600">{{ \App\Models\Assistance::count() }}</p>
            </div>
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-bold mb-4">Aktivitas Terbaru</h2>
            <ul class="divide-y">
                @foreach(\App\Models\Assistance::latest()->take(5)->get() as $a)
                    <li class="py-2">
                        <strong>{{ $a->student->name }}</strong> - {{ $a->topic }}
                        <span class="text-gray-500 text-sm">({{ \Carbon\Carbon::parse($a->date)->format('d-m-Y') }})</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>
