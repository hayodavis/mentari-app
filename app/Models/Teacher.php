<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nip',
        'phone',
        'user_id',
    ];

    /**
     * Relasi ke User (akun login).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Siswa (guru punya banyak siswa).
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'teacher_id');
    }

    /**
     * Relasi tidak langsung ke Catatan Pendampingan (Assistance)
     * melalui siswa yang dibimbing oleh guru ini.
     */
    public function assistances()
    {
        return $this->hasManyThrough(Assistance::class, Student::class, 'teacher_id', 'student_id');
    }

    public function classroom()
{
    return $this->hasOne(\App\Models\Classroom::class, 'teacher_id');
}

}
