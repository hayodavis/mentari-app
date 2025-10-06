<x-app-layout>
    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="bg-white shadow rounded-lg p-4 text-center">
                <p class="text-gray-500">Jumlah Siswa</p>
                <p class="text-2xl font-bold text-indigo-600">{{ $totalStudents ?? 0 }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-4 text-center">
                <p class="text-gray-500">Jumlah Guru</p>
                <p class="text-2xl font-bold text-indigo-600">{{ $totalTeachers ?? 0 }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-4 text-center">
                <p class="text-gray-500">Jumlah Kelas</p>
                <p class="text-2xl font-bold text-indigo-600">{{ $totalClassrooms ?? 0 }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-4 text-center">
                <p class="text-gray-500">Catatan Pendampingan</p>
                <p class="text-2xl font-bold text-indigo-600">{{ $totalAssistances ?? 0 }}</p>
            </div>
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-lg font-bold mb-4">Aktivitas Terbaru</h2>
            <ul class="divide-y">
                @forelse($latestAssistances as $a)
                    <li class="py-3 flex justify-between items-start">
                        <div>
                            <div class="font-semibold">{{ $a->student?->name ?? '—' }}</div>
                            <div class="text-sm text-gray-600">{{ $a->topic ?? '-' }}</div>
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($a->date)->format('d-m-Y') }}
                        </div>
                    </li>
                @empty
                    <li class="py-3 text-gray-500">Belum ada catatan pendampingan.</li>
                @endforelse
            </ul>
        </div>

        <!-- Catatan Berdasarkan Topik -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-lg font-bold mb-4">Catatan Berdasarkan Topik</h2>
            @if($assistancesByTopic->isEmpty())
                <div class="text-gray-500">Belum ada data topik.</div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($assistancesByTopic as $topic => $total)
                        <div class="p-4 border rounded-lg flex justify-between items-center">
                            <div class="text-sm">{{ $topic }}</div>
                            <div class="text-lg font-bold text-indigo-600">{{ $total }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- 🏆 Top 5 Guru dengan Catatan Terbanyak -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-bold mb-4">🏆 Top 5 Guru dengan Catatan Pendampingan Terbanyak</h2>
            @if($topTeachers->isEmpty())
                <div class="text-gray-500">Belum ada data guru.</div>
            @else
                <ul class="divide-y">
                    @foreach($topTeachers as $index => $t)
                        @php
                            $medal = match($index) {
                                0 => '🥇',
                                1 => '🥈',
                                2 => '🥉',
                                default => '🎓'
                            };
                        @endphp
                        <li class="py-3 flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">{{ $medal }}</span>
                                <div>
                                    <p class="font-semibold">{{ $t->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $t->nip ?? '-' }}</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-sm rounded-full">
                                {{ $t->total_assistances }} catatan
                            </span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-app-layout>
