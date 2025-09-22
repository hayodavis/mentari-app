<?php

namespace App\Imports;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TeachersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Buat user baru untuk login
        $user = User::create([
            'name'     => $row['name'],
            'email'    => $row['email'],
            'password' => isset($row['password']) 
                ? Hash::make($row['password']) 
                : Hash::make('password123'),
        ]);

        // Simpan ke tabel teachers
        return new Teacher([
            'name'    => $row['name'],
            'nip'     => $row['nip'] ?? null,
            'phone'   => $row['phone'] ?? null,
            'user_id' => $user->id, // relasi ke users
        ]);
    }
}
