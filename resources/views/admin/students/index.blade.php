<x-app-layout>
    <div class="py-6 max-w-6xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Daftar Murid</h1>

        <a href="{{ route('admin.students.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 mb-4 inline-block">
            + Tambah Murid
        </a>

        <table class="w-full border-collapse bg-white shadow rounded-lg overflow-hidden">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 border">NISN</th>
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">Kelas</th>
                    <th class="px-4 py-2 border">Gender</th>
                    <th class="px-4 py-2 border">Guru Wali</th>
                    <th class="px-4 py-2 border">Kontak Ortu</th> {{-- ✅ Tambahan --}}
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $s)
                    <tr>
                        <td class="px-4 py-2 border">{{ $s->nisn }}</td>
                        <td class="px-4 py-2 border">{{ $s->name }}</td>
                        <td class="px-4 py-2 border">{{ $s->classroom?->name ?? '-' }}</td>
                        <td class="px-4 py-2 border">{{ $s->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td class="px-4 py-2 border">{{ $s->teacher?->name ?? '-' }}</td>
                        <td class="px-4 py-2 border">{{ $s->parent_contact ?? '-' }}</td> {{-- ✅ Tampilkan kontak ortu --}}
                        <td class="px-4 py-2 border">
                            <a href="{{ route('admin.students.show', $s->id) }}" class="px-2 py-1 bg-gray-500 text-white rounded">Lihat</a>
                            <a href="{{ route('admin.students.edit', $s->id) }}" class="px-2 py-1 bg-blue-500 text-white rounded">Edit</a>
                            <form action="{{ route('admin.students.destroy', $s->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus siswa ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $students->links() }}
        </div>
    </div>
</x-app-layout>
