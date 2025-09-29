@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-2xl font-bold mb-6">📊 Dashboard Admin</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="p-4 bg-blue-100 rounded-lg shadow">
            <h2 class="text-lg font-semibold">Jumlah Siswa</h2>
            <p class="text-2xl font-bold">{{ $totalStudents }}</p>
        </div>
        <div class="p-4 bg-green-100 rounded-lg shadow">
            <h2 class="text-lg font-semibold">Jumlah Guru</h2>
            <p class="text-2xl font-bold">{{ $totalTeachers }}</p>
        </div>
        <div class="p-4 bg-yellow-100 rounded-lg shadow">
            <h2 class="text-lg font-semibold">Jumlah Kelas</h2>
            <p class="text-2xl font-bold">{{ $totalClassrooms }}</p>
        </div>
        <div class="p-4 bg-purple-100 rounded-lg shadow">
            <h2 class="text-lg font-semibold">Catatan Pendampingan</h2>
            <p class="text-2xl font-bold">{{ $totalAssistances }}</p>
        </div>
    </div>
</div>
@endsection
