<x-app-layout>
    <div class="py-6 max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Daftar Kelas</h1>

        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('admin.classrooms.create') }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded-lg">
               Tambah Kelas
            </a>

            {{-- 🔍 Form pencarian --}}
            <form method="GET" action="{{ route('admin.classrooms.index') }}" class="flex space-x-2">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari kelas..."
                       class="border rounded px-3 py-1">
                <button type="submit" 
                        class="px-4 py-1 bg-gray-600 text-white rounded hover:bg-gray-700">
                    Cari
                </button>
            </form>
        </div>

        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="w-full border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">Nama Kelas</th>
                        <th class="px-4 py-2 border">Deskripsi</th>
                        <th class="px-4 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classrooms as $c)
                        <tr class="border-t">
                            <td class="px-4 py-2 border">
                                {{ ($classrooms->currentPage() - 1) * $classrooms->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-4 py-2 border">{{ $c->name }}</td>
                            <td class="px-4 py-2 border">{{ $c->description ?? '-' }}</td>
                            <td class="px-4 py-2 border">
                                <a href="{{ route('admin.classrooms.edit', $c->id) }}" class="text-blue-600">Edit</a>
                                <form action="{{ route('admin.classrooms.destroy', $c->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Yakin hapus kelas ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 ml-2">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-2 text-center text-gray-500">
                                Tidak ada kelas ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ✅ Pagination --}}
        <div class="mt-4">
            {{ $classrooms->appends(['search' => request('search')])->links() }}
        </div>
    </div>
</x-app-layout>
