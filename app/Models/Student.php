<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi (mass assignable).
     */
    protected $fillable = [
        'nisn',
        'name',
        'classroom_id',   // ✅ perbaiki
        'gender',
        'parent_contact',
        'notes',
        'teacher_id',
    ];

    /**
     * Relasi ke Guru (Teacher).
     * Satu siswa punya satu guru wali.
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Relasi ke catatan pendampingan (Assistance).
     * Satu siswa bisa punya banyak catatan pendampingan.
     */
    public function assistances()
    {
        return $this->hasMany(Assistance::class);
    }

    /**
     * Relasi ke Kelas (Classroom).
     * Satu siswa hanya punya satu kelas.
     */
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
