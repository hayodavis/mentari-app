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
        $user = auth()->user();
    $query = Assistance::with('student');

    // 🔹 Filter otomatis untuk guru
    if ($user->role === 'guru') {
        $teacher = \App\Models\Teacher::where('user_id', $user->id)->first();

        if ($teacher) {
            $query->whereHas('student', function ($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
            });
        } else {
            // Jika guru belum punya data di tabel teachers
            $query->whereRaw('1=0'); // tidak tampilkan data apa pun
        }
    }

    // 🔍 Pencarian
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->whereHas('student', function ($q2) use ($search) {
                $q2->where('name', 'like', "%{$search}%");
            })
            ->orWhere('topic', 'like', "%{$search}%");
        });
    }

    // 🎯 Filter topik & status
    if ($request->filled('topic')) {
        $query->where('topic', $request->topic);
    }
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // 📅 Urutkan berdasarkan tanggal
    $sort = $request->get('sort', 'desc');
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
        $user = auth()->user();

        // Jika role guru, ambil data guru berdasarkan user_id
        if ($user->role === 'guru') {
            $teacher = \App\Models\Teacher::where('user_id', $user->id)->first();

            if ($teacher) {
            // Ambil hanya siswa binaan guru tersebut
                $students = Student::where('teacher_id', $teacher->id)
                    ->orderBy('name')
                    ->get();
            } else {
                // Jika guru belum punya data di tabel teachers
                $students = collect(); // kirim kosong biar tidak error
            }
        } else {
            // Admin tetap bisa lihat semua siswa
            $students = Student::orderBy('name')->get();
        }

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
            'status'      => 'required|in:pending,in_progress,done', // ✅ validasi status
        ]);

        Assistance::create($request->only([
            'student_id','date','topic','notes','follow_up','status'
        ]));

        return redirect()->route('assistances.index')->with('success', 'Catatan berhasil disimpan.');
    }

    /**
     * Form edit catatan pendampingan
     */
    public function edit(Assistance $assistance)
    {
        $user = auth()->user();

        if ($user->role === 'guru') {
            $teacher = \App\Models\Teacher::where('user_id', $user->id)->first();

            if (!$teacher) {
                abort(403, 'Akses ditolak: Anda belum terdaftar sebagai guru.');
            }

            // 🔒 Pastikan catatan ini benar-benar milik siswa binaan guru tersebut
            if ($assistance->student->teacher_id !== $teacher->id) {
                abort(403, 'Akses ditolak: Catatan ini bukan untuk siswa binaan Anda.');
            }

            // 🔹 Tampilkan hanya murid binaan guru tersebut di dropdown
            $students = Student::where('teacher_id', $teacher->id)
                ->orderBy('name')
                ->get();
        } else {
            // Admin bisa mengakses semua siswa
            $students = Student::orderBy('name')->get();
        }

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
            'status'      => 'required|in:pending,in_progress,done',
        ]);

        $assistance->update($request->only([
            'student_id','date','topic','notes','follow_up','status'
        ]));

        return redirect()->route('assistances.index')->with('success', 'Catatan berhasil diperbarui.');
    }

    /**
     * Hapus catatan pendampingan
     */
    public function destroy(Assistance $assistance)
    {
        $assistance->delete();

        return redirect()->route('assistances.index')
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
            'status'    => 'required|in:pending,in_progress,done', // ✅ tambahkan status
        ]);

        $student->assistances()->create($request->only([
            'date', 'topic', 'notes', 'follow_up', 'status'
        ]));

        return redirect()->route('admin.students.show', $student->id)
            ->with('success', 'Catatan pendampingan berhasil ditambahkan untuk siswa.');
    }
}
