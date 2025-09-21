<x-app-layout>
    <div class="py-6 max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Tambah Murid</h1>

        <form action="{{ route('admin.students.store') }}" method="POST" class="space-y-4 bg-white shadow rounded-lg p-6">
            @csrf

            <div>
                <label class="block font-medium">NISN</label>
                <input type="text" name="nisn" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block font-medium">Nama</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block font-medium">Kelas</label>
                <select name="classroom_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($classrooms as $classroom)
                        <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-medium">Gender</label>
                <select name="gender" class="w-full border rounded px-3 py-2" required>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>

            <div>
                <label class="block font-medium">Kontak Ortu</label>
                <input type="text" name="parent_contact" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block font-medium">Catatan</label>
                <textarea name="notes" class="w-full border rounded px-3 py-2"></textarea>
            </div>

            <div>
                <label class="block font-medium">Guru Wali</label>
                <select name="teacher_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Pilih Guru Wali --</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.students.index') }}" class="px-4 py-2 bg-gray-300 rounded-lg mr-2">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
