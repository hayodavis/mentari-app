<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AssistanceController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TeacherPerformanceController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Student;

// 🔹 Redirect root ke halaman login
Route::get('/', fn() => redirect()->route('login'));

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
     * 🔍 Endpoint Pencarian Siswa (autocomplete di form laporan)
     * Hasil pencarian otomatis menghapus duplikat berdasarkan kombinasi nama + kelas
     */
    Route::get('/students/search', [StudentController::class, 'search'])->name('students.search');
});

// 🔹 Route khusus admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('teachers', TeacherController::class);
    Route::resource('students', StudentController::class);
    Route::resource('classrooms', ClassroomController::class);

    // ✅ Kinerja Guru Wali
    Route::get('/teacher-performance', [TeacherPerformanceController::class, 'index'])
        ->name('teacherPerformance');
    Route::get('/teacher-performance/{id}', [TeacherPerformanceController::class, 'detail'])
        ->name('teacherPerformance.detail');

    // ✅ Tambahkan di bawah route detail
    Route::get('/teacher-performance/{id}/export-pdf', [TeacherPerformanceController::class, 'exportPDF'])
        ->name('teacherPerformance.export');


    // ✅ Import & Template Guru
    Route::post('/teachers/import', [TeacherController::class, 'import'])->name('teachers.import');
    Route::get('/teachers/template', [TeacherController::class, 'downloadTemplate'])->name('teachers.template');

    // ✅ Import & Template Siswa
    Route::post('/students/import', [StudentController::class, 'import'])->name('students.import');
    Route::get('/students/template', [StudentController::class, 'downloadTemplate'])->name('students.template');
});

// 🔹 Route uji admin
Route::middleware(['auth', 'admin'])->get('/test-admin', fn() => 'Halo Admin!');

require __DIR__ . '/auth.php';
