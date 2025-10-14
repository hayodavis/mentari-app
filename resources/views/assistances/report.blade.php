<x-app-layout>
    <div class="max-w-3xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Laporkan Siswa ke Wali Kelas</h1>

        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('assistances.report.store') }}" method="POST" class="space-y-4">
                @csrf

                <!-- 🔍 Search siswa -->
                <div>
                    <label for="student_search" class="block font-medium mb-1">Cari Siswa</label>
                    <input type="text" id="student_search" placeholder="Ketik nama siswa..." 
                           class="w-full border rounded px-3 py-2" autocomplete="off">
                    <input type="hidden" name="student_id" id="student_id">
                    <div id="search_results" class="border rounded bg-white mt-1 hidden max-h-40 overflow-y-auto shadow">
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
                    <input type="text" name="topic" class="w-full border rounded px-3 py-2" required>
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
                    <a href="{{ route('assistances.index') }}" class="px-4 py-2 bg-gray-300 rounded mr-2">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Kirim Laporan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ✅ Script pencarian -->
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

            const res = await fetch(`/students/search?q=${query}`);
            const students = await res.json();

            if (students.length === 0) {
                resultBox.innerHTML = '<p class="px-3 py-2 text-gray-500 text-sm">Tidak ditemukan.</p>';
            } else {
                students.forEach(s => {
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
        });

        document.addEventListener('click', e => {
            if (!resultBox.contains(e.target) && e.target !== input) {
                resultBox.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
