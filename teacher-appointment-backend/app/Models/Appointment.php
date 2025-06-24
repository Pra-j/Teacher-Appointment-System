<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{

protected $fillable = [
        'teachers_id',
        'student_id',
        'appointment_date',
        'appointment_time',
    'status',
    ];
    public function teacher()
{
    return $this->belongsTo(Teacher::class, 'teachers_id');
}

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

public function user()
{
    return $this->belongsTo(User::class);
}


}
