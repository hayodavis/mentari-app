<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Imports\TeachersImport;
use Maatwebsite\Excel\Facades\Excel;

class TeacherController extends Controller
{
    protected $routeBase = 'admin.teachers.';

    public function index()
    {
        $teachers = Teacher::with('user')->latest()->paginate(10);
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'nip'      => 'required|string|max:20|unique:teachers',
            'phone'    => 'nullable|string|max:20',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        // 1️⃣ Buat user baru
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'guru',
        ]);

        // 2️⃣ Buat teacher & hubungkan ke user
        Teacher::create([
            'name'    => $request->name,
            'nip'     => $request->nip,
            'phone'   => $request->phone,
            'user_id' => $user->id,
        ]);

        return redirect()->route($this->routeBase . 'index')
            ->with('success', 'Guru berhasil ditambahkan beserta akunnya.');
    }

    public function show(Teacher $teacher)
    {
        return view('admin.teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'nip'      => 'required|string|max:20|unique:teachers,nip,' . $teacher->id,
            'phone'    => 'nullable|string|max:20',
            'email'    => 'required|email|unique:users,email,' . $teacher->user->id,
            'password' => 'nullable|string|min:6',
        ]);

        // 🔹 Update user (akun login)
        if ($teacher->user) {
            $teacher->user->update([
                'name'  => $request->name,
                'email' => $request->email,
                'password' => $request->password
                    ? Hash::make($request->password)
                    : $teacher->user->password,
            ]);
        }

        // 🔹 Update teacher
        $teacher->update([
            'name'  => $request->name,
            'nip'   => $request->nip,
            'phone' => $request->phone,
        ]);

        return redirect()->route($this->routeBase . 'index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Teacher $teacher)
    {
        // Hapus user terkait
        if ($teacher->user) {
            $teacher->user->delete();
        }

        // Hapus teacher
        $teacher->delete();

        return redirect()->route($this->routeBase . 'index')
            ->with('success', 'Guru beserta akun login berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
        'file' => 'required|mimes:xlsx,csv,xls'
    ]);
    
    Excel::import(new TeachersImport, $request->file('file'));

    return redirect()->route('admin.teachers.index')
        ->with('success', 'Data guru berhasil diimport!');
    }

    public function downloadTemplate()
    {
    $headers = [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    ];

    $fileName = 'template_guru.xlsx';
    $path = storage_path('app/public/' . $fileName);

    // Kalau template sudah dibuat via Excel::download langsung, bisa gini:
    return \Maatwebsite\Excel\Facades\Excel::download(
        new \App\Exports\TeachersTemplateExport,
        $fileName,
        \Maatwebsite\Excel\Excel::XLSX
    );
    }
}
