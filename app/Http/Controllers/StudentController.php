<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Classroom;
use App\Imports\StudentsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    protected $routeBase = 'admin.students.';

    /**
     * Daftar semua siswa
     */
    public function index(Request $request)
    {
        $query = Student::with(['teacher', 'classroom'])->latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nisn', 'like', "%$search%")
                ->orWhere('name', 'like', "%$search%")
                ->orWhereHas('classroom', function ($qc) use ($search) {
                    $qc->where('name', 'like', "%$search%");
                })
                ->orWhereHas('teacher', function ($qt) use ($search) {
                    $qt->where('name', 'like', "%$search%");
                });
            });
        }

        $students = $query->paginate(10);

        return view('admin.students.index', compact('students'));
    }

    /**
     * Form tambah siswa baru
     */
    public function create()
    {
        $teachers   = Teacher::all();    // daftar guru wali
        $classrooms = Classroom::all();  // daftar kelas

        return view('admin.students.create', compact('teachers', 'classrooms'));
    }

    /**
     * Simpan siswa baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nisn'           => 'required|string|max:20|unique:students',
            'name'           => 'required|string|max:100',
            'classroom_id'   => 'required|exists:classrooms,id',
            'gender'         => 'required|in:L,P',
            'parent_contact' => 'nullable|string|max:20',
            'notes'          => 'nullable|string',
            'teacher_id'     => 'required|exists:teachers,id',
        ]);

        Student::create($request->all());

        return redirect()->route($this->routeBase . 'index')
            ->with('success', 'Siswa berhasil ditambahkan.');
    }

    /**
     * Detail siswa
     */
    public function show(Student $student)
    {
        return view('admin.students.show', compact('student'));
    }

    /**
     * Form edit siswa
     */
    public function edit(Student $student)
    {
        $teachers   = Teacher::all();
        $classrooms = Classroom::all();

        return view('admin.students.edit', compact('student', 'teachers', 'classrooms'));
    }

    /**
     * Update siswa
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'nisn'           => 'required|string|max:20|unique:students,nisn,' . $student->id,
            'name'           => 'required|string|max:100',
            'classroom_id'   => 'required|exists:classrooms,id',
            'gender'         => 'required|in:L,P',
            'parent_contact' => 'nullable|string|max:20',
            'notes'          => 'nullable|string',
            'teacher_id'     => 'required|exists:teachers,id',
        ]);

        $student->update($request->all());

        return redirect()->route($this->routeBase . 'index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Hapus siswa
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route($this->routeBase . 'index')
            ->with('success', 'Siswa berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        Excel::import(new StudentsImport, $request->file('file'));

        return redirect()->route('admin.students.index')
            ->with('success', 'Data siswa berhasil diimport!');
    }

    public function downloadTemplate()
    {
        $filePath = storage_path('app/public/template_siswa.xlsx');

        if (!file_exists($filePath)) {
            abort(404, 'Template siswa tidak ditemukan.');
        }

        return response()->download($filePath, 'template_siswa.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
