<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Classroom;
use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
         // Normalize key ke lowercase semua
        $row = array_change_key_case($row, CASE_LOWER);

        // cari classroom berdasarkan nama
        $classroom = Classroom::where('name', $row['classroom'] ?? '')->first();
        
        // cari teacher berdasarkan nama
        $teacher   = Teacher::where('name', $row['teacher'] ?? '')->first();

        return new Student([
            'nisn'           => $row['nisn'] ?? null,
            'name'           => $row['name'] ?? null,
            'gender'         => $row['gender'] ?? null,
            'parent_contact' => $row['parent_contact'] ?? null,
            'classroom_id'   => $classroom?->id,
            'teacher_id'     => $teacher?->id,
        ]);
    }
}
