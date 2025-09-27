<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AssistanceController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ClassroomController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 🔹 Route umum (semua user login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 🔹 Route untuk guru (wali kelas)
Route::middleware(['auth'])->group(function () {
    Route::resource('assistances', AssistanceController::class);
    Route::post('/students/{student}/assistances', [AssistanceController::class, 'storeForStudent'])
        ->name('students.assistances.store');
});

// 🔹 Route khusus admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('teachers', TeacherController::class);
    Route::resource('students', StudentController::class);
    Route::resource('classrooms', ClassroomController::class);

    // ✅ Import & Template
    Route::post('/teachers/import', [TeacherController::class, 'import'])->name('teachers.import');
    Route::get('/teachers/template', [TeacherController::class, 'downloadTemplate'])->name('teachers.template');

    // ✅ Import siswa
    Route::post('/students/import', [StudentController::class, 'import'])->name('students.import');
    Route::get('/students/template', [StudentController::class, 'downloadTemplate'])->name('students.template');
});

// 🔹 Route uji admin
Route::middleware(['auth', 'admin'])->get('/test-admin', function () {
    return 'Halo Admin!';
});

require __DIR__.'/auth.php';
