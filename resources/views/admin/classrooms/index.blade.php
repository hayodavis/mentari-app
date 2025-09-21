<x-app-layout>
    <div class="py-6 max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Daftar Kelas</h1>

        <a href="{{ route('admin.classrooms.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Tambah Kelas</a>

        <table class="w-full mt-4 border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Nama Kelas</th>
                    <th class="px-4 py-2">Deskripsi</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($classrooms as $c)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2">{{ $c->name }}</td>
                    <td class="px-4 py-2">{{ $c->description ?? '-' }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.classrooms.edit', $c->id) }}" class="text-blue-600">Edit</a>
                        <form action="{{ route('admin.classrooms.destroy', $c->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 ml-2">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
