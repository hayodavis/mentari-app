<x-app-layout>
    <div class="py-6 max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Catatan Pendampingan</h1>
            <a href="{{ route('assistances.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
               + Tambah Catatan
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
                        <th class="px-4 py-2 text-left">Tanggal</th>
                        <th class="px-4 py-2 text-left">Murid</th>
                        <th class="px-4 py-2 text-left">Topik</th>
                        <th class="px-4 py-2 text-left">Catatan</th>
                        <th class="px-4 py-2 text-left">Tindak Lanjut</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assistances as $a)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $a->date }}</td>
                            <td class="px-4 py-2">{{ $a->student->name }}</td>
                            <td class="px-4 py-2">{{ $a->topic }}</td>
                            <td class="px-4 py-2">{{ $a->notes }}</td>
                            <td class="px-4 py-2">{{ $a->follow_up }}</td>
                            <td class="px-4 py-2 text-center">
                                <a href="{{ route('assistances.edit',$a->id) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                                <form action="{{ route('assistances.destroy',$a->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus catatan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-center text-gray-500">
                                Belum ada catatan pendampingan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
