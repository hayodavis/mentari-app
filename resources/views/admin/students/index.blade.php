<x-app-layout>
    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Alert Success --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Daftar Murid</h1>
            <div class="flex space-x-2">
                <a href="{{ route('admin.students.create') }}" 
                   class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    + Tambah Murid
                </a>
                <a href="{{ asset('storage/template_siswa.xlsx') }}" 
                   class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Download Template Siswa
                </a>
            </div>
        </div>

        {{-- Import Form --}}
        <form action="{{ route('admin.students.import') }}" method="POST" enctype="multipart/form-data" 
              class="flex items-center space-x-2 mb-6">
            @csrf
            <input type="file" name="file" class="border p-2 rounded w-full sm:w-auto" required>
            <button type="submit" 
                    class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Import Siswa
            </button>
        </form>

        <form method="GET" action="{{ route('admin.students.index') }}" class="mb-4 flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari NISN / Nama / Kelas / Guru"
            class="border px-3 py-2 rounded w-1/3">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Cari
            </button>
            @if(request('search'))
            <a href="{{ route('admin.students.index') }}"
            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            Reset</a>
            @endif
        </form>

        {{-- Table --}}
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full text-sm text-left border-collapse">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2 border">NISN</th>
                        <th class="px-4 py-2 border">Nama</th>
                        <th class="px-4 py-2 border">Kelas</th>
                        <th class="px-4 py-2 border">Gender</th>
                        <th class="px-4 py-2 border">Guru Wali</th>
                        <th class="px-4 py-2 border">Kontak Ortu</th>
                        <th class="px-4 py-2 border text-center w-48">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $s)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $s->nisn }}</td>
                            <td class="px-4 py-2">{{ $s->name }}</td>
                            <td class="px-4 py-2">{{ $s->classroom?->name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $s->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td class="px-4 py-2">{{ $s->teacher?->name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $s->parent_contact ?? '-' }}</td>
                            <td class="px-4 py-2 text-center space-x-1">
                                <a href="{{ route('admin.students.show', $s->id) }}" 
                                   class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600">Lihat</a>
                                <a href="{{ route('admin.students.edit', $s->id) }}" 
                                   class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Edit</a>
                                <form action="{{ route('admin.students.destroy', $s->id) }}" 
                                      method="POST" class="inline-block"
                                      onsubmit="return confirm('Yakin hapus siswa ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-3 text-center text-gray-500">
                                Belum ada data siswa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $students->appends(['search' => request('search')])->links() }}
        </div>
    </div>
</x-app-layout>
