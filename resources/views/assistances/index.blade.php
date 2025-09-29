<x-app-layout>
    <div class="py-6 max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Catatan Pendampingan</h1>
            <a href="{{ route('assistances.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                + Tambah Catatan
            </a>
        </div>

        {{-- 🔍 Form pencarian & sorting --}}
        <form method="GET" action="{{ route('assistances.index') }}" class="flex items-center gap-2 mb-4">
    <input type="text" name="search" value="{{ request('search') }}" 
        placeholder="Cari nama atau topik..." 
        class="border rounded px-3 py-2 w-1/3">

    {{-- 🔽 Dropdown topik --}}
    <select name="topic" onchange="this.form.submit()" class="border rounded px-8 py-2">
        <option value="">Semua Topik</option>
        @foreach($topics as $t)
            <option value="{{ $t }}" {{ request('topic') == $t ? 'selected' : '' }}>{{ $t }}</option>
        @endforeach
    </select>

    {{-- ⏳ Sorting tanggal --}}
    <select name="sort" onchange="this.form.submit()" class="border rounded px-8 py-2">
        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Terbaru</option>
        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Terlama</option>
    </select>

    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg">Cari</button>
</form>


        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">Tanggal</th>
                        <th class="px-4 py-2 border">Murid</th>
                        <th class="px-4 py-2 border">Topik</th>
                        <th class="px-4 py-2 border">Catatan</th>
                        <th class="px-4 py-2 border">Tindak Lanjut</th>
                        <th class="px-4 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assistances as $a)
                        <tr>
                            <td class="px-4 py-2 border">{{ $a->date }}</td>
                            <td class="px-4 py-2 border">{{ $a->student?->name ?? '-' }}</td>
                            <td class="px-4 py-2 border">{{ $a->topic }}</td>
                            <td class="px-4 py-2 border">{{ $a->notes }}</td>
                            <td class="px-4 py-2 border">{{ $a->follow_up }}</td>
                            <td class="px-4 py-2 border">
                                <a href="{{ route('assistances.edit', $a->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('assistances.destroy', $a->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus catatan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline ml-2">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-center text-gray-500">Belum ada catatan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $assistances->appends(request()->all())->links() }}
        </div>
    </div>
</x-app-layout>
