<x-app-layout>
    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <!-- Judul Halaman -->
        <h1 class="text-2xl font-bold mb-4 text-gray-800">
            👨‍🏫 Detail Aktivitas Guru Wali: {{ $teacher->name }}
        </h1>

        <p class="text-gray-600 mb-6">
            Berikut adalah seluruh catatan pendampingan yang dibuat oleh guru ini, baik untuk siswa binaan
            maupun laporan siswa lain yang dibuat secara langsung.
        </p>

        <!-- Tombol kembali -->
        <a href="{{ route('admin.teacherPerformance') }}"
           class="inline-block mb-4 bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-2 rounded text-sm transition">
            ← Kembali ke Daftar Guru
        </a>

        <!-- 🔹 Daftar Catatan (Responsif) -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-gray-700 border border-gray-200">
                    <thead class="bg-indigo-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold border-b">Tanggal</th>
                            <th class="px-4 py-3 text-left font-semibold border-b">Siswa</th>
                            <th class="px-4 py-3 text-left font-semibold border-b">Kelas</th>
                            <th class="px-4 py-3 text-left font-semibold border-b">Topik</th>
                            <th class="px-4 py-3 text-left font-semibold border-b">Catatan</th>
                            <th class="px-4 py-3 text-left font-semibold border-b">Tindak Lanjut</th>
                            <th class="px-4 py-3 text-center font-semibold border-b">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assistances as $a)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border-b whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($a->date)->translatedFormat('d F Y') }}
                                </td>
                                <td class="px-4 py-2 border-b whitespace-nowrap">{{ $a->student->name ?? '—' }}</td>
                                <td class="px-4 py-2 border-b whitespace-nowrap">{{ $a->student->classroom->name ?? '—' }}</td>
                                <td class="px-4 py-2 border-b">{{ $a->topic }}</td>
                                <td class="px-4 py-2 border-b">{{ $a->notes ?: '—' }}</td>
                                <td class="px-4 py-2 border-b">{{ $a->follow_up ?: '—' }}</td>
                                <td class="px-4 py-2 text-center border-b whitespace-nowrap">
                                    @php
                                        $color = [
                                            'pending' => 'bg-yellow-100 text-yellow-700',
                                            'in_progress' => 'bg-blue-100 text-blue-700',
                                            'done' => 'bg-green-100 text-green-700'
                                        ][$a->status] ?? 'bg-gray-100 text-gray-700';
                                    @endphp
                                    <span class="{{ $color }} px-3 py-1 rounded-full text-xs font-semibold">
                                        {{ ucfirst(str_replace('_', ' ', $a->status)) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-gray-500">
                                    Tidak ada catatan pendampingan untuk guru ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- ✅ Pagination -->
<div class="px-4 py-3 bg-white border-t border-gray-200">
    {{ $assistances->links() }}
</div>
            </div>
        </div>
    </div>
</x-app-layout>
