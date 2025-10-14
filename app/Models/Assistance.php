<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assistance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'date',
        'topic',
        'notes',
        'follow_up',
        'status', 
    ];


    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function reporter()
    {
        return $this->belongsTo(\App\Models\Teacher::class, 'reported_by');
    }

}
