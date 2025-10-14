<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AssistanceController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Student;

// 🔹 Redirect root ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// 🔹 Dashboard utama
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// 🔹 Route umum (semua user login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 🔹 Route untuk guru (wali kelas)
Route::middleware(['auth'])->group(function () {

    /**
     * 🧾 Fitur Laporan Guru (semua siswa bisa dilaporkan)
     */
    Route::get('/assistances/report', [AssistanceController::class, 'reportForm'])
        ->name('assistances.report.form');
    Route::post('/assistances/report', [AssistanceController::class, 'storeReport'])
        ->name('assistances.report.store');

    /**
     * 🧭 CRUD Catatan Pendampingan (siswa binaan)
     */
    Route::resource('assistances', AssistanceController::class);

    // Tambah catatan langsung ke siswa tertentu
    Route::post('/students/{student}/assistances', [AssistanceController::class, 'storeForStudent'])
        ->name('students.assistances.store');

    /**
     * 🔍 Endpoint Pencarian Siswa (untuk autocomplete di form laporan)
     */
    Route::get('/students/search', function (Request $request) {
        $q = $request->get('q');
        $students = Student::with('classroom')
            ->where('name', 'like', "%{$q}%")
            ->orderBy('name')
            ->limit(10)
            ->get()
            ->map(fn($s) => [
                'id' => $s->id,
                'name' => $s->name,
                'classroom' => $s->classroom?->name,
            ]);
        return response()->json($students);
    })->name('students.search');
});

// 🔹 Route khusus admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('teachers', TeacherController::class);
    Route::resource('students', StudentController::class);
    Route::resource('classrooms', ClassroomController::class);

    // ✅ Import & Template Guru
    Route::post('/teachers/import', [TeacherController::class, 'import'])->name('teachers.import');
    Route::get('/teachers/template', [TeacherController::class, 'downloadTemplate'])->name('teachers.template');

    // ✅ Import & Template Siswa
    Route::post('/students/import', [StudentController::class, 'import'])->name('students.import');
    Route::get('/students/template', [StudentController::class, 'downloadTemplate'])->name('students.template');
});

// 🔹 Route uji admin
Route::middleware(['auth', 'admin'])->get('/test-admin', function () {
    return 'Halo Admin!';
});

require __DIR__ . '/auth.php';
