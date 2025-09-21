<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Classroom;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    protected $routeBase = 'admin.students.';

    /**
     * Daftar semua siswa
     */
    public function index()
    {
        $students = Student::with(['teacher', 'classroom'])->latest()->paginate(10);
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
}
