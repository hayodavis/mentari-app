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
}
