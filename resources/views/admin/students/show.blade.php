<x-app-layout>
    <div class="py-6 max-w-5xl mx-auto" x-data="{ openModal: false }">
        
        <!-- Detail Murid -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Detail Murid</h2>
                <a href="{{ route('admin.students.index') }}" 
                   class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                    ← Kembali
                </a>
            </div>

            <table class="w-full border border-gray-300 rounded-lg">
                <tbody>
                    <tr>
                        <td class="font-medium w-40 border px-4 py-2 bg-gray-50">NISN</td>
                        <td class="px-4 py-2 border">{{ $student->nisn }}</td>
                    </tr>
                    <tr>
                        <td class="font-medium border px-4 py-2 bg-gray-50">Nama</td>
                        <td class="px-4 py-2 border">{{ $student->name }}</td>
                    </tr>
                    <tr>
                        <td class="font-medium border px-4 py-2 bg-gray-50">Kelas</td>
                        <td class="px-4 py-2 border">{{ $student->classroom?->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="font-medium border px-4 py-2 bg-gray-50">Gender</td>
                        <td class="px-4 py-2 border">
                            {{ $student->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="font-medium border px-4 py-2 bg-gray-50">Guru Wali</td>
                        <td class="px-4 py-2 border">{{ $student->teacher?->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="font-medium border px-4 py-2 bg-gray-50">Kontak Ortu</td>
                        <td class="px-4 py-2 border">{{ $student->parent_contact ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="font-medium border px-4 py-2 bg-gray-50">Catatan</td>
                        <td class="px-4 py-2 border">{{ $student->notes ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Riwayat Pendampingan -->
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Riwayat Pendampingan</h2>
                <button @click="openModal = true"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    + Tambah Catatan
                </button>
            </div>

            <table class="w-full border border-gray-300 rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">Tanggal</th>
                        <th class="px-4 py-2 border">Topik</th>
                        <th class="px-4 py-2 border">Catatan</th>
                        <th class="px-4 py-2 border">Tindak Lanjut</th>
                        <th class="px-4 py-2 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($student->assistances as $a)
                        <tr>
                            <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($a->date)->format('d-m-Y') }}</td>
                            <td class="px-4 py-2 border">{{ $a->topic }}</td>
                            <td class="px-4 py-2 border">{{ $a->notes }}</td>
                            <td class="px-4 py-2 border">{{ $a->follow_up }}</td>
                            <td class="px-4 py-2 border text-center">
                                <a href="{{ route('assistances.edit', $a->id) }}" 
                                   class="text-blue-600 hover:underline mr-2">Edit</a>
                                <form action="{{ route('assistances.destroy', $a->id) }}" 
                                      method="POST" class="inline-block"
                                      onsubmit="return confirm('Yakin hapus catatan ini?')">
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
                            <td colspan="5" class="px-4 py-3 text-center text-gray-500">
                                Belum ada catatan pendampingan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Modal Tambah Catatan -->
        <div x-show="openModal" 
             class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50"
             x-cloak>
            <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold mb-4">Tambah Catatan Pendampingan</h2>

                <form action="{{ route('students.assistances.store', $student->id) }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block font-medium">Tanggal</label>
                        <input type="date" name="date" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block font-medium">Topik</label>
                        <input type="text" name="topic" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block font-medium">Catatan</label>
                        <textarea name="notes" class="w-full border rounded px-3 py-2"></textarea>
                    </div>

                    <div>
                        <label class="block font-medium">Tindak Lanjut</label>
                        <input type="text" name="follow_up" class="w-full border rounded px-3 py-2">
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button" @click="openModal = false" 
                                class="px-4 py-2 bg-gray-300 rounded-lg">Batal</button>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
