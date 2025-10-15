<x-app-layout>
    <div class="max-w-3xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Laporkan Siswa ke Guru Wali</h1>

        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('assistances.report.store') }}" method="POST" class="space-y-4">
                @csrf

                <!-- 🔍 Search siswa -->
                <div>
                    <label for="student_search" class="block font-medium mb-1">Cari Siswa</label>
                    <input type="text" id="student_search" placeholder="Ketik nama siswa..." 
                           class="w-full border rounded px-3 py-2" autocomplete="off">
                    <input type="hidden" name="student_id" id="student_id">
                    <div id="search_results" 
                         class="border rounded bg-white mt-1 hidden max-h-40 overflow-y-auto shadow z-50 absolute w-full">
                        <!-- hasil pencarian muncul di sini -->
                    </div>
                </div>

                <!-- 🗓️ Tanggal -->
                <div>
                    <label class="block font-medium">Tanggal</label>
                    <input type="date" name="date" value="{{ date('Y-m-d') }}" 
                           class="w-full border rounded px-3 py-2" required>
                </div>

                <!-- 🧭 Topik -->
                <div>
                    <label class="block font-medium">Topik</label>
                    <select name="topic" class="w-full border rounded px-3 py-2" required>
                        <option value="">-- Pilih Topik --</option>
                        <option value="Kedisiplinan">Kedisiplinan</option>
                        <option value="Prestasi">Prestasi</option>
                        <option value="Absensi">Absensi</option>
                        <option value="Akademik">Akademik</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <!-- 📝 Catatan -->
                <div>
                    <label class="block font-medium">Catatan</label>
                    <textarea name="notes" rows="4" class="w-full border rounded px-3 py-2" required></textarea>
                </div>

                <!-- 🔄 Tindak Lanjut -->
                <div>
                    <label class="block font-medium">Tindak Lanjut (opsional)</label>
                    <input type="text" name="follow_up" class="w-full border rounded px-3 py-2">
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('assistances.index') }}" 
                       class="px-4 py-2 bg-gray-300 rounded mr-2 hover:bg-gray-400 transition">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                        Kirim Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ✅ Script pencarian siswa -->
    <script>
        const input = document.getElementById('student_search');
        const resultBox = document.getElementById('search_results');
        const hiddenId = document.getElementById('student_id');

        input.addEventListener('input', async () => {
            const query = input.value.trim();
            resultBox.innerHTML = '';
            if (query.length < 2) {
                resultBox.classList.add('hidden');
                return;
            }

            try {
                const res = await fetch(`/students/search?q=${query}`);
                const students = await res.json();

                // Hapus duplikat berdasarkan nama + kelas
                const unique = [];
                const filtered = students.filter(s => {
                    const key = s.name + '-' + (s.classroom ?? '');
                    if (unique.includes(key)) return false;
                    unique.push(key);
                    return true;
                });

                if (filtered.length === 0) {
                    resultBox.innerHTML = '<p class="px-3 py-2 text-gray-500 text-sm">Tidak ditemukan.</p>';
                } else {
                    filtered.forEach(s => {
                        const item = document.createElement('div');
                        item.className = 'px-3 py-2 hover:bg-indigo-50 cursor-pointer text-sm';
                        item.textContent = `${s.name} — ${s.classroom ?? '-'}`;
                        item.addEventListener('click', () => {
                            input.value = s.name;
                            hiddenId.value = s.id;
                            resultBox.classList.add('hidden');
                        });
                        resultBox.appendChild(item);
                    });
                }

                resultBox.classList.remove('hidden');
            } catch (error) {
                console.error('Error fetching students:', error);
                resultBox.classList.add('hidden');
            }
        });

        // Klik di luar kotak -> sembunyikan hasil pencarian
        document.addEventListener('click', e => {
            if (!resultBox.contains(e.target) && e.target !== input) {
                resultBox.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
