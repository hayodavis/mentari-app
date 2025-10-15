<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Assistance;
use App\Models\Student;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class TeacherPerformanceController extends Controller
{
    /**
     * 🧭 Tampilkan halaman pemantauan kinerja guru wali
     */
    public function index(Request $request)
    {
        // Bulan & tahun default = bulan & tahun saat ini
        $month = $request->get('month', now()->month);
        $year  = $request->get('year', now()->year);

        // Ambil semua guru wali
        $teachers = Teacher::all();

        // 🔹 Hitung performa per guru
        $performances = $teachers->map(function ($teacher) use ($month, $year) {
            $assistances = Assistance::whereMonth('date', $month)
                ->whereYear('date', $year)
                ->where(function ($q) use ($teacher) {
                    $q->where('reported_by', $teacher->id)
                      ->orWhereHas('student', function ($sub) use ($teacher) {
                          $sub->where('teacher_id', $teacher->id);
                      });
                })
                ->get();

            $count = $assistances->count();
            $lastUpdate = $assistances->max('date');

            // Tentukan status aktivitas
            if ($count >= 10) {
                $status = 'Aktif';
            } elseif ($count >= 5) {
                $status = 'Cukup Aktif';
            } else {
                $status = 'Kurang Aktif';
            }

            return [
                'teacher_id'        => $teacher->id,
                'teacher_name'      => $teacher->name,
                'total_assistances' => $count,
                'last_activity'     => $lastUpdate,
                'status'            => $status,
            ];
        });

        // 🔹 Pagination manual (karena ini hasil dari Collection)
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $performances->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginatedPerformances = new LengthAwarePaginator(
            $currentItems,
            $performances->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // 🔹 Statistik ringkas
        $summary = [
            'aktif'  => $performances->where('status', 'Aktif')->count(),
            'cukup'  => $performances->where('status', 'Cukup Aktif')->count(),
            'kurang' => $performances->where('status', 'Kurang Aktif')->count(),
        ];

        return view('admin.teacher-performance', [
            'performances' => $paginatedPerformances,
            'month' => $month,
            'year' => $year,
            'summary' => $summary,
        ]);
    }

    /**
     * 📋 Detail catatan pendampingan dari satu guru wali
     */
    public function detail($id)
    {
        // Ambil data guru wali
        $teacher = Teacher::findOrFail($id);

        // Ambil siswa binaan guru ini
        $studentIds = Student::where('teacher_id', $id)->pluck('id');

        // Ambil semua catatan: siswa binaan ATAU laporan yang dibuat guru tsb
        $assistances = Assistance::whereIn('student_id', $studentIds)
            ->orWhere('reported_by', $id)
            ->with(['student.classroom'])
            ->orderByDesc('date')
            ->paginate(10); // ✅ Pagination bawaan Laravel

        return view('admin.teacher-performance-detail', compact('teacher', 'assistances'));
    }
}
