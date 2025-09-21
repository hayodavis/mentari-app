<x-app-layout>
    <div class="py-6 max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Edit Kelas</h1>

        <form action="{{ route('admin.classrooms.update', $classroom->id) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block font-medium">Nama Kelas</label>
                <input type="text" name="name" value="{{ $classroom->name }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block font-medium">Deskripsi</label>
                <textarea name="description" class="w-full border rounded px-3 py-2">{{ $classroom->description }}</textarea>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>
