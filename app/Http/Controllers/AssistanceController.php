<?php

namespace App\Http\Controllers;

use App\Models\Assistance;
use App\Models\Student;
use Illuminate\Http\Request;

class AssistanceController extends Controller
{
    protected $routeBase = 'assistances.';

    /**
     * Daftar semua catatan pendampingan
     */
    public function index(Request $request)
    {
        $query = \App\Models\Assistance::with('student');
        
        // 🔍 Pencarian berdasarkan nama murid atau topik
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%");
        })->orWhere('topic', 'like', "%{$search}%");
    }

        // 🎯 Filter berdasarkan topik
        if ($request->filled('topic')) {
            $query->where('topic', $request->topic);
        }

        // 📅 Urutkan berdasarkan tanggal
        $sort = $request->get('sort', 'desc'); // default terbaru
        $query->orderBy('date', $sort);

        $assistances = $query->paginate(10);

        // daftar topik untuk filter dropdown
        $topics = ['Kedisiplinan', 'Prestasi', 'Absensi', 'Akademik', 'Lainnya'];

        return view('assistances.index', compact('assistances', 'topics'))
            ->with('sort', $sort)
            ->with('search', $request->search)
            ->with('selectedTopic', $request->topic);
    }

    /**
     * Form tambah catatan pendampingan
     */
    public function create()
    {
        $students = Student::orderBy('name')->get();
        return view('assistances.create', compact('students'));
    }

    /**
     * Simpan catatan pendampingan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id'  => 'required|exists:students,id',
            'date'        => 'required|date',
            'topic'       => 'required|string|max:255',
            'notes'       => 'nullable|string',
            'follow_up'   => 'nullable|string|max:255',
        ]);

        Assistance::create($request->all());

        return redirect()->route($this->routeBase . 'index')
            ->with('success', 'Catatan pendampingan berhasil ditambahkan.');
    }

    /**
     * Form edit catatan pendampingan
     */
    public function edit(Assistance $assistance)
    {
        $students = Student::orderBy('name')->get();
        return view('assistances.edit', compact('assistance', 'students'));
    }

    /**
     * Update catatan pendampingan
     */
    public function update(Request $request, Assistance $assistance)
    {
        $request->validate([
            'student_id'  => 'required|exists:students,id',
            'date'        => 'required|date',
            'topic'       => 'required|string|max:255',
            'notes'       => 'nullable|string',
            'follow_up'   => 'nullable|string|max:255',
        ]);

        $assistance->update($request->all());

        return redirect()->route($this->routeBase . 'index')
            ->with('success', 'Catatan pendampingan berhasil diperbarui.');
    }

    /**
     * Hapus catatan pendampingan
     */
    public function destroy(Assistance $assistance)
    {
        $assistance->delete();

        return redirect()->route($this->routeBase . 'index')
            ->with('success', 'Catatan pendampingan berhasil dihapus.');
    }

    /**
     * Tambahkan catatan langsung dari halaman detail siswa
     */
    public function storeForStudent(Request $request, Student $student)
    {
        $request->validate([
            'date'      => 'required|date',
            'topic'     => 'required|string|max:255',
            'notes'     => 'nullable|string',
            'follow_up' => 'nullable|string|max:255',
        ]);

        $student->assistances()->create($request->all());

        return redirect()->route('admin.students.show', $student->id)
            ->with('success', 'Catatan pendampingan berhasil ditambahkan untuk siswa.');
    }
}
