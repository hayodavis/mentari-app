<x-app-layout>
    <div class="py-6 max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        <h1 class="text-xl sm:text-2xl font-bold mb-6 text-center sm:text-left">
            Dashboard Admin
        </h1>

        <!-- 📊 Statistik Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 mb-6">
            <div class="bg-white shadow rounded-lg p-3 sm:p-4 text-center">
                <p class="text-gray-500 text-xs sm:text-sm">Jumlah Siswa</p>
                <p class="text-lg sm:text-2xl font-bold text-indigo-600">{{ $totalStudents ?? 0 }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-3 sm:p-4 text-center">
                <p class="text-gray-500 text-xs sm:text-sm">Jumlah Guru</p>
                <p class="text-lg sm:text-2xl font-bold text-indigo-600">{{ $totalTeachers ?? 0 }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-3 sm:p-4 text-center">
                <p class="text-gray-500 text-xs sm:text-sm">Jumlah Kelas</p>
                <p class="text-lg sm:text-2xl font-bold text-indigo-600">{{ $totalClassrooms ?? 0 }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-3 sm:p-4 text-center">
                <p class="text-gray-500 text-xs sm:text-sm">Catatan Pendampingan</p>
                <p class="text-lg sm:text-2xl font-bold text-indigo-600">{{ $totalAssistances ?? 0 }}</p>
            </div>
        </div>

        <!-- 🕒 Aktivitas Terbaru -->
        <div class="bg-white shadow rounded-lg p-4 sm:p-6 mb-6">
            <h2 class="text-base sm:text-lg font-bold mb-4 text-center sm:text-left">
                Aktivitas Terbaru
            </h2>
            <ul class="divide-y">
                @forelse($latestAssistances as $a)
                    <li class="py-3 flex flex-col sm:flex-row sm:justify-between sm:items-center">
                        <div class="text-center sm:text-left">
                            <div class="font-semibold text-sm sm:text-base">
                                {{ $a->student?->name ?? '—' }}
                            </div>
                            <div class="text-xs sm:text-sm text-gray-600">{{ $a->topic ?? '-' }}</div>
                        </div>
                        <div class="text-xs sm:text-sm text-gray-500 mt-1 sm:mt-0 text-center sm:text-right">
                            {{ \Carbon\Carbon::parse($a->date)->format('d-m-Y') }}
                        </div>
                    </li>
                @empty
                    <li class="py-3 text-gray-500 text-sm text-center sm:text-left">
                        Belum ada catatan pendampingan.
                    </li>
                @endforelse
            </ul>
        </div>

        <!-- 📚 Catatan Berdasarkan Topik -->
        <div class="bg-white shadow rounded-lg p-4 sm:p-6 mb-6">
            <h2 class="text-base sm:text-lg font-bold mb-4 text-center sm:text-left">
                Catatan Berdasarkan Topik
            </h2>
            @if($assistancesByTopic->isEmpty())
                <div class="text-gray-500 text-sm text-center sm:text-left">Belum ada data topik.</div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
                    @foreach($assistancesByTopic as $topic => $total)
                        <div class="p-3 sm:p-4 border rounded-lg flex justify-between items-center text-sm sm:text-base">
                            <div class="truncate max-w-[70%]">{{ $topic }}</div>
                            <div class="font-bold text-indigo-600">{{ $total }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- 🏆 Top 5 Guru dengan Catatan Terbanyak -->
        <div class="bg-white shadow rounded-lg p-4 sm:p-6">
            <h2 class="text-base sm:text-lg font-bold mb-4 text-center sm:text-left">
                🏆 Top 5 Guru dengan Catatan Pendampingan Terbanyak
            </h2>

            @if($topTeachers->isEmpty())
                <div class="text-gray-500 text-center sm:text-left">Belum ada data guru.</div>
            @else
                <div class="overflow-x-auto pb-4 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                    <div class="flex space-x-4 sm:space-x-6 min-w-max snap-x snap-mandatory px-1">
                        @foreach($topTeachers as $index => $t)
                            @php
                                $medal = match($index) {
                                    0 => '🥇',
                                    1 => '🥈',
                                    2 => '🥉',
                                    default => '🎓'
                                };
                                $bgColor = match($index) {
                                    0 => 'bg-yellow-100 border-yellow-400',
                                    1 => 'bg-gray-100 border-gray-400',
                                    2 => 'bg-amber-100 border-amber-400',
                                    default => 'bg-indigo-50 border-indigo-300'
                                };
                            @endphp

                            <div class="flex-shrink-0 w-52 sm:w-56 md:w-60 border {{ $bgColor }} rounded-2xl shadow-sm hover:shadow-md transition transform hover:-translate-y-1 snap-center">
                                <div class="p-4 flex flex-col items-center text-center">
                                    <span class="text-4xl mb-2">{{ $medal }}</span>
                                    <p class="font-semibold text-sm sm:text-lg text-gray-800">{{ $t->name }}</p>
                                    <p class="text-xs sm:text-sm text-gray-500 mb-3">{{ $t->nip ?? '-' }}</p>

                                    <div class="w-full h-2 bg-gray-200 rounded-full mb-2">
                                        <div class="h-2 bg-indigo-500 rounded-full" style="width: {{ min(100, $t->total_assistances * 20) }}%"></div>
                                    </div>

                                    <span class="text-xs sm:text-sm font-medium text-indigo-700 bg-indigo-100 px-3 py-1 rounded-full whitespace-nowrap">
                                        {{ $t->total_assistances }} catatan
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
