<x-app-layout>
    <div class="max-w-3xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Tambah Catatan Pendampingan</h1>

        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('assistances.store') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Murid -->
                <div>
                    <label for="student_id" class="block font-medium text-gray-700">Murid</label>
                    <select name="student_id" id="student_id"
                            class="w-full border rounded px-3 py-2" required>
                        <option value="">-- Pilih Murid --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">
                                {{ $student->name }} - {{ $student->classroom?->name ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal -->
                <div>
                    <label for="date" class="block font-medium text-gray-700">Tanggal</label>
                    <input type="date" name="date" id="date"
                           class="w-full border rounded px-3 py-2" required>
                </div>

                <!-- Topik -->
                <div>
                    <label for="topic" class="block mb-1 font-medium">Topik</label>
                    <select name="topic" id="topic" class="w-full border rounded p-2" required>
                        <option value="">-- Pilih Topik --</option>
                        <option value="Kedisiplinan">Kedisiplinan</option>
                        <option value="Prestasi">Prestasi</option>
                        <option value="Absensi">Absensi</option>
                        <option value="Akademik">Akademik</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <!-- Catatan -->
                <div>
                    <label for="notes" class="block font-medium text-gray-700">Catatan</label>
                    <textarea name="notes" id="notes"
                              class="w-full border rounded px-3 py-2"></textarea>
                </div>

                <!-- Tindak Lanjut -->
                <div>
                    <label for="follow_up" class="block font-medium text-gray-700">Tindak Lanjut</label>
                    <input type="text" name="follow_up" id="follow_up"
                           class="w-full border rounded px-3 py-2">
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block mb-1 font-medium">Status</label>
                    <select name="status" id="status" class="w-full border rounded p-2" required>
                        <option value="pending">⏳ Pending</option>
                        <option value="in_progress">🔄 Sedang Diproses</option>
                        <option value="done">✅ Selesai</option>
                    </select>
                </div>

                <!-- Tombol -->
                <div class="flex justify-end space-x-2">
                    <a href="{{ route('assistances.index') }}"
                       class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
