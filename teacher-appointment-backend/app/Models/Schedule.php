<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'teacher_id',
        'day',
        'from_time',
        'to_time',
    ];

     public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id'); // or 'teachers_id' if that is your column
    }
}
