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
        // ✅ Skip kalau kosong
        if (empty($row['name']) || empty($row['email']) || empty($row['password'])) {
            return null;
        }

        // ✅ Skip kalau email sudah ada
        if (User::where('email', $row['email'])->exists()) {
            return null;
        }

        // 🔹 Buat user baru
        $user = User::create([
            'name'     => $row['name'],
            'email'    => $row['email'],
            'password' => Hash::make($row['password']),
            'role'     => 'guru',
        ]);

        // 🔹 Buat teacher terkait
        return new Teacher([
            'name'    => $row['name'],
            'nip'     => $row['nip'] ?? null,
            'phone'   => $row['phone'] ?? null,
            'user_id' => $user->id,
        ]);
    }
}
