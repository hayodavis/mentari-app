<x-app-layout>
    <div class="py-6 max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Edit Catatan Pendampingan</h1>

        <form action="{{ route('assistances.update',$assistance->id) }}" method="POST" class="space-y-4 bg-white shadow rounded-lg p-6">
            @csrf
            @method('PUT')

            {{-- Pilih Murid --}}
            <div>
                <label class="block font-medium">Murid</label>
                <select name="student_id" class="w-full border rounded px-3 py-2" required>
                    @foreach($students as $s)
                        <option value="{{ $s->id }}" @if($s->id == $assistance->student_id) selected @endif>
                            {{ $s->name }} ({{ $s->classroom?->name ?? '-' }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tanggal --}}
            <div>
                <label class="block font-medium">Tanggal</label>
                <input type="date" name="date" value="{{ $assistance->date }}" class="w-full border rounded px-3 py-2" required>
            </div>

            {{-- Topik (dropdown biar konsisten) --}}
            <div>
                <label class="block font-medium">Topik</label>
                <select name="topic" class="w-full border rounded px-3 py-2" required>
                    @php
                        $topics = ['Kedisiplinan','Prestasi','Absensi','Akademik','Lainnya'];
                    @endphp
                    @foreach($topics as $topic)
                        <option value="{{ $topic }}" @if($topic == $assistance->topic) selected @endif>
                            {{ $topic }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Catatan --}}
            <div>
                <label class="block font-medium">Catatan</label>
                <textarea name="notes" class="w-full border rounded px-3 py-2">{{ $assistance->notes }}</textarea>
            </div>

            {{-- Tindak Lanjut --}}
            <div>
                <label class="block font-medium">Tindak Lanjut</label>
                <input type="text" name="follow_up" value="{{ $assistance->follow_up }}" class="w-full border rounded px-3 py-2">
            </div>

            {{-- Status --}}
            <div>
                <label class="block font-medium">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2" required>
                    <option value="pending" @if($assistance->status == 'pending') selected @endif>⏳ Pending</option>
                    <option value="in_progress" @if($assistance->status == 'in_progress') selected @endif>🔄 Sedang Diproses</option>
                    <option value="done" @if($assistance->status == 'done') selected @endif>✅ Selesai</option>
                </select>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('assistances.index') }}" class="px-4 py-2 bg-gray-300 rounded-lg mr-2">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Update
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
