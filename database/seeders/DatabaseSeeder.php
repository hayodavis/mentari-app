<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Assistance;
use App\Models\Classroom;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 🔹 Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 🔹 Guru 1
        $guru1User = User::create([
            'name' => 'Guru Satu',
            'email' => 'guru1@example.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
        ]);

        $guru1 = Teacher::create([
            'name'    => 'Guru Satu',
            'nip'     => '1111111111',
            'phone'   => '081111111111',
            'user_id' => $guru1User->id,
        ]);

        // 🔹 Guru 2
        $guru2User = User::create([
            'name' => 'Guru Dua',
            'email' => 'guru2@example.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
        ]);

        $guru2 = Teacher::create([
            'name'    => 'Guru Dua',
            'nip'     => '2222222222',
            'phone'   => '082222222222',
            'user_id' => $guru2User->id,
        ]);

        // 🔹 Kelas
        $kelas1 = Classroom::create(['name' => 'XI RPL 1']);
        $kelas2 = Classroom::create(['name' => 'XI RPL 2']);
        $kelas3 = Classroom::create(['name' => 'XI RPL 3']);

        // 🔹 Murid untuk Guru 1
        $murid1 = Student::create([
            'nisn'          => '1001',
            'name'          => 'Budi Santoso',
            'gender'        => 'L',
            'parent_contact'=> '081333333333',
            'notes'         => 'Anak rajin',
            'teacher_id'    => $guru1->id,
            'classroom_id'  => $kelas1->id,
        ]);

        $murid2 = Student::create([
            'nisn'          => '1002',
            'name'          => 'Siti Aminah',
            'gender'        => 'P',
            'parent_contact'=> '081444444444',
            'notes'         => 'Perlu bimbingan belajar',
            'teacher_id'    => $guru1->id,
            'classroom_id'  => $kelas2->id,
        ]);

        // 🔹 Murid untuk Guru 2
        $murid3 = Student::create([
            'nisn'          => '1003',
            'name'          => 'Andi Wijaya',
            'gender'        => 'L',
            'parent_contact'=> '081555555555',
            'notes'         => 'Sering absen',
            'teacher_id'    => $guru2->id,
            'classroom_id'  => $kelas3->id,
        ]);

        // 🔹 Catatan Pendampingan
        Assistance::create([
            'student_id' => $murid1->id,
            'title'      => 'Bimbingan Akademik',
            'date'       => now()->toDateString(),
            'topic'      => 'Matematika',
            'notes'      => 'Budi mendapat arahan untuk meningkatkan nilai matematika.',
            'follow_up'  => 'Orang tua akan dihubungi untuk mendukung belajar di rumah.',
        ]);

        Assistance::create([
            'student_id' => $murid2->id,
            'title'      => 'Pendampingan Belajar',
            'date'       => now()->toDateString(),
            'topic'      => 'Bahasa Inggris',
            'notes'      => 'Siti perlu tambahan les Bahasa Inggris.',
            'follow_up'  => 'Akan dicari tutor tambahan.',
        ]);

        Assistance::create([
            'student_id' => $murid3->id,
            'title'      => 'Konseling Disiplin',
            'date'       => now()->toDateString(),
            'topic'      => 'Absensi',
            'notes'      => 'Andi sering bolos, diberikan peringatan.',
            'follow_up'  => 'Jadwalkan pertemuan dengan orang tua.',
        ]);
    }
}
