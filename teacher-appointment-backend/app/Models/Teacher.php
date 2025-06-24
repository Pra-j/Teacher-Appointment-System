<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'department',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments() {
    return $this->hasMany(Appointment::class, 'teachers_id');
}
}
