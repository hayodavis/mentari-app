<x-app-layout>
    <div class="py-6 max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Catatan Pendampingan</h1>
            <div class="flex gap-2">
                <a href="{{ route('assistances.create') }}" 
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    + Tambah Catatan
                </a>

                {{-- 🔘 Switch tampilan --}}
                @php $view = request('view', 'table'); @endphp
                <a href="{{ route('assistances.index', array_merge(request()->all(), ['view' => $view == 'table' ? 'card' : 'table'])) }}"
                   class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                    {{ $view == 'table' ? '📦 Card View' : '📊 Table View' }}
                </a>
            </div>
        </div>

        {{-- 🔍 Form pencarian & filter --}}
        <form method="GET" action="{{ route('assistances.index') }}" class="flex flex-wrap gap-2 mb-6">
            <input type="hidden" name="view" value="{{ $view }}"> {{-- supaya nggak hilang --}}
            <input type="text" name="search" value="{{ request('search') }}" 
                placeholder="Cari nama atau topik..." 
                class="border rounded px-3 py-2 w-full md:w-1/3">

            <select name="topic" onchange="this.form.submit()" class="border rounded px-8 py-2">
                <option value="">Semua Topik</option>
                @foreach($topics as $t)
                    <option value="{{ $t }}" {{ request('topic') == $t ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
            </select>

            <select name="status" onchange="this.form.submit()" class="border rounded px-8 py-2">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>⏳ Pending</option>
                <option value="in_progress" {{ request('status')=='in_progress' ? 'selected' : '' }}>🔄 Proses</option>
                <option value="done" {{ request('status')=='done' ? 'selected' : '' }}>✅ Selesai</option>
            </select>

            <select name="sort" onchange="this.form.submit()" class="border rounded px-8 py-2">
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Terbaru</option>
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Terlama</option>
            </select>

            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg">Cari</button>
        </form>

        {{-- ✅ Tampilan dinamis --}}
        @if($view == 'table')
            {{-- 📊 Table View --}}
            <div class="overflow-x-auto bg-white shadow rounded-lg">
                <table class="min-w-full border-collapse">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">Tanggal</th>
                            <th class="px-4 py-2 border">Murid</th>
                            <th class="px-4 py-2 border">Topik</th>
                            <th class="px-4 py-2 border">Catatan</th>
                            <th class="px-4 py-2 border">Tindak Lanjut</th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assistances as $a)
                            <tr>
                                <td class="px-4 py-2 border">{{ $a->date }}</td>
                                <td class="px-4 py-2 border">{{ $a->student?->name ?? '-' }}</td>
                                <td class="px-4 py-2 border">{{ $a->topic }}</td>
                                <td class="px-4 py-2 border">{{ $a->notes }}</td>
                                <td class="px-4 py-2 border">{{ $a->follow_up }}</td>
                                <td class="px-4 py-2 border text-center">
                                    @if($a->status == 'pending')
                                        <span class="inline-flex items-center gap-1 px-2 py-1 text-xs bg-gray-200 text-gray-700 rounded-full">
                                            ⏳ Pending
                                        </span>
                                    @elseif($a->status == 'in_progress')
                                        <span class="inline-flex items-center gap-1 px-2 py-1 text-xs bg-yellow-200 text-yellow-800 rounded-full">
                                            🔄 Proses
                                        </span>
                                    @elseif($a->status == 'done')
                                        <span class="inline-flex items-center gap-1 px-2 py-1 text-xs bg-green-200 text-green-800 rounded-full">
                                            ✅ Selesai
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 border text-center">
                                    <div class="flex gap-2 justify-center">
                                        <a href="{{ route('assistances.edit', $a->id) }}" 
                                           class="px-3 py-1 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">Edit</a>
                                        <form action="{{ route('assistances.destroy', $a->id) }}" method="POST" 
                                              onsubmit="return confirm('Yakin hapus catatan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="px-3 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-3 text-center text-gray-500">Belum ada catatan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @else
            {{-- 📦 Card View --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($assistances as $a)
                    <div class="bg-white p-4 rounded-lg shadow border flex flex-col justify-between">
                        <div>
                            <p class="text-sm text-gray-500">{{ $a->date }}</p>
                            <h2 class="text-lg font-semibold">{{ $a->student?->name ?? '-' }}</h2>
                            <p class="text-sm"><strong>Topik:</strong> {{ $a->topic }}</p>
                            <p class="text-sm"><strong>Catatan:</strong> {{ \Illuminate\Support\Str::limit($a->notes, 60) }}</p>
                            <p class="text-sm"><strong>Tindak Lanjut:</strong> {{ \Illuminate\Support\Str::limit($a->follow_up, 60) }}</p>

                            {{-- Status --}}
                            <div class="mt-2">
                                @if($a->status == 'pending')
                                    <span class="inline-flex items-center gap-1 px-2 py-1 text-xs bg-gray-200 text-gray-700 rounded-full">
                                        ⏳ Pending
                                    </span>
                                @elseif($a->status == 'in_progress')
                                    <span class="inline-flex items-center gap-1 px-2 py-1 text-xs bg-yellow-200 text-yellow-800 rounded-full">
                                        🔄 Proses
                                    </span>
                                @elseif($a->status == 'done')
                                    <span class="inline-flex items-center gap-1 px-2 py-1 text-xs bg-green-200 text-green-800 rounded-full">
                                        ✅ Selesai
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="flex justify-end gap-2 mt-4">
                            <a href="{{ route('assistances.edit', $a->id) }}" 
                               class="px-3 py-1 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">Edit</a>
                            <form action="{{ route('assistances.destroy', $a->id) }}" method="POST" 
                                  onsubmit="return confirm('Yakin hapus catatan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-3 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500 py-6">
                        Belum ada catatan.
                    </div>
                @endforelse
            </div>
        @endif

        <div class="mt-6">
            {{ $assistances->appends(request()->all())->links() }}
        </div>
    </div>
</x-app-layout>
