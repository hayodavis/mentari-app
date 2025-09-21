<x-app-layout>
    <div class="py-6 max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Tambah Murid</h1>

        <form action="{{ route('students.store') }}" method="POST" class="space-y-4 bg-white shadow rounded-lg p-6">
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
                <input type="text" name="class" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block font-medium">Gender</label>
                <select name="gender" class="w-full border rounded px-3 py-2">
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
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

            <div class="flex justify-end">
                <a href="{{ route('students.index') }}" class="px-4 py-2 bg-gray-300 rounded-lg mr-2">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
