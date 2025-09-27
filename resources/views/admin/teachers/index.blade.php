<x-app-layout>
    {{-- ✅ Notifikasi sukses sekali saja --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="py-6 max-w-6xl mx-auto">
        {{-- ✅ Judul + Tombol aksi sejajar --}}
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Daftar Guru</h1>
            <div class="space-x-2">
                <a href="{{ route('admin.students.template') }}"
                   class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Download Template
                </a>
                <a href="{{ route('admin.teachers.create') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    + Tambah Guru
                </a>
            </div>
        </div>

        {{-- ✅ Form Import Guru --}}
        <form action="{{ route('admin.teachers.import') }}" method="POST" enctype="multipart/form-data"
              class="mb-4 flex items-center">
            @csrf
            <input type="file" name="file" class="border p-2 rounded" required>
            <button type="submit"
                    class="ml-2 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Import Guru
            </button>
        </form>

        {{-- ✅ Tabel Daftar Guru --}}
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Nama</th>
                        <th class="px-4 py-2 text-left">Email</th>
                        <th class="px-4 py-2 text-left">NIP</th>
                        <th class="px-4 py-2 text-left">Phone</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teachers as $t)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $t->name }}</td>
                            <td class="px-4 py-2">{{ $t->user->email ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $t->nip }}</td>
                            <td class="px-4 py-2">{{ $t->phone }}</td>
                            <td class="px-4 py-2 text-center">
                                <a href="{{ route('admin.teachers.edit', $t->id) }}"
                                   class="text-blue-600 hover:underline mr-2">Edit</a>
                                <form action="{{ route('admin.teachers.destroy',$t->id) }}" method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('Yakin hapus guru ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-3 text-center text-gray-500">
                                Belum ada data guru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ✅ Pagination --}}
        <div class="mt-4">
            {{ $teachers->links() }}
        </div>
    </div>
</x-app-layout>
