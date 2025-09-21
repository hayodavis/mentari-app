<x-app-layout>
    <div class="py-6 max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Edit Catatan Pendampingan</h1>

        <form action="{{ route('assistances.update',$assistance->id) }}" method="POST" class="space-y-4 bg-white shadow rounded-lg p-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium">Murid</label>
                <select name="student_id" class="w-full border rounded px-3 py-2">
                    @foreach($students as $s)
                        <option value="{{ $s->id }}" @if($s->id==$assistance->student_id) selected @endif>
                            {{ $s->name }} ({{ $s->class }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-medium">Tanggal</label>
                <input type="date" name="date" value="{{ $assistance->date }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block font-medium">Topik</label>
                <input type="text" name="topic" value="{{ $assistance->topic }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block font-medium">Catatan</label>
                <textarea name="notes" class="w-full border rounded px-3 py-2">{{ $assistance->notes }}</textarea>
            </div>

            <div>
                <label class="block font-medium">Tindak Lanjut</label>
                <input type="text" name="follow_up" value="{{ $assistance->follow_up }}" class="w-full border rounded px-3 py-2">
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
