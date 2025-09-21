<?php

namespace App\Http\Controllers;

use App\Models\Assistance;
use App\Models\Student;
use Illuminate\Http\Request;

class AssistanceController extends Controller
{
    public function index()
    {
        $assistances = Assistance::with('student')->latest()->get();
        return view('students.index', compact('students'));
    }

    public function create()
    {
        $students = Student::all();
        return view('assistances.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'topic' => 'required|string',
            'notes' => 'nullable|string',
            'follow_up' => 'nullable|string',
        ]);

        Assistance::create($validated);

        return redirect()->route('assistances.index')->with('success','Catatan pendampingan berhasil ditambahkan');
    }

    public function edit(Assistance $assistance)
    {
        $students = Student::all();
        return view('assistances.edit', compact('assistance','students'));
    }

    public function update(Request $request, Assistance $assistance)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'topic' => 'required|string',
            'notes' => 'nullable|string',
            'follow_up' => 'nullable|string',
        ]);

        $assistance->update($validated);

        return redirect()->route('assistances.index')->with('success','Catatan pendampingan berhasil diperbarui');
    }

    public function destroy(Assistance $assistance)
    {
        $assistance->delete();
        return redirect()->route('assistances.index')->with('success','Catatan pendampingan berhasil dihapus');
    }

    public function storeForStudent(Request $request, Student $student)
    {
        $validated = $request->validate([
        'date' => 'required|date',
        'topic' => 'required|string',
        'notes' => 'nullable|string',
        'follow_up' => 'nullable|string',
    ]);
        $student->assistances()->create($validated);
        return redirect()->route('students.show', $student->id)->with('success','Catatan pendampingan berhasil ditambahkan');
    }
}
