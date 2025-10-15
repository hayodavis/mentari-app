<x-app-layout>
    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">
            📊 Pemantauan Kinerja Guru Wali
        </h1>

        <!-- Filter Periode -->
        <form method="GET" action="{{ route('admin.teacherPerformance') }}" class="mb-6 flex flex-wrap gap-3 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-600">Bulan</label>
                <select name="month" class="border rounded px-3 py-2 text-sm">
                    @foreach (range(1, 12) as $m)
                        <option value="{{ $m }}" {{ request('month', date('m')) == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Tahun</label>
                <select name="year" class="border rounded px-7 py-2 text-sm">
                    @foreach (range(date('Y') - 3, date('Y')) as $y)
                        <option value="{{ $y }}" {{ request('year', date('Y')) == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit"
                class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">
                🔍 Tampilkan
            </button>
        </form>

        <!-- 🔹 Tabel Kinerja Guru (Responsif) -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-gray-700 border border-gray-200">
                    <thead class="bg-indigo-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold border-b">#</th>
                            <th class="px-4 py-3 text-left font-semibold border-b">Nama Guru Wali</th>
                            <th class="px-4 py-3 text-center font-semibold border-b">Jumlah Catatan</th>
                            <th class="px-4 py-3 text-center font-semibold border-b">Terakhir Mencatat</th>
                            <th class="px-4 py-3 text-center font-semibold border-b">Status Aktivitas</th>
                            <th class="px-4 py-3 text-center font-semibold border-b">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($performances as $index => $p)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border-b">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 border-b whitespace-nowrap">{{ $p['teacher_name'] }}</td>
                                <td class="px-4 py-2 text-center border-b font-semibold text-indigo-700">
                                    {{ $p['total_assistances'] }}
                                </td>
                                <td class="px-4 py-2 text-center border-b whitespace-nowrap">
                                    {{ $p['last_activity'] ? \Carbon\Carbon::parse($p['last_activity'])->translatedFormat('d F Y') : '—' }}
                                </td>
                                <td class="px-4 py-2 text-center border-b">
                                    @if ($p['status'] === 'Aktif')
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Aktif</span>
                                    @elseif ($p['status'] === 'Cukup Aktif')
                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Cukup Aktif</span>
                                    @else
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">Kurang Aktif</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-center border-b">
                                    <a href="{{ route('admin.teacherPerformance.detail', ['id' => $p['teacher_id']]) }}"
                                       class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs transition">
                                        👁️ Lihat
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-gray-500">
                                    Tidak ada data untuk periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- ✅ Pagination -->
<div class="px-4 py-3 bg-white border-t border-gray-200">
    {{ $performances->links() }}
</div>
            </div>
        </div>

        <!-- 🔹 Statistik Ringkas -->
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                <p class="text-green-700 font-bold text-2xl">{{ $summary['aktif'] ?? 0 }}</p>
                <p class="text-sm text-green-700">Guru Aktif</p>
            </div>
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
                <p class="text-yellow-700 font-bold text-2xl">{{ $summary['cukup'] ?? 0 }}</p>
                <p class="text-sm text-yellow-700">Guru Cukup Aktif</p>
            </div>
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                <p class="text-red-700 font-bold text-2xl">{{ $summary['kurang'] ?? 0 }}</p>
                <p class="text-sm text-red-700">Guru Kurang Aktif</p>
            </div>
        </div>
    </div>
</x-app-layout>
