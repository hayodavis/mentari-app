<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Classroom;
use App\Models\Assistance;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents   = Student::count();
        $totalTeachers   = Teacher::count();
        $totalClassrooms = Classroom::count();
        $totalAssistances = Assistance::count();

        return view('admin.dashboard', compact(
            'totalStudents',
            'totalTeachers',
            'totalClassrooms',
            'totalAssistances'
        ));
    }
}
