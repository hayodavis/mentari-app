<x-app-layout>
    <div class="py-6 max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Data Murid</h1>
            <a href="{{ route('students.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
               + Tambah Murid
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">NISN</th>
                        <th class="px-4 py-2 text-left">Nama</th>
                        <th class="px-4 py-2 text-left">Kelas</th>
                        <th class="px-4 py-2 text-left">Gender</th>
                        <th class="px-4 py-2 text-left">Kontak Ortu</th>
                        <th class="px-4 py-2 text-left">Catatan</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $s)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $s->nisn }}</td>
                            <td class="px-4 py-2">{{ $s->name }}</td>
                            <td class="px-4 py-2">{{ $s->class }}</td>
                            <td class="px-4 py-2">{{ $s->gender }}</td>
                            <td class="px-4 py-2">{{ $s->parent_contact }}</td>
                            <td class="px-4 py-2">{{ $s->notes }}</td>
                            <td class="px-4 py-2 text-center">
                                 <a href="{{ route('students.show',$s->id) }}" class="text-green-600 hover:underline mr-2">Detail</a>
                                <a href="{{ route('students.edit',$s->id) }}"
                                   class="text-blue-600 hover:underline mr-2">Edit</a>
                                <form action="{{ route('students.destroy',$s->id) }}"
                                      method="POST" class="inline-block"
                                      onsubmit="return confirm('Yakin hapus murid ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-3 text-center text-gray-500">
                                Belum ada data murid.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
