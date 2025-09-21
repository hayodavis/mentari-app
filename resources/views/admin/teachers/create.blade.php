<x-app-layout>
    <div class="py-6 max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Tambah Guru</h1>

        <form action="{{ route('admin.teachers.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block font-medium">Nama</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block font-medium">Email</label>
                <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block font-medium">Password</label>
                <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block font-medium">NIP</label>
                <input type="text" name="nip" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block font-medium">No HP</label>
                <input type="text" name="phone" class="w-full border rounded px-3 py-2">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>
