<x-app-layout>
    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 flex items-center gap-2">
            📊 Pemantauan Kinerja Guru Wali
        </h1>

        <!-- 🔹 Filter Periode -->
        <form method="GET" action="{{ route('admin.teacherPerformance') }}"
              class="mb-6 flex flex-col sm:flex-row sm:flex-wrap sm:items-end gap-3">
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Bulan</label>
                <select name="month"
                        class="border rounded-md px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition w-full sm:w-auto">
                    @foreach (range(1, 12) as $m)
                        <option value="{{ $m }}" {{ request('month', date('m')) == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Tahun</label>
                <select name="year"
                        class="border rounded-md px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition w-full sm:w-auto">
                    @foreach (range(date('Y') - 3, date('Y')) as $y)
                        <option value="{{ $y }}" {{ request('year', date('Y')) == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-transparent mb-1">_</label>
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm px-4 py-2 rounded-md shadow-sm transition-all duration-200 w-full sm:w-auto">
                    🔍 <span>Tampilkan</span>
                </button>
            </div>
        </form>

        <!-- 🔹 Tabel Kinerja Guru (Responsif) -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-gray-700 border border-gray-200">
                    <thead class="bg-indigo-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold border-b">#</th>
                            <th class="px-4 py-3 text-left font-semibold border-b whitespace-nowrap">Nama Guru Wali</th>
                            <th class="px-4 py-3 text-center font-semibold border-b">Jumlah Catatan</th>
                            <th class="px-4 py-3 text-center font-semibold border-b whitespace-nowrap">Terakhir Mencatat</th>
                            <th class="px-4 py-3 text-center font-semibold border-b whitespace-nowrap">Status Aktivitas</th>
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
                                       class="inline-flex items-center gap-1 bg-blue-500 hover:bg-blue-600 
                                              text-white px-3 py-1 rounded text-xs transition">
                                        👁️ <span>Lihat</span>
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
                <div class="px-4 py-3 bg-white border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center text-sm">
                    <div class="text-gray-500 mb-2 sm:mb-0">
                        Menampilkan {{ $performances->firstItem() ?? 0 }}–{{ $performances->lastItem() ?? 0 }} dari {{ $performances->total() }} data
                    </div>
                    <div class="flex justify-center sm:justify-end w-full sm:w-auto">
                        {{ $performances->onEachSide(1)->links() }}
                    </div>
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
