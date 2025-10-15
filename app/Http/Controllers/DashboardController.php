<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Classroom;
use App\Models\Assistance;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents   = Student::count();
        $totalTeachers   = Teacher::count();
        $totalClassrooms = Classroom::count();
        $totalAssistances = Assistance::count();

        // 🔹 Aktivitas terbaru
        $latestAssistances = Assistance::with('student')
            ->latest('date')
            ->take(5)
            ->get();

        // 🔹 Catatan berdasarkan topik
        $assistancesByTopic = Assistance::select('topic', DB::raw('count(*) as total'))
            ->groupBy('topic')
            ->pluck('total', 'topic');

        // 🔹 Top 5 guru dengan catatan terbanyak
        $topTeachers = Teacher::withCount(['students as total_assistances' => function ($q) {
                $q->join('assistances', 'students.id', '=', 'assistances.student_id');
            }])
            ->orderByDesc('total_assistances')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalStudents',
            'totalTeachers',
            'totalClassrooms',
            'totalAssistances',
            'latestAssistances',
            'assistancesByTopic',
            'topTeachers'
        ));
    }

    public function teacherPerformance(Request $request)
{
    $month = $request->get('month', now()->format('Y-m'));

    $data = \App\Models\Teacher::select('teachers.id', 'teachers.name')
        ->leftJoin('assistances', 'assistances.reported_by', '=', 'teachers.id')
        ->whereMonth('assistances.date', '=', date('m', strtotime($month)))
        ->whereYear('assistances.date', '=', date('Y', strtotime($month)))
        ->selectRaw('COUNT(assistances.id) as total_reports')
        ->groupBy('teachers.id', 'teachers.name')
        ->orderByDesc('total_reports')
        ->get();

    return view('admin.teacher-performance', compact('data'));
}

}
