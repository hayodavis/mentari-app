@extends('layouts.guru')

@section('content')
<div class="bg-white shadow rounded-lg p-4 sm:p-6">

    <!-- Header & Tombol Tambah -->
    <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
        <h1 class="text-lg sm:text-xl font-bold mb-2 sm:mb-0">📑 Catatan Pendampingan</h1>
        <div class="flex gap-2">
            <a href="{{ route('assistances.report.form') }}" 
               class="bg-red-600 text-white px-3 py-2 rounded hover:bg-red-700 text-sm sm:text-base">
                🚨 Laporkan Siswa
            </a>
            <a href="{{ route('assistances.create') }}" 
               class="bg-indigo-600 text-white px-3 py-2 rounded hover:bg-indigo-700 text-sm sm:text-base">
                + Tambah Catatan
            </a>
        </div>
    </div>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-3 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- 🔍 Form Pencarian, Sorting, & Filter -->
    <form method="GET" action="{{ route('assistances.index') }}" 
          class="flex flex-col sm:flex-row sm:items-center gap-2 mb-4 flex-wrap">

        <!-- Pencarian -->
        <input type="text" name="search" value="{{ request('search') }}" 
               placeholder="Cari nama murid atau topik..." 
               class="border rounded px-3 py-2 w-full sm:w-1/3 text-sm focus:ring-indigo-300 focus:outline-none">

        <!-- Filter Status -->
        <select name="status" onchange="this.form.submit()" 
                class="border rounded px-8 py-2 w-full sm:w-auto text-sm">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>🔄 Proses</option>
            <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>✅ Selesai</option>
        </select>

        <!-- Sorting -->
        <select name="sort" onchange="this.form.submit()" 
                class="border rounded px-8 py-2 w-full sm:w-auto text-sm">
            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Terbaru</option>
            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Terlama</option>
        </select>

        <!-- Tombol Cari -->
        <button type="submit" 
                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
            🔍 Cari
        </button>
    </form>

    <!-- 🧾 Tabel Data -->
    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200 text-sm sm:text-base">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left font-semibold">Tanggal</th>
                    <th class="px-4 py-2 text-left font-semibold">Murid</th>
                    <th class="px-4 py-2 text-left font-semibold">Dilaporkan Oleh</th>
                    <th class="px-4 py-2 text-left font-semibold">Topik</th>
                    <th class="px-4 py-2 text-left font-semibold">Catatan</th>
                    <th class="px-4 py-2 text-center font-semibold">Status</th>
                    <th class="px-4 py-2 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($assistances as $a)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 whitespace-nowrap">{{ $a->date }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $a->student?->name ?? '-' }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            {{ $a->reporter?->name ?? '—' }}
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $a->topic }}</td>
                        <td class="px-4 py-2 max-w-[250px] truncate">{{ $a->notes }}</td>
                        <td class="px-4 py-2 text-center">
                            @if($a->status == 'pending')
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-xs bg-gray-200 text-gray-700 rounded-full">
                                    ⏳ Pending
                                </span>
                            @elseif($a->status == 'in_progress')
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-xs bg-yellow-200 text-yellow-800 rounded-full">
                                    🔄 Proses
                                </span>
                            @elseif($a->status == 'done')
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-xs bg-green-200 text-green-800 rounded-full">
                                    ✅ Selesai
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('assistances.edit', $a->id) }}" 
                                   class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('assistances.destroy', $a->id) }}" 
                                      method="POST" class="inline-block" 
                                      onsubmit="return confirm('Hapus catatan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 py-3">
                            Belum ada catatan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $assistances->appends(request()->all())->links() }}
    </div>
</div>
@endsection
