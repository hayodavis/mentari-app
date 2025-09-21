<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    protected $routeBase = 'admin.classrooms.';

    public function index()
    {
        $classrooms = Classroom::latest()->paginate(10);
        return view('admin.classrooms.index', compact('classrooms'));
    }

    public function create()
    {
        return view('admin.classrooms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:classrooms',
            'description' => 'nullable|string',
        ]);

        Classroom::create($request->all());

        return redirect()->route($this->routeBase . 'index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit(Classroom $classroom)
    {
        return view('admin.classrooms.edit', compact('classroom'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:classrooms,name,' . $classroom->id,
            'description' => 'nullable|string',
        ]);

        $classroom->update($request->all());

        return redirect()->route($this->routeBase . 'index')
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(Classroom $classroom)
    {
        $classroom->delete();

        return redirect()->route($this->routeBase . 'index')
            ->with('success', 'Kelas berhasil dihapus.');
    }
}
